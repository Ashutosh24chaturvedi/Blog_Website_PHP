<?php

require 'config/database.php';

if (isset($_GET['id'])) {
    //get updated form data
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
    // fetch user data from database
    $query = "SELECT * FROM users WHERE id = $id;";
    $result = mysqli_query($conn, $query);
    $user = mysqli_fetch_assoc($result);

    // make sure we get back one record 
    if (mysqli_num_rows($result) == 1) {
        // var_dump($user);
        $avatar_name = $user['avatar'];
        $avatar_path = '../images/' . $avatar_name;
        //delete image if available
        if ($avatar_name) {
            unlink($avatar_path);
        }
    }

    //For Later
    //fetch all thumbnails of user and delete items

    $thumbnails_query = "SELECT thumbnail FROM posts WHERE author_id =$id;";
    $thumbnails_result = mysqli_query($conn, $thumbnails_query);
    if (mysqli_num_rows($thumbnails_result) > 0) {
        while ($thumbnail = mysqli_fetch_assoc($thumbnails_result)) {
            $thumbnail_path = '../images/thumbnail/' . $thumbnail['thumbnail'];
            //delete thumbnail from the folder
            if ($thumbnail_path) {
                unlink($thumbnail_path);
            }
        }
    }
    $delete_post_query = "Delete from posts where author_id=$id;";
    $delete_post_result = mysqli_query($conn, $delete_post_query);


    //delete user from users table
    $delete_query = "Delete from users where id=$id;";
    $delete_result = mysqli_query($conn, $delete_query);
    if (mysqli_error($conn)) {
        $_SESSION['delete-user'] = "Failed to delete user";
    } else {
        $_SESSION['delete-user-success'] = "User $firstname $lastname deleted successfully";
    }
}

header('location:' . ROOT_URL . 'admin/manage-users.php');
die();
