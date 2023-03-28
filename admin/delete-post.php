<?php

require 'config/database.php';

if (isset($_GET['id'])) {
    //get updated form data
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
    // fetch user data from database
    $query = "SELECT * FROM posts WHERE id = $id;";
    $result = mysqli_query($conn, $query);
    $post = mysqli_fetch_assoc($result);

    // make sure we get back one record 
    if (mysqli_num_rows($result) == 1) {
        // var_dump($user);
        $thumbnail_name = $post['thumbnail'];
        $thumbnail_path = '../images/thumbnail/' . $thumbnail_name;
        //delete image if available
        if ($thumbnail_name) {
            unlink($thumbnail_path);
        }
    }

    //delete post from posts table
    $delete_query = "Delete from posts where id=$id;";
    $delete_result = mysqli_query($conn, $delete_query);
    if (mysqli_error($conn)) {
        $_SESSION['delete-post'] = "Failed to delete post";
    } else {
        $_SESSION['delete-post-success'] = "Post deleted successfully";
    }
}

header('location:' . ROOT_URL . 'admin/');
die();
