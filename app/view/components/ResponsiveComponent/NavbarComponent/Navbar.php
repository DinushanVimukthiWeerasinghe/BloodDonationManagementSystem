<?php

namespace App\view\components\ResponsiveComponent\NavbarComponent;

use App\model\users\Manager;
use App\model\users\User;
use Core\Application;
use Core\SessionObject;

class Navbar
{
    public const Authenticated=true;
    public const NotAuthenticated=false;
    private array $links;
    private string $profileLinks;
    private string $profileImage;
    private string $profileName;
    private bool $AuthNavBar;

    /**
     * @param array $links
     * @param string $profileLinks
     * @param string $profileImage
     * @param string $profileName
     */
    public function __construct(array $links, string $profileLinks, string $profileImage,bool $auth=false, string $profileName='')
    {
        $this->links = $links;
        $this->profileLinks = $profileLinks;
        $this->profileImage = $profileImage;
        $this->profileName = $profileName;
        $this->AuthNavBar= $auth;
    }

    private function getLinks(): string
    {

        $links = '';
        foreach ($this->links as $key => $value) {
            $id=substr($value,1).'Link';
            if ($value==='/home')
                $value='/';

            $links .= <<<HTML
                <li class="navLi"  onclick="Redirect('$value')"><a id="$id" href="$value">$key</a></li>
            HTML;
        }
        return $links;
    }

    private function getProfile()
    {
        if ($this->AuthNavBar)
        {
        $user_role=Application::$app->getUser()->getTypeId();
        $id=Application::$app->getUser()->getUid();
        $profileName='';
        if ($user_role==='manager')
        {
            $manager= Manager::findOne(['Officer_ID'=>$id]);
            $profileName=$manager->getFirstName().' '.$manager->getLastName();
        }
            return <<<HTML
                <div class="profile">
                        <div class="logout" onclick="Logout()"><img src="/public/images/icons/navbar/sign-out.png" alt=""> </div>
                        <div class="navProfile"><img class="profile-icon" src="/public/images/icons/user.png" alt=""></div>
                        <div class="navProfileName"><span>$profileName</span></div>
                </div>
            HTML;
        }else{
            return '';
        }
    }

    public static function getNavbarCSS(): string
    {
        return <<<HTML
            <link rel="stylesheet" href="/public/css/components/navbar/navbar.css">
        HTML;
    }

    public static function getNavbarJS(): string{
        return <<<HTML
            <script src="/public/js/components/navbar/navbar.js"></script>
        HTML;
    }

//echo "<li class='navLi'><a href='$value'>$key</a></li>";
    public function __toString(): string
    {
        return <<<HTML
            <header>
                <nav>
                    <div class="logo" id="Brand" onclick="Redirect('/')"><img src="/public/images/logo.png" id="BrandIcon" width="80rem" alt=""><span class="BrandText">Be Positive</span></div>
                    <!-- nav List -->
                    <ul class="navList">
                        <div class="profile-sm">
                            <div class="navProfile"><img class="profile-icon" src="/public/images/icons/user.png" alt=""></div>
                            <div class="navProfileName"><span>$this->profileName</span></div>
                            <div class="logout" onclick="Logout()">Sign Out</div>
                        </div>
                        {$this->getLinks()}
                    </ul>
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