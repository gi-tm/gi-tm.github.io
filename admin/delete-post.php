<?php
 include 'config/database.php';

 if (isset($_GET['id'])) {
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
    $query ="SELECT * FROM posts WHERE  id=$id";
    $result =  mysqli_query($connection, $query);
    $user = mysqli_fetch_assoc($result);

    // make sure only one users is fetched
    if(mysqli_num_rows($result) == 1) {
        $thumbnail_name = $user['thumbnail'];
        $thumbnail_path = '../images/' . $thumbnail_name;
        //delete image if available
        if($thumbnail_path) {
            unlink($thumbnail_path);

            // delete posts from database 
            $delete_post_query  = "DELETE FROM posts WHERE id = $id LIMIT 1";
            $delete_post_result = mysqli_query($connection, $delete_post_query);
            if(mysqli_errno($connection)) {
                $_SESSION['delete-post'] = "Failed to delete post '{$user['title']}' ";
            }else {
                $_SESSION['delete-post-success'] = "{$user['title']} deleted successfully";
            }
            
        }
    }

 } 

 header ('location:' .ROOT_URL. 'admin/index.php');
 die();
 


 
 ?>