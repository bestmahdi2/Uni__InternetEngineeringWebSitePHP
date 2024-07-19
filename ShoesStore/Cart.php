<?php
// Include the database connection file
include "DataBaseConnect.php";

/**
 * Start the session to access session variables.
 */
session_start();

/**
 * Redirect to the login page if the user is not logged in.
 */
if (!isset($_SESSION['user']))
    header("location: index.php?Message=Login To Continue");

/**
 * Retrieve the username of the logged-in user.
 */
$customer_name = $_SESSION['user'];
$query_ = "SELECT * FROM users WHERE username='$customer_name'";
$result_ = mysqli_query($con, $query_) or die(mysqli_error($con));
$row = mysqli_fetch_assoc($result_);
$customer = $row['user_id'];

/**
 * Process the order placement.
 */
if (isset($_GET['place'])) {
    // Clear the cart for the current customer
    $query = "DELETE FROM cart where user_id='$customer'";
    $result = mysqli_query($con, $query);

    // Display a success message for order placement using JavaScript alert
    ?>
    <script type="text/javascript">
        alert("Order Successfully Placed!");
    </script>
    <?php
}

/**
 * Process the removal of an item from the cart.
 */
if (isset($_GET['remove'])) {
    // Retrieve the product to be removed
    $product = $_GET['remove'];

    // Remove the specified item from the cart for the current customer
    $query = "DELETE FROM cart where user_id='$customer' AND product_id='$product'";
    $result = mysqli_query($con, $query);

    // Display a success message for item removal using JavaScript alert
    ?>
    <script type="text/javascript">
        alert("Item Successfully Removed!");
    </script>
    <?php
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
    <meta name="author" content="Hossein">

    <!-- Define the shortcut icon for the website -->
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
    <link rel="icon" href="/favicon.ico" type="image/x-icon">

    <!-- Add an additional description for the document -->
    <meta name="description" content="Cart">

    <!-- Set the title of the HTML document -->
    <title>Order</title>

    <!-- Include external CSS files, such as Bootstrap and custom styles -->
    <link href="CSS/bootstrap.min.css" rel="stylesheet">
    <link href="CSS/my.css" rel="stylesheet">

    <!-- Define internal styles using the <style> tag -->
    <style>
        #cart {
            /* Styling for the 'cart' element */
            margin-top: 30px;
            margin-bottom: 30px;
        }

        .panel {
            /* Styling for panels */
            border: 1px solid #D67B22;
            padding-left: 0px;
            padding-right: 0px;
        }

        .panel-heading {
            /* Styling for panel headings */
            background: #D67B22 !important;
            color: white !important;
        }

        @media only screen and (width: 767px) {
            /* Media query for screens with width up to 767px */
            body {
                margin-top: 150px;
            }
        }
    </style>
</head>

