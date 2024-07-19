<?php
/**
 * Start the session and include the database connection file.
 */
session_start();

include "DataBaseConnect.php";

/**
 * Display alert messages based on the 'Message' query parameter in the URL.
 */
if (isset($_GET['Message'])) {
    print '<script type="text/javascript">
               alert("' . $_GET['Message'] . '");
           </script>';
}

/**
 * Display alert messages based on the 'response' query parameter in the URL.
 */
if (isset($_GET['response'])) {
    print '<script type="text/javascript">
               alert("' . $_GET['response'] . '");
           </script>';
}

/**
 * Handle login and registration form submissions.
 */
if (isset($_POST['submit'])) {
    // Check if the form submission is for login
    if ($_POST['submit'] == "login") {
        $username = $_POST['login_username'];
        $password = $_POST['login_password'];

        // Query the database to check login credentials
        $query = "SELECT * from users where UserName ='$username' AND Password='$password'";
        $result = mysqli_query($con, $query) or die(mysql_error());

        // Check if the login credentials are valid
        if (mysqli_num_rows($result) > 0) {
            // Fetch the user data and set the session variable
            $row = mysqli_fetch_assoc($result);
            $_SESSION['user'] = $row['username'];

            // Display a success message using JavaScript alert
            print'
                <script type="text/javascript">alert("Successfully logged in!!!");</script>
            ';
        } else {
            // Display an error message for incorrect login credentials
            print'
                <script type="text/javascript">alert("Incorrect Username Or Password!!");</script>
            ';
        }
    } // Check if the form submission is for registration
    else if ($_POST['submit'] == "register") {
        $username = $_POST['register_username'];
        $password = $_POST['register_password'];

        // Query the database to check if the username is already taken
        $query = "select * from users where UserName = '$username'";
        $result = mysqli_query($con, $query) or die(mysql_error);

        // Check if the username is already taken
        if (mysqli_num_rows($result) > 0) {
            // Display an alert message for a taken username
            print'
                <script type="text/javascript">alert("Username is already taken");</script>
            ';
        } else {
            // Insert the new user into the database
            $query = "INSERT INTO users (username, password) VALUES ('$username', '$password')";
            $result = mysqli_query($con, $query);

            // Display a success message for registration
            print'
                <script type="text/javascript">alert("Successfully Registered!!!");</script>
            ';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!--
    This section contains metadata and links to external resources for the HTML document.
    -->

    <!-- Set the character set for the document -->
    <meta charset="utf-8">

    <!-- Ensure proper rendering and compatibility in Internet Explorer -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- Configure the viewport for responsive design -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Set a brief description of the document -->
    <meta name="description" content="Shoes">

    <!-- Define the shortcut icon for the website -->
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
    <link rel="icon" href="/favicon.ico" type="image/x-icon">

    <!-- Add a description for the document -->
    <meta name="description" content="Cart">
    <meta name="author" content="Hossein">

    <!-- Set the title of the HTML document -->
    <title>Online Shoes Store</title>

    <!-- Include external CSS files, such as Bootstrap and custom styles -->
    <link href="CSS/bootstrap.min.css" rel="stylesheet">
    <link href="CSS/my.css" rel="stylesheet">

    <!-- Define internal styles using the <style> tag -->
    <style>
        .modal-header {
            /* Style the modal header */
            background-color: #D67B22; /* Set the background color to #D67B22 (orange) */
            color: #fff; /* Set the text color to #fff (white) */
            font-weight: 800; /* Set the font weight to bold */
        }

        .modal-body {
            /* Style the modal body */
            font-weight: 800; /* Set the font weight to bold */
        }

        .modal-body ul {
            /* Style the list in the modal body */
            list-style: none; /* Remove the bullet points from the list */
        }

        .modal .btn {
            /* Style the buttons in the modal */
            background-color: #D67B22; /* Set the background color to #D67B22 (orange) */
            color: #fff; /* Set the text color to #fff (white) */
        }

        .modal a {
            /* Style the links in the modal */
            color: #D67B22; /* Set the link color to #D67B22 (orange) */
        }

        .modal-backdrop {
            /* Style the backdrop of the modal */
            position: inherit !important; /* Set the position to inherit from its parent element */
        }

        #login_button, #register_button {
            /* Style the login and register buttons */
            background: none; /* Remove the background color from the buttons */
            color: #D67B22 !important; /* Set the text color to #D67B22 */
        }

        #query_button {
            /* Style the query button */
            position: fixed; /* Position the button fixed to the right and bottom of the screen */
            right: 0px; /* Set the right position to 0 pixels */
            bottom: 0px; /* Set the bottom position to 0 pixels */
            padding: 10px 80px; /* Set the padding to 10px on the top, right, and bottom, and 80px on the left */
            background-color: #D67B22; /* Set the background color to #D67B22 (orange) */
            color: #fff; /* Set the text color to #fff (white) */
            border-color: #f05f40; /* Set the border color to #f05f40 (orange-red) */
            border-radius: 2px; /* Set the border radius to 2px */
        }

        @media (max-width: 767px) {
            /* Style the query button for smaller screens */
            #query_button {
                padding: 5px 20px; /* Reduce the padding to 5px on the top and bottom, and 20px on the left and right */
            }
        }
    </style>
