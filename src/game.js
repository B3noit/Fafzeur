var game = new Phaser.Game(1000, 600, Phaser.AUTO, '');

game.state.add('play', {
    preload: function() {
        this.game.load.image('nursery', 'assets/nursery.png');

        this.game.load.image('micron', 'assets/enemy/micron.png');
        this.game.load.image('xi', 'assets/enemy/xi.png');
        this.game.load.image('vereu', 'assets/enemy/vereu.png');
        this.game.load.image('jeancortex', 'assets/enemy/jeancortex.png');
        this.game.load.image('fafzeur', 'assets/enemy/fafzeur.png');

        this.game.load.image('pass', 'assets/pass.png');

        this.game.load.image('seringue', 'assets/seringue.png');
        this.game.load.image('swordIcon1', 'assets/seringueauto.png');

        // build panel for upgrades
        var bmd = this.game.add.bitmapData(250, 110);
        bmd.ctx.fillStyle = '#9a783d';
        bmd.ctx.strokeStyle = '#35371c';
        bmd.ctx.lineWidth = 12;
        bmd.ctx.fillRect(0, 0, 250, 500);
        bmd.ctx.strokeRect(0, 0, 250, 500);
        this.game.cache.addBitmapData('upgradePanel', bmd);

        var buttonImage = this.game.add.bitmapData(476, 48);
        buttonImage.ctx.fillStyle = '#e6dec7';
        buttonImage.ctx.strokeStyle = '#35371c';
        buttonImage.ctx.lineWidth = 4;
        buttonImage.ctx.fillRect(0, 0, 225, 48);
        buttonImage.ctx.strokeRect(0, 0, 225, 48);
        this.game.cache.addBitmapData('button', buttonImage);

        // the main player
        this.player = {
            clickDmg: 1,
            gold: 50,
            dps: 0
        };

        // world progression
        this.level = 1;
        // how many monsters have we killed during this level
        this.levelKills = 0;
        // how many monsters are required to advance a level
        this.levelKillsRequired = 10;
    },
    create: function() {
        var state = this;

        this.background = this.game.add.group();
        // setup each of our background layers to take the full screen
        ['nursery']
            .forEach(function(image) {
                var bg = state.game.add.tileSprite(0, 0, state.game.world.width,
                    state.game.world.height, image, '', state.background);
                bg.tileScale.setTo(4,4);
            });

        this.upgradePanel = this.game.add.image(10, 70, this.game.cache.getBitmapData('upgradePanel'));
        var upgradeButtons = this.upgradePanel.addChild(this.game.add.group());
        upgradeButtons.position.setTo(8, 8);

        var upgradeButtonsData = [
            {icon: 'seringue', name: 'Dosage', level: 0, cost: 5, purchaseHandler: function(button, player) {
                player.clickDmg += 1;
            }},
            {icon: 'swordIcon1', name: 'Auto-Dose', level: 0, cost: 25, purchaseHandler: function(button, player) {
                player.dps += 5;
            }}
        ];

        var button;
        upgradeButtonsData.forEach(function(buttonData, index) {
            button = state.game.add.button(0, (50 * index), state.game.cache.getBitmapData('button'));
            button.icon = button.addChild(state.game.add.image(6, 6, buttonData.icon));
            button.text = button.addChild(state.game.add.text(42, 6, buttonData.name + ': ' + buttonData.level, {font: '16px Arial Black'}));
            button.details = buttonData;
            button.costText = button.addChild(state.game.add.text(42, 24, 'Coût: ' + buttonData.cost, {font: '16px Arial Black'}));
            button.events.onInputDown.add(state.onUpgradeButtonClick, state);

            upgradeButtons.addChild(button);
        });

        var monsterData = [
            {name: 'Véreu veut en découdre ! :(',                       image: 'vereu',             maxHealth: 20},
            {name: 'Micron veut sa dose ! ^^',                          image: 'micron',            maxHealth: 40},
            {name: 'Cortex veut que tu ailles te faire voir ! O_O ',    image: 'jeancortex',        maxHealth: 30},
            {name: 'Fafzeur vient chercher son argent ! ;)',            image: 'fafzeur',           maxHealth: 60},
            {name: 'Xi surveille ton crédit sociale ! --\'',            image: 'xi',                maxHealth: 100}
        ];
        this.monsters = this.game.add.group();

        var monster;
        monsterData.forEach(function(data) {
            // create a sprite for them off screen
            monster = state.monsters.create(2000, state.game.world.centerY, data.image);
            // use the built in health component
            monster.health = monster.maxHealth = data.maxHealth;
            // center anchor
            monster.anchor.setTo(0.5, 1);
            // reference to the database
            monster.details = data;

            //enable input so we can click it!
            monster.inputEnabled = true;
            monster.events.onInputDown.add(state.onClickMonster, state);

            // hook into health and lifecycle events
            monster.events.onKilled.add(state.onKilledMonster, state);
            monster.events.onRevived.add(state.onRevivedMonster, state);
        });

        // display the monster front and center
        this.currentMonster = this.monsters.getRandom();
        this.currentMonster.position.set(this.game.world.centerX + 00, this.game.world.centerY +150);

        this.monsterInfoUI = this.game.add.group();
        this.monsterInfoUI.position.setTo(this.currentMonster.x - 490, this.currentMonster.y + 10);
        this.monsterNameText = this.monsterInfoUI.addChild(this.game.add.text(0, 0, this.currentMonster.details.name, {
            font: '48px Arial Black',
            fill: '#fff',
            strokeThickness: 2
        }));
        this.monsterHealthText = this.monsterInfoUI.addChild(this.game.add.text(0, 80, this.currentMonster.health + ' Points de crédébilité', {
            font: '32px Arial Black',
            fill: '#ff0000',
            strokeThickness: 3
        }));

        ///////////////////////////////////////////////////////////////Particules
        this.dmgTextPool = this.add.group();
        var dmgText;
        for (var d=0; d<50; d++) {
            dmgText = this.add.text(0, 0, '1', {
                font: '64px Arial Black',
                fill: '#fff',
                strokeThickness: 4
            });
            dmgText.exists = false;
            dmgText.tween = game.add.tween(dmgText)
                .to({
                    alpha: 0,
                    y: 100,
                    x: this.game.rnd.integerInRange(100, 700)
                }, 1000, Phaser.Easing.Cubic.Out);

            dmgText.tween.onComplete.add(function(text, tween) {
                text.kill();
            });
            this.dmgTextPool.add(dmgText);
        }

        /////////////////////////////////////////////////////////Passes 
        this.coins = this.add.group();
        this.coins.createMultiple(50, 'pass', '', false);
        this.coins.setAll('inputEnabled', true);
        this.coins.setAll('goldValue', 1);
        this.coins.callAll('events.onInputDown.add', 'events.onInputDown', this.onClickCoin, this);

        this.playerGoldText = this.add.text(30, 30, 'Passes : ' + this.player.gold, {
            font: '24px Arial Black',
            fill: '#fff',
            strokeThickness: 4
        });


        /////////////////////////////////////////////////////////////////Auto-dose
        this.dpsTimer = this.game.time.events.loop(100, this.onDPS, this);



        this.levelUI = this.game.add.group();
        this.levelUI.position.setTo(this.game.world.centerX, 30);
        this.levelText = this.levelUI.addChild(this.game.add.text(180, 0, 'Niveau: ' + this.level, {
            font: '24px Arial Black',
            fill: '#fff',
            strokeThickness: 4
        }));
        this.levelKillsText = this.levelUI.addChild(this.game.add.text(180, 30, 'Vaccinés: ' + this.levelKills + '/' + this.levelKillsRequired, {
            font: '24px Arial Black',
            fill: '#fff',
            strokeThickness: 4
        }));
    },

    //////////////////////////////////////////////////////////////////////////////Update au degat par seconde
    onDPS: function() {
        if (this.player.dps > 0) {
            if (this.currentMonster && this.currentMonster.alive) {
                var dmg = this.player.dps / 10;
                this.currentMonster.damage(dmg);
                this.monsterHealthText.text = this.currentMonster.alive ? Math.round(this.currentMonster.health) + ' Points de crédébilité' : 'DEAD';
            }
        }
    },

    //////////////////////////////////////////////////////////Update après achat
    onUpgradeButtonClick: function(button, pointer) {
        function getAdjustedCost() {
            return Math.ceil(button.details.cost + (button.details.level * 1.46));
        }

        if (this.player.gold - getAdjustedCost() >= 0) {
            this.player.gold -= getAdjustedCost();
            this.playerGoldText.text = 'Passe sanitaires : ' + this.player.gold;
            button.details.level++;
            button.text.text = button.details.name + ': ' + button.details.level;
            button.costText.text = 'Coût: ' + getAdjustedCost();
            button.details.purchaseHandler.call(this, button, this.player);
        }
    },

    ///////////////////////////////////////////////////////////Ramassage des passes
    onClickCoin: function(coin) {
        if (!coin.alive) {
            return;
        }
        // give the player gold
        this.player.gold += coin.goldValue;
        // update UI
        this.playerGoldText.text = 'Passe sanitaires : ' + this.player.gold;
        // remove the coin
        coin.kill();
    },


    onKilledMonster: function(monster) {
        monster.position.set(2000, this.game.world.centerY);

        var coin;
        coin = this.coins.getFirstExists(false);
        coin.reset(this.game.world.centerX + this.game.rnd.integerInRange(-100, 100), this.game.world.centerY);
        coin.goldValue = Math.round(this.level * 1.33);
        this.game.time.events.add(Phaser.Timer.SECOND * 3, this.onClickCoin, this, coin);

        this.levelKills++;

        if (this.levelKills >= this.levelKillsRequired) {
            this.level++;
            this.levelKills = 0;
        }

        this.levelText.text = 'Niveau : ' + this.level;
        this.levelKillsText.text = 'Vaccinés: ' + this.levelKills + '/' + this.levelKillsRequired;

        this.currentMonster = this.monsters.getRandom();
        this.currentMonster.maxHealth = Math.ceil(this.currentMonster.details.maxHealth + ((this.level - 1) * 10.6));
        this.currentMonster.revive(this.currentMonster.maxHealth);
    },

    onRevivedMonster: function(monster) {
        monster.position.set(this.game.world.centerX + 0, this.game.world.centerY + 150);
        // update the text display
        this.monsterNameText.text = monster.details.name;
        this.monsterHealthText.text = monster.health + 'Points de crédébilité ';
    },

    onClickMonster: function(monster, pointer) {
        // apply click damage to monster
        this.currentMonster.damage(this.player.clickDmg);

        // grab a damage text from the pool to display what happened
        var dmgText = this.dmgTextPool.getFirstExists(false);
        if (dmgText) {
            dmgText.text = this.player.clickDmg;
            dmgText.reset(pointer.positionDown.x, pointer.positionDown.y);
            dmgText.alpha = 1;
            dmgText.tween.start();
        }

        // update the health text
        this.monsterHealthText.text = this.currentMonster.alive ? this.currentMonster.health + ' Points de crédébilité' : 'DEAD';
    }
});

game.state.start('play');
