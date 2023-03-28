<?php
require 'config/constants.php';

//get back form data if there was a registeration error

$firstname = $_SESSION['signup-data']['firstname'] ?? null;
$lastname = $_SESSION['signup-data']['lastname'] ?? null;
$username = $_SESSION['signup-data']['username'] ?? null;
$email = $_SESSION['signup-data']['email'] ?? null;
$createpassword = $_SESSION['signup-data']['createpassword'] ?? null;
$confirmpassword = $_SESSION['signup-data']['confirmpassword'] ?? null;

//delete signup-data session
unset($_SESSION['signup-data']);
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
            <h2>Sign Up</h2>
            <?php if (isset($_SESSION['signup'])) : ?>

                <div class="alert_message error">
                    <p>
                        <?= $_SESSION['signup'];
                        unset($_SESSION['signup']);
                        ?>
                    </p>
                </div>

            <?php endif; ?>
            <!-- signup-logic.php     multipart/form-data is used as for file upload -->
            <form action="<?= ROOT_URL ?>signup-logic.php" enctype="multipart/form-data" method="POST">
                <input type="text" placeholder="First Name" value="<?= $firstname ?>" name="firstname">
                <input type="text" placeholder="Last Name" value="<?= $lastname ?>" name="lastname">
                <input type="text" placeholder="Username" value="<?= $username ?>" name="username">
                <input type="email" placeholder="Email" value="<?= $email ?>" name="email">
                <input type="password" placeholder="Create Password" name="createpassword" value="<?= $createpassword ?>">
                <input type="password" placeholder="Confirm Password" name="confirmpassword" value="<?= $confirmpassword ?>">
                <div class="form_control">
                    <label for="avatar">User Avatar</label>
                    <input type="file" id="avatar" name="avatar">
                </div>
                <button type="submit" class="btn" name="submit">Sign Up</button>
                <small>Already have an account? <a href="signin.php">Sign In</a></small>
            </form>
        </div>
    </section>

    <script src="./js/main.js"></script>
</body>

</html>