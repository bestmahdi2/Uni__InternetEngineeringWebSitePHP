<?php
/*
 * Checks if the user is logged in.
 *
 * If the user is not logged in, redirects them to the login page.
 */
session_start();

if (!isset($_SESSION['user'])) {
    /*
     * Sends a header to redirect the user to the login page.
     *
     * The header contains a query parameter named "Message" with the value
     * "Login To Continue".
     */
    header("location: index.php?Message=Login To Continue");
}

// Include the database connection file
include "DataBaseConnect.php";
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

    <!-- Set the title of the HTML document -->
    <title>Online Shoes Store</title>

    <!-- Include external CSS files, such as Bootstrap and custom styles -->
    <link href="CSS/bootstrap.min.css" rel="stylesheet">
    <link href="CSS/my.css" rel="stylesheet">

    <!-- Define internal styles using the <style> tag -->
    <style>
        /* Style for the #shoes container with rows */
        #shoes .row {
            margin-top: 30px; /* Top margin for better spacing */
            font-weight: 800; /* Bold font weight for emphasis */
        }

        /* Responsive styling for smaller screens (max-width: 760px) */
        @media only screen and (max-width: 760px) {
            #shoes .row {
                margin-top: 10px; /* Adjusted top margin for smaller screens */
            }
        }

        /* Style for individual shoe blocks */
        .shoe-block {
            margin-top: 20px; /* Top margin for spacing between shoe blocks */
            margin-bottom: 10px; /* Bottom margin for spacing between shoe blocks */
            padding: 10px; /* Padding inside each shoe block */
            border: 1px solid #DEEAEE; /* Border color and thickness */
            border-radius: 10px; /* Rounded corners for a more visually appealing look */
            height: 100%; /* Set height to 100% */
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
                    echo ' <li> <a href="#" class="btn btn-lg"> Hello ' . $_SESSION['user'] . '.</a></li>
                    <li> <a href="Cart.php" class="btn btn-lg"> Cart </a> </li>; 
                    <li> <a href="Destroy.php" class="btn btn-lg"> LogOut </a> </li>';

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

<?php
// Get the keyword from the POST request
$keyword = $_POST['keyword'];

// find the category_id by its name
$query_ = "SELECT * FROM categories WHERE category_name='$keyword'";
$result_ = mysqli_query($con, $query_) or die(mysqli_error($con));
$row = mysqli_fetch_assoc($result_);
if (isset($row['category_id']))
    $category_id = $row['category_id'];
else
    $category_id = 12345678;

// Query to search for records based on the keyword
$query = "SELECT * FROM products WHERE product_id LIKE '%{$keyword}%' OR product_name LIKE '%{$keyword}%' OR product_seller LIKE '%{$keyword}%' OR category_id = '$category_id'";
$result = mysqli_query($con, $query) or die(mysqli_error($con));;

$i = 0;

// Display container and heading for the search results
echo '<div class="container-fluid" id="shoes">
        <div class="row">
          <div class="col-xs-12 text-center" id="heading">
                 <h4 style="color:#00B9F5;text-transform:uppercase;"> found  ' . mysqli_num_rows($result) . ' records </h4>
           </div>
        </div>';

// Check if there are any search results
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $path = "Image/shoes/" . $row['image_url'];
        $description = "description.php?ID=" . $row["product_id"];

        // Set offset based on the position in the row
        if ($i % 3 == 0) $offset = 0;
        else  $offset = 1;

        // Display a new row at the beginning of every third item
        if ($i % 3 == 0)
            echo '<div class="row">';

        // Display individual shoe block
        echo '
               <a href="' . $description . '">
                <div class="col-sm-5 col-sm-offset-1 col-md-3 col-md-offset-' . $offset . ' col-lg-3 text-center w3-card-8 w3-dark-grey">
                    <div class="shoe-block">
                        <img class="shoe block-center img-responsive" src="' . $path . '" alt="">
                        <hr>
                         ' . $row["product_name"] . '<br>
                        ' . ($row["product_price"] - ($row["product_price"] * $row["product_discount"] / 100)) . '  &nbsp
                        <span style="text-decoration:line-through;color:#828282;"> ' . $row["product_price"] . ' </span>
                        <span class="label label-warning">' . $row["product_discount"] . '%</span>
                    </div> 
                </div> 
               </a> ';

        $i++;

        // Close the row tag at the end of every third item
        if ($i % 3 == 0)
            echo '</div>';
    }
}

// Close the container tag
echo '</div>';
?>

</body>
</html>		