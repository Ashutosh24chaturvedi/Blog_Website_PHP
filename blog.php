<?php
include 'partials/header.php';

//fetch all posts from posts table
$query = "SELECT * FROM posts ORDER BY date_time DESC;";
$result = mysqli_query($conn, $query);
?>
<!-- ===========================Start of Search Post=========================== -->

<section class="search_bar">
    <form class="container search_bar-container" action="<?= ROOT_URL ?>search.php" method="GET">
        <div>
            <i class="uil uil-search"></i>
            <input type="search" name="search" placeholder="Search">
        </div>
        <button type="submit" class="btn" name="submit">Go</button>
    </form>
</section>

<!-- ===========================End of Search Post=========================== -->

<!-- ===========================Start of Multiple-1 Posts=========================== -->

<section class="posts">
    <div class="container posts_container">

        <?php while ($posts = mysqli_fetch_assoc($result)) : ?>

            <article class="post">
                <div class="post_thumbnail">
                    <img src="./images/thumbnail/<?= $posts['thumbnail'] ?>" alt="" style="height:250px; width:100%;">
                </div>
                <div class="post_info">
                    <?php
                    //fetch category from categories table using category_id of post
                    $category_id = $posts['category_id'];
                    $category_query = "SELECT * FROM categories WHERE id= $category_id;";
                    $category_result = mysqli_query($conn, $category_query);
                    $category = mysqli_fetch_assoc($category_result);
                    ?>
                    <a href="<?= ROOT_URL ?>category-posts.php?id=<?= $posts['category_id'] ?>" class="category_button">
                        <?= $category['title'] ?>
                    </a>
                    <h3 class="post_title">
                        <a href="<?= ROOT_URL ?>post.php?id=<?= $posts['id'] ?>"><?= $posts['title'] ?></a>
                    </h3>
                    <p class="post_body">
                        <?= substr($posts['body'], 0, 300); ?>...</br>Read more
                    </p>
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
                </div>
            </article>
        <?php endwhile; ?>
    </div>
</section>

<!-- ===========================End of Multiple-1 Posts=========================== -->

<!-- ===========================Start of Category Posts=========================== -->

<section class="category_buttons">
    <div class="container category_buttons-container">
        <?php
        $all_categories = "SELECT * FROM categories;";
        $all_categories_result = mysqli_query($conn, $all_categories);
        ?>
        <?php while ($category = mysqli_fetch_assoc($all_categories_result)) : ?>
            <a href="<?= ROOT_URL ?>category-posts.php?id=<?= $category['id'] ?>" class="category_button"><?= $category['title'] ?></a>
        <?php endwhile; ?>
    </div>
</section>

<!-- ===========================End of Category Posts=========================== -->

<?php
include 'partials/footer.php';
?>