<?php
/* @var string $firstName*/
/* @var string $lastName*/

use App\view\components\ResponsiveComponent\ImageComponent\BackGroundImage;
use App\view\components\ResponsiveComponent\NavbarComponent\AuthNavbar;
use App\view\components\ResponsiveComponent\NavbarComponent\Navbar;

$navbar= new Navbar([
    'Home'=>'/home',
    'About'=>'/about',
    'Contact'=>'/contact',
    'Register'=>'/register'
],'#','/public/images/icons/user.png','');
$background=new BackGroundImage();
echo $navbar;
echo $background
?>
<div class="d-flex text-white bg-white-0-5 p-3 border-radius-10">
    <div class="d-flex">
        <form action="" method="post">
            <em class="text-xl m-2 mb-1 text-danger" ><?= $errors['error'] ?? '' ?></em>
            <input type="text" name="token" value="<?= $token?>" hidden="">
            <div class="form-group">
                <label for="password">New Password</label>
                <input type="password" name="password" id="password" class="form-control">
            </div>
            <div class="form-group">
                <label for="confirm-password">Confirm New Password</label>
                <input type="password" name="confirmPassword" id="confirm-password" class="form-control">
            </div>
            <div class="form-group d-flex justify-content-center">
                <input type="submit" value="Change Password" class="btn btn-primary">
            </div>
    </div>
</div>