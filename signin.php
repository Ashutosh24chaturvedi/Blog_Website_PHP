<?php
require 'config/constants.php';

$username_email = $_SESSION['signin-data']['username_email'] ?? null;
$password = $_SESSION['signin-data']['password'] ?? null;

unset($_SESSION['signin-data']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog Website</title>
    <!-- Custom stylesheet -->
    <link rel="stylesheet" href="./css/style.css" />
    <!-- iconscout Cdn -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css" />
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Bubblegum+Sans&family=Libre+Baskerville&family=Montserrat:ital,wght@0,300;0,400;0,500;0,800;0,900;1,600&display=swap" rel="stylesheet">
</head>

<body>

    <section class="form_section">
        <div class="container form_section-container">
            <h2>Sign In</h2>
            <?php if (isset($_SESSION['signup-success'])) : ?>
                <div class="alert_message success">
                    <p>
                        <?= $_SESSION['signup-success'];
                        unset($_SESSION['signup-success']); ?>
                    </p>
                </div>
            <?php elseif (isset($_SESSION['signin'])) : ?>
                <div class="alert_message error">
                    <p>
                        <?= $_SESSION['signin'];
                        unset($_SESSION['signin']); ?>
                    </p>
                </div>
            <?php endif; ?>
            <form action="<?= ROOT_URL ?>signin-logic.php" enctype="multipart/form-data" method="POST">
                <input type="text" placeholder="Username or Email" name="username_email" value="<?= $username_email ?>">
                <input type="password" placeholder="Password" name="password" value="<?= $password ?>">
                <button type="submit" class="btn" name="submit">Sign In</button>
                <small>Don't have an account? <a href="signup.php">Sign Up</a></small>
            </form>
        </div>
    </section>

    <script src="./js/main.js"></script>
</body>

</html>