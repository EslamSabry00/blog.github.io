<?php require_once('inc/header.php'); ?>
<?php require_once('inc/navbar.php'); ?>
<?php require_once('inc/connection.php'); ?>
<?php require_once('inc/functions.php'); 
if(! isset($_SESSION['user_id'])){
    header('location:login.php');
}
?>

<?php

    if(isset($_GET['page'])) {
        $page =  $_GET['page'];
    }else{
        $page = 1;
    }

    $totalQuery  = "select count(`id`) as total from posts";
    $totalResult =   mysqli_query($conn,$totalQuery);

    if(mysqli_num_rows($totalResult)==1){
       $post = mysqli_fetch_assoc($totalResult);
       $total = $post['total'];
    }

    $limit = 2;

    $offset = ($page-1)*$limit;


    $numberOfPages = (int) ceil($total / $limit);
    // echo "$page  ,  $limit  , $offset  ,$total , $numberOfPages";
    
    if(! check_limit(  $page ,  $numberOfPages)) {

        header("location: ".$_SERVER['PHP_SELF']."?page=1");
    }


        $query  = "select id , title , created_at from posts
            limit $limit offset $offset
        ";
        $result =  mysqli_query($conn,$query);
        
        if(mysqli_num_rows($result)>0) {

           $posts =  mysqli_fetch_all($result , MYSQLI_ASSOC);

        }else {
            echo "no data founded";
        }


?>
<?php if(isset($_SESSION['error'])): ?>
    <div class="alert alert-danger">
    <?php echo $_SESSION['error']  ?>
    </div>
<?php endif; unset($_SESSION['error']); ?>

<?php require_once 'inc/success.php'; ?>

<div class="container-fluid pt-4">
    <div class="row">
        <div class="col-md-10 offset-md-1">
            <div class="d-flex justify-content-between border-bottom mb-5">
                <div>
                    <h3><?php echo $message['all posts']  ?></h3>
                </div>
                <div>
                    <a href="create-post.php" class="btn btn-sm btn-success"><?php echo $message['add new post']  ?></a>
                </div>
            </div>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Title</th>
                        <th scope="col">Published At</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>

        <?php foreach($posts as $post): ?>
                    <tr>
                        <td><?php echo $post['title'] ?></td>
                        <td><?php echo $post['created_at'] ?></td>
                        <td>
                            <a href="show-post.php?id=<?php echo $post['id'] ?>" class="btn btn-sm btn-primary"><?php echo $message['show']  ?></a>
                            <a href="edit-post.php?id=<?php echo $post['id'] ?>" class="btn btn-sm btn-secondary"><?php echo $message['edit']  ?></a>
                            <a href="handle/delete-post.php?id=<?php echo $post['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('do you really want to delete post?')"><?php echo $message['delete']  ?></a>
                        </td>
                    </tr>

            <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="d-flex justify-content-center">
<nav aria-label="...">
  <ul class="pagination">
    <li class="page-item <?php if($page==1) echo "disabled" ?>">
      <a class="page-link" href="<?php echo $_SERVER['PHP_SELF']."?page=".$page-1 ?>" tabindex="-1" aria-disabled="true">Previous</a>
    </li>
    <li class="page-item"><a class="page-link" href="#"><?php echo $page ?> of <?php  echo $numberOfPages ?></a></li>
   
    <li class="page-item <?php if($page==$numberOfPages) echo "disabled" ?>">
      <a class="page-link" href="<?php echo $_SERVER['PHP_SELF']."?page=".$page+1 ?>">Next</a>
    </li>
  </ul>
</nav>
</div>

<?php require('inc/footer.php'); ?>