<?php
$connection = mysqli_connect('localhost', 'root', '', 'book_db');
if (!$connection) {
    die('Database connection error: ' . mysqli_connect_error());
}

$errors = array();

if (isset($_POST['send'])) {
    //Sanitize data
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_NUMBER_INT);
    $address = filter_input(INPUT_POST, 'address', FILTER_SANITIZE_STRING);
    $location = filter_input(INPUT_POST, 'location', FILTER_SANITIZE_STRING);
    $guests = filter_input(INPUT_POST, 'guests', FILTER_SANITIZE_NUMBER_INT);
    $arrivals = $_POST['arrivals'];
    $leaving = $_POST['leaving'];


    // Validate name
    if (empty($name)) {
        $errors['name'] = "Name is required";
    } elseif (strlen($name) < 2 || strlen($name) > 20) {
        $errors['name'] = "Name must be between 2 and 20 characters";
    }

    // Validate email
    if (empty($email)) {
        $errors['email'] = "Email is required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Invalid email format";
    }

    // Validate phone number
    if (empty($phone)) {
        $errors['phone'] = "Phone number is required";
    } elseif (!preg_match("/^[0-9]{10}$/", $phone)) {
        $errors['phone'] = "Invalid phone number format. Need 10 numbers";
    }

    // Validate address
    if (empty($address)) {
        $errors['address'] = "Address is required";
    }

    // Validate location
    if (empty($location)) {
        $errors['location'] = "Location is required";
    }

    // Validate number of guests
    if (empty($guests)) {
        $errors['guests'] = "Number of guests is required";
    } elseif (!preg_match("/^[1-9][0-9]*$/", $guests)) {
        $errors['guests'] = "Invalid number of guests";
    }

    if (empty($errors)) {
        $request = "INSERT INTO book_form (name, email, phone, address, location, guests, arrivals, leaving) VALUES ('$name','$email','$phone','$address','$location','$guests','$arrivals','$leaving')";

        $result = mysqli_query($connection, $request);
        if ($result) {
            header('Location: book.php');
            exit;
        } else {
            echo 'Query error: ' . mysqli_error($connection);
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>home</title>
    <!-- swiper css link -->
    <link rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css"/>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- custom css file link -->
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
<!-- header section starts -->
<section class="header">
    <a href="home.php" class="logo">Travel</a>
    <nav class="navbar">
        <a href="home.php">home</a>
        <a href="about.php">about</a>
        <a href="package.php">package</a>
        <a href="book.php">book</a>
    </nav>

    <div id="menu-btn" class="fas fa-bars"></div>
</section>


<!-- header section ends -->
<div class="heading" style="background: url(images/header-bg-3.png)no-repeat;">
    <h1>book now</h1>
</div>

<!-- booking section starts  -->

<section class="booking">

    <h1 class="heading-title">book your trip!</h1>

    <form action="book.php" method="post" class="book-form">

        <div class="flex">
            <div class="inputBox">
                <span>name :</span>
                <input type="text" placeholder="enter your name" name="name">
                <?php if (isset($errors['name'])) { ?>
                    <span class="error"><?php echo $errors['name']; ?></span>
                <?php } ?>
            </div>
            <div class="inputBox">
                <span>email :</span>
                <input type="email" placeholder="enter your email" name="email">
                <?php if (isset($errors['email'])) { ?>
                    <span class="error"><?php echo $errors['email']; ?></span>
                <?php } ?>
            </div>
            <div class="inputBox">
                <span>phone :</span>
                <input type="number" placeholder="enter your number" name="phone">
                <?php if (isset($errors['phone'])) { ?>
                    <span class="error"><?php echo $errors['phone']; ?></span>
                <?php } ?>
            </div>
            <div class="inputBox">
                <span>address :</span>
                <input type="text" placeholder="enter your address" name="address">
                <?php if (isset($errors['address'])) { ?>
                    <span class="error"><?php echo $errors['address']; ?></span>
                <?php } ?>
            </div>
            <div class="inputBox">
                <span>where to :</span>
                <input type="text" placeholder="place you want to visit" name="location">
                <?php if (isset($errors['location'])) { ?>
                    <span class="error"><?php echo $errors['location']; ?></span>
                <?php } ?>
            </div>
            <div class="inputBox">
                <span>how many :</span>
                <input type="number" placeholder="number of guests" name="guests">
                <?php if (isset($errors['guests'])) { ?>
                    <span class="error"><?php echo $errors['guests']; ?></span>
                <?php } ?>
            </div>
            <div class="inputBox">
                <span>arrivals :</span>
                <input type="date" name="arrivals">
            </div>
            <div class="inputBox">
                <span>leaving :</span>
                <input type="date" name="leaving">
            </div>
        </div>

        <input type="submit" value="submit" class="btn" name="send">

    </form>

</section>

<!-- booking section ends -->

<!-- footer section starts  -->

<section class="footer">

    <div class="box-container">

        <div class="box">
            <h3>quick links</h3>
            <a href="home.php"> <i class="fas fa-angle-right"></i> home</a>
            <a href="about.php"> <i class="fas fa-angle-right"></i> about</a>
            <a href="package.php"> <i class="fas fa-angle-right"></i> package</a>
            <a href="book.php"> <i class="fas fa-angle-right"></i> book</a>
        </div>

        <div class="box">
            <h3>extra links</h3>
            <a href="#"> <i class="fas fa-angle-right"></i> ask questions</a>
            <a href="#"> <i class="fas fa-angle-right"></i> about us</a>
            <a href="#"> <i class="fas fa-angle-right"></i> privacy policy</a>
            <a href="#"> <i class="fas fa-angle-right"></i> terms of use</a>
        </div>

        <div class="box">
            <h3>contact info</h3>
            <a href="#"> <i class="fas fa-phone"></i> +123-456-7890 </a>
            <a href="#"> <i class="fas fa-phone"></i> +111-222-3333 </a>
            <a href="#"> <i class="fas fa-envelope"></i> jelanialexander@ymail.com </a>
            <a href="#"> <i class="fas fa-map"></i> Gamagori, Japan - 400104 </a>
        </div>

        <div class="box">
            <h3>follow us</h3>
            <a href="#"> <i class="fab fa-facebook-f"></i> facebook </a>
            <a href="#"> <i class="fab fa-twitter"></i> twitter </a>
            <a href="#"> <i class="fab fa-instagram"></i> instagram </a>
            <a href="#"> <i class="fab fa-linkedin"></i> linkedin </a>
        </div>

    </div>

    <div class="credit"> created by <span>Jelani Alexander</span> | all rights reserved!</div>

</section>

<!-- footer section ends -->


<!-- swiper js link -->
<script src="swiper.php"></script>
<!-- custom js file link -->
<script src="js/script.js"></script>
</body>

</html>