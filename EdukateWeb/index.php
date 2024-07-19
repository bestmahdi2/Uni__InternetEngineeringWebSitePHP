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
// Start a new or resume the existing session
session_start();

// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$database = "edukate";

try {
    // Create connection
    $conn = new mysqli($servername, $username, $password, $database);
} catch (mysqli_sql_exception $ex) {
    echo nl2br(file_get_contents("README.txt")); // get the contents, insert HTML line breaks, and echo it out.
    exit();
}

// Check connection
if ($conn->connect_error) {
     die("Connection failed: " . $conn->connect_error);
}

// Get number of categories
$sqlCategories = "SELECT COUNT(*) AS categoryCount FROM Categories";
$resultCategories = $conn->query($sqlCategories);
$categoryCount = ($resultCategories->num_rows > 0) ? $resultCategories->fetch_assoc()['categoryCount'] : 0;

// Get number of all courses
$sqlCourses = "SELECT COUNT(*) AS courseCount FROM Courses";
$resultCourses = $conn->query($sqlCourses);
$courseCount = ($resultCourses->num_rows > 0) ? $resultCourses->fetch_assoc()['courseCount'] : 0;

// Get number of instructors
$sqlInstructors = "SELECT COUNT(*) AS instructorCount FROM Instructors";
$resultInstructors = $conn->query($sqlInstructors);
$instructorCount = ($resultInstructors->num_rows > 0) ? $resultInstructors->fetch_assoc()['instructorCount'] : 0;

// Get number of students
$sqlStudents = "SELECT COUNT(*) AS studentCount FROM Users WHERE user_type = 'student'";
$resultStudents = $conn->query($sqlStudents);
$studentCount = ($resultStudents->num_rows > 0) ? $resultStudents->fetch_assoc()['studentCount'] : 0;

// Close the initial connection
$conn->close();