</head>

<body>
<!-- Navigation bar with fixed top, default style, and inverse color scheme -->
<nav class="navbar navbar-default navbar-fixed-top navbar-inverse">
    <!-- Container for the navigation bar content -->
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <!-- Button for collapsing and expanding the navigation links -->
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <!-- Brand/logo link in the navigation bar -->
            <a class="navbar-brand" href="#" style="padding: 1px;"><img class="img-responsive" alt="Brand"
                                                                        src="Image/logo.jpg"
                                                                        style="width: 147px;margin: 0px;"></a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <!-- Unordered list for navigation links, aligned to the right -->
            <ul class="nav navbar-nav navbar-right">
                <?php
                // Check if a user session is set
                if (!isset($_SESSION['user'])) {
                    echo '
            <li>
                <!-- Button to trigger the login modal -->
                <button type="button" id="login_button" class="btn btn-lg" data-toggle="modal" data-target="#login">Login</button>
                  <!-- Login modal -->
                  <div id="login" class="modal fade" role="dialog">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title text-center">Login Form</h4>
                            </div>
                            <div class="modal-body">
                                          <!-- Login form -->
                                          <form class="form" role="form" method="post" action="index.php" accept-charset="UTF-8">
                                              <div class="form-group">
                                                  <label class="sr-only" for="username">Username</label>
                                                  <input type="text" name="login_username" class="form-control" placeholder="Username" required>
                                              </div>
                                              <div class="form-group">
                                                  <label class="sr-only" for="password">Password</label>
                                                  <input type="password" name="login_password" class="form-control"  placeholder="Password" required>
                                              </div>
                                              <div class="form-group">
                                                  <button type="submit" name="submit" value="login" class="btn btn-block">
                                                      Sign in
                                                  </button>
                                              </div>
                                          </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                  </div>
            </li>
            <li>
              <!-- Button to trigger the registration modal -->
              <button type="button" id="register_button" class="btn btn-lg" data-toggle="modal" data-target="#register">Sign Up</button>
                <!-- Registration modal -->
                <div id="register" class="modal fade" role="dialog">
                  <div class="modal-dialog">
                      <div class="modal-content">
                          <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal">&times;</button>
                              <h4 class="modal-title text-center">Member Registration Form</h4>
                          </div>
                          <div class="modal-body">
                                        <!-- Registration form -->
                                        <form class="form" role="form" method="post" action="index.php" accept-charset="UTF-8">
                                            <div class="form-group">
                                                <label class="sr-only" for="username">Username</label>
                                                <input type="text" name="register_username" class="form-control" placeholder="Username" required>
                                            </div>
                                            <div class="form-group">
                                                <label class="sr-only" for="password">Password</label>
                                                <input type="password" name="register_password" class="form-control"  placeholder="Password" required>
                                            </div>
                                            <div class="form-group">
                                                <button type="submit" name="submit" value="register" class="btn btn-block">
                                                    Sign Up
                                                </button>
                                            </div>
                                        </form>
                          </div>
                          <div class="modal-footer">
                              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                          </div>
                      </div>
                  </div>
                </div>
            </li>';
                } else {
                    echo ' <li> <a href="#" class="btn btn-lg"> Hi ' . $_SESSION['user'] . '! </a></li>
                    <li><a href="Cart.php" class="btn btn-md"><span class="glyphicon glyphicon-shopping-cart">Cart</span></a></li>
                    <li><a href="Destroy.php" class="btn btn-md"> <span class="glyphicon glyphicon-log-out">LogOut</span></a></li> 
                    ';
                }
                ?>

            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>

<div id="top">
    <!-- Top section of the page containing the search box -->
    <div id="searchbox" class="container-fluid" style="width:112%;margin-left:-6%;margin-right:-6%;">
        <!-- Search box container -->
        <div>
            <!-- Form for search functionality -->
            <form role="search" method="POST" action="Result.php">
                <!-- Input field for entering search keyword -->
                <input type="text" class="form-control" name="keyword" style="width:80%;margin:20px 10% 20px 10%;"
                       placeholder="Search for a Shoe, Category or Seller">
            </form>
        </div>
    </div>
</div>

