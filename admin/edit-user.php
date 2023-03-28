<?php
include 'partials/header.php';

if (isset($_GET['id'])) {
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
    $query = "SELECT * FROM users WHERE id ='$id';";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);
    }
} else {
    header('location:' . ROOT_URL . 'admin/manage-categories.php');
    die();
}

?>
<section class="form_section">
    <div class="container form_section-container">
        <h2>Edit User</h2>
        <form action="<?= ROOT_URL ?>admin/edit-user-logic.php" enctype="multipart/form-data" method="POST">
            <input type="hidden" name="id" value="<?= $user['id'] ?>">
            <input type="text" placeholder="First Name" name="firstname" value="<?= $user['firstname'] ?>">
            <input type="text" placeholder="Last Name" name="lastname" value="<?= $user['lastname'] ?>">
            <div class="form_control">
                <label>User Role</label>
            </div>
            <select name="userrole">
                <option value="0">Author</option>
                <option value="1">Admin</option>
            </select>
            <button type="submit" class="btn" name="submit">Update User</button>
        </form>
    </div>
</section>

<?php
include '../partials/footer.php';
?>