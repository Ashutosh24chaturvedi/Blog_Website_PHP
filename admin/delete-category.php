<?php

require 'config/database.php';

if (isset($_GET['id'])) {
    //get updated form data
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);


    //for later
    //update category_id of posts that belong to this category to id of uncategorized of id 6 category
    $update_category = "UPDATE posts SET category_id = 1 Where category_id= $id;";
    $update_result = mysqli_query($conn, $update_category);

    if (!mysqli_errno($conn)) {
        //delete category
        $delete_query = "Delete from categories where id=$id;";
        $delete_result = mysqli_query($conn, $delete_query);
        if (mysqli_error($conn)) {
            $_SESSION['delete-category'] = "Failed to delete category";
        } else {
            $_SESSION['delete-category-success'] = "Category $title deleted successfully";
        }
    }
}

header('location:' . ROOT_URL . 'admin/manage-categories.php');
die();
