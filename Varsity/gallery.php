<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Character set and compatibility settings -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Page title -->
    <title>Varsity | Gallery</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="assets/img/favicon.ico" type="image/x-icon">

    <!-- Font Awesome styles -->
    <link href="assets/css/font-awesome.css" rel="stylesheet">

    <!-- Bootstrap styles -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">

    <!-- Slick slider styles -->
    <link rel="stylesheet" type="text/css" href="assets/css/slick.css">

    <!-- Fancybox slider styles -->
    <link rel="stylesheet" href="assets/css/jquery.fancybox.css" type="text/css" media="screen"/>

    <!-- Theme color styles -->
    <link id="switcher" href="assets/css/theme-color/default-theme.css" rel="stylesheet">

    <!-- Main stylesheet -->
    <link href="assets/css/style.css" rel="stylesheet">

    <!-- Google Fonts -->
    <link href='https://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,400italic,300,300italic,500,700' rel='stylesheet'
          type='text/css'>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <-- HTML5 shim -->
    <script src="https://github.com/aFarkas/html5shiv/blob/master/dist/html5shiv.min.js"></script>
    <!-- Respond.js for IE8 support -->
    <script src="https://github.com/scottjehl/Respond/blob/master/dest/respond.min.js"></script>
    <!--    <![endif]-->
</head>

<body>
<!-- Scroll Top Button -->
<a class="scrollToTop" href="#">
    <!-- Up arrow icon -->
    <i class="fa fa-angle-up"></i>
</a>
<!-- End Scroll Top Button -->

<!-- Start header -->
<header id="mu-header">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="mu-header-area">
                    <div class="row">
                        <!-- Header top-left section -->
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                            <div class="mu-header-top-left">
                                <!-- Email information -->
                                <div class="mu-top-email">
                                    <i class="fa fa-envelope"></i>
                                    <span>amirhosseinBoro@markups.io</span>
                                </div>
                                <!-- Phone information -->
                                <div class="mu-top-phone">
                                    <i class="fa fa-phone"></i>
                                    <span>+98 913 554 7889</span>
                                </div>
                            </div>
                        </div>
                        <!-- Header top-right section -->
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                            <div class="mu-header-top-right">
                                <!-- Navigation with social icons -->
                                <nav>
                                    <ul class="mu-top-social-nav">
                                        <li><a href="https://facebook.com/social_user_varsity"><span
                                                        class="fa fa-facebook"></span></a></li>
                                        <li><a href="https://twitter.com/@social_user_varsity"><span
                                                        class="fa fa-twitter"></span></a></li>
                                        <li><a href="https://google-plus.com/@social_user_varsity"><span
                                                        class="fa fa-google-plus"></span></a></li>
                                        <li><a href="https://linkedin.com/user/social_user_varsity"><span
                                                        class="fa fa-linkedin"></span></a></li>
                                        <li><a href="https://youtube.com/@social_user_varsity"><span
                                                        class="fa fa-youtube"></span></a></li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- End header -->

<!-- Start menu -->
<section id="mu-menu">
    <nav class="navbar navbar-default" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <!-- Mobile view collapsed button for navigation -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
                        aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <!-- Logo -->
                <!-- Text-based logo -->
                <a class="navbar-brand" href="index.php"><i class="fa fa-university"></i><span>Varsity</span></a>
                <!-- Image-based logo -->
                <!-- <a class="navbar-brand" href="index.php"><img src="assets/img/logo.png" alt="logo"></a> -->
            </div>
            <div id="navbar" class="navbar-collapse collapse">
                <ul id="top-menu" class="nav navbar-nav navbar-right main-nav">
                    <!-- Menu items -->
                    <li><a href="index.php">Home</a></li>
                    <li><a href="course.php">Course Archive</a></li>
                    <li><a href="gallery.php">Gallery</a></li>
                    <li><a href="blog.php">Blog Archive</a></li>
                    <li><a href="contact.php">Contact</a></li>
                    <li><a href="#" id="mu-search-icon"><i class="fa fa-search"></i></a></li>
                </ul>
            </div><!--/.nav-collapse -->
        </div>
    </nav>
