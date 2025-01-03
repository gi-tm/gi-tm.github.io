<?php 
require 'config/database.php';

if (isset($_POST['submit'])) {
    //get form data
    $id = filter_var($_POST['id'],FILTER_SANITIZE_NUMBER_INT);
    $previous_thumbnail_name = filter_var($_POST['previous_thumbnail_name'],FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $title = filter_var($_POST['title'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $body = filter_var($_POST['body'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $category_id = filter_var($_POST['category_id'],FILTER_SANITIZE_NUMBER_INT);
    $is_featured = filter_var($_POST['is_featured'],FILTER_SANITIZE_NUMBER_INT);
    $thumbnail = $_FILES['thumbnail'];

    //set is featured to 0 if it was unchecked
    $is_featured = $is_featured == 1 ?: 0;

    if(!$title) {
        $_SESSION['edit-post'] = "Invalid Form data on edit post";

    }elseif(!$category_id){
        $_SESSION['edit post'] = "Invalid Form data on edit post";

    }elseif(!$body){
        $_SESSION['edit post'] = "Invalid Form data on edit post";

    }else {
        //delete existing thumbnail if new thumbnail is available
        if($thumbnail['name']){
            $previous_thumbnail_name = '../images/' . $previous_thumbnail_name;
            if($previous_thumbnail_name){
                unlink($previous_thumbnail_name);
            }
            //work on thumbnail
        //rename image
        $time = time();
        $thumbnail_name = $time . $thumbnail['name'];
        $thumbnail_tmp_name = $thumbnail['tmp_name'];
        $thumbnail_destination_path = '../images/' . $thumbnail_name;

        //make sure file is an image 
        $allowed_files = ['png', 'jpg', 'jpeg'];
        $extension = explode('.', $thumbnail_name);
        $extension = end($extension);
        if(in_array($extension, $allowed_files)) {

            // make sure image is not too big
            if($thumbnail['size'] < 2_000_000){
                //upload fle
                move_uploaded_file($thumbnail_tmp_name, $thumbnail_destination_path);

            }else {
                $_SESSION['edit-post'] = "file size too big. Should be less than 2mb";
                
            }

        }else {
            $_SESSION['edit-post'] = "File is not an image";
        }
        }
    }
    // redirect back to add post page with form data 
    if(isset($_SESSION['edit-post'])) {
        $_SESSION['edit-post-data'] = $_POST;
        header('location: ' . ROOT_URL .  'admin/edit-post.php');
        die();

    }else {
        // set is_featured of all other posts to 0 if this post is 1
        if($is_featured == 1) {
            $zero_all_featured = "UPDATE posts SET is_featured=0";
            $zero_all_featured_result = mysqli_query($connection, $zero_all_featured);
        }
        //insert post into database
        //if there is a new thumbnail that is waht we will insert if not the old one remains
        $thumbnail_to_insert = $thumbnail_name ?? $previous_thumbnail_name;
        $query = "UPDATE posts SET  title ='$title', body = '$body', thumbnail ='$thumbnail_to_insert', category_id = '$category_id', is_featured=$is_featured WHERE id = $id LIMIT 1";
        $result = mysqli_query($connection, $query);
        if(mysqli_errno($connection)) {
            $_SESSION['edit-post'] = "could not edit post";
            header('location: ' . ROOT_URL .  'admin/edit-post.php');
            die();
        } else {
            $_SESSION['edit-post-success'] = "post edited successfully";
            header('location: ' . ROOT_URL .  'admin/index.php');
            die();
           
        }
    }
    
}
