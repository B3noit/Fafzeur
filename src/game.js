var game = new Phaser.Game(450, 800, Phaser.AUTO, '');
game.state.add('play', {
    preload: function() {
        game.load.image('micron', 'assets/micron.png');
    },
    create: function() {
        var micronSprite = game.add.sprite(210, 120, 'micron');
        micronSprite.anchor.setTo(0.5, 0.5);
    },
    render: function() {
        game.debug.text('Vite ta dose, vite !', 130, 290);
    }
});
game.state.start('play');