<!-- ===========================Start of Footer=========================== -->

<footer>
    <div class="footer_socials">
        <!-- https://iconscout.com/unicons/explore/line -->
        <a href="https://www.youtube.com/" target="_blank"><i class="uil uil-youtube"></i></a>
        <a href="https://www.facebook.com/" target="_blank"><i class="uil uil-facebook-f"></i></a>
        <a href="https://twitter.com/?lang=en-in" target="_blank"><i class="uil uil-twitter"></i></a>
        <a href="https://www.instagram.com/" target="_blank"><i class="uil uil-instagram-alt"></i></a>
        <a href="https://in.linkedin.com/" target="_blank"><i class="uil uil-linkedin"></i></a>
    </div>
    <div class="container footer_container">
        <article>
            <h4>Categories</h4>
            <ul>
                <?php
                $all_categories = "SELECT * FROM categories;";
                $all_categories_result = mysqli_query($conn, $all_categories);
                ?>
                <?php while ($all_category = mysqli_fetch_assoc($all_categories_result)) : ?>
                    <li><a href="<?= ROOT_URL ?>category-posts.php?id=<?= $all_category['id'] ?>"><?= $all_category['title'] ?></a></li>
                <?php endwhile; ?>
            </ul>
        </article>
        <article>
            <h4>Support</h4>
            <ul>
                <li><a href="#">Online Support</a></li>
                <li><a href="#">Call Numbers</a></li>
                <li><a href="#">Emails</a></li>
                <li><a href="#">Social Support</a></li>
                <li><a href="#">Location</a></li>
            </ul>
        </article>
        <article>
            <h4>Blog</h4>
            <ul>
                <li><a href="#">Safety</a></li>
                <li><a href="#">Repair</a></li>
                <li><a href="#">Recent</a></li>
                <li><a href="#">Popular</a></li>
                <li><a href="#">Categories</a></li>
            </ul>
        </article>
        <article>
            <h4>Permalinks</h4>
            <ul>
                <li><a href="<?= ROOT_URL ?>">Home</a></li>
                <li><a href="<?= ROOT_URL ?>blog.php">Blog</a></li>
                <li><a href="<?= ROOT_URL ?>about.php">About</a></li>
                <li><a href="<?= ROOT_URL ?>services.php">Services</a></li>
                <li><a href="<?= ROOT_URL ?>contact.php">Contact</a></li>
            </ul>
        </article>
    </div>
    <div class="footer_copyright">
        <small>Copyright &copy; MyBlog</small>
    </div>
</footer>

<!-- ===========================End of Footer=========================== -->

<script src="<?= ROOT_URL ?>js/main.js"></script>
</body>

</html>