<?php

//connect  - check - filter - validation  - empty --> insert (move) - header 

require_once '../inc/connection.php'; 

if(isset($_POST['submit'])) {
    $title  = trim(htmlspecialchars($_POST['title']));
    $body  = trim(htmlspecialchars($_POST['body']));

    $errros = [];
    // title (empty - string)

    if(empty($title)) {
        $errros[] = "title is required";
    }elseif(is_numeric($title)) {
        $errros[] = "title must be string";
    }

    if(empty($body)) {
        $errros[] = "body is required";
    }elseif(is_numeric($body)) {
        $errros[] = "body must be string";
    }

    if($_FILES && $_FILES['image']['name']){
            $image  = $_FILES['image'];
            $image_name = $image['name'];
            $image_tmpname = $image['tmp_name'];
            $sizeMB = $image['size']/(1024*1024);
            $ext = strtolower(pathinfo($image_name , PATHINFO_EXTENSION));
            $newName  = uniqid().time().".".$ext;

            if($sizeMB >1) {
                $errros[] = "large image ";
            }elseif(! in_array($ext , ['png','jpg','jpeg'])){
                $errros[] = "upload  valid image ";

            }

        }else {
                $newName = "";
        }

        if(empty($errros)) {
            $query  = "insert into posts(`title`,`body`,`image`,`user_id`) 
            values('$title','$body','$newName',1)";
            $result  = mysqli_query($conn,$query);
            if($result) {

                if($_FILES['image']['name']){
                    move_uploaded_file($image_tmpname , "../uploads/$newName");
                }

             $_SESSION['success'] = "post inserted successfuly";
                header('location:../index.php');

            }else {
             $_SESSION['errors'] = ["error while insert post"];
            header('location:../create-post.php');
                
            }
        }else{
            $_SESSION['errors'] = $errros;
            $_SESSION['title'] = $title;
            $_SESSION['body'] = $body;
            header('location:../create-post.php');

        }

}else {
    header('location:../create-post.php');
}