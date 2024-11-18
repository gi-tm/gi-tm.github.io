<?php
 require 'config/database.php';

 if (isset($_GET['id'])) {
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);





    $update_query = "UPDATE posts SET category_id = 7 WHERE category_id = $id";
    $update_result = mysqli_query($connection, $update_query);

    if(!mysqli_errno($connection) ){

   // update category_id of posts that belong to this category to id of uncategorized 
    $delete_user_query  = "DELETE FROM categories WHERE id = $id  LIMIT 1";
    $delete_user_result = mysqli_query($connection, $delete_user_query);
    $_SESSION['delete-category'] = "Category deleted successfully ";

    }

    
        
 } 

 
 header ('location:' .ROOT_URL. 'admin/manage-categories.php');
die();
 ?>