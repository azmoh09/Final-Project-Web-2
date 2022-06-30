<?php
include('config.php');
include('session.php');

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--Bootstrap 5 css-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!--font-awesome-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!--style-->
    <link rel="stylesheet" href="css/style_index.css">
    <title>Social Media</title>
    <style>
        textarea {
            resize: none;
        }

        .divNumComments {
            display: flex;
            align-items: center;
            color: #707070;
            font-size: 15px;
            justify-content: end;
            margin-bottom: 10px;
        }

        .divNumComments i {
            margin-right: 5px;
        }
    </style>
</head>

<body>

    <!--start nav bar-->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand brand">Social Media</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarText" style="flex-grow: 0;">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <!-- <a class="nav-link " aria-current="page" href="login.php">LOGIN</a> -->
                        <div class="imgPostForm">
                            <?php
                            if (!empty($link)) {

                                $query = mysqli_query($link, "SELECT * from users  ");
                                while ($post_row = mysqli_fetch_array($query)) {
                                    $upid = $_SESSION['id'];
                                    $q = mysqli_query($link, "SELECT picture_user FROM users WHERE id = '$upid'");
                                    while ($users_row = mysqli_fetch_array($q)) {
                                        $img = $users_row['picture_user'];
                                        $a = substr($img, 57);




                            ?>
                                        <img src="img/<?php echo $a; ?>" alt="">
                        </div>
                    </li>
                    <li class="nav-item">
                        <!-- <a class="nav-link asignUp" href="register.php">SIGNUP</a> -->
                        <b><?php
                                        if (!empty($_SESSION["username"])) {
                                            echo htmlspecialchars($_SESSION["username"]);
                                        } else {
                                            echo '<p><b><a href="login.php">Log in</a></b></p>';
                                        }

                            ?></b>
                        <p><b>

                                <?php
                                        if (!empty($_SESSION["username"])) {
                                            echo '<p><b><a href="logout.php">Log out</a></b></p>';
                                        } else {
                                            echo '<p><b><a href="register.php">Sign up</a></b></p>';
                                        }

                                ?>

                            </b></p>
                    </li>
                </ul>
                <!--if login-->
                <!-- <div class="flexPostForm">
            <div class="imgPostForm imgHead" >
                <img src="img/man.jpg" alt="">
            </div>
            <div class="namePostCard">
                <p class="name">Omar Khaled</p>
            </div>   
        </div>  -->
            </div>
        </div>
    </nav>
    <!--end nav bar-->

    <!--start content-->
    <div class="container">
        <div class="postForm">
            <div class="flexPostForm">
                <div class="imgPostForm">

                    <img src="img/<?php echo $a; ?>" alt="">
                </div>
                <!-- <input data-bs-toggle="modal" data-bs-target="#exampleModal" class="form-control" type="text" placeholder="Type Your Post Here" aria-label=".form-control-lg example"> -->

                <!-- Modal -->
                <form method="post" action="post.php" enctype="multipart/form-data">
                    <textarea name="content" rows="2.5" cols="80" style="text-align:center;" placeholder="Type Your Post Here" required></textarea>
                    <br>
                    <input type="file" name="img" accept="image/*" required>
                    <br>
                    <button name="post">&nbsp;POST</button>
                    <?php

                    ?>
                    <br>
                    <hr>
                </form>



                <?php
                                        $query = mysqli_query($link, "SELECT  p.post_id, p.picture, p.create_at, p.text_p, p.User_id, u.id, u.username, u.picture_user
                                         from posts as p JOIN users as u WHERE u.id = p.User_id order by p.create_at desc");
                                        while ($post_row = mysqli_fetch_array($query)) {
                                            $id = $post_row['post_id'];
                                            $upid = $post_row['id'];
                                            $picture = $post_row['picture'];
                                            $pictureUser = $post_row['picture_user'];
                                            $picUser = substr($pictureUser, 57);
                                            $create_at = $post_row['create_at'];
                                            $posted_by = $post_row['username'];
                                            $text_p = $post_row['text_p'];

                                            $q = mysqli_query($link, "SELECT COUNT(post_id) FROM comments WHERE post_id = '$id'");
                                            while ($posts_row = mysqli_fetch_array($q)) {
                                                $number_commant = $posts_row[0];
                                                echo '</div>

            

                                                <div class="postCard">
                                                <div class="postForm">
                                                    <div class="flexPostForm">
                                                        <div class="imgPostForm">
                                                            <img src="img/' . $picUser . '" alt="">
                                                        </div>
                                                        <div class="namePostCard">
                                                            <p class="name">' . $posted_by . '</p>
                                                            <div class="divTime">
                                                                <i class="fa-solid fa-clock"></i>
                                                                <p>' . $create_at . '</p>
                                                                
                                                            </div>
                                                            <p> ' . $text_p . '</p>
                                                        </div>
                                                    </div>
                                                    <div class="imgPost">
                                                        <img src="img/' . $picture . '" class="img-fluid rounded" alt="...">
                                                    </div>
                                                    <div class="divNumComments">
                                                        <i class="fa-solid fa-comment pNumComments"></i>
                                                        <p class="pNumComments">' . $number_commant . ' Comments</p>
                                                    </div>';


                                                echo '<div class="flexPostForm">
                                                    <div class="imgPostForm">
                                                        <img src="img/' . $a . '" alt="">
                                                    </div>
                                                    <form class="form-control" method="post" action="comment.php">
                                                        <input type="hidden" name ="id" value="' . $id . '">
                                                        <input class="form-control" name = "comment_content" type="text" placeholder="Type your comment" aria-label=".form-control-lg example">
                                                        <input type="submit" name="comment" value="Comment">
                                                    </form>
                                        
                                                </div>
                                            </div>
                                            <hr class="hr">
                                            ';

                                                $comment_query = mysqli_query(
                                                    $link,
                                                    "SELECT c.Comment_id, c.text, c.create_at, c.User_id, c.post_id, u.username, u.picture_user
                                                    FROM comments as c JOIN users as u on u.id = c.User_id  WHERE post_id = '$id' order by c.create_at ASC"
                                                );
                                                while ($comment_row = mysqli_fetch_array($comment_query)) {
                                                    $comment_id = $comment_row['Comment_id'];
                                                    $comment_by = $comment_row['username'];
                                                    $text = $comment_row['text'];
                                                    $picture = $comment_row['picture_user'];
                                                    $pic22 = substr($picture, 57);



                                                    $create_at = $comment_row['create_at'];


                                                    echo '<div>
                                                        
                                                    <div class="comment">
                                                    <div class="flexPostForm">
                                                        <div class="imgPostForm">
                                                            
                                                            <img src="img/' . $pic22 . '" alt="">
                                                        </div>
                                                        <div class="boxComment">
                                                            <p class="nameBoxComment">' . $comment_by . '</p>
                                                            <p class="contentBoxComment">' . $text . '</p>
                                                            <div class="divTime">
                                                                <i class="fa-solid fa-clock"></i>
                                                                <p>' .  $create_at . 'h</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>';
                                                }
                                                echo '
                                                </div>
                                
                                            </div>
                                            </div>';

                ?>





            </div>
            <!--end content-->
            <!--Bootstrap 5 js-->
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
            </script>

</body>
<?php } ?>
<?php } ?>
<?php } ?>
<?php } ?>
<?php } ?>

</html>