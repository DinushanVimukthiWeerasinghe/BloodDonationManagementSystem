<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" /> <?php
/* @var string $organization_Name */


use App\view\components\ResponsiveComponent\Alert\FlashMessage;
use App\view\components\ResponsiveComponent\CardGroup\CardGroup;
use App\view\components\ResponsiveComponent\ImageComponent\BackGroundImage;
use App\view\components\ResponsiveComponent\NavbarComponent\AuthNavbar;

$navbar = new AuthNavbar('Inform Donors', '/organization', '/public/images/icons/user.png', true,false );
echo $navbar;

use App\view\components\WebComponent\Card\Card;

echo Card::ImportJS();
//echo Card::ImportCSS();

/* @var Organization $user */

use App\model\users\Organization;
use App\view\components\WebComponent\Card\NavigationCard;
$background = new BackGroundImage();
echo $background;
FlashMessage::RenderFlashMessages();
?>
<link rel="stylesheet" href="/public/css/components/form/index2.css">
<link rel="stylesheet" href="/public/css/framework/util/border/border-radius.css">
<div class="container p-5">
    <form action="#" method="post" class="form-column p-3">
        <h1 class="form-title mt-0">Inform Donors</h1>
        <div class="form-entity mt-2">
            <label class="form-label">Your Message</label><br><br>
            <input type="text" class="form-input">
        </div>
        <div class="form-entity mt-3">
            <label class="form-label">Message Type</label><br><br>
            <select class="form-select">
                <option>Urgent</option>
                <option>Not Urgent</option>
            </select>
        </div><br><br>
        <div class="form-row">
            <input type="submit" class="btn btn-success mr-2">
            <input type="reset" class="btn btn-dark">
         <div>
    </form>
</div>
