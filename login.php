<?php
include 'db.php';
session_start();
$data = mysqli_connect($host, $user, $pass, $db);

if (!$data) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($data, $_POST["username"]);
    $password = mysqli_real_escape_string($data, $_POST["password"]);

    if ($username == "admin" && $password == "admin@123") {
        echo "Log in to ADMIN LOGIN !";
    } else {
        $encrypted_password = md5($password);
        $sql = "SELECT * FROM id_emp WHERE username='$username' AND password='$password'";
        $result = mysqli_query($data, $sql);

        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $_SESSION["username"] = $username;
            
            if ($_SESSION["username"] == 'isp_admin') {
                header("Location: viewpage.php");
                exit();
            } else {
                header("Location: viewuser.php");
                exit();
            }
             // Always call exit after a header redirect
        } else {
            echo "<script>alert('Username or password incorrect')</script>";
        }
    }
}
mysqli_close($data);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        /* General styles */
        body {
            background-color: #e9ecef;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .header {
            background-color: brown;
            color: white;
            padding: 15px 20px;
            display: flex;
            align-items: center;
            justify-content: space-evenly;
        }

        .header img {
            height: 50px;
        }

        .header h1 {
            font-size: 22px;
            margin: 0;
        }

        .main-content {
            display: flex;
            flex-grow: 1;
            flex-wrap: wrap;
            padding: 30px;
            box-sizing: border-box;
        }

        .image-container {
            flex: 0 0 30%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 20px;
            box-sizing: border-box;
        }

        .image-container h1 {
            margin-bottom: 20px;
            color: #333;
            font-size: 50px;
            text-align: center;
        }

        .image-container img {
            max-width: 100%;
            height: auto;
            border-radius: 10px;
        }

        .heading {
            background-color: lightsalmon;
            border-radius: 20px;
            margin-bottom: 10px;
        }

        .login-container {
            flex: 0 0 70%;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #fff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            box-sizing: border-box;
        }

        .login-box {
            width: 100%;
            max-width: 400px;
        }

        .login-box h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #333;
            font-size: 24px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-size: 16px;
            margin-bottom: 8px;
            color: #555;
        }

        .form-group input[type="text"],
        .form-group input[type="password"] {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 16px;
        }

        .form-group input[type="text"]:focus,
        .form-group input[type="password"]:focus {
            border-color: #007bff;
            box-shadow: 0 0 8px rgba(0, 123, 255, 0.2);
            outline: none;
        }

        .btn {
            display: block;
            width: 100%;
            padding: 14px;
            border: none;
            border-radius: 6px;
            background-color: #007bff;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: #0056b3;
        }

        footer {
            background-color: brown;
            color: white;
            text-align: center;
            padding: 10px 0;
            margin-top: auto;
        }

        /* Responsive styles */
        @media (max-width: 768px) {
            .image-container,
            .login-container {
                flex: 1 1 100%;
            }

            .image-container h1 {
                font-size: 20px;
            }

            .login-box h2 {
                font-size: 20px;
            }
        }

        @media (max-width: 576px) {
            .header h1 {
                font-size: 18px;
            }

            .header img {
                height: 40px;
            }

            .login-box h2 {
                font-size: 18px;
            }

            .form-group label {
                font-size: 14px;
            }

            .form-group input[type="text"],
            .form-group input[type="password"],
            .btn {
                font-size: 14px;
            }
        }
    </style>
</head>

<body>
    <div class="header">
        <img src="drdologo.jpg" alt="DRDO Logo">
        <h1>अग्नि, विस्फोटक और पर्यावरण सुरक्षा केंद्र (सीएफईईएस)<br>
        Centre for Fire, Explosive and Environment Safety (CFEES) </h1>
    </div>
    <div class="main-content">
        <div class="image-container">
            <div class="heading"><h1 style="color:firebrick">Information Security Guidelines Portal</h1></div>
            <img src="img.png" alt="Image">
        </div>
        <div class="login-container">
            <div class="login-box">
                <h2>Login</h2>
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" name="myform" method="post" onsubmit="return validateForm()">
                    <div class="form-group" id="username">
                        <label for="username">Username:</label>
                        <input type="text" id="username" name="username" required>
                        <b><span class="formerror"></span></b>
                    </div>
                    <div class="form-group" id="password">
                        <label for="password">Password:</label>
                        <input type="password" id="password" name="password" required>
                        <b><span class="formerror"></span></b>
                    </div>
                    <input type="submit" class="btn" name="login" value="Login">
                </form>
                <?php if (isset($error_message)): ?>
                    <div class="error-message"><?php echo $error_message; ?></div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <footer>
        <h3>Designed and maintained by QRS&IT group.</h3>
    </footer>

</body>

</html>