// Create a new PDO instance for further database operations
$conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
// Set the PDO error mode to exception
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Prepare and execute the SQL query to fetch instructors
$stmt = $conn->query("SELECT * FROM Instructors JOIN Users ON Instructors.user_id = Users.user_id");
$stmt->execute();
// Fetch all instructors as an associative array
$instructors = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Prepare and execute the SQL query to fetch top courses
$stmt = $conn->prepare("SELECT Courses.*, Instructors.user_id, Users.full_name AS instructor_name
                        FROM Courses
                        INNER JOIN Instructors ON Courses.instructor_id = Instructors.instructor_id
                        INNER JOIN Users ON Instructors.user_id = Users.user_id
                        ORDER BY Courses.title DESC
                        LIMIT 6;");
$stmt->execute();
// Fetch all rows as associative arrays
$topCourses = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Close the database connection
$conn = null;

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the submitted form is for signup
    if (isset($_POST["signup_submit"])) {
        // Retrieve form data for signup
        $user_username = $_POST["username"];
        $user_password = $_POST["password"];
        $user_email = $_POST["email"];
        $user_full_name = $_POST["full_name"];

        try {
            // Create a new PDO instance
            $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
            // Set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Prepare and execute the SQL query to insert a new user
            $stmt = $conn->prepare("INSERT INTO Users (username, password, email, full_name, user_type, photo_address)
                                    VALUES (:username, :password, :email, :full_name, 'student', 'default.jpg')");

            $hashed_password = password_hash($user_password, PASSWORD_DEFAULT); // Hash the password before storing

            // Bind parameters
            $stmt->bindParam(':username', $user_username);
            $stmt->bindParam(':password', $hashed_password);
            $stmt->bindParam(':email', $user_email);
            $stmt->bindParam(':full_name', $user_full_name);

            // Execute the query
            $stmt->execute();

            echo '<script>showNotification("You signed up successfully!", "success");</script>';

        } catch (PDOException $e) {
            $errorMessage = strval($e->getMessage()); // Using strval function
            echo '<script>showNotification("Error: ' . $errorMessage . '");</script>';
        }

        // Close the database connection
        $conn = null;

    } elseif (isset($_POST["login_submit"])) { // Check if the submitted form is for login
        // Retrieve form data for login
        $login_username = $_POST["login_username"];
        $login_password = $_POST["login_password"];

        try {
            // Create a new PDO instance
            $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
            // Set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Prepare and execute the SQL query to fetch user details
            $stmt = $conn->prepare("SELECT * FROM Users WHERE username = :username");
            $stmt->bindParam(':username', $login_username);
            $stmt->execute();

            // Check if the user exists and password is correct
            if ($stmt->rowCount() > 0) {
                $user = $stmt->fetch(PDO::FETCH_ASSOC);

                if (password_verify($login_password, $user['password'])) {
                    $_SESSION['username'] = $user['full_name']; // Use the appropriate user field
                    $_SESSION['id'] = $user['user_id']; // Use the appropriate user field
                    echo '<script>showNotification("Login successful. Welcome, ' . $user['full_name'] . '", "success");</script>';
                } else
                    echo '<script>showNotification("Incorrect username or password!");</script>';
            } else
                echo '<script>showNotification("Incorrect username or password!");</script>';

        } catch (PDOException $e) {
            $errorMessage = strval($e->getMessage()); // Using strval function
            echo '<script>showNotification("Error: ' . $errorMessage . '");</script>';
        }

        // Close the database connection
        $conn = null;
    }
}
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
                <a href="index.php" class="nav-item nav-link active">Home</a>
                <!-- About link -->
                <a href="about.php" class="nav-item nav-link">About</a>
                <!-- Courses link -->
                <a href="course.php" class="nav-item nav-link">Courses</a>

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
<div class="jumbotron jumbotron-fluid position-relative overlay-bottom" style="margin-bottom: 90px;">

    <!-- Container for jumbotron content with text centering and vertical spacing -->
    <div class="container text-center my-5 py-5">

        <!-- Heading 1 with white text, margin, and padding -->
        <h1 class="text-white mt-4 mb-4">Learn From Home</h1>

        <!-- Large display Heading 1 with white text and additional bottom margin -->
        <h1 class="text-white display-1 mb-5">Education Courses</h1>

        <!-- Container for search input with maximum width and centering -->
        <div class="mx-auto mb-5" style="width: 100%; max-width: 600px;">
            <!-- Form for submitting the search text to search.php -->
            <form action="search.php" method="post" class="input-group">
                <!-- Text input for entering search keywords with light border -->
                <input type="text" name="search_text" class="form-control border-light" style="padding: 30px 25px;"
                       placeholder="Search in all courses..." required>

                <!-- Button for triggering the search with secondary color and padding -->
                <div class="input-group-append">
                    <button type="submit" class="btn btn-secondary px-4 px-lg-5">Search</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Container for a section with fluid padding on the top and bottom -->
<div class="container-fluid py-5">

    <!-- Inner container with additional padding on the top and bottom -->
    <div class="container py-5">

        <!-- Row containing two columns -->
        <div class="row">

            <!-- Left column with fixed height and an image -->
            <div class="col-lg-5 mb-5 mb-lg-0" style="min-height: 500px;">
                <div class="position-relative h-100">
                    <!-- Absolute-positioned image with cover style -->
                    <img class="position-absolute w-100 h-100" src="img/about.jpg" style="object-fit: cover;">
                </div>
            </div>

            <!-- Right column with text content -->
            <div class="col-lg-7">

                <!-- Section title with a small heading and a large heading -->
                <div class="section-title position-relative mb-4">
                    <h6 class="d-inline-block position-relative text-secondary text-uppercase pb-2">About Us</h6>
                    <h1 class="display-4">First Choice For Online Education Anywhere</h1>
                </div>

                <!-- Paragraph describing the platform and its commitment to education -->
                <p>Welcome to our educational platform, where excellence meets innovation.
                    Our commitment to providing top-tier online education is unwavering,
                    making us the first choice for learners anywhere. With a focus on interactive learning,
                    personalized instruction, and a diverse range of courses,
                    we aim to redefine the online education experience. At our core,
                    we believe that education knows no boundaries,
                    and our platform reflects this by offering a dynamic and enriching environment accessible from any
                    corner of the globe.
                    Join us on this educational journey to discover a world of knowledge, growth, and endless
                    possibilities.</p>

                <!-- Row with four columns displaying statistics -->
                <div class="row pt-3 mx-0">
                    <!-- Column for available subjects -->
                    <div class="col-3 px-0">
                        <div class="bg-success text-center p-4">
                            <h1 class="text-white" data-toggle="counter-up"><?php echo $categoryCount; ?></h1>
                            <h6 class="text-uppercase text-white">Available<span class="d-block">Subjects</span></h6>
                        </div>
                    </div>

                    <!-- Column for online courses -->
                    <div class="col-3 px-0">
                        <div class="bg-primary text-center p-4">
                            <h1 class="text-white" data-toggle="counter-up"><?php echo $courseCount; ?></h1>
                            <h6 class="text-uppercase text-white">Online<span class="d-block">Courses</span></h6>
                        </div>
                    </div>

                    <!-- Column for skilled instructors -->
                    <div class="col-3 px-0">
                        <div class="bg-secondary text-center p-4">
                            <h1 class="text-white" data-toggle="counter-up"><?php echo $instructorCount; ?></h1>
                            <h6 class="text-uppercase text-white">Skilled<span class="d-block">Instructors</span></h6>
                        </div>
                    </div>

                    <!-- Column for happy students -->
                    <div class="col-3 px-0">
                        <div class="bg-warning text-center p-4">
                            <h1 class="text-white" data-toggle="counter-up"><?php echo $studentCount; ?></h1>
                            <h6 class="text-uppercase text-white">Happy<span class="d-block">Students</span></h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Container for a section with a background image and top margin -->
<div class="container-fluid bg-image" style="margin: 90px 0;">

    <!-- Inner container with additional padding -->
    <div class="container">

        <!-- Row containing two columns -->
        <div class="row">

            <!-- Left column with top margin, padding, and content -->
            <div class="col-lg-7 my-5 pt-5 pb-lg-5">

                <!-- Section title with a small heading and a large heading -->
                <div class="section-title position-relative mb-4">
                    <h6 class="d-inline-block position-relative text-secondary text-uppercase pb-2">Why Choose Us?</h6>
                    <h1 class="display-4">Why You Should Start Learning with Us?</h1>
                </div>

                <!-- Paragraph describing the platform's commitment to personalized learning -->
                <p class="mb-4 pb-2">Discover a world of educational excellence with us as your trusted learning
                    companion.
                    Our dedication to personalized learning ensures your needs are at the forefront of your educational
                    experience.
                    By choosing us, you are selecting a path to success marked by expert guidance, diverse course
                    offerings,
                    and a supportive community. Join us to embrace a transformative learning journey and
                    unlock your full potential in a dynamic, innovative educational environment.</p>

                <!-- Three sections with icons, headings, and descriptions -->
                <div class="d-flex mb-3">
                    <div class="btn-icon bg-primary mr-4">
                        <i class="fa fa-2x fa-graduation-cap text-white"></i>
                    </div>
                    <div class="mt-n1">
                        <h4>Skilled Instructors</h4>
                        <p>Our skilled instructors bring expertise and passion to every learning experience,
                            empowering students to thrive. Join us and experience the impact of learning from industry
                            professionals invested in your growth.</p>
                    </div>
                </div>

                <div class="d-flex mb-3">
                    <div class="btn-icon bg-secondary mr-4">
                        <i class="fa fa-2x fa-certificate text-white"></i>
                    </div>
                    <div class="mt-n1">
                        <h4>International Certificate</h4>
                        <p>Join us and gain access to internationally recognized certification,
                            validating your expertise on a global scale.
                            Elevate your credentials with our comprehensive certification programs,
                            designed to empower you in the international arena.</p>
                    </div>
                </div>

                <div class="d-flex">
                    <div class="btn-icon bg-warning mr-4">
                        <i class="fa fa-2x fa-book-reader text-white"></i>
                    </div>
                    <div class="mt-n1">
                        <h4>Online Classes</h4>
                        <p class="m-0">Embrace the flexibility of our online classes, designed to accommodate your
                            schedule and learning preferences. Join a global community of learners and experience
                            interactive, engaging virtual classrooms led by expert instructors.</p>
                    </div>
                </div>
            </div>

            <!-- Right column with fixed height and an image -->
            <div class="col-lg-5" style="min-height: 500px;">
                <div class="position-relative h-100">
                    <!-- Absolute-positioned image with cover style -->
                    <img class="position-absolute w-100 h-100" src="img/feature.jpg" style="object-fit: cover;" alt="Feature Image">
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Container for a section with full width, no horizontal padding, and vertical padding -->
<div class="container-fluid px-0 py-5">

    <!-- Row for the section title centered and with top padding -->
    <div class="row mx-0 justify-content-center pt-5">

        <!-- Column for the section title -->
        <div class="col-lg-6">

            <!-- Section title with a small heading and a large heading -->
            <div class="section-title text-center position-relative mb-4">
                <h6 class="d-inline-block position-relative text-secondary text-uppercase pb-2">Our Courses</h6>
                <h1 class="display-4">Checkout Our Best Rated Courses</h1>
            </div>
        </div>
    </div>

    <!-- Owl Carousel for displaying multiple courses -->
    <div class="owl-carousel courses-carousel">
        <?php foreach ($topCourses as $course): ?>
            <div class="courses-item position-relative">
                <img class="img-fluid" src="./img/<?php echo $course['photo_address']; ?>" alt="">
                <div class="courses-text">
                    <h4 class="text-center text-white px-3"><?php echo $course['title']; ?></h4>
                    <div class="border-top w-100 mt-3">
                        <div class="d-flex justify-content-between p-4">
                            <span class="text-white"><i class="fa fa-user mr-2"></i><?php echo $course['instructor_name']; ?></span>
                            <span class="text-white"><i class="fa fa-star mr-2"></i><?php echo $course['rating']; ?><small>(<?php echo $course['lessons_count']; ?>)</small></span>
                        </div>
                    </div>
                    <div class="w-100 bg-white text-center p-4">
                        <a class="btn btn-primary" href="detail.php?id=<?php echo $course['course_id']; ?>">Course Detail</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Row for a promotion with background image, centered content, and bottom margin -->
    <div id="signup-section" class="row justify-content-center bg-image mx-0 mb-5">
        <!-- Column for the promotion content -->
        <div class="col-lg-6 py-5">
            <!-- Background white box with padding and margin -->
            <div class="bg-white p-5 my-5">
                <h1 class="text-center mb-4">Sign Up Now !</h1>
                <!-- Form for capturing user information -->
                <form action="index.php" method="post">
                    <div class="form-row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <input type="text" name="username" class="form-control bg-light border-0"
                                       placeholder="Username" style="padding: 30px 20px;" required>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <input type="password" name="password" class="form-control bg-light border-0"
                                       placeholder="Password" style="padding: 30px 20px;" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <input type="email" name="email" class="form-control bg-light border-0"
                                       placeholder="Your Email" style="padding: 30px 20px;" required>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <input type="text" name="full_name" class="form-control bg-light border-0"
                                       placeholder="Your Full Name" style="padding: 30px 20px;" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-sm-12">
                            <input type="hidden" name="signup_submit" value="1"> <!-- Hidden input for signup -->
                            <button type="submit" class="btn btn-primary btn-block" style="height: 60px;">Sign Up Now</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>

<!-- Display the fetched instructors -->
<div class="container-fluid py-5">
    <div class="container py-5">
        <!-- Section title for the instructors -->
        <div class="section-title text-center position-relative mb-5">
            <h6 class="d-inline-block position-relative text-secondary text-uppercase pb-2">Instructors</h6>
            <h1 class="display-4">Meet Our Instructors</h1>
        </div>

        <!-- Owl Carousel for displaying instructor information -->
        <div class="owl-carousel team-carousel position-relative" style="padding: 0 30px;">
            <?php foreach ($instructors as $instructor) : ?>
                <div class="team-item">
                    <!-- Instructor's photo -->
                    <img class="img-fluid w-100" src="./img/<?php echo $instructor['photo_address']; ?>" alt="">
                    <div class="bg-light text-center p-4">
                        <!-- Instructor's full name -->
                        <h5 class="mb-3"><?php echo $instructor['full_name']; ?></h5>
                        <!-- Instructor's specialization -->
                        <p class="mb-2"><?php echo $instructor['specialization']; ?></p>
                        <div class="d-flex justify-content-center">
                            <!-- Social media links for the instructor -->
                            <a class="mx-1 p-1" href="<?php echo $instructor['facebook']; ?>"><i class="fab fa-facebook-f"></i></a>
                            <a class="mx-1 p-1" href="<?php echo $instructor['youtube']; ?>"><i class="fab fa-youtube"></i></a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<!-- Full-width container with background image and vertical padding -->
<div class="container-fluid bg-image py-5" style="margin: 90px 0;">

    <!-- Container for content with vertical padding -->
    <div class="container py-5">

        <!-- Row for aligning content vertically -->
        <div class="row align-items-center">

            <!-- Column for testimonial text -->
            <div class="col-lg-5 mb-5 mb-lg-0">
                <!-- Section title for the testimonial -->
                <div class="section-title position-relative mb-4">
                    <h6 class="d-inline-block position-relative text-secondary text-uppercase pb-2">Testimonial</h6>
                    <h1 class="display-4">What Say Our Students</h1>
                </div>
                <!-- Text content of the testimonial -->
                <p class="m-0">Our experience with the online classes has been truly transformative.
                    The instructors are knowledgeable, supportive, and foster a strong sense of community in the
                    virtual classroom. The international certification program offered here has opened doors we
                    never thought possible, propelling our careers to new heights. The level of expertise and
                    dedication displayed by the instructors is unparalleled, making learning not only effective
                    but also enjoyable. We are truly grateful for the invaluable skills and knowledge gained through
                    this program, which have had a substantial impact on our personal and professional development.</p>
            </div>

            <!-- Column for testimonial carousel -->
            <div class="col-lg-7">
                <!-- Owl Carousel for displaying testimonials -->
                <div class="owl-carousel testimonial-carousel">
                    <!-- Individual testimonial with background, quote, text, and student details -->
                    <div class="bg-white p-5">
                        <!-- Quotation icon -->
                        <i class="fa fa-3x fa-quote-left text-primary mb-4"></i>
                        <!-- Testimonial text -->
                        <p>This program seems like an excellent opportunity to deepen my understanding of search engine
                            optimization. I'm eager to learn about on-page and off-page SEO techniques and how to
                            effectively optimize content for search engines. The prospect of gaining insights into
                            keyword research and competitor analysis is particularly exciting. I believe that this
                            course will provide me with the knowledge and skills required to enhance a website's
                            visibility and drive organic traffic. Understanding the intricacies of search engine
                            algorithms and best practices for link building is crucial, and I look forward to mastering
                            these concepts. </p>
                        <!-- Student details -->
                        <div class="d-flex flex-shrink-0 align-items-center mt-4">
                            <img class="img-fluid mr-4" src="img/testimonial-1.jpg" alt="">
                            <div>
                                <h5>Olivia Learner</h5>
                                <span>SEO</span>
                            </div>
                        </div>
                    </div>
                    <!-- Another individual testimonial -->
                    <div class="bg-white p-5">
                        <i class="fa fa-3x fa-quote-left text-primary mb-4"></i>
                        <p>The curriculum looks exciting, and I can't wait to dive into topics such as user interface
                            design, responsive layouts, and typography. The instructors seem knowledgeable, and I'm
                            eager to learn from their expertise. I'm particularly looking forward to the hands-on
                            projects, where I'll have the chance to apply what I learn in real-world scenarios.
                            Understanding HTML, CSS, and JavaScript is crucial for web design, and I'm excited to master
                            these languages. I'm also eager to explore the latest design tools and technologies to stay
                            updated with industry trends. Ultimately, I aim to create visually websites, and I believe this course will provide me with the skills to do so.</p>
                        <!-- Student details -->
                        <div class="d-flex flex-shrink-0 align-items-center mt-4">
                            <img class="img-fluid mr-4" src="img/testimonial-2.jpg" alt="">
                            <div>
                                <h5>Michael Student</h5>
                                <span>Web Design</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Container for a section with full width, no horizontal padding, and vertical padding -->
<div class="container-fluid px-0 py-5">

    <!-- Row for a promotion with background image, centered content, and bottom margin -->
    <div id="login-section" class="row justify-content-center bg-image mx-0 mb-5">

        <!-- Column for the login content -->
        <div class="col-lg-6 py-5">

            <!-- Background white box with padding and margin -->
            <div class="bg-white p-5 my-5">

                <!-- Login section title -->
                <h1 class="text-center mb-4">Login Now !</h1>

                <!-- Form for capturing user login information -->
                <form action="index.php" method="post">

                    <!-- Form input fields for username and password -->
                    <div class="form-row">
                        <!-- Username input field -->
                        <div class="col-sm-6">
                            <div class="form-group">
                                <input type="text" name="login_username" class="form-control bg-light border-0"
                                       placeholder="Username" style="padding: 30px 20px;" required>
                            </div>
                        </div>
                        <!-- Password input field -->
                        <div class="col-sm-6">
                            <div class="form-group">
                                <input type="password" name="login_password" class="form-control bg-light border-0"
                                       placeholder="Password" style="padding: 30px 20px;" required>
                            </div>
                        </div>
                    </div>

                    <!-- Hidden input field for login -->
                    <div class="form-row">
                        <div class="col-sm-12">
                            <input type="hidden" name="login_submit" value="1"> <!-- Hidden input for login -->
                            <!-- Login button -->
                            <button type="submit" class="btn btn-primary btn-block" style="height: 60px;">Login Now
                            </button>
                        </div>
                    </div>

                </form> <!-- End of login form -->

            </div> <!-- End of background white box -->

        </div> <!-- End of login column -->

    </div> <!-- End of login section row -->

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