<?php

try {
    //code...
    // Initialize the session - بداية الجلسة 
    session_start();

    // Check if the user is already logged in, if yes then redirect him to index page - نفحص اليوزر اذا سجل او لا ، اذا سجل بنحول على صفحة اندكس
    if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
        header("location: index.php");
        exit;
    }

    // Include config file -- نجيب ملف اتصال داتا بيز
    require_once "config.php";


    $username  = $password = "";
    $email_username_err = $password_err = $login_err = "";

    // Processing form data when form is submit -- نعمل فحص للبيانات اليوزر يلي دخلها 
    if ($_SERVER["REQUEST_METHOD"] == "POST") {


        if (empty(trim($_POST["username"]))) {
            $email_username_err = "Please enter username.";
        } else {
            $username = trim($_POST["username"]);
        }


        if (empty(trim($_POST["password"]))) {
            $password_err = "Please enter your password.";
        } else {
            $password = trim($_POST["password"]);
        }


        if (empty($email_username_err) && empty($password_err)) {
            // Prepare a select statement -- نحل مشكلة انجكشن 
            $sql = "SELECT id, username, password FROM users WHERE username = ?";
            if (!empty($link)) {
                if ($stmt = mysqli_prepare($link, $sql)) {
                    mysqli_stmt_bind_param($stmt, "s", $param_username);
                    $param_username = $username;

                    // Attempt to execute the prepared statement -- نعمل تنفيذ على بارم 
                    if (mysqli_stmt_execute($stmt)) {
                        // Store result -- نخزن النتجية 
                        mysqli_stmt_store_result($stmt);

                        if (mysqli_stmt_num_rows($stmt) == 1) {
                            mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                            if (mysqli_stmt_fetch($stmt)) {
                                if (password_verify($password, $hashed_password)) {


                                    if (!isset($_SESSION)) {
                                        session_start();
                                    }



                                    // Store data in session variables -- نخزن الداتا في سيشن 
                                    $_SESSION["loggedin"] = true;
                                    $_SESSION["id"] = $id;
                                    $_SESSION["username"] = $username;
                                } else {
                                    $login_err = "Invalid  password.";
                                }
                            }
                        } else {
                            $login_err = "Invalid  username .";
                        }
                    } else {
                        $login_err =  "Oops! Something went wrong. Please try again later.";
                    }

                    // Close statement -- نعمل كلوس لل بارم .
                    mysqli_stmt_close($stmt);
                }
            } else {
                $login_err =  "Something went wrong, please try again later.";
            }
        }

        // Close connection -- نسكر اتصال داتا بيز
        if (!empty($link)) {
            mysqli_close($link);
        } else {
            $login_err =  "Something went wrong, please try again later.";
        }
    }
} catch (Exception $th) {
    //throw $th;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font: 14px sans-serif;
        }

        .wrapper {
            width: 360px;
            padding: 20px;
        }
    </style>
</head>

<body style="background-color: #2ffc6a;">
    <div class="wrapper" style="margin: 10px auto; width: 400px; height: 380px; background-color: #ffffff; border-radius: 16px; margin-top: 10%;">
        <h2>Login</h2>
        <p>Please fill in your credentials to login.</p>

        <?php
        if (!empty($login_err)) {
            echo '<div class="alert alert-danger">' . $login_err . '</div>';
        }
        ?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">

                <input type="text" name="username" placeholder="Username" class="form-control <?php echo (!empty($email_username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username;  ?>">
                <span class="invalid-feedback"><?php echo $email_username_err; ?></span>
            </div>
            <div class="form-group">

                <input type="password" name="password" placeholder="Passowrd" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>">
                <span class="invalid-feedback"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Login">
            </div>
            <p>Don't have an account? <a href="register.php">Sign up now </a>.</p>
        </form>
    </div>
</body>

</html>