<!-- Header Section -->
<div class="container-fluid" id="header">
    <div class="row">
        <!-- Category Section -->
        <div class="col-md-3 col-lg-3" id="category">
            <div style="background:#D67B22;color:#fff;font-weight:800;border:none;padding:15px;"> The Shoes Shop
            </div>
            <ul>
                <!-- Links to different product categories -->
                <li><a href="Product.php?value=1"> Running Shoes </a></li>
                <li><a href="Product.php?value=2"> Casual Shoes </a></li>
                <li><a href="Product.php?value=3"> Formal Shoes </a></li>
                <li><a href="Product.php?value=4"> Sneakers </a></li>
                <li><a href="Product.php?value=5"> Sandals </a></li>
            </ul>
        </div>

        <!-- Carousel Section -->
        <div class="col-md-6 col-lg-6">
            <div id="myCarousel" class="carousel slide carousel-fade" data-ride="carousel">
                <!-- Indicators -->
                <ol class="carousel-indicators">
                    <!-- Indicator dots for each slide -->
                    <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                    <li data-target="#myCarousel" data-slide-to="1"></li>
                    <li data-target="#myCarousel" data-slide-to="2"></li>
                    <li data-target="#myCarousel" data-slide-to="3"></li>
                </ol>

                <!-- Wrapper for slides -->
                <div class="carousel-inner" role="listbox">
                    <!-- Individual carousel items with images -->
                    <div class="item active">
                        <img class="img-responsive" src="Image/carousel/1.jpg" alt="">
                    </div>
                    <div class="item">
                        <img class="img-responsive " src="Image/carousel/2.jpg" alt="">
                    </div>
                    <div class="item">
                        <img class="img-responsive" src="Image/carousel/3.jpg" alt="">
                    </div>
                    <div class="item">
                        <img class="img-responsive" src="Image/carousel/4.jpg" alt="">
                    </div>
                </div>
            </div>
        </div>

        <!-- Offer Section -->
        <div class="col-md-3 col-lg-3" id="offer">
            <!-- Links to special offers with corresponding images -->
            <a href="Product.php?value=3"> <img class="img-responsive center-block" src="Image/offers/1.png" alt=""></a>
            <a href="Product.php?value=2"> <img class="img-responsive center-block" src="Image/offers/2.png" alt=""></a>
            <a href="Product.php?value=1"> <img class="img-responsive center-block" src="Image/offers/3.png" alt=""></a>
        </div>
    </div>
</div>

<!-- Footer Section -->
<footer style="margin-left:-6%;margin-right:-6%;">
    <div class="container-fluid">
        <div class="row">
            <!-- Contact Information Section -->
            <div class="col-sm-1 col-md-1 col-lg-1">
            </div>
            <div class="col-sm-7 col-md-5 col-lg-5">
                <div class="row text-center">
                    <h2>Let's Get In Touch!</h2>
                    <hr class="primary">
                    <p>Still Confused? Give us a call or send us an email and we will get back to you as soon as
                        possible!</p>
                </div>
                <div class="row">
                    <!-- Contact details -->
                    <div class="col-md-6 text-center">
                        <span class="glyphicon glyphicon-earphone"></span>
                        <p>123-456-6789</p>
                    </div>
                    <div class="col-md-6 text-center">
                        <span class="glyphicon glyphicon-envelope"></span>
                        <p>shoeStore@gmail.com</p>
                    </div>
                </div>
            </div>

            <!-- Social Media Section -->
            <div class="hidden-sm-down col-md-2 col-lg-2">
            </div>
            <div class="col-sm-4 col-md-3 col-lg-3 text-center">
                <h2 style="color:#D67B22;">Follow Us At</h2>
                <div>
                    <!-- Links to social media profiles with corresponding icons -->
                    <a href="https://twitter.com/strandshoestore">
                        <img title="Twitter" alt="Twitter" src="Image/social/twitter.png" width="35" height="35"/>
                    </a>
                    <a href="https://www.linkedin.com/company/strand-shoe-store">
                        <img title="LinkedIn" alt="LinkedIn" src="Image/social/linkedin.png" width="35" height="35"/>
                    </a>
                    <a href="https://www.facebook.com/strandshoestore/">
                        <img title="Facebook" alt="Facebook" src="Image/social/facebook.png" width="35" height="35"/>
                    </a>
                    <a href="https://plus.google.com/111917722383378485041">
                        <img title="google+" alt="google+" src="Image/social/google.jpg" width="35" height="35"/>
                    </a>
                    <a href="https://www.pinterest.com/strandshoestore/">
                        <img title="Pinterest" alt="Pinterest" src="Image/social/pinterest.jpg" width="35" height="35"/>
                    </a>
                </div>
            </div>
        </div>
    </div>
</footer>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="JS/bootstrap.min.js"></script>
</body>
</html>	