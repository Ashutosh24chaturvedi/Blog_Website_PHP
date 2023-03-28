<?php

include 'partials/header.php';

//get back form data if there was a add-category error

$title = $_SESSION['add-category-data']['title'] ?? null;
$description = $_SESSION['add-category-data']['description'] ?? null;

//delete add-category-data session
unset($_SESSION['add-category-data']);

?>

<section class="form_section">
    <div class="container form_section-container">
        <h2>Add Category</h2>
        <?php if (isset($_SESSION['add-category'])) : ?>

            <div class="alert_message error">
                <p>
                    <?= $_SESSION['add-category'];
                    unset($_SESSION['add-category']);
                    ?>
                </p>
            </div>

        <?php endif; ?>
        <form action="<?= ROOT_URL ?>admin/add-category-logic.php" enctype="multipart/form-data" method="POST">
            <input type="text" placeholder="Title" name="title" value="<?= $title ?>">
            <textarea rows="5" placeholder="Description" name="description" value="<?= $description ?>"></textarea>
            <button type="submit" class="btn" name="submit">Add Category</button>
        </form>
    </div>
</section>

<?php
include '../partials/footer.php';
?>