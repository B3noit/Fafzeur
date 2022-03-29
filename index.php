<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />




        <title>TheTopRando</title>

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />

        <!-- Font Awesome icons-->
        <script src="https://use.fontawesome.com/releases/v6.0.0/js/all.js" crossorigin="anonymous"></script>

        <!-- Google fonts-->
        <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css" />
        <link href="https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700" rel="stylesheet" type="text/css" />

        <!-- CSS-->
        <link href="css/styles.css" rel="stylesheet" />
    </head>

    <body id="page-top">

        <!-- Navigation-->
        <nav class="navbar navbar-expand-lg navbar-dark fixed-top" id="mainNav">
            <div class="container">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                    Menu
                    <i class="fas fa-bars ms-1"></i>
                </button>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav text-uppercase ms-auto py-4 py-lg-0">
                        <li class="nav-item"><a class="nav-link" href="#whatwedo">What do we do ?</a></li>
                        <li class="nav-item"><a class="nav-link" href="#portfolio">Hikes</a></li>
                        <li class="nav-item"><a class="nav-link" href="#Connect">Login</a></li>
                        <li class="nav-item"><a class="nav-link" href="#contact">Contact</a></li>
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Masthead-->
        <header class="masthead">
            <div class="container">
                <div class="masthead-subheading">Welcome To The Top Rando</div>
                <div class="masthead-heading text-uppercase">Join the bests adventures</div>
                <a class="btn btn-primary btn-xl text-uppercase" href="#whatwedo">Tell Me More</a>
            </div>
        </header>

        <!-- Whatwedo-->
        <section class="page-section" id="whatwedo">
            <div class="container">
                <div class="text-center">
                    <h2 class="section-heading text-uppercase">This is what we do</h2>
                    <h3 class="section-subheading text-muted">We allow everyone to live the bests hikes</h3>
                </div>
                <div class="row text-center">
                    <div class="col-md-4">
                        <span class="fa-stack fa-4x">
                            <i class="fas fa-circle fa-stack-2x text-primary"></i>
                            <i class="fas fa-magnifying-glass-location fa-stack-1x fa-inverse"></i>
                        </span>
                        <h4 class="my-3">We search</h4>
                        <p class="text-muted">Our agents work hard to spot the best place in the world with the most beautiful hikes.</p>
                    </div>
                    <div class="col-md-4">
                        <span class="fa-stack fa-4x">
                            <i class="fas fa-circle fa-stack-2x text-primary"></i>
                            <i class="fas fa-calendar-check fa-stack-1x fa-inverse"></i>
                        </span>
                        <h4 class="my-3">We plan</h4>
                        <p class="text-muted">Then we find the bests guides to help you to take part in our adventures. </p>
                    </div>
                    <div class="col-md-4">
                        <span class="fa-stack fa-4x">
                            <i class="fas fa-circle fa-stack-2x text-primary"></i>
                            <i class="fas fa-tags fa-stack-1x fa-inverse"></i>
                        </span>
                        <h4 class="my-3">We offer</h4>
                        <p class="text-muted">We offer you the choice among our hikes, so you can find the perfect adventure for you.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- ShowRoomHikes Grid-->
        <section class="page-section bg-light" id="portfolio">
            <div class="container">
                <div class="text-center">
                    <h2 class="section-heading text-uppercase">Check our hikes</h2>
                    <h3 class="section-subheading text-muted">For sure you'll find what you need</h3>
                </div>
                <div class="row">
<?php
try
{
    $db = new PDO('mysql:host=localhost;dbname=the_top_rando;charset=utf8', 'root', '');
}
catch(Exception $e)
{
        die('Erreur : '.$e->getMessage());
}
$sqlQuery = 'SELECT * FROM hike';
$hikesStatement = $db->prepare($sqlQuery);
$hikesStatement->execute();
$hikes = $hikesStatement->fetchAll();

