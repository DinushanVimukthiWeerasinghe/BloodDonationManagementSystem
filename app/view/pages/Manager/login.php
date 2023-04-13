<link rel="stylesheet" href="/public/styles/manager/login.css" xmlns="http://www.w3.org/1999/html">
<div class="dark-bg">
<?php

/**
 * @var Login $model
 */

use App\model\Authentication\Login;

?>


</div>
<div class="login-form">
    <div class="outer-form">
        <div class="sign-in-image">
        </div>
        <div class="form">
            <div class="form-header">
                <div class="form-title"><span class="lock-ico"> </span> Sign In</div>
            </div>
            <form action="/manager/login" method="post">
                <div class="error"><span><?php echo $model->hasError('email')?$model->getFirstError('email'):($model->hasError('password')?$model->getFirstError('password'):'')?></span></div>
                <label for="email"></label><input class="input" id="email" name="email" placeholder="Username | Email" type="text"/>
                <label for="password"></label>
                <span class="pass">
                    <input id="password" name="password" placeholder="Password" type="password"/>
                    <span class="show-password" id="pass_icon" onclick="showPassword()">Show</span>
                </span>


                <div class="form-buttons">
                    <input class="btn-hover color-11" type="submit" value="LogIn"/>
<!--                    <input class="btn-hover color-9" type="reset" value="Reset"/>-->
                </div>
                <div class="form-footer">
                    <div class="form-footer-text">
                        <p>Don't have an account? </p>
                        <div>
                            <input type="button" class="btn-hover color-9" value="Register" onclick="window.location.href='/manager/register'">
                        </div>
                    </div>
                </div>
            </form>
        </div>


    </div>


</div>
<script src="/public/scripts/manager/login.js"></script>
