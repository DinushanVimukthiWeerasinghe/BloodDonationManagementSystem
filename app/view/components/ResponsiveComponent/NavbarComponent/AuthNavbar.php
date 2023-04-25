<?php

namespace App\view\components\ResponsiveComponent\NavbarComponent;

use App\model\users\Manager;
use App\model\users\User;
use Core\Application;
use Core\SessionObject;

class AuthNavbar
{
    public const Authenticated=true;
    public const NotAuthenticated=false;
    private string $title;
    private string $Istitle;
    private string $profileLinks;
    private string $profileImage;
    private string $profileName;
    private bool $navList;

    /**
     * @param string $title
     * @param string $profileLinks
     * @param string $profileImage
     * @param bool $IsTitle
     * @param bool $navList
     */
    public function __construct(string $title, string $profileLinks, string $profileImage, bool $IsTitle=false,bool $navList=true)
    {
        $this->title = $title;
        $this->Istitle = $IsTitle;
        $this->profileLinks = $profileLinks;
        $this->profileImage = $profileImage;
        $this->profileName = Application::$app->getUser()->getFullName();
        $this->navList=$navList;
    }


    private function getProfile()
    {
        $user=Application::$app->getUser();
        $profileName=$user->getFirstName().' '.$user->getLastName();
        $actions=Application::$app->request->getPath();
        $path=explode('/',$actions);
        $action=$path[2];
        $link=[];
        if ($action==='notification')
        {
            $link[0]=[
                'link'=>'/manager/dashboard',
                'icon'=>'/public/images/icons/navbar/home.png',
                'title'=>'Notification'
            ];
        }else if (($action==='dashboard')){
            $link[0]=[
                'link'=>'/manager/notification',
                'icon'=>'/public/images/icons/navbar/bell.png',
                'title'=>'Notification'
            ];
        }else{
            $link[0]=[
                'link'=>'/manager/dashboard',
                'icon'=>'/public/images/icons/navbar/home.png',
                'title'=>'Dashboard'
            ];
            $link[1]=[
                'link'=>'/manager/notification',
                'icon'=>'/public/images/icons/navbar/bell.png',
                'title'=>'Notification'
            ];

        }
        $lnk='';
        foreach ($link as $item)
        {
            $lnk.="
            <a href='{$item['link']}' class='logout'>
                <img src='{$item['icon']}' alt='' width='45rem'>
            </a>
            ";
        }

        $profilePicture=Application::$app->getUser()->getProfileImage();
        $profileLnk=$this->profileLinks;
           return <<<HTML
                <div class="profile">
                        $lnk
                        <a href="/logout" class="logout"><img src="/public/images/icons/navbar/sign-out.png" alt="" width="45rem"> </a>
                        <a  href="$profileLnk" class="navProfile"><img class="profile-icon" src="$profilePicture" width="40rem" alt="profile"></a>
                        <div class="navProfileName"><span>{$profileName}</span></div>
                </div>
            HTML;
    }


    public static function getNavbarJS(): string{
        return <<<HTML
            <script src="/public/js/components/navbar/navbar.js"></script>
        HTML;
    }

    public function RenderNavList(): string
    {
        $actions=Application::$app->request->getPath();
        $path=explode('/',$actions);
        $action=$path[2];
        $link=[];
        if ($action==='notification')
        {
            $link[0]=[
                'link'=>'/manager/dashboard',
                'icon'=>'/public/images/icons/navbar/home.png',
                'title'=>'Notification'
            ];
        }else if (($action==='dashboard')){
            $link[0]=[
                'link'=>'/manager/notification',
                'icon'=>'/public/images/icons/navbar/bell.png',
                'title'=>'Notification'
            ];
        }else{
            $link[0]=[
                'link'=>'/manager/dashboard',
                'icon'=>'/public/images/icons/navbar/home.png',
                'title'=>'Dashboard'
            ];
            $link[1]=[
                'link'=>'/manager/notification',
                'icon'=>'/public/images/icons/navbar/bell.png',
                'title'=>'Notification'
            ];

        }
        $lnk='';
        foreach ($link as $item)
        {
            $lnk.="
            <a href='{$item['link']}' class='link-sm'>
                <img src='{$item['icon']}' alt='' width='30rem'> <div class='link-text'>{$item['title']}</div>
            </a>
            ";
        }
        $profilePicture=Application::$app->getUser()->getProfileImage();
        if ($this->navList){
            return <<<HTML
                <ul class="navList">
                        <div class="profile-sm">
                            <div class="navProfile"><img class="profile-icon" src="$profilePicture" alt=""></div>
                            <div class="navProfileName"><span>$this->profileName</span></div>
                            <div class="logout" onclick="Logout()">Sign Out</div>
                            $lnk
                        </div>
                    </ul>
            HTML;
        }else{
            return '';
        }

    }

//echo "<li class='navLi'><a href='$value'>$key</a></li>";
    public function __toString(): string
    {
        return <<<HTML
            <header>
                <nav>
                    <div class="logo" onclick="Redirect('/')"><img src="/public/images/logo.png" width="80rem" alt=""><span>Be Positive</span></div>
                    <!-- nav List -->
                    <div class="title">{$this->title}</div>
                    {$this->RenderNavList()}
                    {$this->getProfile()}
                    <!-- nav Button -->
                    <div class="navBtn ">
                        <div class="line1"></div>
                        <div class="line2"></div>
                        <div class="line3"></div>
                    </div>
                </nav>
            </header>
            
        HTML;

    }


}