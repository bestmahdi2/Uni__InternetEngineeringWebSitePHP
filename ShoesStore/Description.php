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
    <title>Shoe Description</title>

    <!-- Include external CSS files, such as Bootstrap and custom styles -->
    <link href="CSS/bootstrap.min.css" rel="stylesheet">
    <link href="CSS/my.css" rel="stylesheet">

    <!-- Define internal styles using the <style> tag -->
    <style>
        /* Media query for screens with a width of 768px or higher */
        @media only screen and (width: 768px) {
            body {
                margin-top: 150px; /* Add top margin to the body */
            }
        }

        /* Media query for screens with a maximum width of 760px */
        @media only screen and (max-width: 760px) {
            #shoes .row {
                margin-top: 10px; /* Adjust margin for rows within the #shoes section */
            }
        }

        /* CSS styles for the tag class */
        .tag {
            display: inline;
            float: left;
            padding: 2px 5px;
            width: auto;
            background: #F5A623;
            color: #fff;
            height: 23px;
        }

        /* CSS styles for the tag-side class */
        .tag-side {
            display: inline;
            float: left;
        }

        /* CSS styles for the #shoes section */
        #shoes {
            border: 1px solid #DEEAEE;
            margin-bottom: 20px;
            padding-top: 30px;
            padding-bottom: 20px;
            background: #fff;
            margin-left: 10%;
            margin-right: 10%;
        }

        /* CSS styles for the #description section */
        #description {
            border: 1px solid #DEEAEE;
            margin-bottom: 20px;
            padding: 20px 50px;
            background: #fff;
            margin-left: 10%;
            margin-right: 10%;
        }

        /* CSS styles for horizontal rule within the #description section */
        #description hr {
            margin: auto;
        }

        /* CSS styles for the #service section */
        #service {
            background: #fff;
            padding: 20px 10px;
            width: 112%;
            margin-left: -6%;
            margin-right: -6%;
        }

        /* CSS styles for the glyphicon class */
        .glyphicon {
            color: #D67B22;
        }
    </style>
</head>

