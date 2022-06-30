<?php

try {
    //code...
    // Include config file
    require_once "config.php";


    $username = $password = $email = $photo =  "";
    $username_err = $password_err = $email_err = $photo_err =  "";

    // نفحص الدنا يلي راح يدخلها المتسختدم
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        if (!empty($link)) {
            // Validate username
            if (empty(trim($_POST["username"]))) {
                $username_err = "Please enter a username.";
            } elseif (!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["username"]))) {
                $username_err = "Username can only contain letters, numbers, and underscores.";
            } elseif (strlen(trim($_POST["username"])) < 3) {
                $username_err = "Username must have atleast 3 characters.";
            } else {
                $sql = "SELECT id FROM users WHERE username = ?";

                if (!empty($link)) {
                }
                if ($stmt = mysqli_prepare($link, $sql)) {
                    mysqli_stmt_bind_param($stmt, "s", $param_username);

                    $param_username = trim($_POST["username"]);

                    if (mysqli_stmt_execute($stmt)) {
                        mysqli_stmt_store_result($stmt);

                        if (mysqli_stmt_num_rows($stmt) == 1) {
                            $username_err = "This username is already taken.";
                        } else {
                            $username = trim($_POST["username"]);
                        }
                    } else {
                        echo "Oops! Something went wrong. Please try again later.";
                    }

                    mysqli_stmt_close($stmt);
                }
            }

            if (empty(trim($_POST["email"]))) {
                $email_err = "Please enter a Email Address.";
            } elseif (!preg_match('/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\\.[a-zA-Z]{3}$/', trim($_POST["email"]))) {
                $email_err = "Email can only contain letters, numbers, and underscores.";
            } else {
                $sql = "SELECT id FROM users WHERE email = ?";

                if ($stmt = mysqli_prepare($link, $sql)) {
                    mysqli_stmt_bind_param($stmt, "s", $param_email);

                    $param_email = trim($_POST["email"]);

                    if (mysqli_stmt_execute($stmt)) {
                        mysqli_stmt_store_result($stmt);

                        if (mysqli_stmt_num_rows($stmt) == 1) {
                            $email_err = "This email is already taken.";
                        } else {
                            $email = trim($_POST["email"]);
                        }
                    } else {
                        $email_err = "Oops! Something went wrong. Please try again later.";
                    }

                    mysqli_stmt_close($stmt);
                }
            }

            if (empty(trim($_POST["password"]))) {
                $password_err = "Please enter a password.";
            } elseif (strlen(trim($_POST["password"])) < 8) {
                $password_err = "Password must have atleast 8 characters.";
            } else {
                $password = trim($_POST["password"]);
            }

            // Validate file - نفحص نوع ملف 

            if (empty(trim($_FILES['photo']['name']))) {
                $photo_err = "Please choose imgae profile.";
            } else {
                $file_type = $_FILES['photo']['type'];

                $allowed = array("image/jpeg", "image/jpg", "image/png");
                if (!in_array($file_type, $allowed)) {
                    $photo_err = 'Only jpg1, jpeg, and png files are allowed.';
                }
                $path = getcwd() . '\\img\\' . $_FILES['photo']['name'];
                move_uploaded_file($_FILES['photo']['tmp_name'], $path);
                $photo = $path;
            }






            // نفحص دااتا بعد ما نجيبهما من داتا بيز
            if (empty($username_err) && empty($password_err) && empty($email_err) && empty($photo_err)) {

                // Prepare an insert statement
                $sql = "INSERT INTO users (username, password, email, picture_user) VALUES (?, ?, ?, ?)";

                if ($stmt = mysqli_prepare($link, $sql)) {
                    mysqli_stmt_bind_param($stmt, "ssss", $param_username, $param_password, $param_email, $param_photo);

                    $param_username = $username;
                    $param_email = $email;
                    $param_photo = $photo;
                    $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash

                    if (mysqli_stmt_execute($stmt)) {
                        header("location: login.php");
                    } else {
                        $password_err =  "Oops! Something went wrong. Please try again later.";
                    }

                    mysqli_stmt_close($stmt);
                }
            }

            // نسكر الاتصال 

            mysqli_close($link);
        } else {
            $password_err =  "Something went wrong, please try again later.";
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
    <title>Sign Up</title>
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

<body style="background-color: rgb(100,50,200); margin-top: 6%;">
    <div class="wrapper" style="margin: 10px auto; width: 400px; height: 480px; background-color: #ffffff; border-radius: 16px;">
        <h2>Sign Up</h2>
        <p>Please fill this form to create an account.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
            <div class="form-group">

                <input type="text" name="username" placeholder="User name" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                <span class="invalid-feedback"><?php echo $username_err; ?></span>
            </div>

            <div class="form-group">

                <input type="email" name="email" placeholder="Email address" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>">
                <span class="invalid-feedback"><?php echo $email_err; ?></span>
            </div>

            <div class="form-group">

                <input type="password" name="password" placeholder="Password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>">
                <span class="invalid-feedback"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">

                <input type="file" name="photo" accept="image/*" class="form-control <?php echo (!empty($photo_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $photo; ?>">
                <span class="invalid-feedback"><?php echo $photo_err; ?></span>


            </div>

            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <input type="reset" class="btn btn-secondary ml-2" value="Reset">
            </div>
            <p>Already have an account? <a href="login.php">Login here</a>.</p>
        </form>
    </div>

</body>

</html>