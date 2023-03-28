<?php

require 'config/database.php';

if (isset($_POST['submit'])) {
    //get updated form data
    $id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
    $title = filter_var($_POST['title'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $body = filter_var($_POST['body'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $category_id = filter_var($_POST['category'], FILTER_SANITIZE_NUMBER_INT);
    $is_featured = filter_var($_POST['is_featured'], FILTER_SANITIZE_NUMBER_INT);
    $previous_thumbnail_name = filter_var($_POST['previous_thumbnail_name'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $thumbnail = $_FILES['thumbnail'];

    //set is_featured to 0 if it was unchecked

    $is_featured = $is_featured == 1 ?: 0;

    //check for valid input
    if (!$title || !$category_id || !$body) {
        $_SESSION['edit-post'] = "Couldn't update post. Invalid form data on edit post page.";
    } else {
        //delete existing thumbnail if new thumbnail is available
        if ($thumbnail['name']) {
            $previous_thumbnail_path = "../images/thumbnail/" . $previous_thumbnail_name;
            if ($previous_thumbnail_path) {
                unlink($previous_thumbnail_path);
            }

            //Work on new thumbnail
            //rename image
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
                if ($thumbnail['size'] < 2000000) {
                    //upload image
                    move_uploaded_file($thumbnail_tmp_name, $thumbnail_destination_path);
                } else {
                    $_SESSION['edit-post'] = "File size is too large, should be smaller than 2 MB";
                }
            } else {
                $_SESSION['edit-post'] = "File should be png, jpg or jpeg";
            }
        }
    }

    if ($_SESSION['edit-post']) {
        //redirect to manage form page if form was invalid
        header('location:' . ROOT_URL . 'admin/');
        die();
    } else {
        //set is_featured of all posts to 0 if is_featured for this post is 1
        if ($is_featured == 1) {
            $zero_all_is_featured_query = "UPDATE posts SET is_featured = 0;";
            $zero_all_is_featured_result = mysqli_query($conn, $zero_all_is_featured_query);
        }
        //set thumbnail name if a new one is uploaded, else keep existing thumbnail
        $thumbnail_to_insert = $thumbnail_name ?? $previous_thumbnail_name;

        $query = "UPDATE posts SET title='$title', body='$body', thumbnail='$thumbnail_to_insert', category_id=$category_id, is_featured=$is_featured WHERE id=$id LIMIT 1;";
        $result = mysqli_query($conn, $query);
    }

    if (mysqli_error($conn)) {
        $_SESSION['edit-post'] = "Failed to edit user";
    } else {
        $_SESSION['edit-post-success'] = "Post title:'$title' updated successfully";
    }
}

header('location:' . ROOT_URL . 'admin/');
die();