<body>
<!-- Navigation bar with fixed top, default style, and inverse color scheme -->
<nav class="navbar navbar-default navbar-fixed-top navbar-inverse">
    <!-- Container for the navigation bar content -->
    <div class="container-fluid">
        <!-- Brand and toggle button for better mobile display -->
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
            <a class="navbar-brand" href="index.php">
                <!-- Image logo with specified width and margin -->
                <img alt="Brand" src="Image/logo.jpg" style="width: 118px; margin-top: -7px; margin-left: -10px;">
            </a>
        </div>

        <!-- Collect the navigation links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <!-- Unordered list for navigation links, aligned to the right -->
            <ul class="nav navbar-nav navbar-right">
                <?php
                // Check if a user session is set
                if (isset($_SESSION['user'])) {
                    // Display Cart and Logout links if the user is logged in
                    echo '
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

<?php
// Include the database connection file
include "DataBaseConnect.php";

// Get the product ID from the URL parameter
$PID = $_GET['ID'];

// Query to retrieve product information based on the product ID
$query = "SELECT *, cat.category_name FROM products p JOIN categories cat ON p.category_id = cat.category_id WHERE product_id='$PID'";
$result = mysqli_query($con, $query) or die(mysql_error());

// Check if there are rows returned from the query
if (mysqli_num_rows($result) > 0) {
    // Loop through each row of the result set
    while ($row = mysqli_fetch_assoc($result)) {
        // Construct the path to the product image
        $path = "Image/shoes/" . $row['image_url'];

        // Construct the target link for adding the product to the cart
        $target = "Cart.php?ID=" . $PID . "&";

        // Display the product details and image in a container
        echo '
        <div class="container-fluid" id="shoes"> 
            <div class="row">
                <div class="col-sm-10 col-md-6">
                    <div class="tag">' . $row["product_discount"] . '%OFF</div>
                    <div class="tag-side"><img src="Image/orange-flag.png"></div>
                    <img class="center-block img-responsive" src="' . $path . '" height="550px" style="padding:20px;" alt="">
                </div>
                <div class="col-sm-10 col-md-4 col-md-offset-1">
                    <h2> ' . $row["product_name"] . '</h2>
                    <span style="color:#00B9F5;"> 
                        #' . $row["product_seller"] . '&nbsp &nbsp #' . str_replace(" ", "_", $row["category_name"]) . '
                    </span>
                    <hr>            
                    <span style="font-weight:bold;"> Quantity : </span>';
        // Display a dropdown for selecting the quantity of the product
        echo '<select id="quantity">';
        for ($i = 1; $i <= $row['product_available']; $i++)
            echo '<option value="' . $i . '">' . $i . '</option>';
        echo '</select>';
        echo '<br><br><br>
                    <a id="buyLink" href="' . $target . '" class="btn btn-lg btn-danger" style="padding:15px;color:white;text-decoration:none;"> 
                        ADD TO CART for ' . $row["product_price"] - ($row["product_price"]*$row["product_discount"]/100) . '$ <br>
                        <span style="text-decoration:line-through;"> ' . $row["product_price"] . '$ </span> 
                        | ' . $row["product_discount"] . '% discount
                    </a>  
                </div>
            </div>
        </div>';

        // Display a container with product description and details
        echo '<div class="container-fluid" id="description">
                    <div class="row">
                        <h2> Description </h2> 
                        <p>' . $row['product_full_description'] . '</p>
                        <pre style="background:inherit;border:none;">
                            CODE          ' . $row["product_id"] . '   <hr> 
                            NAME          ' . $row["product_name"] . ' <hr> 
                            SHORT STORY   ' . $row["product_description"] . ' <hr>
                            SELLER        ' . $row["product_seller"] . ' <hr>
                            AVAILABLE     ' . $row["product_available"] . ' <hr>  
                            WEIGHT        ' . $row["product_weight"] . ' <hr>
                        </pre>
                    </div>
                </div>';
    }
}

// Close the container div
echo '</div>';
?>

<!-- Service Section -->
<div class="container-fluid" id="service">
    <div class="row">
        <!-- Service Box 1 -->
        <div class="col-sm-6 col-md-3 text-center">
            <span class="glyphicon glyphicon-heart"></span> <br>
            24X7 Care <br>
            Happy to help 24X7, call us on +989145258789 !
        </div>
        <!-- Service Box 2 -->
        <div class="col-sm-6 col-md-3 text-center">
            <span class="glyphicon glyphicon-ok"></span> <br>
            Trust <br>
            Your money is yours! All refunds come with no question asked guarantee.
        </div>
        <!-- Service Box 3 -->
        <div class="col-sm-6 col-md-3 text-center">
            <span class="glyphicon glyphicon-check"></span> <br>
            Assurance <br>
            We provide 100% assurance. If you have any issue, your money is immediately refunded. Sit back and enjoy
            your shopping.
        </div>
        <!-- Service Box 4 -->
        <div class="col-sm-6 col-md-3 text-center">
            <span class="glyphicon glyphicon-tags"></span> <br>
            Good Shop <br>
            Happiness is guaranteed. If we fall short of your expectations, give us a shout.
        </div>
    </div>
</div>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="JS/bootstrap.min.js"></script>

<!-- JavaScript for Dynamic Link Update -->
<script>
    $(function () {
        // Get the original link from the buyLink element
        var link = $('#buyLink').attr('href');

        // Append the quantity parameter to the link based on the selected quantity
        $('#buyLink').attr('href', link + 'quantity=' + $('#quantity option:selected').val());

        // Update the link when the quantity dropdown changes
        $('#quantity').on('change', function () {
            $('#buyLink').attr('href', link + 'quantity=' + $('#quantity option:selected').val());
        });
    });
</script>

</body>
</html>       
