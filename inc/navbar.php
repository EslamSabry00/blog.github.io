<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php">Blog</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
            <?php 
                require_once('connection.php');  ?>

        <?php if(isset($_SESSION['lang'])  && $_SESSION['lang']=="ar"): ?>
            <li class="nav-item">
                    <a class="nav-link" href="inc/change-lang.php?lang=en">English</a>
            </li>
            <?php else: ?>
            <li class="nav-item">
                <a class="nav-link" href="inc/change-lang.php?lang=ar">العربيه</a>
            </li>
            <?php endif; ?>
<?php if( ! isset($_SESSION['user_id'])): ?>

                <li class="nav-item">
                    <a class="nav-link" href="login.php">Login</a>
                </li>
                <?php else : ?>
                <li class="nav-item">
                    <a class="nav-link" href="handle/logout.php">Logout</a>
                </li> 
                <?php endif; session_abort(); ?>   
            </ul>
        </div>
    </div>
</nav>