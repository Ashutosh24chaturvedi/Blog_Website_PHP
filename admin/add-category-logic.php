<?php
require 'config/database.php';

//get add-category form data if signup button is clicked

if (isset($_POST['submit'])) {
    $title = filter_var($_POST['title'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $description = filter_var($_POST['description'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    //validate input values
    if (!$title) {
        $_SESSION['add-category'] = "Please enter Title";
    } else if (!$description) {
        $_SESSION['add-category'] = "Please enter Description";
    }
    //redirect back to add-category page if there was any problem
    if (isset($_SESSION['add-category'])) {
        //pass form data back to add-category page
        $_SESSION['add-category-data'] = $_POST;
        header('location: ' . ROOT_URL . 'admin/add-category.php');
        die();
    } else {
        //insert new user data into categories table in database
        $insert_query = "INSERT INTO categories (title, description) VALUES ('$title','$description');";

        $insert_result = mysqli_query($conn, $insert_query);

        if (mysqli_errno($conn)) {
            $_SESSION['add-category'] = "Couldn't add category";
            header('location:' . ROOT_URL . 'admin/add-category.php');
            die();
        } else {
            $_SESSION['add-category-success'] = "Category $title added successfully";
            header('location:' . ROOT_URL . 'admin/manage-categories.php');
            die();
        }
    }
} else {
    //if btn wasn't clicked, bounce back to add-category page
    header('location:' . ROOT_URL . 'admin/add-category.php');
    die();
}
