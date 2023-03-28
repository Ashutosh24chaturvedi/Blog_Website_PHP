<?php
include 'partials/header.php';

if (isset($_GET['id'])) {
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
    $query = "SELECT * FROM categories WHERE id ='$id';";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) == 1) {
        $category = mysqli_fetch_assoc($result);
    }
} else {
    header('location:' . ROOT_URL . 'admin/manage-categories.php');
    die();
}

?>
<section class="form_section">
    <div class="container form_section-container">
        <h2>Edit Category</h2>
        <form action="<?= ROOT_URL ?>admin/edit-category-logic.php" enctype="multipart/form-data" method="POST">
            <input type="hidden" name="id" value="<?= $category['id'] ?>">
            <input type="text" placeholder="Title" name="title" value="<?= $category['title'] ?>">
            <textarea rows="5" placeholder="Description" name="description"><?= $category['description'] ?></textarea>
            <button type="submit" class="btn" name="submit">Update Category</button>
        </form>
    </div>
</section>

<?php
include '../partials/footer.php';
?>