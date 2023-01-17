<?php

// connection  - id - submit  - filter - validation - empty(update ) -->$_COOKIE
require_once '../inc/connection.php';

if(isset($_GET['id'])){
    $id = $_GET['id'];

    $title  = trim(htmlspecialchars($_POST['title']));
    $body  = trim(htmlspecialchars($_POST['body']));

    $errors = [];
    // title (empty - string)

    if(empty($title)) {
        $errors[] = "title is required";
    }elseif(is_numeric($title)) {
        $errors[] = "title must be string";
    }

    if(empty($body)) {
        $errors[] = "body is required";
    }elseif(is_numeric($body)) {
        $errors[] = "body must be string";
    }

    $query  = "select image from posts where id=$id ";
    $result  =  mysqli_query($conn ,$query);
    if(mysqli_num_rows($result)==1){
       $post =  mysqli_fetch_assoc($result);
       $oldName = $post['image'];
    }

    if($_FILES && $_FILES['image']['name']){
            $image  = $_FILES['image'];
            $image_name = $image['name'];
            $image_tmpname = $image['tmp_name'];
            $sizeMB = $image['size']/(1024*1024);
            $ext = strtolower(pathinfo($image_name , PATHINFO_EXTENSION));
            $newName  = uniqid().time().".".$ext;

            if($sizeMB >1) {
                $errors[] = "large image ";
            }elseif(! in_array($ext , ['png','jpg','jpeg'])){
                $errors[] = "upload  valid image ";

            }

        }else {
                $newName = $oldName; //old name
        }

        if(empty($errors)) {
            $query = "update posts set `title`='$title',`body`='$body' , `image`='$newName' where id=$id";
            $result =   mysqli_query($conn , $query);

            if($result) {
                //check (new image ->move,unlink) -- 
                // show post

                if($_FILES['image']['name']){
                    unlink("../uploads/$oldName");
                    move_uploaded_file($image_tmpname , "../uploads/$newName");
                }
                $_SESSION['success'] = "post updated successfuly";
                header('location:../show-post.php?id='.$id);
            }else{
                $_SESSION['errors'] = "error while update";
                header('location:../edit-post.php?id='.$id);  
            }
        
        }else {
            $_SESSION['errors']  = $errors;
            $_SESSION['title'] = $title;
            $_SESSION['body'] = $body;
            header('location:../edit-post.php?id='.$id);
        }




}else {
    header('location:../index.php');
}