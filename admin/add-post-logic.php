<?php 
require 'config/database.php';

if (isset($_POST['submit'])) {
    //get form data
    $author_id = $_SESSION['user-id'];
    $title = filter_var($_POST['title'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $body = filter_var($_POST['body'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $category_id = filter_var($_POST['category'], FILTER_SANITIZE_NUMBER_INT);
    $is_featured = filter_var($_POST['is_featured'], FILTER_SANITIZE_NUMBER_INT);
    $thumbnail = $_FILES['thumbnail'];
    //set is featured to 0 if unchecked
    $is_featured = $is_featured == 1?: 0;


    //form validation

    if(!$title) {
        $_SESSION['add-post'] = "Enter Ttile";

    }elseif(!$category_id){
        $_SESSION['add-post'] = "Enter post category";

    }elseif(!$body){
        $_SESSION['add-post'] = "Enter post body";

    }elseif(!$thumbnail['name']){
        $_SESSION['add-post'] = "choose post thumbnail";

    }else {
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
                $_SESSION['add-post'] = "file size too big. Should be less than 2mb";
                
            }

        }else {
            $_SESSION['add-post'] = "File is not an image";
        }

    }
    // redirect back to add post page with form data 
    if(isset($_SESSION['add-post'])) {
        $_SESSION['add-post-data'] = $_POST;
        header('location: ' . ROOT_URL .  'admin/add-post.php');
        die();

    }else {
        // set is_featured of all other posts to 0 if this post is 1
        if($is_featured == 1) {
            $zero_all_featured = "UPDATE posts SET is_featured=0";
            $zero_all_featured_result = mysqli_query($connection, $zero_all_featured);
        }
        //insert post into database
        $query = "INSERT INTO posts (title, body, thumbnail, category_id, author_id, is_featured) VALUES ('$title', '$body', '$thumbnail_name', $category_id, $author_id, $is_featured)";
        $result = mysqli_query($connection, $query);
        if(mysqli_errno($connection)) {
            $_SESSION['add-post'] = "could not add post";
            header('location: ' . ROOT_URL .  'admin/add-post.php');
            die();
        } else {
            $_SESSION['add-post-success'] = "post added successfully";
            header('location: ' . ROOT_URL .  'admin/index.php');
            die();
           
        }
    }
    
}