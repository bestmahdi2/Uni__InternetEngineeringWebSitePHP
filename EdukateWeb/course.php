<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Edukate - Educational Platform</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Ali Badiee" name="keywords">
    <meta content="Online Education " name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@500;600;700&family=Open+Sans:wght@400;600&display=swap"
          rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/style.css" rel="stylesheet">

    <!-- Include jQuery library -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
</head>

<body>
<div id="notification"
     style="color: white; display: none; position: fixed; top: 0; left: 0; width: 100%; background-color: #f0f0f0; padding: 10px; text-align: center; z-index: 1000;"></div>

<script>
    function showNotification(message, type) {
        var notificationDiv = document.getElementById("notification");
        notificationDiv.style.display = "block";
        notificationDiv.innerHTML = message;
        notificationDiv.style.backgroundColor = type === "success" ? "#4CAF50" : "#f44336"; // Set background color based on type

        setTimeout(function () {
            notificationDiv.style.display = "none";
        }, 5000); // Hide after 3 seconds
    }
</script>

<?php
// Start a new session
session_start();

// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$database = "edukate";
$category_name = "";

try {
    // Create a new PDO instance
    $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if the value is set in the URL
    if (isset($_GET['category'])) {
        // Retrieve the value from the URL
        $receivedValue = $_GET['category'];

        // Prepare SQL query to fetch courses with the number of students
        $stmt = $conn->prepare("SELECT c.*, COALESCE(e.number_of_students, 0) AS number_of_students
            FROM Courses c
            LEFT JOIN (
                SELECT course_id, COUNT(DISTINCT user_id) AS number_of_students
                FROM Enrollments 
                GROUP BY course_id
            ) e ON c.course_id = e.course_id
            WHERE c.category_id = :receivedValue;");
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
        $stmt = $conn->prepare("SELECT c.*, COALESCE(e.number_of_students, 0) AS number_of_students
            FROM Courses c
            LEFT JOIN (
                SELECT course_id, COUNT(DISTINCT user_id) AS number_of_students
                FROM Enrollments 
                GROUP BY course_id
            ) e ON c.course_id = e.course_id;");
    }

    // Execute the prepared statement
    $stmt->execute();

    // Fetch all rows as associative arrays
    $courses = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    // Display an error message if an exception occurs
    echo "Error: " . $e->getMessage();
}

// Close the database connection
$conn = null;
?>

<!-- This is the main container for the header section with a dark background -->
<div class="container-fluid bg-dark">

    <!-- This is a row within the container, with padding on the top and bottom and horizontal padding for larger screens -->
    <div class="row py-2 px-lg-5">

        <!-- Left column for contact information, with text alignment based on screen size -->
        <div class="col-lg-6 text-center text-lg-left mb-2 mb-lg-0">

            <!-- Inline flex container for contact details with white text -->
            <div class="d-inline-flex align-items-center text-white">

                <!-- Small element with phone icon and phone number -->
                <small><i class="fa fa-phone-alt mr-2"></i>+1 (352) 444 1455</small>

                <!-- Small element with a pipe separator -->
                <small class="px-3">|</small>

                <!-- Small element with email icon and email address -->
                <small><i class="fa fa-envelope mr-2"></i>contact@edukate.com</small>
            </div>
        </div>

        <!-- Right column for social media links, with text alignment based on screen size -->
        <div class="col-lg-6 text-center text-lg-right">

            <!-- Inline flex container for social media links with white text -->
            <div class="d-inline-flex align-items-center">

                <!-- Anchor tag with Facebook icon and link -->
                <a class="text-white px-2" href="https://www.facebook.com/edukates/">
                    <i class="fab fa-facebook-f"></i>
                </a>

                <!-- Anchor tag with Twitter icon and link -->
                <a class="text-white px-2" href="https://twitter.com/edukates">
                    <i class="fab fa-twitter"></i>
                </a>

                <!-- Anchor tag with LinkedIn icon and link -->
                <a class="text-white px-2" href="https://www.linkedin.com/in/edukates/">
                    <i class="fab fa-linkedin-in"></i>
                </a>

                <!-- Anchor tag with Instagram icon and link -->
                <a class="text-white px-2" href="https://www.instagram.com/edukates">
                    <i class="fab fa-instagram"></i>
                </a>

                <!-- Anchor tag with YouTube icon and link -->
                <a class="text-white pl-2" href="https://youtube.com/edukates">
                    <i class="fab fa-youtube"></i>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Navbar -->
<div class="container-fluid p-0">
    <!-- Navigation bar with white background, padding, and additional styling -->
    <nav class="navbar navbar-expand-lg bg-white navbar-light py-3 py-lg-0 px-lg-5">

        <!-- Brand/logo on the left side of the navbar -->
        <a href="index.php" class="navbar-brand ml-lg-3">
            <!-- Heading with Edukate title and book icon -->
            <h1 class="m-0 text-uppercase text-primary"><i class="fa fa-book-reader mr-3"></i>Edukate</h1>
        </a>

        <!-- Toggler button for responsive design on smaller screens -->
        <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Collapsible content area with navigation links and Join Us & Login buttons -->
        <div class="collapse navbar-collapse justify-content-between px-lg-3" id="navbarCollapse">

            <!-- Navigation links aligned to the center -->
            <div class="navbar-nav mx-auto py-0">
                <!-- Home link with active state -->
                <a href="index.php" class="nav-item nav-link">Home</a>
                <!-- About link -->
                <a href="about.php" class="nav-item nav-link">About</a>
                <!-- Courses link -->
                <a href="course.php" class="nav-item nav-link active">Courses</a>

                <!-- Dropdown menu for additional pages -->
                <div class="nav-item dropdown">
                    <!-- Dropdown toggle link -->
                    <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Pages</a>

                    <!-- Dropdown menu items -->
                    <div class="dropdown-menu m-0">
                        <a href="feature.php" class="dropdown-item">Our Features</a>
                        <a href="team.php" class="dropdown-item">Instructors</a>
                        <a href="my_course.php" class="dropdown-item">My Courses</a>
                    </div>
                </div>
            </div>

            <!-- Check if the user is logged in -->
            <?php
            if (isset($_SESSION['username'])) {
                // Display user's name and Logout button if logged in
                echo '<span class="navbar-text mx-3">Welcome, ' . $_SESSION['username'] . '!</span>';
                echo '<a href="logout.php" class="btn btn-danger py-2 px-4 d-none d-lg-inline-block">Logout</a>';
            } else {
                // Display "Join Us" and "Login" buttons if not logged in
                echo '<a href="index.php#signup-section" class="btn btn-primary py-2 px-4 mr-2 d-none d-lg-inline-block">Join Us</a>';
                echo '<a href="index.php#login-section" class="btn btn-success py-2 px-4 d-none d-lg-inline-block">Login</a>';
            }
            ?>
        </div>
    </nav>
</div>

<!-- Jumbotron Start: Fluid jumbotron with relative positioning and bottom overlay -->
<div class="jumbotron jumbotron-fluid page-header position-relative overlay-bottom" style="margin-bottom: 90px;">

    <!-- Container for jumbotron content with text centering and vertical spacing -->
    <div class="container text-center py-5">

        <!-- Heading 1 with white text, margin, and padding -->
        <h1 class="text-white display-1">Course</h1>

        <!-- Large display Heading 1 with white text and additional bottom margin -->
        <div class="d-inline-flex text-white mb-5">
            <p class="m-0 text-uppercase"><a class="text-white" href="index.php">Home</a></p>
            <i class="fa fa-angle-double-right pt-1 px-3"></i>
            <p class="m-0 text-uppercase">Course</p>
        </div>

        <!-- Container for search input with maximum width and centering -->
        <div class="mx-auto mb-5" style="width: 100%; max-width: 600px;">
            <!-- Form for submitting the search text to search.php -->
            <form action="search.php" method="post" class="input-group">
                <!-- Text input for entering search keywords with light border -->
                <input type="text" name="search_text" class="form-control border-light" style="padding: 30px 25px;"
                       placeholder="Search in courses and instructors..." required>

                <!-- Button for triggering the search with secondary color and padding -->
                <div class="input-group-append">
                    <button type="submit" class="btn btn-secondary px-4 px-lg-5">Search</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Courses Start -->
<div class="container-fluid">
    <div class="container">
        <?php
        // Check if the courses array is empty
        if (empty($courses))
            // Display message when no courses are available
            echo '<div class="section-title position-relative mb-4">
                    <h1 class="display-4">No Courses Here!</h1>
                  </div>';
        else
            // Check if the category is set in the URL
            if (isset($_GET['category']))
                // Display category-specific section title
                echo '<div class="section-title position-relative mb-4">
                    <h1 class="display-4">' . $category_name . ' Courses:</h1>
                  </div><br><br>';
        ?>
        <div class="row">
            <?php foreach ($courses as $course): ?>
                <div class="col-lg-4 col-md-6 pb-4">
                    <!-- Course item with a link to the course detail page -->
                    <a class="courses-list-item position-relative d-block overflow-hidden mb-2"
                       href="detail.php?id=<?php echo $course['course_id']; ?>">
                        <!-- Course image -->
                        <img class="img-fluid" src="./img/<?php echo $course['photo_address']; ?>" alt="">
                        <div class="courses-text">
                            <!-- Course title -->
                            <h4 class="text-center text-white px-3"><?php echo $course['title']; ?></h4>
                            <div class="border-top w-100 mt-3">
                                <div class="d-flex justify-content-between p-4">
                                    <!-- Number of students enrolled -->
                                    <span class="text-white"><i
                                                class="fa fa-user mr-2"></i><?php echo $course['number_of_students']; ?></span>
                                    <!-- Course rating with stars and number of ratings -->
                                    <span class="text-white"><i
                                                class="fa fa-star mr-2"></i><?php if ($course['number_of_students'] > 0) echo $course['rating']; else echo '0.0'  ?><small>(<?php if ($course['number_of_students'] > 0) echo $course['number_of_students']; else echo '♾'; ?>)</small></span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<!-- Footer: -->
<!-- Full-width container with dark background, position relative, and overlay -->
<div class="container-fluid position-relative overlay-top bg-dark text-white-50 py-5" style="margin-top: 90px;">

    <!-- Container with top margin and padding top -->
    <div class="container mt-5 pt-5">

        <!-- First row with column containing brand and platform description -->
        <div class="row">
            <div class="col-md-6 mb-5">

                <!-- Navbar brand with logo and platform name -->
                <a href="index.php" class="navbar-brand">
                    <h1 class="mt-n2 text-uppercase text-white"><i class="fa fa-book-reader mr-3"></i>Edukate</h1>
                </a>

                <!-- Platform description -->
                <p class="m-0">Discover a world of learning without limits. Our platform empowers students to thrive in
                    an interactive, globally connected educational environment.</p>
            </div>
        </div>

        <!-- Second row with contact information and social links -->
        <div class="row">
            <div class="col-md-4 mb-5">

                <!-- Contact information -->
                <h3 class="text-white mb-4">Get In Touch</h3>
                <p><i class="fa fa-map-marker-alt mr-2"></i>123 Street, New York, USA</p>
                <p><i class="fa fa-phone-alt mr-2"></i>+1 (352) 444 1455</p>
                <p><i class="fa fa-envelope mr-2"></i>contact@edukate.com</p>

                <!-- Social links -->
                <div class="d-flex justify-content-start mt-4">
                    <a class="text-white mr-4" href="https://twitter.com/edukates"><i class="fab fa-2x fa-twitter"></i></a>
                    <a class="text-white mr-4" href="https://www.facebook.com/edukates/"><i
                                class="fab fa-2x fa-facebook-f"></i></a>
                    <a class="text-white mr-4" href="https://www.linkedin.com/in/edukates/"><i
                                class="fab fa-2x fa-linkedin-in"></i></a>
                    <a class="text-white" href="https://www.instagram.com/edukates"><i
                                class="fab fa-2x fa-instagram"></i></a>
                </div>
            </div>

            <!-- Third column with course categories -->
            <div class="col-md-4 mb-5">

                <!-- Course categories -->
                <h3 class="text-white mb-4">Our Courses</h3>
                <div class="d-flex flex-column justify-content-start">
                    <a class="text-white-50 mb-2" href="course.php?category=1"><i class="fa fa-angle-right mr-2"></i>Web
                        Design</a>
                    <a class="text-white-50 mb-2" href="course.php?category=2"><i class="fa fa-angle-right mr-2"></i>Apps
                        Design</a>
                    <a class="text-white-50 mb-2" href="course.php?category=3"><i class="fa fa-angle-right mr-2"></i>Marketing</a>
                    <a class="text-white-50 mb-2" href="course.php?category=4"><i class="fa fa-angle-right mr-2"></i>Research</a>
                    <a class="text-white-50" href="course.php?category=5"><i class="fa fa-angle-right mr-2"></i>SEO</a>
                </div>
            </div>

            <!-- Fourth column with quick links -->
            <div class="col-md-4 mb-5">

                <!-- Quick links -->
                <h3 class="text-white mb-4">Quick Links</h3>
                <div class="d-flex flex-column justify-content-start">
                    <a class="text-white-50 mb-2" href="about.php"><i class="fa fa-angle-right mr-2"></i>About</a>
                    <a class="text-white-50 mb-2" href="course.php"><i class="fa fa-angle-right mr-2"></i>Courses</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Full-width container with dark background, text and border at the top -->
<div class="container-fluid bg-dark text-white-50 border-top py-4"
     style="border-color: rgba(256, 256, 256, .1) !important;">

    <!-- Container for copyright information -->
    <div class="container">

        <!-- Row containing copyright information -->
        <div class="row">

            <!-- Column with copyright text, aligned for small to medium devices -->
            <div class="col-md-6 text-center text-md-left mb-3 mb-md-0">

                <!-- Copyright text -->
                <p class="m-0">Copyright &copy; <a class="text-white" href="#">Edukate</a>. All Rights Reserved.
                </p>
            </div>
        </div>
    </div>
</div>

<!-- Back to top button -->
<a href="#" class="btn btn-lg btn-primary rounded-0 btn-lg-square back-to-top">
    <!-- Icon for the back-to-top button (double-up arrow) -->
    <i class="fa fa-angle-double-up"></i>
</a>

<!-- Include Bootstrap library (JavaScript bundle) -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>

<!-- Include Easing library -->
<script src="lib/easing/easing.min.js"></script>

<!-- Include Waypoints library -->
<script src="lib/waypoints/waypoints.min.js"></script>

<!-- Include CounterUp library -->
<script src="lib/counterup/counterup.min.js"></script>

<!-- Include Owl Carousel library -->
<script src="lib/owlcarousel/owl.carousel.min.js"></script>

<!-- Include custom JavaScript file (main.js) -->
<script src="js/main.js"></script>
</body>
</html>