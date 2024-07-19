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
        /* This style rule adds a bottom margin of 50px to the element with the id "shoes". */
        #shoes {
            margin-bottom: 50px;
        }

        /* This media query applies to screens with a width of 767px or less. */
        @media only screen and (width: 767px) {
            /* This rule adds a top margin of 150px to the body element. */
            body {
                margin-top: 150px;
            }
        }

        /* This style rule applies to the element with the class "row" within the element with the id "shoes". */
        #shoes .row {
            /* This rule adds a top margin of 20px and a bottom margin of 10px to the element with the class "row". */
            margin-top: 20px;
            margin-bottom: 10px;

            /* This rule sets the font weight of the element with the class "row" to 800. */
            font-weight: 800;
        }

        /* This media query applies to screens with a maximum width of 760px. */
        @media only screen and (max-width: 760px) {
            /* This rule reduces the top margin of the element with the class "row" to 10px. */
            #shoes .row {
                margin-top: 10px;
            }
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
/*
 * This code retrieves shoes from a database and displays them on a web page.
 *
 * It takes the category of shoes as a parameter, and sorts the shoes by price or discount as requested by the user.
 */

// Check if the category parameter is set
if (isset($_GET['value'])) {
    // Set the category variable
    $_SESSION['category'] = $_GET['value'];
}

// Get the category from the session variable
$category = $_SESSION['category'];

// Check if the sort parameter is set
if (isset($_POST['sort'])) {
    // Set the sort order according to the selected option
    if ($_POST['sort'] == "price")
        $sort_order = "product_price";
    else if ($_POST['sort'] == "price_d")
        $sort_order = "product_price DESC";
    else if ($_POST['sort'] == "discount")
        $sort_order = "product_discount";
    else if ($_POST['sort'] == "discount_d")
        $sort_order = "product_discount DESC";

    // Retrieve the shoes from the database and sort them by the specified order
    $query = "SELECT *, cat.category_name FROM products p JOIN categories cat ON p.category_id = cat.category_id WHERE p.category_id='$category' ORDER BY $sort_order";
    $result = mysqli_query($con, $query) or die(mysqli_error($con));
    $row = mysqli_fetch_assoc($result);
    // reproduce the results to avoid losing the first one
    $result = mysqli_query($con, $query) or die(mysqli_error($con));
    $category_name = $row['category_name'];

} else {
    // Retrieve the shoes from the database and do not sort them
    $query = "SELECT *, cat.category_name FROM products p JOIN categories cat ON p.category_id = cat.category_id WHERE p.category_id='$category'";
    $result = mysqli_query($con, $query) or die(mysqli_error($con));
    $row = mysqli_fetch_assoc($result);
    // reproduce the results to avoid losing the first one
    $result = mysqli_query($con, $query) or die(mysqli_error($con));
    $category_name = $row['category_name'];
}

// Initialize a counter to keep track of the row number
$i = 0;

// Display the heading of the page
echo '<div class="container-fluid" id="shoes">
  <div class="row">
    <div class="col-xs-12 text-center" id="heading">
      <h2 style="color:rgb(228, 55, 25);text-transform:uppercase;margin-bottom:0px;"> ' . $category_name . ' STORE </h2>
    </div>
  </div>
</div>';

// Display the form for sorting the shoes
echo '<div class="container fluid">
  <div class="row">
    <div class="col-sm-5 col-sm-offset-6 col-md-5 col-md-offset-7 col-lg-4 col-lg-offset-8">
      <form action="' . $_SERVER['PHP_SELF'] . '" method="post" class="pull-right">
        <label for="sort">Sort by &nbsp: &nbsp</label>
        <select name="sort" id="select" onchange="form.submit()">
          <option value="default" name="default" selected="selected">Select</option>
          <option value="price" name="price">Low To High Price</option>
          <option value="price_d" name="price_d">Highest To Lowest Price</option>
          <option value="discount" name="discount">Low To High Discount</option>
          <option value="discount_d" name="discount_d">Highest To Lowest Discount</option>
        </select>
      </form>
    </div>
  </div>
</div>';

// Display the shoes
if (mysqli_num_rows($result) > 0) {
    // Loop through the results and display each shoe
    while ($row = mysqli_fetch_assoc($result)) {
        // Get the image path and description for the shoe
        $path = "Image/shoes/" . $row['image_url'] ;
        $description = "description.php?ID=" . $row["product_id"];

        // Check if the current row number is divisible by 4
        if ($i % 4 == 0) {
            // Start a new row
            echo '<div class="row">';
        }

        // Display the shoe block with the image, title, price, and discount
        echo '<a href="' . $description . '">
      <div class="col-sm-6 col-md-3 col-lg-3 text-center">
        <div class="shoe-block" style="border :3px solid #DEEAEE;">
          <img class="shoe block-center img-responsive" src="' . $path . '">
          <hr> 
          ' . $row["product_name"] . '<br>
          ' . $row["product_price"] - ($row["product_price"]*$row["product_discount"]/100) . ' &nbsp
          <span style="text-decoration:line-through;color:#828282;"> ' . $row["product_price"] . ' </span>
          <span class="label label-warning">' . $row["product_discount"] . '%</span>
        </div>
      </div>
    </a>
  </div>';

        // Increment the row counter
        $i++;

        // Check if the current row number is divisible by 4 and a new row should be started
        if ($i % 4 == 0) {
            echo '</div>';
        }
    }
}

// Close the container for the page
echo '</div>';

// Close the database connection
mysqli_close($con);
?>


<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="JS/bootstrap.min.js"></script>

</body>
</html>

<!--	
<script>
$('#my_select').change(function() {   
   // assign the value to a variable, so you can test to see if it is working
    var selectVal = $('#my_select :selected').val();
    alert(selectVal);
});
</script>

-->
