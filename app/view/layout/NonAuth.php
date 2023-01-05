<<?php
/* @var string $firstName*/
/* @var string $lastName*/

use App\view\components\ResponsiveComponent\NavbarComponent\AuthNavbar;
use App\view\components\ResponsiveComponent\NavbarComponent\Navbar;

$navbar= new Navbar([
    'Home'=>'/home',
    'About'=>'/about',
    'Contact'=>'/contact',
    'Register'=>'/register'
],'#','/public/images/icons/user.png','');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>My Site</title>
    <meta charset="UTF-8">
    <meta content='width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;' name='viewport' />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
</head>
<body>

<?php
echo AuthNavbar::getNavbarCSS();

echo $navbar
?>
    {{content}}
</body>
<?php
echo AuthNavbar::getNavbarJS();
?>
<!--<script src="/public/scripts/navbar/navbar.js"></script>-->

</html>
