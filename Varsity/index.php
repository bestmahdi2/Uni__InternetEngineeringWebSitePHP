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

    // Prepare and execute the SQL query to fetch all courses with the number of students
    $stmt = $conn->prepare("SELECT (SELECT COUNT(*) FROM Users WHERE user_type = 'Student') AS number_of_students,
                                    (SELECT COUNT(*) FROM Users WHERE user_type = 'Teacher') AS number_of_teachers,
                                    COUNT(*) AS number_of_courses
                                FROM Courses;");

    // Execute the prepared statement
    $stmt->execute();

    // Fetch all rows as associative arrays
    $numbers = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Prepare and execute the SQL query to fetch top courses
    $stmt = $conn->prepare("SELECT c.*, Teachers.user_id, Users.full_name AS teacher_name, cat.name AS category_name
                        FROM Courses c
                        JOIN Categories cat ON c.category_id = cat.category_id
                        INNER JOIN Teachers ON c.teacher_id = Teachers.teacher_id
                        INNER JOIN Users ON Teachers.user_id = Users.user_id
                        ORDER BY c.title DESC
                        LIMIT 5;");
    $stmt->execute();

    // Fetch all rows as associative arrays
    $topCourses = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Prepare and execute the SQL query to fetch top courses
    $stmt = $conn->prepare("SELECT b.*, cat.name AS category_name, COALESCE(comment_counts.num_comments, 0) AS num_comments
                                    FROM Blogs b
                                    JOIN Categories cat ON b.category_id = cat.category_id
                                    LEFT JOIN (
                                        SELECT blog_id, COUNT(*) AS num_comments
                                        FROM Comments
                                        GROUP BY blog_id
                                    ) comment_counts ON b.blog_id = comment_counts.blog_id
                                    LIMIT 2;");
    $stmt->execute();

    // Fetch all rows as associative arrays
    $topBlogs = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Prepare and execute the SQL query to fetch top courses
    $stmt = $conn->prepare("SELECT u.full_name AS teacher_name, t.specialization, t.bio, u.photo_address AS photo_address
                                    FROM Teachers t
                                    JOIN Users u ON t.user_id = u.user_id;");
    $stmt->execute();

    // Fetch all rows as associative arrays
    $teachers = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
    <title>Varsity | HOME</title>

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

<!-- Start Slider -->
<section id="mu-slider">
    <!-- Start single slider item -->
    <div class="mu-slider-single">
        <div class="mu-slider-img">
            <figure>
                <img src="assets/img/slider/1.jpg" alt="img">
            </figure>
        </div>
        <div class="mu-slider-content">
            <h4>Welcome To Varsity</h4>
            <span></span>
            <h2>We Will Help You To Learn</h2>
            <p>where the pursuit of knowledge is more than just a journey. At Varsity, we go beyond teaching; we empower
                you
                to learn, grow, and thrive. Let's embark on this educational voyage together, as we guide you towards a
                future filled with endless possibilities. Join us at Varsity, and let the journey of learning
                unfold!</p>
            <a href="course.php" class="mu-read-more-btn">Find Your Course</a>
        </div>
    </div>

    <!-- Start single slider item -->
    <div class="mu-slider-single">
        <div class="mu-slider-img">
            <figure>
                <img src="assets/img/slider/2.jpg" alt="img">
            </figure>
        </div>
        <div class="mu-slider-content">
            <h4>Premium Quality Free Template</h4>
            <span></span>
            <h2>Best Education Template Ever</h2>
            <p>Our platform boasts the most advanced and user-friendly educational template, offering a seamless and
                enjoyable learning experience.</p>
            <a href="#" class="mu-read-more-btn">Find Your Course</a>
        </div>
    </div>
    <!-- Start single slider item -->
    <div class="mu-slider-single">
        <div class="mu-slider-img">
            <figure>
                <img src="assets/img/slider/3.jpg" alt="img">
            </figure>
        </div>
        <div class="mu-slider-content">
            <h4>Exclusively For Education</h4>
            <span></span>
            <h2>Education For Everyone</h2>
            <p>Tailored specifically for the realm of education, our platform is designed to meet the unique needs of
                learners, educators, and institutions alike.</p>
            <a href="#" class="mu-read-more-btn">Find Your Course</a>
        </div>
    </div>
</section>
<!-- End Slider -->

<!-- Start service  -->
<section id="mu-service">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="mu-service-area">
                    <!-- Start single service -->
                    <div class="mu-service-single">
                        <span class="fa fa-book"></span>
                        <h3>Learn Online</h3>
                        <p>Explore a world of knowledge from the comfort of your home. Our online platform offers an
                            immersive and flexible learning environment tailored to your needs.</p>
                    </div>
                    <!-- Start single service -->
                    <div class="mu-service-single">
                        <span class="fa fa-users"></span>
                        <h3>Expert Teachers</h3>
                        <p>Join our community of dedicated and experienced educators who are committed to guiding you on
                            your educational journey. Benefit from their expertise and personalized support to achieve
                            your academic goals.</p>
                    </div>
                    <!-- Start single service -->
                    <div class="mu-service-single">
                        <span class="fa fa-table"></span>
                        <h3>Best Classrooms</h3>
                        <p>Experience top-notch virtual classrooms that foster collaboration and engagement. Our
                            innovative learning spaces transcend physical boundaries, providing you with the best tools
                            and resources for a dynamic educational experience</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End service  -->

<!-- Start about us -->
<section id="mu-about-us">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="mu-about-us-area">
                    <div class="row">
                        <div class="col-lg-6 col-md-6">
                            <div class="mu-about-us-left">
                                <!-- Start Title -->
                                <div class="mu-title">
                                    <h2>About Us</h2>
                                </div>
                                <!-- End Title -->
                                <p>Welcome to [Your Educational Platform] - where innovation meets education. As a
                                    pioneering force in the realm of online learning, we take pride in offering a
                                    transformative educational experience. Here's why we stand out:
                                <ul>
                                    <li>Cutting-Edge Learning Technology</li>
                                    <li>World-Class Teachers</li>
                                    <li>Interactive Classrooms</li>
                                    <li>24/7 Access</li>
                                    <li>Global Community</li>
                                </ul>
                                <p>Receive real-time assessments and feedback, gauging your progress and identifying
                                    areas for improvement to enhance your overall learning experience!</p>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="mu-about-us-right">
                                <a id="mu-abtus-video" href="https://www.youtube.com/embed/HN3pm9qYAUs"
                                   target="mutube-video">
                                    <img src="assets/img/about-us.jpg" alt="img">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End about us -->

<!-- Start about us counter -->
<section id="mu-abtus-counter">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="mu-abtus-counter-area">
                    <div class="row">
                        <!-- Start counter item -->
                        <div class="col-lg-3 col-md-3 col-sm-3">
                            <div class="mu-abtus-counter-single">
                                <span class="fa fa-book"></span>
                                <h4 class="counter"><?php echo $numbers['number_of_courses']; ?></h4>
                                <p>Subjects</p>
                            </div>
                        </div>
                        <!-- End counter item -->
                        <!-- Start counter item -->
                        <div class="col-lg-3 col-md-3 col-sm-3">
                            <div class="mu-abtus-counter-single">
                                <span class="fa fa-users"></span>
                                <h4 class="counter"><?php echo $numbers['number_of_students']; ?></h4>
                                <p>Students</p>
                            </div>
                        </div>
                        <!-- End counter item -->
                        <!-- Start counter item -->
                        <div class="col-lg-3 col-md-3 col-sm-3">
                            <div class="mu-abtus-counter-single">
                                <span class="fa fa-flask"></span>
                                <h4 class="counter">65</h4>
                                <p>Modern Lab</p>
                            </div>
                        </div>
                        <!-- End counter item -->
                        <!-- Start counter item -->
                        <div class="col-lg-3 col-md-3 col-sm-3">
                            <div class="mu-abtus-counter-single no-border">
                                <span class="fa fa-user-secret"></span>
                                <h4 class="counter"><?php echo $numbers['number_of_teachers']; ?></h4>
                                <p>Teachers</p>
                            </div>
                        </div>
                        <!-- End counter item -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End about us counter -->

<!-- Start features section -->
<section id="mu-features">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="mu-features-area">
                    <!-- Start Title -->
                    <div class="mu-title">
                        <h2>Our Features</h2>
                        <p>Unveiling the essence of learning with our distinctive features that redefine the educational
                            landscape. Explore the core elements that set us apart and elevate your educational
                            experience to new heights. Here's a glimpse into what makes our platform exceptional.</p>
                    </div>
                    <!-- End Title -->
                    <!-- Start features content -->
                    <div class="mu-features-content">
                        <div class="row">
                            <div class="col-lg-4 col-md-4  col-sm-6">
                                <div class="mu-single-feature">
                                    <span class="fa fa-book"></span>
                                    <h4>Professional Courses</h4>
                                    <p>Embark on a journey of specialized knowledge with our meticulously curated
                                        professional courses. Dive deep into subjects crafted by industry experts,
                                        ensuring a learning experience tailored to meet the demands of today's
                                        professional landscape.</p>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-6">
                                <div class="mu-single-feature">
                                    <span class="fa fa-users"></span>
                                    <h4>Expert Teachers</h4>
                                    <p>Our platform boasts a roster of seasoned educators, each a specialist in their
                                        field. Benefit from personalized guidance and mentorship as our expert teachers
                                        empower you to grasp complex concepts, offering insights and skills that extend
                                        beyond the curriculum.</p>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-6">
                                <div class="mu-single-feature">
                                    <span class="fa fa-laptop"></span>
                                    <h4>Online Learning</h4>
                                    <p>Experience the flexibility of learning anytime, anywhere with our comprehensive
                                        online learning platform. Break free from traditional constraints and tailor
                                        your education to suit your schedule, allowing you to absorb knowledge
                                        seamlessly, whether at home or on the go.</p>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-6">
                                <div class="mu-single-feature">
                                    <span class="fa fa-microphone"></span>
                                    <h4>Audio Lessons</h4>
                                    <p>Immerse yourself in the auditory dimension of learning with our thoughtfully
                                        designed audio lessons. Delve into the richness of content through clear and
                                        engaging audio, enhancing your understanding and retention of course
                                        materials.</p>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-6">
                                <div class="mu-single-feature">
                                    <span class="fa fa-film"></span>
                                    <h4>Video Lessons</h4>
                                    <p>Visualize your education with dynamic video lessons that bring concepts to life.
                                        Our video-based learning approach ensures an interactive and engaging
                                        experience, making complex topics more accessible and fostering a deeper
                                        understanding.</p>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-6">
                                <div class="mu-single-feature">
                                    <span class="fa fa-certificate"></span>
                                    <h4>Professional Certificate</h4>
                                    <p>Elevate your credentials with our professional certificates, recognized
                                        endorsements of your newfound expertise. Validate your achievements and stand
                                        out in your field as you complete courses that lead to tangible,
                                        career-enhancing certifications.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End features content -->
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End features section -->

<!-- Start latest course section -->
<section id="mu-latest-courses">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="mu-latest-courses-area">
                    <!-- Start Title -->
                    <div class="mu-title">
                        <h2>Latest Courses</h2>
                        <p>Explore the most recent additions to our curriculum, meticulously crafted to address emerging
                            trends and ensure you acquire skills that align with the dynamic demands of various
                            industries. Enrich your learning experience with courses that reflect the latest
                            advancements, empowering you to thrive in today's ever-evolving landscape.</p>
                    </div>
                    <!-- End Title -->
                    <!-- Start latest course content -->
                    <div id="mu-latest-course-slide" class="mu-latest-courses-content">
                        <?php foreach ($topCourses as $course): ?>
                        <div class="col-lg-4 col-md-4 col-xs-12">
                            <div class="mu-latest-course-single">
                                <figure class="mu-latest-course-img">
                                    <a href="#"><img src="assets/img/courses/<?php echo $course['photo_address'] ?>" alt="img"></a>
                                    <figcaption class="mu-latest-course-imgcaption">
                                        <a href="search.php?search=<?php echo $course['category_name']; ?>"><?php echo $course['category_name']; ?></a>
                                        <span><i class="fa fa-clock-o"></i><?php echo $course['duration_hour']; ?></span>
                                    </figcaption>
                                </figure>
                                <div class="mu-latest-course-single-content">
                                    <h4>
                                        <a href="course-detail.php?id=<?php echo $course['course_id']; ?>"><?php echo $course['title']; ?></a>
                                    </h4>
                                    <p><?php echo $course['description']; ?></p>
                                    <div class="mu-latest-course-single-contbottom">
                                        <a class="mu-course-details"
                                           href="course-detail.php?id=<?php echo $course['course_id']; ?>">Details</a>
                                        <span class="mu-course-price"><?php echo $course['price']; ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <!-- End latest course content -->
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End latest course section -->

<!-- Start our teacher -->
<section id="mu-our-teacher">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="mu-our-teacher-area">
                    <!-- begain title -->
                    <div class="mu-title">
                        <h2>Our Teachers</h2>
                        <p>Our dedicated and experienced educators bring passion and expertise to every lesson, ensuring
                            a transformative learning experience. Get to know the mentors who are committed to guiding
                            you toward success, providing personalized attention, and shaping your academic path with a
                            wealth of knowledge and real-world insights</p>
                    </div>
                    <!-- end title -->
                    <!-- begain our teacher content -->
                    <div class="mu-our-teacher-content">
                        <div class="row">
                            <?php foreach ($teachers as $teacher): ?>
                            <div class="col-lg-3 col-md-3  col-sm-6">
                                <div class="mu-our-teacher-single">
                                    <figure class="mu-our-teacher-img">
                                        <img src="assets/img/teachers/<?php echo $teacher['photo_address'] ?>" alt="teacher img">
                                    </figure>
                                    <div class="mu-ourteacher-single-content">
                                        <h4><?php echo $teacher['teacher_name'] ?></h4>
                                        <span><?php echo $teacher['specialization'] ?></span>
                                        <p><?php echo $teacher['bio'] ?></p>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <!-- End our teacher content -->
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End our teacher -->

<!-- Start testimonial -->
<section id="mu-testimonial">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="mu-testimonial-area">
                    <div id="mu-testimonial-slide" class="mu-testimonial-content">
                        <!-- start testimonial single item -->
                        <div class="mu-testimonial-item">
                            <div class="mu-testimonial-quote">
                                <blockquote>
                                    <p>This educational platform has truly revolutionized the way I learn. The
                                        interactive lessons, expert teachers, and diverse learning materials make it an
                                        unparalleled resource for students like me, eager to excel in their studies.</p>
                                </blockquote>
                            </div>
                            <div class="mu-testimonial-img">
                                <img src="assets/img/testimonial-1.png" alt="img">
                            </div>
                            <div class="mu-testimonial-info">
                                <h4>John Doe</h4>
                                <span>Happy Student</span>
                            </div>
                        </div>
                        <!-- end testimonial single item -->
                        <!-- start testimonial single item -->
                        <div class="mu-testimonial-item">
                            <div class="mu-testimonial-quote">
                                <blockquote>
                                    <p>Varsity has provided me with an exceptional online learning environment. The
                                        user-friendly interface, engaging content, and responsive support have made my
                                        educational journey not only effective but also enjoyable. It's a game-changer
                                        in the world of e-learning.</p>
                                </blockquote>
                            </div>
                            <div class="mu-testimonial-img">
                                <img src="assets/img/testimonial-3.png" alt="img">
                            </div>
                            <div class="mu-testimonial-info">
                                <h4>Rebaca Michel</h4>
                                <span>Happy Parent</span>
                            </div>
                        </div>
                        <!-- end testimonial single item -->
                        <!-- start testimonial single item -->
                        <div class="mu-testimonial-item">
                            <div class="mu-testimonial-quote">
                                <blockquote>
                                    <p>Being a part of this educational community has been an inspiring experience. The
                                        encouragement from teachers, the collaborative spirit among students, and the
                                        innovative teaching methods have created a dynamic space for learning. Varsity
                                        is more than a platform; it's a catalyst for academic success and personal
                                        growth.</p>
                                </blockquote>
                            </div>
                            <div class="mu-testimonial-img">
                                <img src="assets/img/testimonial-2.png" alt="img">
                            </div>
                            <div class="mu-testimonial-info">
                                <h4>Stev Smith</h4>
                                <span>Happy Student</span>
                            </div>
                        </div>
                        <!-- end testimonial single item -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End testimonial -->

<!-- Start from blog -->
<section id="mu-from-blog">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="mu-from-blog-area">
                    <!-- start title -->
                    <div class="mu-title">
                        <h2>From Blog</h2>
                        <p>Explore insightful articles, educational tips, and latest updates on our blog to stay
                            informed and inspired in your learning journey.</p>
                    </div>
                    <!-- end title -->
                    <!-- start from blog content   -->
                    <div class="mu-from-blog-content">
                        <div class="row">
                            <?php foreach ($topBlogs as $blog): ?>
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
                    <!-- end from blog content   -->
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End from blog -->

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
                                <p>Chaharmahal and Bakhtiari Province, Shahrekord، University, Rahbar Blvd، 9R3G+3C3, Iran</p>
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