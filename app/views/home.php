<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login | School Management System</title>
    <link href="<?php echo URL_APP_PUBLIC; ?>css/login.css" rel="stylesheet">
</head>
<body>
    <div id="loginWrapper">
        <h2>Welcome back,</h2>
        <?php 
            if(isset($error)){
                echo "<div class='error'>$error</div>";
            }
        ?>
        <form action="" method="POST">
            <input type="text" name="studentIdentityNumber" placeholder="Identity Number" autocomplete="off">
            <input type="password" name="password" placeholder="Password" autocomplete="new-password">
            <input type="hidden" name="token" value="<?= $csrf ?>">
            <input type="submit" name="submitLogin" value="Sign In">
        </form>
    </div>
</body>
</html>
