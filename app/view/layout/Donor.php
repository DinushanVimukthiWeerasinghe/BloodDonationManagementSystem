<!DOCTYPE html>
<html lang="en">
<head>
    <title>Donor Dashboard</title>
    <meta charset="UTF-8">
    <meta content='width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;' name='viewport' />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<!--    <link rel="stylesheet" href="/public/css/components/navbar/navbar.css">-->
    <link rel="stylesheet" href="/public/css/framework/utils.css">
    <link rel="stylesheet" href="/public/css/components/cardPane/index.css">
    <script src="/public/scripts/index.js"></script>
</head>
<body>
    <?php
    /* @var string $firstName */
    /* @var string $lastName */
    use App\view\components\ResponsiveComponent\ImageComponent\BackGroundImage;
    use App\view\components\ResponsiveComponent\NavbarComponent\DonorNavbar;

//    $background = new BackGroundImage();

//    echo $background;

    $navbar = new DonorNavbar('Donor Board', '/donor/profile', '/public/images/icons/user.png', true,$firstName . ' ' . $lastName,false );
        echo $navbar;
    ?>
    {{content}}
</body>
<script src="/public/js/components/navbar/navbar.js"></script>
<script src="/public/js/components/dialog-box/dialog-box.js"></script>
</html>
