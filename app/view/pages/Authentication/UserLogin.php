<link rel="stylesheet" href="/public/styles/manager/login.css" xmlns="http://www.w3.org/1999/html">
<div class="dark-bg"></div>
<?php

use App\view\components\ResponsiveComponent\NavbarComponent\AuthNavbar;
use App\view\components\ResponsiveComponent\NavbarComponent\Navbar;

$navbar= new Navbar([
],'#','/public/images/icons/user.png','');
echo AuthNavbar::getNavbarCSS();
echo $navbar;
echo AuthNavbar::getNavbarJS();
?>
    <?php

    /**
     * @var Login $model
     */

    use App\model\Authentication\Login;

    ?>



<div class="login-form">
    <div class="outer-form">
        <div class="sign-in-image">
        </div>
        <div class="form">
            <div class="form-header">
                <div class="form-title"><span class="lock-ico"> </span> Sign In</div>
            </div>
            <form autocomplete="off" action="/login" method="post">
                <div class="error"><span><?php echo $model->hasError('Email')?$model->getFirstError('Email'):($model->hasError('Password')?$model->getFirstError('Password'):'')?></span></div>
                <label for="email"></label><input autocomplete="off" class="input" id="email" name="Email" placeholder="Username | Email" type="text"/>
                <label for="password"></label>
                <span class="pass">
                    <input id="password" name="Password" placeholder="Password" type="password"/>
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