foreach ($hikes as $hike) {
?>

    <div class="col-lg-4 col-sm-6 mb-4">
        <div class="portfolio-item">
             <a class="portfolio-link" data-bs-toggle="modal" href="#ShowCaseHikesModal<?php echo $hike['ID'];?>">
                <div class="portfolio-hover">
                    <div class="portfolio-hover-content">
                        <i class="fas fa-plus fa-3x"></i>
                    </div>
                </div>
                <img class="img-fluid" src="assets/img/ShowCaseHikes/<?php echo $hike['NAME'];?>.jpg" alt="..." />
            </a>
            <div class="portfolio-caption">
                <div class="portfolio-caption-heading"><?php echo $hike['NAME'];?></div>
                <div class="portfolio-caption-subheading text-muted"><?php echo $hike['SHORT_DESCRIPTION'];?></div>
            </div>
        </div>
    </div>

<?php
}
?>
                </div>
            </div>
        </section>

        <!-- Connect yourself-->
        <section class="page-section bg-light" id="Connect">
            <div class="container">
                <div class="text-center">
                    <h2 class="section-heading text-uppercase">Connect Yourself</h2>

                    <h3 class="section-subheading text-muted">Are you a hiker or a guide ?</h3>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="team-member">
                            <a href="hikerLogin.php">
                            	<img class="mx-auto rounded-circle" src="assets/img/connect/Hiker.jpg" alt="..." />
                            </a>
                            <h4>Hiker</h4>
                            <a href="hikerLogin.php">
                            	<p class="text-muted">Log in</p>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="team-member">
                        	<a href="guideLogin.php">
                            	<img class="mx-auto rounded-circle" src="assets/img/connect/Guide.jpg" alt="..." />
                            </a>
                            <h4>Guide</h4>
                            <a href="guideLogin.php">
                            	<p class="text-muted">Log in</p>
                            </a>
                        </div>
                    </div>
                    </div>
                </div>	
            </div>
        </section>

        <!-- Contact-->
        <section class="page-section" id="contact">
            <div class="container">
                <div class="text-center">
                    <h2 class="section-heading text-uppercase">Contact Us</h2>
                    <h3 class="section-subheading text-muted">We'll answer you in the shortest delay.</h3>
                </div>

                <!-- This form is pre-integrated with SB Forms.-->
                <!-- To make this form functional, sign up at-->
                <!-- https://startbootstrap.com/solution/contact-forms-->
                <!-- to get an API token!-->
                <form method="POST" id="contactForm" action="https://formsubmit.co/bde8dc2991f06b7a46099b9e798de76f">
                    <!-- Hidden input for formsubmit-->
                    <input type="hidden" name="_subject" value="TheTopRando_Contact"/>
                    <input type="hidden" name="_next" value="http://thetoprando/contactFeedBack.php"/>
                    <input type="hidden" name="_captcha" value="false">


                    <div class="row align-items-stretch mb-5">
                        <div class="col-md-6">
                            <div class="form-group">
                                <!-- Name input-->
                                <input class="form-control" id="name" type="text" placeholder="Your Name *" data-sb-validations="required" />
                                <div class="invalid-feedback" data-sb-feedback="name:required">A name is required.</div>
                            </div>
                            <div class="form-group">
                                <!-- Email address input-->
                                <input class="form-control" name="email" id="email" type="email" placeholder="Your Email *" data-sb-validations="required,email" />
                                <div class="invalid-feedback" data-sb-feedback="email:required">An email is required.</div>
                                <div class="invalid-feedback" data-sb-feedback="email:email">Email is not valid.</div>
                            </div>
                            <div class="form-group mb-md-0">
                                <!-- Phone number input-->
                                <input class="form-control" name="phone" id="phone" type="tel" placeholder="Your Phone *" data-sb-validations="required" />
                                <div class="invalid-feedback" data-sb-feedback="phone:required">A phone number is required.</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group form-group-textarea mb-md-0">
                                <!-- Message input-->
                                <textarea class="form-control" name="message" id="message" placeholder="Your Message *" data-sb-validations="required"></textarea>
                                <div class="invalid-feedback" data-sb-feedback="message:required">A message is required.</div>
                            </div>
                        </div>
                    </div>

                    <div class="d-none" id="submitErrorMessage"><div class="text-center text-danger mb-3">Error sending message!</div></div>
                    <!-- Submit Button-->
                    <div class="text-center">
                        <button  type="submit"  class="btn btn-primary btn-xl text-uppercase" id="submitButton">Send Message</button>
                    </div>
                </form>
            </div>
        </section>

        <!-- Footer-->
        <footer class="footer py-4">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-4 text-lg-start">TheTopRando&copy; 2022</div>
                    <div class="col-lg-4 my-3 my-lg-0">
                        <a class="btn btn-dark btn-social mx-2" href="#!"><i class="fab fa-instagram"></i></a>
                        <a class="btn btn-dark btn-social mx-2" href="#!"><i class="fab fa-facebook-f"></i></a>
                        <a class="btn btn-dark btn-social mx-2" href="#!"><i class="fab fa-twitter"></i></a>
                    </div>
                    <div class="col-lg-4 text-lg-end">
                        <a class="link-dark text-decoration-none me-3" href="#!">Privacy Policy</a>
                        <a class="link-dark text-decoration-none" href="#!">Terms of Use</a>
                    </div>
                </div>
            </div>
        </footer>

<?php
$sqlQuery = 'SELECT * FROM hike';
$hikesStatement = $db->prepare($sqlQuery);
$hikesStatement->execute();
$hikes = $hikesStatement->fetchAll();

