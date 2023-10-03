<?php
/**
 * @var Login $model
 */

use App\model\Authentication\Login;

?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BDMS</title>
<!--    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>-->
<!--    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">-->
<!--    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">-->
    <link rel="stylesheet" href="/public/styles/organization/Orglogin.css">
</head>
<body>
<div class="login-container">
    <div class="login-info-container">
        <h1 class="title">Organization Login</h1>
        <form action="/organisation/login" method="post" class="inputs-container">
            <input class="input" type="text" placeholder="email" name="email">
            <input class="input" type="password" placeholder="Password" name="password">
            <label style="color: red;font-family: 'Arial Black';margin-left: 5%;"><b><?php echo $model->getFirstError('email')?></b></label>
            <label style="color: red;font-family: 'Arial Black';margin-left: 5%;"><b><?php echo $model->getFirstError('password')?></b></label>
            <p>Forgot password? <span class="span">Click here</span></p>
            <button class="btn" type="submit">login</button>
            <p>Don't have an account? <a href="/organisation/register" style="text-decoration: none;"><span class="span">Sign Up</span></a></p>
        </form>
    </div>
    <img class="image-container" src="../../../../public/images/orgsave.png" alt="">
</div>


</body>
</html>

</body>

</html>