</section>
<!-- End menu -->

<!-- Start search box -->
<div id="mu-search">
    <div class="mu-search-area">
        <!-- Close button for search box -->
        <button class="mu-search-close"><span class="fa fa-close"></span></button>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <form action="search.php" method="post" class="mu-search-form">
                        <!-- Input field for search with placeholder text -->
                        <input type="search" name="search_text" placeholder="Type Your Keyword(s) & Hit Enter" required>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End search box -->

<!-- Page breadcrumb -->
<section id="mu-page-breadcrumb">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="mu-page-breadcrumb-area">
                    <!-- Heading for the breadcrumb section -->
                    <h2>Gallery</h2>
                    <!-- Breadcrumb navigation links -->
                    <ol class="breadcrumb">
                        <li>Home</li>
                        <li class="active">Gallery</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End breadcrumb -->

<!-- Start gallery  -->
<section id="mu-gallery">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="mu-gallery-area">
                    <!-- start title -->
                    <div class="mu-title">
                        <h2>Some Moments</h2>
                        <p>
                            Savor the essence of our educational journey through the captivating lens of 'Some Moments'
                            in our gallery. Each frame encapsulates the vibrant learning experiences, shared
                            accomplishments, and cherished memories that define our educational community. Explore the
                            mosaic of moments that shape our vibrant and dynamic learning environment.
                        </p>
                    </div>
                    <!-- end title -->
                    <!-- start gallery content -->
                    <div class="mu-gallery-content">
                        <!-- Start gallery menu -->
                        <div class="mu-gallery-top">
                            <ul>
                                <li class="filter active" data-filter="all">All</li>
                                <li class="filter" data-filter=".lab">Lab</li>
                                <li class="filter" data-filter=".classroom">Class Room</li>
                                <li class="filter" data-filter=".library">Library</li>
                                <li class="filter" data-filter=".cafe">Cafe</li>
                                <li class="filter" data-filter=".others">Others</li>
                            </ul>
                        </div>
                        <!-- End gallery menu -->
                        <div class="mu-gallery-body">
                            <ul id="mixit-container" class="row">
                                <!-- start single gallery image -->
                                <li class="col-md-4 col-sm-6 col-xs-12 mix lab">
                                    <div class="mu-single-gallery">
                                        <div class="mu-single-gallery-item">
                                            <div class="mu-single-gallery-img">
                                                <a href="#"><img alt="img" src="assets/img/gallery/small/1.jpg"></a>
                                            </div>
                                            <div class="mu-single-gallery-info">
                                                <div class="mu-single-gallery-info-inner">
                                                    <h4>Image Title</h4>
                                                    <p>Web Design</p>
                                                    <a href="assets/img/gallery/big/1.jpg" data-fancybox-group="gallery"
                                                       class="fancybox"><span class="fa fa-eye"></span></a>
                                                    <a href="#" class="aa-link"><span class="fa fa-link"></span></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <!-- start single gallery image -->
                                <li class="col-md-4 col-sm-6 col-xs-12 mix library">
                                    <div class="mu-single-gallery">
                                        <div class="mu-single-gallery-item">
                                            <div class="mu-single-gallery-img">
                                                <a href="#"><img alt="img" src="assets/img/gallery/small/2.jpg"></a>
                                            </div>
                                            <div class="mu-single-gallery-info">
                                                <div class="mu-single-gallery-info-inner">
                                                    <h4>Image Title</h4>
                                                    <p>Animation</p>
                                                    <a href="assets/img/gallery/big/2.jpg" data-fancybox-group="gallery"
                                                       class="fancybox"><span class="fa fa-eye"></span></a>
                                                    <a href="#" class="aa-link"><span class="fa fa-link"></span></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <!-- start single gallery image -->
                                <li class="col-md-4 col-sm-6 col-xs-12 mix lab">
                                    <div class="mu-single-gallery">
                                        <div class="mu-single-gallery-item">
                                            <div class="mu-single-gallery-img">
                                                <a href="#"><img alt="img" src="assets/img/gallery/small/3.jpg"></a>
                                            </div>
                                            <div class="mu-single-gallery-info">
                                                <div class="mu-single-gallery-info-inner">
                                                    <h4>Image Title</h4>
                                                    <p>Math</p>
                                                    <a href="assets/img/gallery/big/3.jpg" data-fancybox-group="gallery"
                                                       class="fancybox"><span class="fa fa-eye"></span></a>
                                                    <a href="#" class="aa-link"><span class="fa fa-link"></span></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <!-- start single gallery image -->
                                <li class="col-md-4 col-sm-6 col-xs-12 mix classroom">
                                    <div class="mu-single-gallery">
                                        <div class="mu-single-gallery-item">
                                            <div class="mu-single-gallery-img">
                                                <a href="#"><img alt="img" src="assets/img/gallery/small/4.jpg"></a>
                                            </div>
                                            <div class="mu-single-gallery-info">
                                                <div class="mu-single-gallery-info-inner">
                                                    <h4>Image Title</h4>
                                                    <p>English</p>
                                                    <a href="assets/img/gallery/big/4.jpg" data-fancybox-group="gallery"
                                                       class="fancybox"><span class="fa fa-eye"></span></a>
                                                    <a href="#" class="aa-link"><span class="fa fa-link"></span></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <!-- start single gallery image -->
                                <li class="col-md-4 col-sm-6 col-xs-12 mix others">
                                    <div class="mu-single-gallery">
                                        <div class="mu-single-gallery-item">
                                            <div class="mu-single-gallery-img">
                                                <a href="#"><img alt="img" src="assets/img/gallery/small/5.jpg"></a>
                                            </div>
                                            <div class="mu-single-gallery-info">
                                                <div class="mu-single-gallery-info-inner">
                                                    <h4>Image Title</h4>
                                                    <p>Graphics</p>
                                                    <a href="assets/img/gallery/big/5.jpg" data-fancybox-group="gallery"
                                                       class="fancybox"><span class="fa fa-eye"></span></a>
                                                    <a href="#" class="aa-link"><span class="fa fa-link"></span></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <!-- start single gallery image -->
                                <li class="col-md-4 col-sm-6 col-xs-12 mix cafe">
                                    <div class="mu-single-gallery">
                                        <div class="mu-single-gallery-item">
                                            <div class="mu-single-gallery-img">
                                                <a href="#"><img alt="img" src="assets/img/gallery/small/6.jpg"></a>
                                            </div>
                                            <div class="mu-single-gallery-info">
                                                <div class="mu-single-gallery-info-inner">
                                                    <h4>Image Title</h4>
                                                    <p>Health</p>
                                                    <a href="assets/img/gallery/big/6.jpg" data-fancybox-group="gallery"
                                                       class="fancybox"><span class="fa fa-eye"></span></a>
                                                    <a href="#" class="aa-link"><span class="fa fa-link"></span></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <!-- start single gallery image -->
                                <li class="col-md-4 col-sm-6 col-xs-12 mix others">
                                    <div class="mu-single-gallery">
                                        <div class="mu-single-gallery-item">
                                            <div class="mu-single-gallery-img">
                                                <a href="#"><img alt="img" src="assets/img/gallery/small/7.jpg"></a>
                                            </div>
                                            <div class="mu-single-gallery-info">
                                                <div class="mu-single-gallery-info-inner">
                                                    <h4>Image Title</h4>
                                                    <p>Sports</p>
                                                    <a href="assets/img/gallery/big/7.jpg" data-fancybox-group="gallery"
                                                       class="fancybox"><span class="fa fa-eye"></span></a>
                                                    <a href="#" class="aa-link"><span class="fa fa-link"></span></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <!-- start single gallery image -->
                                <li class="col-md-4 col-sm-6 col-xs-12 mix library">
                                    <div class="mu-single-gallery">
                                        <div class="mu-single-gallery-item">
                                            <div class="mu-single-gallery-img">
                                                <a href="#"><img alt="img" src="assets/img/gallery/small/8.jpg"></a>
                                            </div>
                                            <div class="mu-single-gallery-info">
                                                <div class="mu-single-gallery-info-inner">
                                                    <h4>Image Title</h4>
                                                    <p>Health</p>
                                                    <a href="assets/img/gallery/big/8.jpg" data-fancybox-group="gallery"
                                                       class="fancybox"><span class="fa fa-eye"></span></a>
                                                    <a href="#" class="aa-link"><span class="fa fa-link"></span></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <!-- start single gallery image -->
                                <li class="col-md-4 col-sm-6 col-xs-12 mix lab">
                                    <div class="mu-single-gallery">
                                        <div class="mu-single-gallery-item">
                                            <div class="mu-single-gallery-img">
                                                <a href="#"><img alt="img" src="assets/img/gallery/small/9.jpg"></a>
                                            </div>
                                            <div class="mu-single-gallery-info">
                                                <div class="mu-single-gallery-info-inner">
                                                    <h4>Image Title</h4>
                                                    <p>Sports</p>
                                                    <a href="assets/img/gallery/big/9.jpg" data-fancybox-group="gallery"
                                                       class="fancybox"><span class="fa fa-eye"></span></a>
                                                    <a href="#" class="aa-link"><span class="fa fa-link"></span></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!-- end gallery content -->
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End gallery  -->

