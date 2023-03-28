<?php
require 'config/database.php';

//get post form if submit button is clicked

if (isset($_POST['submit'])) {
    $author_id = $_SESSION['user_id'];
    $title = filter_var($_POST['title'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $body = filter_var($_POST['body'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $category_id = filter_var($_POST['category'], FILTER_SANITIZE_NUMBER_INT);
    $is_featured = filter_var($_POST['is_featured'], FILTER_SANITIZE_NUMBER_INT);
    $thumbnail = $_FILES['thumbnail'];
    // var_dump($thumbnail);

    //set is_featured to 0 if unchecked 

    $is_featured = $is_featured == 1 ? 1 : 0;

    //validate input values

    if (!$title) {
        $_SESSION['add-post'] = "Please enter Post Title";
    } else if (!$category_id) {
        $_SESSION['add-post'] = "Please select Post Category";
    } else if (!$body) {
        $_SESSION['add-post'] = "Please enter Post Body";
    } else if (!$thumbnail['name']) {
        $_SESSION['add-post'] = "Please add Thumbnail";
    } else {
        //work on thumbnail
        //rename thumbnail
        $time = time();  //current time
        $thumbnail_name = $time . $thumbnail['name'];
        $thumbnail_tmp_name = $thumbnail['tmp_name'];
        $thumbnail_destination_path = '../images/thumbnail/' . $thumbnail_name;

        //make sure file is an image
        $allowed_files = ['png', 'jpg', 'jpeg'];
        $extension = explode('.', $thumbnail_name);
        $extension = end($extension);
        if (in_array($extension, $allowed_files)) {
            //make sure image is not too large(2mb+)
            if ($thumbnail['size'] < 2_000_000) {
                //upload image
                move_uploaded_file($thumbnail_tmp_name, $thumbnail_destination_path);
            } else {
                $_SESSION['add-post'] = "File size is too large, should be smaller than 2 MB";
            }
        } else {
            $_SESSION['add-post'] = "File should be png, jpg or jpeg";
        }
    }
    //redirect back to add-post page if there was any problem
    if (isset($_SESSION['add-post'])) {
        //pass form data back to add post page
        $_SESSION['add-post-data'] = $_POST;
        header('location: ' . ROOT_URL . 'admin/add-post.php');
        die();
    } else {

        //set is_featured of all posts to 0 if is_featured for this post is 1

        if ($is_featured == 1) {
            $zero_all_is_featured_query = "UPDATE posts SET is_featured=0;";
            $zero_all_is_featured_result = mysqli_query($conn, $zero_all_is_featured_query);
        }

        //insert new post data into posts table in database
        $insert_post_query = "INSERT INTO posts (title, body, thumbnail, category_id, author_id, is_featured) VALUES ('$title','$body','$thumbnail_name',$category_id,$author_id,$is_featured);";

        $insert_post_result = mysqli_query($conn, $insert_post_query);

        if (!mysqli_errno($conn)) {
            //redirect to admin index page with success message
            $_SESSION['add-post-success'] = "New Post title:'$title' added successfully";
            header('location:' . ROOT_URL . 'admin/index.php');
            die();
        }
    }
} else {
    //if btn wasn't clicked, bounce back to add-user page
    header('location:' . ROOT_URL . 'admin/add-user.php');
    die();
}
