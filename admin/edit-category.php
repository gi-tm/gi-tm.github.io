<?php
 include 'partials/header.php';
 if(isset($_GET['id'])){
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
    //fetch category from database
    $query = "SELECT * FROM categories WHERE id=$id";
    $result = mysqli_query($connection, $query);
    if(mysqli_num_rows($result) == 1) {
        $category = mysqli_fetch_assoc($result);
    }

 }else  {
    header('location:' .ROOT_URL. 'admin/manage-categories.php');
    die();
 }
 ?>
           
    <section class="form__section">
        <div class="container form__section-container">s
            <h2> Edit Category</h2>
        <div class="alert__message error"s>
            <p> This is an error message</p>
        </div>
        <form  action="<?= ROOT_URL ?>admin/edit-category-logic.php" method="POST">
        <input type="hidden" name="id" value="<?= $category['id'] ?>" >
            <input type="text" name="Title" value="<?= $category['Title'] ?>" placeholder="Title">
            <textarea rows="4" name = "Description" placeholder="Description"> <?= $category['Description'] ?></textarea>
            <button type="submit" name="submit"  class="btn"> Update Category</button>
            

        </form>
    </section>

    <?php
 include 'partials/footer.php'
 ?>