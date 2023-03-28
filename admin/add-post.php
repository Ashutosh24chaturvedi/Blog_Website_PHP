<?php
include 'partials/header.php';

//to get all categories from database
$query = "SELECT * FROM categories;";
$result = mysqli_query($conn, $query);

//get back form data if there was an error

$title = $_SESSION['add-post-data']['title'] ?? null;
$body = $_SESSION['add-post-data']['body'] ?? null;

//delete add-post-data session
unset($_SESSION['add-post-data']);
?>
<section class="form_section">
    <div class="container form_section-container">
        <h2>Add Post</h2>
        <?php if (isset($_SESSION['add-post'])) : ?>

            <div class="alert_message error">
                <p>
                    <?= $_SESSION['add-post'];
                    unset($_SESSION['add-post']);
                    ?>
                </p>
            </div>

        <?php endif; ?>
        <form action="<?= ROOT_URL ?>admin/add-post-logic.php" enctype="multipart/form-data" method="POST">
            <input type="text" placeholder="Title" name="title" value="<?= $title ?>">
            <select name="category">
                <?php while ($category = mysqli_fetch_assoc($result)) : ?>
                    <option value="<?= $category['id'] ?>"><?= $category['title'] ?></option>
                <?php endwhile; ?>
            </select>
            <textarea rows="10" placeholder="Body" name="body"><?= $body ?></textarea>
            <?php if (isset($_SESSION['user_is_admin'])) : ?>
                <div class="form_control inline">
                    <input type="checkbox" id="is_featured" name="is_featured" value="1" checked>
                    <label for="is_featured">Featured</label>
                </div>
            <?php endif; ?>
            <div class="form_control">
                <label for="thumbnail">Add Thumbnail</label>
                <input type="file" id="thumbnail" name="thumbnail">
            </div>
            <button type="submit" class="btn" name="submit">Add Post</button>
        </form>
    </div>
</section>

<?php
include '../partials/footer.php';
?>