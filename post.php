<?php
include 'partials/header.php';

//get data if id is set

if (isset($_GET['id'])) {
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
    $query = "SELECT * FROM posts WHERE id =$id;";
    $result = mysqli_query($conn, $query);
    $posts = mysqli_fetch_assoc($result);
} else {
    header('location' . ROOT_URL . 'blog.php');
    die();
}
?>
<!-- ===========================Start of Single Post=========================== -->

<section class="singlepost">
    <div class="container singlepost_container">
        <h2><?= $posts['title'] ?></h2>
        <div class="post_author">
            <?php
            // fetch author from users table using the author_id
            $author_id = $posts['author_id'];
            $author_query = "SELECT * FROM users WHERE id= $author_id;";
            $author_result = mysqli_query($conn, $author_query);
            $author = mysqli_fetch_assoc($author_result);
            ?>
            <div class="post_author-avatar">
                <img src="./images/<?= $author['avatar'] ?>" />
            </div>
            <div class="post_author-info">
                <h5>By: <?= "{$author['firstname']} {$author['lastname']}" ?></h5>
                <small>
                    <?= date("M d, Y - H : i", strtotime($posts['date_time'])) ?>
                </small>
            </div>
        </div>
        <div class="singlepost_thumbnail">
            <img src="./images/thumbnail/<?= $posts['thumbnail'] ?>">
        </div>
        <p>
            <?= $posts['body'] ?>
        </p>
    </div>
</section>

<!-- ===========================End of Single Post=========================== -->

<?php
include 'partials/footer.php';
?>