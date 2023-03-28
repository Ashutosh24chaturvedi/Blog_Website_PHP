<?php

require 'config/database.php';

if (isset($_POST['submit'])) {
    //get updated form data
    $id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
    $title = filter_var($_POST['title'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $description = filter_var($_POST['description'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    //check for valid input
    if (!$title || !$description) {
        $_SESSION['edit-category'] = "Invalid form input on edit page.";
    } else {
        //update user
        $query = "UPDATE categories SET title = '$title', description = '$description' where id = $id LIMIT 1;";
        $result = mysqli_query($conn, $query);

        if (mysqli_error($conn)) {
            $_SESSION['edit-category'] = "Failed to update category information";
        } else {
            $_SESSION['edit-category-success'] = "Category $title updated successfully";
        }
    }
}

header('location:' . ROOT_URL . 'admin/manage-categories.php');
die();
