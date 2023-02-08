<link rel="stylesheet" href="/public/css/framework/utils.css">
<link rel="stylesheet" href="/public/css/components/cardPane/index.css">
<!--<script src="/public/scripts/index.js"></script>-->
<?php
/* @var string $firstName */

/* @var string $lastName */

use App\model\users\organization;
use App\model\Requests\AttendanceAcceptedRequest;
use App\view\components\ResponsiveComponent\Alert\FlashMessage;
use App\view\components\ResponsiveComponent\CardPane\CardPane;
use App\view\components\ResponsiveComponent\ImageComponent\BackGroundImage;
use App\view\components\ResponsiveComponent\NavbarComponent\AuthNavbar;

//echo Loader::GetLoader();
$background = new BackGroundImage();
$navbar = new AuthNavbar('Accepted Donors', '/organization/accepted', '/public/images/icons/user.png', false);

echo $navbar;
echo $background;
//echo new primaryTitle('Manage Medical Officers');
/* @var array $data */
/* @var string $count */
/* @var organization $value */


function GetImage($imageURL)
{
    if ($imageURL == null) {
        return '/public/images/icons/user1.png';
    } else {
        return $imageURL;
    }
}

FlashMessage::RenderFlashMessages();
?>
<div class="card none detail-card p-2"  style="height: 40vh;cursor: default;width: 40vw;min-width: auto;background-size: cover">
    <div class="card-title">
        <h1 style="font-size: 2em;">Accepted No. of Donors:</h1>
    </div>
    <div class="card-body">
        <?php if($count>=10) {?>
            <div class="card-title"><h2 style="font-size: 4em;background-color: green;color: #cccccc;border-radius: 5px;"><?php echo $count ?></h2></div>
        <?php } ?>
        <?php if(0<$count && $count<10) {?>
            <div class="card-title"><h2 style="font-size: 4em;background-color: red;color: #cccccc;border-radius: 5px;"><?php echo $count ?></h2></div>
        <?php } ?>
        <?php if($count==0) {?>
            <div class="card-title"><h2 style="font-size: 4em;background-color: yellow;color: red;border-radius: 5px;">No Donors!</h2></div>
        <?php } ?>
    </div>
</div>

<?php
echo CardPane::GetJS('/organization/received/search');
?>