foreach ($hikes as $hike) {
    $sqlQuery = 'SELECT ROUND(AVG(PLACES),0)  FROM `adventure` WHERE HIKE = (?)';
    $stmt = $db->prepare($sqlQuery)
    //$stmt->bind_param("s",$hike)
    //$stmt->execute();
    //$adventurePlaces = $stmt->fetchAll();

?>

        <div class="portfolio-modal modal fade" id="ShowCaseHikesModal<?php echo $hike['ID'];?>" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="close-modal" data-bs-dismiss="modal"><img src="assets/img/close-icon.svg" alt="Close modal" /></div>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-8">
                                <div class="modal-body">
                                    <!-- Project details-->
                                    <h2 class="text-uppercase"><?php echo $hike['NAME'];?></h2>
                                    <p class="item-intro text-muted"><?php echo $hike['SHORT_DESCRIPTION'];?></p>
                                    <img class="img-fluid d-block mx-auto" src="assets/img/ShowCaseHikes/<?php echo $hike['NAME'];?>.jpg" alt="..." />
                                    <p><?php echo $hike['DESCRIPTION'];?></p>
                                    <ul class="list-inline">
                                        <li>
                                            <strong>PLaces available:</strong>
                                            $adventurePlaces
                                        </li>
                                        <li>
                                            <strong>Date:</strong>
                                            03-28-2021 to 04-01-2021
                                        </li>
                                        <li>
                                            <strong>Price:</strong>
                                            600$
                                        </li>
                                        <li>
                                            <strong>Difficulty:</strong>
                                            Hardcore
                                        </li>
                                    </ul>
                                    <button class="btn btn-primary btn-xl text-uppercase" data-bs-dismiss="modal" type="button">
                                        <i class="fas fa-times me-1"></i>
                                        Close
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

<?php
}
?>


        <!-- ShowCaseHikes Modals-->
        <!-- ShowCaseHikes item 1 modal popup-->
        <div class="portfolio-modal modal fade" id="ShowCaseHikesModal1" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="close-modal" data-bs-dismiss="modal"><img src="assets/img/close-icon.svg" alt="Close modal" /></div>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-8">
                                <div class="modal-body">
                                    <!-- Project details-->
                                    <h2 class="text-uppercase">Himalaya</h2>
                                    <p class="item-intro text-muted">Short description</p>
                                    <img class="img-fluid d-block mx-auto" src="assets/img/ShowCaseHikes/Himalaya.jpg" alt="..." />
                                    <p>Description</p>
                                    <ul class="list-inline">
                                        <li>
                                            <strong>PLaces available:</strong>
                                            10
                                        </li>
                                        <li>
                                            <strong>Date:</strong>
                                            03-28-2021 to 04-01-2021
                                        </li>
                                        <li>
                                        	<strong>Price:</strong>
                                            600$
                                        </li>
                                        <li>
                                            <strong>Difficulty:</strong>
                                            Hardcore
                                        </li>
                                    </ul>
                                    <button class="btn btn-primary btn-xl text-uppercase" data-bs-dismiss="modal" type="button">
                                        <i class="fas fa-times me-1"></i>
                                        Close
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- ShowCaseHikes item 2 modal popup-->
        <div class="portfolio-modal modal fade" id="ShowCaseHikesModal2" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="close-modal" data-bs-dismiss="modal"><img src="assets/img/close-icon.svg" alt="Close modal" /></div>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-8">
                                <div class="modal-body">
                                    <!-- Project details-->
                                    <h2 class="text-uppercase">Alps</h2>
                                    <p class="item-intro text-muted">Short description</p>
                                    <img class="img-fluid d-block mx-auto" src="assets/img/ShowCaseHikes/Alps.jpg" alt="..." />
                                    <p>Description</p>
                                    <ul class="list-inline">
                                        <li>
                                            <strong>PLaces available:</strong>
                                            20
                                        </li>
                                        <li>
                                            <strong>Date:</strong>
                                            03-28-2021 to 04-01-2021
                                        </li>
                                        <li>
                                        	<strong>Price:</strong>
                                            600$
                                        </li>
                                        <li>
                                            <strong>Difficulty:</strong>
                                            Medium
                                        </li>
                                    </ul>
                                    <button class="btn btn-primary btn-xl text-uppercase" data-bs-dismiss="modal" type="button">
                                        <i class="fas fa-times me-1"></i>
                                        Close
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- ShowCaseHikes item 3 modal popup-->
        <div class="portfolio-modal modal fade" id="ShowCaseHikesModal3" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="close-modal" data-bs-dismiss="modal"><img src="assets/img/close-icon.svg" alt="Close modal" /></div>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-8">
                                <div class="modal-body">
                                    <!-- Project details-->
                                    <h2 class="text-uppercase">Death Valley</h2>
                                    <p class="item-intro text-muted">Short description</p>
                                    <img class="img-fluid d-block mx-auto" src="assets/img/ShowCaseHikes/DeathValley.jpg" alt="..." />
                                    <p>Description</p>
                                    <ul class="list-inline">
                                        <li>
                                            <strong>PLaces available:</strong>
                                            20
                                        </li>
                                        <li>
                                            <strong>Date:</strong>
                                            03-28-2021 to 04-01-2021
                                        </li>
                                        <li>
                                        	<strong>Price:</strong>
                                            600$
                                        </li>
                                        <li>
                                            <strong>Difficulty:</strong>
                                            Low
                                        </li>
                                    </ul>
                                    <button class="btn btn-primary btn-xl text-uppercase" data-bs-dismiss="modal" type="button">
                                        <i class="fas fa-times me-1"></i>
                                        Close
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- ShowCaseHikes item 4 modal popup-->
        <div class="portfolio-modal modal fade" id="ShowCaseHikesModal4" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="close-modal" data-bs-dismiss="modal"><img src="assets/img/close-icon.svg" alt="Close modal" /></div>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-8">
                                <div class="modal-body">
                                    <!-- Project details-->
                                    <h2 class="text-uppercase">Great Canyon</h2>
                                    <p class="item-intro text-muted">Short description</p>
                                    <img class="img-fluid d-block mx-auto" src="assets/img/ShowCaseHikes/GreatCanyon.jpg" alt="..." />
                                    <p>Description</p>
                                    <ul class="list-inline">
                                        <li>
                                            <strong>PLaces available:</strong>
                                            16
                                        </li>
                                        <li>
                                            <strong>Date:</strong>
                                            03-28-2021 to 04-01-2021
                                        </li>
                                        <li>
                                        	<strong>Price:</strong>
                                            600$
                                        </li>
                                        <li>
                                            <strong>Diificulty</strong>
                                            Difficult
                                        </li>
                                    </ul>
                                    <button class="btn btn-primary btn-xl text-uppercase" data-bs-dismiss="modal" type="button">
                                        <i class="fas fa-times me-1"></i>
                                        Close
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- ShowCaseHikes item 5 modal popup-->
        <div class="portfolio-modal modal fade" id="ShowCaseHikesModal5" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="close-modal" data-bs-dismiss="modal"><img src="assets/img/close-icon.svg" alt="Close modal" /></div>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-8">
                                <div class="modal-body">
                                    <!-- Project details-->
                                    <h2 class="text-uppercase">Zion</h2>
                                    <p class="item-intro text-muted">Short description</p>
                                    <img class="img-fluid d-block mx-auto" src="assets/img/ShowCaseHikes/Zion.jpg" alt="..." />
                                    <p>Description</p>
                                    <ul class="list-inline">
                                        <li>
                                            <strong>PLaces available:</strong>
                                            20
                                        </li>
                                        <li>
                                            <strong>Date:</strong>
                                            03-28-2021 to 04-01-2021
                                        </li>
                                        <li>
                                        	<strong>Price:</strong>
                                            600$
                                        </li>
                                        <li>
                                            <strong>Difficulty:</strong>
                                            Very low
                                        </li>
                                    </ul>
                                    <button class="btn btn-primary btn-xl text-uppercase" data-bs-dismiss="modal" type="button">
                                        <i class="fas fa-times me-1"></i>
                                        Close
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- ShowCaseHikes item 6 modal popup-->
        <div class="portfolio-modal modal fade" id="ShowCaseHikesModal6" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="close-modal" data-bs-dismiss="modal"><img src="assets/img/close-icon.svg" alt="Close modal" /></div>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-8">
                                <div class="modal-body">
                                    <!-- Project details-->
                                    <h2 class="text-uppercase">Andes Cordillera</h2>
                                    <p class="item-intro text-muted">Short description</p>
                                    <img class="img-fluid d-block mx-auto" src="assets/img/ShowCaseHikes/AndesCordilla.jpg" alt="..." />
                                    <p>Description</p>
                                    <ul class="list-inline">
                                        <li>
                                            <strong>PLaces available:</strong>
                                            12
                                        </li>
                                        <li>
                                            <strong>Date:</strong>
                                            03-28-2021 to 04-01-2021
                                        </li>
                                        <li>
                                        	<strong>Price:</strong>
                                            600$
                                        </li>
                                        <li>
                                            <strong>Difficulty:</strong>
                                            Hard
                                        </li>
                                    </ul>
                                    <button class="btn btn-primary btn-xl text-uppercase" data-bs-dismiss="modal" type="button">
                                        <i class="fas fa-times me-1"></i>
                                        Close
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
        <!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *-->
        <!-- * *                               SB Forms JS                               * *-->
        <!-- * * Activate your form at https://startbootstrap.com/solution/contact-forms * *-->
        <!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *-->
        <script src="https://cdn.startbootstrap.com/sb-forms-latest.js"></script>
    </body>
</html>