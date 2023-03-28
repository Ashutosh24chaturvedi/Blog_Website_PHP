<?php
include 'partials/header.php';

//fetch categories from database
$category_query = "SELECT * FROM categories;";
$categories = mysqli_query($conn, $category_query);

//fetch form

if (isset($_GET['id'])) {
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
    $query = "SELECT * FROM posts WHERE id ='$id';";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) == 1) {
        $post = mysqli_fetch_assoc($result);
    }
} else {
    header('location:' . ROOT_URL . 'admin/index.php');
    die();
}

?>
<section class="form_section">
    <div class="container form_section-container">
        <h2>Edit Post</h2>
        <form action="<?= ROOT_URL ?>admin/edit-post-logic.php" enctype="multipart/form-data" method="POST">
            <input type="hidden" name="id" value="<?= $post['id'] ?>">
            <input type="hidden" name="previous_thumbnail_name" value="<?= $post['thumbnail'] ?>">
            <input type="text" placeholder="Title" name="title" value="<?= $post['title'] ?>">
            <select name="category">
                <?php while ($category_rows = mysqli_fetch_assoc($categories)) : ?>
                    <option value="<?= $category_rows['id'] ?>"><?= $category_rows['title'] ?></option>
                <?php endwhile; ?>
            </select>
            <textarea rows="10" placeholder="Body" name="body"><?= $post['body'] ?></textarea>
            <div class="form_control inline">
                <input type="checkbox" id="is_featured" name="is_featured" value="1" checked>
                <label for="is_featured">Featured</label>
            </div>
            <div class="form_control">
                <label for="thumbnail">Change Thumbnail</label>
                <input type="file" id="thumbnail" name="thumbnail">
            </div>
            <button type="submit" class="btn" name="submit">Update Post</button>
        </form>
    </div>
</section>

<?php
include '../partials/footer.php';
?>