<!-- Body section of the HTML document -->
<body>
<nav class="navbar navbar-default navbar-fixed-top navbar-inverse">
    <!-- Navigation bar with default styling, fixed to the top, and using an inverse color scheme -->

    <div class="container-fluid">
        <!-- Container for the navigation bar content -->

        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <!-- Navigation bar header section, including brand/logo and toggle button for mobile display -->

            <!-- Toggle button for collapsed navigation on small screens -->
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            <!-- Brand/logo section -->
            <a class="navbar-brand" href="index.php" style="padding: 1px;">
                <!-- Brand/logo image -->
                <img class="img-responsive" alt="Brand" src="Image/logo.jpg" style="width: 147px; margin: 0px;">
            </a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <!-- Navigation links, forms, and other content when the navbar is collapsed -->

            <ul class="nav navbar-nav navbar-right">
                <!-- List of navigation links aligned to the right -->

                <?php
                // Check if user is not logged in
                if (!isset($_SESSION['user'])) {
                    echo '
                    <!-- Login button and modal -->
                    <li>
                        <button type="button" id="login_button" class="btn btn-lg" data-toggle="modal" data-target="#login">
                            Login
                        </button>

                        <!-- Login modal -->
                        <div id="login" class="modal fade" role="dialog">
                            <!-- Modal content for login -->
                            <!-- ... (login form details) ... -->
                        </div>
                    </li>

                    <!-- Sign Up button and modal -->
                    <li>
                        <button type="button" id="register_button" class="btn btn-lg" data-toggle="modal" data-target="#register">
                            Sign Up
                        </button>

                        <!-- Registration modal -->
                        <div id="register" class="modal fade" role="dialog">
                            <!-- Modal content for registration -->
                            <!-- ... (registration form details) ... -->
                        </div>
                    </li>';
                } else {
                    // User is logged in, display logout option
                    echo ' 
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

<?php
// Display the container for the shopping cart content
echo '<div class="container-fluid" id="cart">
      <div class="row">
          <div class="col-xs-12 text-center" id="heading">
                 <h2 style="color:#D67B22;text-transform:uppercase;">  YOUR CART </h2>
           </div>
        </div>';

// Check if the user is logged in
if (isset($_SESSION['user'])) {
    // Check if product ID and quantity are set in the URL
    if (isset($_GET['ID'])) {
        // Process adding or updating the product in the cart
        $product = $_GET['ID'];
        $quantity = $_GET['quantity'];

        $query = "SELECT * from cart where product_id='$product' AND user_id='$customer'";
        $result = mysqli_query($con, $query);

        $row = mysqli_fetch_assoc($result);

        if (mysqli_num_rows($result) == 0) {
            // Insert a new entry if the product is not in the cart
            $query = "INSERT INTO cart (product_id, user_id, quantity) values ($product, $customer, $quantity)";
            $result = mysqli_query($con, $query);



        } else {
            // Update the quantity if the product is already in the cart
            $new = $_GET['quantity'];
            $query = "UPDATE cart SET quantity=$new WHERE product_id='$product' AND user_id='$customer'";
            $result = mysqli_query($con, $query);
        }
    }

    // Retrieve cart details for the current user
    $query = "SELECT
            p.product_id as PID,
            p.product_name as Name,
            p.product_description as Description,
            p.product_price as Price,
            c.quantity as Quantity,
            cat.category_name as Category,
            p.image_url as Image
            FROM
                cart c
            JOIN
                products p ON c.product_id = p.product_id
            JOIN
                categories cat ON p.category_id = cat.category_id
            WHERE
                c.user_id = '$customer'";

    $result = mysqli_query($con, $query);
    $total = 0;

    if (mysqli_num_rows($result) > 0) {
        // Display cart items
        $i = 1;
        $j = 0;

        while ($row = mysqli_fetch_assoc($result)) {
            // Generate paths and calculate subtotal
            $path = "Image/shoes/" . $row['Image'];
            $Stotal = $row['Quantity'] * $row['Price'];

            // Determine offset for responsive design
            if ($i % 2 == 1) $offset = 1;
            if ($i % 2 == 0) $offset = 2;
            if ($j % 2 == 0)
                echo '<div class="row">';

            // Display individual cart item
            echo '<div class="panel col-xs-12 col-sm-4 col-sm-offset-' . $offset . ' col-md-4 col-md-offset-' . $offset . ' col-lg-4 col-lg-offset-' . $offset . ' text-center" style="color:#D67B22;font-weight:800;">
                  <div class="panel-heading">Order ' . $i . '
                  </div>
                  <div class="panel-body">
                        <img class="image-responsive block-center" src="' . $path . '" style="height :100px;"> <br>
                        Name : ' . $row['Name'] . '  <br> 
                        Code : ' . $row['PID'] . '     <br>        	            
                        Description : ' . $row['Description'] . ' <br>
                        Quantity : ' . $row['Quantity'] . ' <br>
                        Price : ' . $row['Price'] . ' <br>
                        Sub Total : ' . $Stotal . ' <br>
                       <a href="Cart.php?remove=' . $row['PID'] . '" class="btn btn-sm" 
                           style="background:#D67B22;color:white;font-weight:800;">
                           Remove
                       </a>
                </div>
            </div>';

            if ($j % 2 == 1)
                echo '</div>';

            // Update total and counters
            $total = $total + $Stotal;
            $i++;
            $j++;
        }

        // Display total and buttons to continue shopping or place an order
        echo '<div class="container">
                              <div class="row">  
                                 <div class="panel col-xs-8 col-xs-offset-2 col-sm-4 col-sm-offset-4 col-md-4 col-md-offset-4 col-lg-4 col-lg-offset-4 text-center" style="color:#D67B22;font-weight:800;">
                                     <div class="panel-heading">TOTAL
                                     </div>
                                      <div class="panel-body">' . $total . '
                                     </div>
                                 </div>
                               </div>
                          </div>
                         ';
        echo '<br> <br>';
        echo '<div class="row">
                             <div class="col-xs-8 col-xs-offset-2  col-sm-4 col-sm-offset-2 col-md-4 col-md-offset-3 col-lg-4 col-lg-offset-3">
                                  <a href="index.php" class="btn btn-lg" style="background:#D67B22;color:white;font-weight:800;">Continue Shopping</a>
                             </div>
                             <div class="col-xs-6 col-xs-offset-3 col-sm-4 col-sm-offset-2 col-md-4 col-md-offset-1 col-lg-4 ">
                                  <a href="Cart.php?place=true" class="btn btn-lg" style="background:#D67B22;color:white;font-weight:800;margin-top:5px;">Place Order</a>
                             </div>
                           </div>
                           ';
    } else {
        // Display message if the cart is empty
        echo '<div class="row">
                            <div class="col-xs-9 col-xs-offset-3 col-sm-4 col-sm-offset-5 col-md-4 col-md-offset-5">
                                 <span class="text-center" style="color:#D67B22;font-weight:bold;">&nbsp &nbsp &nbsp &nbspCart Is Empty</span>
                             </div>
                         </div>
                         <div class="row">
                             <div class="col-xs-9 col-xs-offset-3 col-sm-2 col-sm-offset-5 col-md-2 col-md-offset-5">
                                  <a href="index.php" class="btn btn-lg" style="background:#D67B22;color:white;font-weight:800;">Do Some Shopping !</a>
                             </div>
                          </div>';
    }
} else
    // Display message if the user is not logged in
    echo "Login to continue";

// Close the container div for the shopping cart content
echo '</div>';
?>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="JS/bootstrap.min.js"></script>
</body>
</html>