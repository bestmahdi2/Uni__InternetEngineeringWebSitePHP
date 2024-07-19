<?php
// Start a new session
session_start();

// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$database = "varsity";
$category_name = "";

try {
    // Create a new PDO instance
    $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if the value is set in the URL
    if (isset($_GET['cat'])) {
        // Retrieve the value from the URL
        $receivedValue = $_GET['cat'];

        // Prepare SQL query to fetch courses with the number of comments
        $stmt = $conn->prepare("SELECT b.*, cat.name AS category_name, COALESCE(comment_counts.num_comments, 0) AS num_comments
                                        FROM Blogs b
                                        JOIN Categories cat ON b.category_id = cat.category_id
                                        LEFT JOIN (
                                            SELECT blog_id, COUNT(*) AS num_comments
                                            FROM Comments
                                            GROUP BY blog_id
                                        ) comment_counts ON b.blog_id = comment_counts.blog_id
                                        WHERE b.category_id = :receivedValue;");
        $stmt->bindParam(':receivedValue', $receivedValue);

        // Prepare SQL query to fetch category name
        $stmt2 = $conn->prepare("SELECT * FROM Categories WHERE category_id = :receivedValue");
        $stmt2->bindParam(':receivedValue', $receivedValue);
        $stmt2->execute();
        $categories = $stmt2->fetchAll(PDO::FETCH_ASSOC);

        // Set the category name if it exists
        if (!empty($categories))
            $category_name = $categories[0]["name"];

    } else {
        // Prepare and execute the SQL query to fetch all courses with the number of students
        $stmt = $conn->prepare("SELECT b.*, cat.name AS category_name, COALESCE(comment_counts.num_comments, 0) AS num_comments
                                    FROM Blogs b
                                    JOIN Categories cat ON b.category_id = cat.category_id
                                    LEFT JOIN (
                                        SELECT blog_id, COUNT(*) AS num_comments
                                        FROM Comments
                                        GROUP BY blog_id
                                    ) comment_counts ON b.blog_id = comment_counts.blog_id;");
    }

    // Execute the prepared statement
    $stmt->execute();

    // Fetch all rows as associative arrays
    $blogs = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Prepare and execute the SQL query to fetch top courses
    $stmt = $conn->prepare("SELECT b.*, COUNT(c.comment_id) AS comment_count
                                FROM Blogs b
                                LEFT JOIN Comments c ON b.blog_id = c.blog_id
                                GROUP BY b.blog_id, b.title
                                ORDER BY comment_count DESC
                                LIMIT 3;");
    $stmt->execute();

    // Fetch all rows as associative arrays
    $topBlogs = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    // Display an error message if an exception occurs
    echo "Error: " . $e->getMessage();
}

// Close the database connection
$conn = null;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Character set and compatibility settings -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Page title -->
    <title>Varsity | 404</title>

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
                    <h2><?php echo $category_name; ?> Blogs</h2>
                    <!-- Breadcrumb navigation links -->
                    <ol class="breadcrumb">
                        <li>Home</li>
                        <li class="active">Blogs</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End breadcrumb -->

<section id="mu-course-content">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="mu-course-content-area">
                    <div class="row">
                        <div class="col-md-9">
                            <!-- start blog content container -->
                            <div class="mu-course-container mu-blog-archive">
                                <div class="row">
                                    <?php foreach ($blogs as $blog): ?>
                                        <div class="col-md-6 col-sm-6">
                                            <article class="mu-blog-single-item">
                                                <figure class="mu-blog-single-img">
                                                    <a href="blog-detail.php?id=<?php echo $blog['blog_id']; ?>"><img
                                                                src="assets/img/blogs/cover_<?php echo $blog['photo_address']; ?>"
                                                                alt="img"></a>
                                                    <figcaption class="mu-blog-caption">
                                                        <h3>
                                                            <a href="blog-detail.php?id=<?php echo $blog['blog_id']; ?>"><?php echo $blog['title']; ?></a>
                                                        </h3>
                                                    </figcaption>
                                                </figure>
                                                <div class="mu-blog-meta">
                                                    <a>By Admin</a>
                                                    <a><?php echo $blog['post_date']; ?></a>
                                                    <span><i class="fa fa-comments-o"></i><?php echo $blog['num_comments']; ?></span>
                                                </div>
                                                <div class="mu-blog-description">
                                                    <p><?php echo $blog['summary']; ?></p>
                                                    <a class="mu-read-more-btn"
                                                       href="blog-detail.php?id=<?php echo $blog['blog_id']; ?>">Read
                                                        More</a>
                                                </div>
                                            </article>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                            <!-- end bloh content container -->
                        </div>
                        <div class="col-md-3">
                            <!-- start sidebar -->
                            <aside class="mu-sidebar">
                                <!-- start single sidebar -->
                                <div class="mu-single-sidebar">
                                    <h3>Categories</h3>
                                    <ul class="mu-sidebar-catg">
                                        <li><a href="blog.php?cat=1">English</a></li>
                                        <li><a href="blog.php?cat=2">Chemistry</a></li>
                                        <li><a href="blog.php?cat=3">Physics</a></li>
                                        <li><a href="blog.php?cat=4">Math</a></li>
                                        <li><a href="blog.php?cat=5">Web Design</a></li>
                                        <li><a href="blog.php?cat=6">Web Development</a></li>
                                    </ul>
                                </div>
                                <!-- end single sidebar -->
                                <!-- start single sidebar -->
                                <div class="mu-single-sidebar">
                                    <h3>Popular News</h3>
                                    <div class="mu-sidebar-popular-courses">
                                        <?php foreach ($topBlogs as $blog): ?>
                                            <div class="media">
                                                <div class="media-left">
                                                    <a href="blog-detail.php?id=<?php echo $blog['blog_id']; ?>">
                                                        <img class="media-object"
                                                             src="assets/img/blogs/popular_<?php echo $blog['photo_address']; ?>"
                                                             alt="img">
                                                    </a>
                                                </div>
                                                <div class="media-body">
                                                    <h4 class="media-heading"><a
                                                                href="blog-detail.php?id=<?php echo $blog['blog_id']; ?>"><?php echo $blog['title']; ?></a>
                                                    </h4>
                                                    <span class="popular-course-price"><?php echo $blog['post_date']; ?></span>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                                <!-- end single sidebar -->
                                <!-- start single sidebar -->
                                <div class="mu-single-sidebar">
                                    <h3>Tags Cloud</h3>
                                    <div class="tag-cloud">
                                        <a href="search.php?search=Health">Health</a>
                                        <a href="search.php?search=Science">Science</a>
                                        <a href="search.php?search=Sports">Sports</a>
                                        <a href="search.php?search=Mathematics">Mathematics</a>
                                        <a href="search.php?search=Web">Web Design</a>
                                        <a href="search.php?search=History">History</a>
                                        <a href="search.php?search=Environment">Environment</a>
                                    </div>
                                </div>
                                <!-- end single sidebar -->
                            </aside>
                            <!-- / end sidebar -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

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