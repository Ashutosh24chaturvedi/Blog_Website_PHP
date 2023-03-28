<?php
require 'config/database.php';

//get user form if submit button is clicked

if (isset($_POST['submit'])) {
    $firstname = filter_var($_POST['firstname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $lastname = filter_var($_POST['lastname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $username = filter_var($_POST['username'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $createpassword = filter_var($_POST['createpassword'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $confirmpassword = filter_var($_POST['confirmpassword'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $is_admin = filter_var($_POST['userrole'], FILTER_SANITIZE_NUMBER_INT);
    $avatar = $_FILES['avatar'];
    // var_dump($avatar);
    // echo $firstname, $lastname, $username, $email, $createpassword, $confirmpassword;

    //validate input values
    if (!$firstname) {
        $_SESSION['add-user'] = "Please enter First Name";
    } else if (!$lastname) {
        $_SESSION['add-user'] = "Please enter Last Name";
    } else if (!$username) {
        $_SESSION['add-user'] = "Please enter UserName";
    } else if (!$email) {
        $_SESSION['add-user'] = "Please enter Email";
    } else if (strlen($createpassword) < 8 || strlen($confirmpassword) < 8) {
        $_SESSION['add-user'] = "Password should be at least 8 characters";
    } else if (!$avatar['name']) {
        $_SESSION['add-user'] = "Please add avatar";
    } else {
        // check if password don't match
        if ($createpassword !== $confirmpassword) {
            $_SESSION['add-user'] = "Password does not match";
        } else {
            //hash password
            $hashed_password = password_hash($createpassword, PASSWORD_DEFAULT);
            // echo $hashed_password;

            //check if username or email is already exists in database
            $user_check_query = "SELECT * FROM users WHERE username='$username' OR email='$email'";
            $user_check_result = mysqli_query($conn, $user_check_query);

            if (mysqli_num_rows($user_check_result) > 0) {
                $_SESSION['add-user'] = "Username or Email already exists";
            } else {
                //work on avatar
                //rename avatar
                $time = time();  //current time
                $avatar_name = $time . $avatar['name'];
                $avatar_tmp_name = $avatar['tmp_name'];
                $avatar_destination_path = '../images/' . $avatar_name;

                //make sure file is an image
                $allowed_files = ['png', 'jpg', 'jpeg'];
                $extension = explode('.', $avatar_name);
                $extension = end($extension);
                if (in_array($extension, $allowed_files)) {
                    //make sure image is not too large(1mb+)
                    if ($avatar['size'] < 1000000) {
                        //upload image
                        move_uploaded_file($avatar_tmp_name, $avatar_destination_path);
                    } else {
                        $_SESSION['add-user'] = "File size is too large, should be smaller than 1 MB";
                    }
                } else {
                    $_SESSION['add-user'] = "File should be png, jpg or jpeg";
                }
            }
        }
    }
    //redirect back to add-user page if there was any problem
    if (isset($_SESSION['add-user'])) {
        //pass form data back to signup page
        $_SESSION['add-user-data'] = $_POST;
        header('location: ' . ROOT_URL . 'admin/add-user.php');
        die();
    } else {
        //insert new user data into user table in database
        $insert_user_query = "INSERT INTO users (firstname, lastname, username, email, password, avatar,is_admin) VALUES ('$firstname','$lastname','$username','$email','$hashed_password','$avatar_name','$is_admin');";

        $insert_user_result = mysqli_query($conn, $insert_user_query);

        if (!mysqli_errno($conn)) {
            //redirect to login page with success message
            $_SESSION['add-user-success'] = "New User $firstname $lastname added successfully";
            header('location:' . ROOT_URL . 'admin/manage-users.php');
            die();
        }
    }
} else {
    //if btn wasn't clicked, bounce back to add-user page
    header('location:' . ROOT_URL . 'admin/add-user.php');
    die();
}
