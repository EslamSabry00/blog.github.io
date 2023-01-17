<?php require('inc/header.php'); ?>
<?php require('inc/navbar.php'); ?>
<?php require('inc/connection.php');

    if(isset($_GET['id'])){
        $id = $_GET['id'];

        $query  = "select * from posts where id=$id";
        $result  =  mysqli_query($conn , $query);

        if(mysqli_num_rows($result)==1){
            $post =  mysqli_fetch_assoc($result);
        } else {
            $_SESSION['errors'] = "post not found";
            header('location:index.php');
            
        }


    }else{
        header('location:index.php');
    }


?>

<div class="container-fluid pt-4">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <div class="d-flex justify-content-between border-bottom mb-5">
                <div>
                    <h3>Edit post</h3>
                </div>
                <div>
                    <a href="index.php" class="text-decoration-none">Back</a>
                </div>
            </div>
            <?php require_once 'inc/errors.php'; ?>
            <form method="POST" action="handle/update-post.php?id=<?php echo $id ?>" enctype="multipart/form-data">
    
                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" class="form-control" id="title" name="title" value="<?php echo $post['title']; ?>">
                </div>

                <div class="mb-3">
                    <label for="body" class="form-label">Body</label>
                    <textarea class="form-control" id="body" name="body" rows="5"><?php echo $post['title']; ?></textarea>
                </div>
                <div class="mb-3">
                    <label for="body" class="form-label">image</label>
                    <input type="file" class="form-control-file" id="image" name="image" >
                </div>
                <div class="m-3">
                    <img src="uploads/<?php echo $post['image'] ?>" alt="" srcset="" width="100px">
                </div>
                <button type="submit" class="btn btn-primary" name="submit">Submit</button>
            </form>
        </div>
    </div>
</div>

<?php require('inc/footer.php'); ?>