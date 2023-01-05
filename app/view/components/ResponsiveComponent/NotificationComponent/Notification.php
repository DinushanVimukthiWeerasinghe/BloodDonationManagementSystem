<?php

namespace App\view\components\ResponsiveComponent\NotificationComponent;

class Notification
{
    private static array $notification_types = [
        'campaign' => '/public/images/icons/notification/campaign.png',
        'donor' => '/public/images/icons/notification/donor.png',
        'hospital' => '/public/images/icons/notification/hospital.png',
    ];

    /**
     * @param $title
     * @param $description
     * @param $date
     * @param $time
     * @param $status
     * @param $type
     * @param $id
     * @param $targetID
     */
    public static function getNotification($title, $description, $date, $time, $status, $type, $id, $targetID): string
    {
        $logo=self::$notification_types[$type];
        return <<<HTML
            <div class="notification status-$status" id="#$id">
                        <div class="notification-logo">
                            <img src="$logo" alt="$logo" width="50px">
                        </div>
                        <div class="notification-content">
                            <div class="notification-title">
                                $title
                            </div>
                            <div class="notification-body">
                                $description
                            </div>
                            
                        </div>
                        <div class="notification-action">
                            <a href="/manager/mngCampaign/view?id=$targetID" class="btn btn-primary">View</a>
                            <div class="notification-timestamp">
                            <img src="/public/images/icons/calender.png" width="30px" alt="">
                                $date $time
                            </div>
                        </div>
            </div>
            HTML;
    }

    public static function NavigationFooter(int $total_pages,int $current_page)
    {
        $pages="";
        $next=$current_page+1;
        $prev=$current_page-1;
        if ($next > $total_pages)
        {
            $next=$total_pages;
        }
        if ($prev < 1)
        {
            $prev=1;
        }
        for($i=1;$i<=$total_pages;$i++)
        {
            if ($i == $current_page){
                $pages.= "<a href='?page=$i'  class='nav-number active'>$i</a>";
                continue;
            }
            $pages.= "<a href='?page=$i'  class='nav-number'>$i</a>";
        }
        return <<<HTML
            <div class="notifications-footer">
                <div class="navigations">
                    <a href="?page=$prev" class="previous nav-btn"><img src="/public/images/icons/previous.png" alt=""></a>
                    <div class="nav-numbers">
                        $pages
                    </div>
                    <a href="?page=$next" class="next nav-btn"> <img src="/public/images/icons/next.png" alt=""> </a>
                </div>
            </div>
        HTML;

    }
}