<?php
include('config.php');
include('session.php');
if (isset($_POST['post'])) {
    $file_type = $_FILES['img']['type']; //نفصح نوع ملف 

    $allowed = array("image/jpeg", "image/jpg", "image/png");
    if (!in_array($file_type, $allowed)) {

        $img_err = '<h1 style = "color:red;">Only jpg, jpeg, and png files are allowed, <a href = "index.php">back to index</a></h1>';
        echo $img_err;



        exit();
    }


    $content  = $_POST['content'];
    $picture = $_FILES['img']['name'];


    $path = getcwd() . '\\img\\' . $_FILES['img']['name'];
    move_uploaded_file($_FILES['img']['tmp_name'], $path);
    $time =  date('Y-m-d h:i:sa');

    if (!empty($link)) {
        mysqli_query($link, "insert into posts (text_p, picture, create_at,User_id) values ('$content', '$picture','$time','$user_id') ");
    } else {
        echo "<h1 style = 'color:red;'>Something went wrong, please try again later.</p>";
    }


?>
    <script>
        window.location = 'index.php';
    </script>
<?php
}
?>