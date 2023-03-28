<?php
require 'config/database.php';

//fetch current user from database

if (isset($_SESSION['user_id'])) {
    $id = filter_var($_SESSION['user_id'], FILTER_SANITIZE_NUMBER_INT);
    $query = "SELECT avatar FROM users WHERE id=$id";
    $result = mysqli_query($conn, $query);
    $avatar = mysqli_fetch_assoc($result);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog Website</title>
    <!-- Custom stylesheet -->
    <link rel="stylesheet" href="<?= ROOT_URL ?>css/style.css" />
    <!-- iconscout Cdn -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css" />
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Bubblegum+Sans&family=Libre+Baskerville&family=Montserrat:ital,wght@0,300;0,400;0,500;0,800;0,900;1,600&display=swap" rel="stylesheet">
</head>

<body>
    <!-- ===========================Start of Nav=========================== -->
    <nav>
        <div class="container nav_container">
            <a href="<?= ROOT_URL ?>" class="nav_logo">MyBlog</a>
            <ul class="nav_items">
                <li><a href="<?php echo ROOT_URL ?>blog.php">Blog</a></li>
                <li><a href="<?= ROOT_URL ?>about.php">About</a></li>
                <li><a href="<?= ROOT_URL ?>services.php">Services</a></li>
                <li><a href="<?= ROOT_URL ?>contact.php">Contact</a></li>
                <?php if (isset($_SESSION['user_id'])) : ?>
                    <li class="nav_profile">
                        <div class="avatar">
                            <img src="<?= ROOT_URL . 'images/' . $avatar['avatar'] ?>" />
                        </div>
                        <ul>
                            <li><a href="<?= ROOT_URL ?>admin/index.php">Dashboard</a></li>
                            <li><a href="<?= ROOT_URL ?>logout.php">Logout</a></li>
                        </ul>
                    </li>
                <?php else : ?>
                    <li><a href="<?= ROOT_URL ?>signin.php">Signin</a></li>
                <?php endif; ?>
            </ul>
            <!-- for small screen -->
            <button id="open_nav_btn"><i class="uil uil-bars"></i></button>
            <button id="close_nav_btn"><i class="uil uil-times"></i></button>
        </div>
    </nav>
    <!-- ===========================End of Nav=========================== -->