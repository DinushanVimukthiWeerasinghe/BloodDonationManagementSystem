<?php
/* @var string $firstName*/
/* @var string $lastName*/
/* @var MedicalOfficer $model*/
use App\model\users\MedicalOfficer;
use App\view\components\ResponsiveComponent\FormComponent\BasicForm;
use App\view\components\ResponsiveComponent\NavbarComponent\AuthNavbar;
use App\view\components\ResponsiveComponent\NotificationComponent\Notification;
use App\view\components\ResponsiveComponent\Title\primaryTitle;

$background=new \App\view\components\ResponsiveComponent\ImageComponent\BackGroundImage();
$navbar= new AuthNavbar('Manager Notification','#','/public/images/icons/user.png',false,'',false);
echo AuthNavbar::getNavbarCSS();

echo $navbar;
echo $background;
?>

<link href="/public/css/components/notification/notification.css" rel="stylesheet">
<div class="outer-notifications">
    <div class="notifications">
        <?php
        foreach ($model as $notification)
        {
            $title=$notification->getTitle();
            $description=$notification->getDescription();
            if (strlen($description) > 100)
            {
                $description=substr($description,0,100).'...';
            }
            $date=$notification->getDate();
            $time=$notification->getTime();
            $status=$notification->getStatus();
            $type=$notification->getType();
            $id=$notification->getID();
            $targetID=$notification->getTargetID();
//            echo Notification::getNotification($title,$description,$date,$time,$status,$type,$id,$targetID);
            echo Notification::getNotification($title,$description,$date,$time,$status,$type,$id,$targetID);
        }
        echo '</div>';
        /** @var int $total_pages */
        /** @var int $current_page */
        echo Notification::NavigationFooter($total_pages,$current_page);
        ?>

    </div>

</div>