<!-- Start footer -->
<footer id="mu-footer">
    <!-- start footer top -->
    <div class="mu-footer-top">
        <div class="container">
            <div class="mu-footer-top-area">
                <div class="row">
                    <!-- Information Section -->
                    <div class="col-lg-3 col-md-3 col-sm-3">
                        <div class="mu-footer-widget">
                            <h4>Usefully Pages</h4>
                            <ul>
                                <li><a href="blog.php">Blog Archive</a></li>
                                <li><a href="course.php">Courses</a></li>
                                <li><a href="gallery.php">Gallery</a></li>
                            </ul>
                        </div>
                    </div>
                    <!-- Student Help Section -->
                    <div class="col-lg-3 col-md-3 col-sm-3">
                        <div class="mu-footer-widget">
                            <h4>Student Help (Not Ready)</h4>
                            <ul>
                                <li><a href="404.php">Get Started</a></li>
                                <li><a href="404.php">My Questions</a></li>
                                <li><a href="404.php">Download Files</a></li>
                                <li><a href="404.php">Latest Course</a></li>
                                <li><a href="404.php">Academic News</a></li>
                            </ul>
                        </div>
                    </div>
                    <!-- Contact Section -->
                    <div class="col-lg-3 col-md-3 col-sm-3">
                        <div class="mu-footer-widget">
                            <h4>Contact</h4>
                            <address>
                                <p>Chaharmahal and Bakhtiari Province, Shahrekord، University, Rahbar Blvd، 9R3G+3C3,
                                    Iran</p>
                                <p>Phone: +98 913 554 7889 </p>
                                <p>Website: www.markups.io</p>
                                <p>Email: amirhosseinBoro@markups.io</p>
                            </address>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end footer top -->
    <!-- start footer bottom -->
    <div class="mu-footer-bottom">
        <div class="container">
            <div class="mu-footer-bottom-area">
                <p>&copy; All Right Reserved. Designed by <a href="http://www.markups.io/" rel="nofollow">MarkUps.io</a>
                </p>
            </div>
        </div>
    </div>
    <!-- end footer bottom -->
</footer>
<!-- End footer -->

<!-- jQuery library -->
<script src="assets/js/jquery.min.js"></script>

<!-- Bootstrap JavaScript -->
<script src="assets/js/bootstrap.js"></script>

<!-- Slick slider -->
<script type="text/javascript" src="assets/js/slick.js"></script>

<!-- Counter -->
<script type="text/javascript" src="assets/js/waypoints.js"></script>
<script type="text/javascript" src="assets/js/jquery.counterup.js"></script>

<!-- Mixit slider -->
<script type="text/javascript" src="assets/js/jquery.mixitup.js"></script>

<!-- Add fancyBox -->
<script type="text/javascript" src="assets/js/jquery.fancybox.pack.js"></script>

<!-- Custom JavaScript -->
<script src="assets/js/custom.js"></script>
</body>
</html>