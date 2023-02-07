<?php
/* @var $role string*/
use App\view\components\ResponsiveComponent\ImageComponent\BackGroundImage;
use App\view\components\ResponsiveComponent\NavbarComponent\AuthNavbar;
use App\view\components\ResponsiveComponent\NavbarComponent\Navbar;

$navbar= new Navbar([
    'Home'=>'/home',
    'About'=>'/about',
    'Contact Us'=>'/contact',
    'Log In'=>'/user/login'
],'#','/public/images/icons/user.png','');
echo $navbar;
$background=new BackGroundImage();
echo $background;
?>
<div class="d-flex bg-white-0-3 gap-1 p-2">
    <div class="d-flex ">
        <img src="/public/images/RegisterImage/<?= $role?>RegImg.jpg" class="border-radius-10" alt="" width="500rem">
    </div>
    <div class="d-flex bg-white-0-7 border-radius-10 p-2" >
        <form action="" method="post">
            <div class="text-2xl mb-1 font-bold text-dark w-100 text-center">
                <?= $role ?> Registration
            </div>
            <div class="form-group">
                <label for="email" class="w-30">Email</label>
                <input type="email" name="email" id="email" class="form-control border-1 w-60">
            </div>
            <div class="form-group">
                <label for="password" class="w-30">Password</label>
                <input type="password" name="password" id="password" class="form-control w-60">
            </div>
            <div class="form-group">
                <label for="confirmPassword" class="w-30">Confirm Password</label>
                <input type="password" name="confirmPassword" id="confirmPassword" class="form-control w-60">
            </div>
            <div class="form-group flex-column">
                <div class="d-flex justify-content-center w-100">
                    Already have an account? &nbsp;<a href="/login" class="text-primary">Log In</a>
                </div>
                <div class="d-flex justify-content-center w-100">
                    <a href="/user/forgot-password" class="text-primary">Forgot Password?</a>
                </div>
            </div>
            <div class="form-group" style="justify-content:center;">
                <input class="btn btn-success" type="submit" value="Register" name="register">
                <input class="btn btn-danger" type="reset" value="Reset" name="register">
            </div>


        </form>
    </div>
</div>
