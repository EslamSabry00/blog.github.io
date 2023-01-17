<?php 

require_once '../inc/connection.php';

if(isset($_POST['submit'])) {
    $email = trim(htmlspecialchars($_POST['email']));
    $password = trim(htmlspecialchars($_POST['password']));

    $errors = [];
    if(empty($email)) {
        $errors[] = "email is requried";
    }elseif(! filter_var($email ,FILTER_VALIDATE_EMAIL) ){

        $errors[] = "enter valid email";
    }

    if(empty($password)) {
        $errors[] = "password is requried";
    }elseif(strlen($password)<5){

        $errors[] = "password must be more than 5 chars";
    }

    if(empty($errors)){

    $query  = "select * from users where `email`='$email'";
    $result  =  mysqli_query($conn , $query);
    if(mysqli_num_rows( $result)==1) {
        // check
      $user =   mysqli_fetch_assoc($result);

        $oldPassword = $user['password'];

        $is_valid =  password_verify($password , $oldPassword);

        if($is_valid) {
            $_SESSION['user_id'] = $user['id'];
             $_SESSION['success'] = "welcome back";
            header('location:../index.php');
        }else {
            $_SESSION['errors'] = ['credenatials not correct ...'];
            header('location:../login.php');
        }

    }else {
        $_SESSION['errors'] = ['this account not found'];

        header('location:../login.php');

    }

    }else {
        $_SESSION['errors'] = $errors;
        $_SESSION['email'] = $email;
        header('location:../login.php');
    }

}else {
    header('location:../login.php');
}

//  md5 sha1  ,,,,,  password_hash  -> password_verify($password , $old) 