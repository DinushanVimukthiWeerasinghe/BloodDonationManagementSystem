<?php
$logo = new \App\view\components\Image\GeneralImage("/public/images/logo.png", "Home Image", "logo","50rem");
?>
<head>
    <link rel="stylesheet" href='/public/styles/DonorLogin.css'>
</head>

<?php echo $logo->render();?>
<div class="container">
    <div class="top">
        <div class="box">
            <h1>Sign In</h1>
        </div>
    </div>
    <div class="center">
        <div class="mid">
            <form action="/donor/login" method="post">
                <label for="email"></label><input id="email" name="email" placeholder="Email" type="email"/>
                <label>
                    <input id="password" name="password" placeholder="Password" type="password"/>
                </label>
                <div class="buttons">
                    <input class="login" type="submit" value="Log In"/>
                    <div style="text-align: center;">
                        <a href="">Forgot your Password?</a>
                    </div>
                </div>
                <div class="buttons">
                    <p>Don’t have an account yet?</p>
                    <a href="/donor/signup">
                        <input class="signup-btn" type="button" value="Register"/>
                    </a>
                </div>
            </form>
        </div>
    </div>
    <div class="bottom"></div>
</div>
