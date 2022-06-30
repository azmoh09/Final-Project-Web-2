<?php
include('config.php');
include('session.php');


if (isset($_POST['comment'])) {
    $comment = $_POST['comment_content'];
    $post_id = $_POST['id'];
    $time =  date('Y-m-d h:i:sa');
    if (!empty($link)) {
        mysqli_query($link, "insert into comments (text, create_at, User_id, post_id ) values ('$comment','$time','$user_id', '$post_id')");
    } else {
        echo "Something went wrong, please try again later.";
    }


?>
    <script>
        window.location = 'index.php';
    </script>

<?php
}
?>