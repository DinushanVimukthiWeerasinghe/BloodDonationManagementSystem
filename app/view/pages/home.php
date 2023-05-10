
<div class="dark-bg"></div>
<?php
/** @var $Blogs \App\model\Blog\Blog[]*/
use App\view\components\ResponsiveComponent\NavbarComponent\AuthNavbar;
use App\view\components\ResponsiveComponent\NavbarComponent\Navbar;

$navbar= new Navbar([
    'Home'=>'/home',
    'Services'=>'#service-panel',
    'Contact'=>'#contact-us-panel',
    'Register'=>'/register'
],'#','/public/images/icons/user.png','');
echo $navbar;
echo AuthNavbar::getNavbarJS();
?>

<div id="home">
    <section id="welcome-panel" class="panel">
        <div class="sub-panel">
            <div class="intro">
                <div id="caption">
                    <span class="main-tagline">Donate Blood <br>Save Life</span>
                    <span id="description">" The Blood You Donate Gives Someone Another Chance At Life "</span>
                    <span id="description-2">" The Blood You Donate Gives Someone Another Chance At Life "</span>
                    <a id="donate-btn" href="/login" class="btn btn-primary">Donate Now</a>
                </div>
                <div class="image-welcome">
                    <img src="/public/images/bd-home.png" alt="">
                </div>
            </div>
            <div class="d-flex">
                <a href="#intro-panel" class="nav-card n-card btn btn-primary">Why Donation</a>
                <a href="#organize-camp-panel" class="nav-card n-card btn btn-primary">Organize<br> Blood Camp</a>
                <a href="#service-panel" class="nav-card n-card btn btn-primary">Our Services</a>
            </div>

        </div>
    </section>
    <section id="intro-panel" class="panel">
        <div class="sub-panel d-flex-row">
            <div class="intro">
                <div class="desc-image">
                    <img src="/public/images/bd-home.png" alt="">
                </div>
                <div id="caption">
                    <div class="tagline">Why Blood Donation Important ?</div>
                    <div class="desc">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Error ex optio qui ratione ullam. Adipisci amet architecto aut culpa cum delectus dicta dolorem, enim impedit iste itaque placeat possimus quasi qui quidem quod quos rem tempora, unde veniam. Debitis molestias nisi vel? Asperiores, optio, quaerat!</div>
                    <div class="btn-container">
                        <a id="donate-btn" href="#blood-info-panel" class="btn btn-primary">Learn More </a>
                        <a id="donate-btn" href="#donation-report" class="btn btn-primary">View Report </a>
                    </div>

                </div>
            </div>
        </div>
    </section>
    <section id="organize-camp-panel" class="panel">
        <div class="sub-panel d-flex-row">
            <div class="intro">
                <div id="caption">
                    <div class="tagline">Organize Blood Campaign</div>
                    <span class="desc">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Error ex optio qui ratione ullam. Adipisci amet architecto aut culpa cum delectus dicta dolorem, enim impedit iste itaque placeat possimus quasi qui quidem quod quos rem tempora, unde veniam. Debitis molestias nisi vel? Asperiores, optio, quaerat!</span>
                    <a id="reg-org-btn" href="/register?role=organization" class="btn btn-primary">Organize Blood Campaign </a>
                </div>
                <div class="desc-image">
                    <img src="/public/images/bd-home.png" alt="">
                </div>
            </div>
        </div>
    </section>
    <section id="blood-info-panel" class="panel">
        <div class="sub-panel d-flex-row">
            <div class="intro">
                <div class="desc-image">
                    <img src="/public/images/blood-cells.jpg" width="600px" alt="">
                </div>
                <div id="caption">
                    <div class="tagline">Importance Of Blood</div>
                    <span class="desc">
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Error ex optio qui ratione ullam.
                        Adipisci amet architecto aut culpa cum delectus dicta dolorem, enim impedit iste itaque placeat
                        possimus quasi qui quidem quod quos rem tempora, unde veniam. Debitis molestias nisi vel? Asperiores, optio, quaerat!
                    </span>
                </div>
            </div>
        </div>
    </section>
    <?php
    $i=5;
    if (!empty($Blogs)):
        foreach ($Blogs as $blog):
    ?>
            <section id="blog-<?=$blog->getBlogID()?>" class="panel">
                <div class="sub-panel d-flex-row">
                    <div class="intro" style="flex-direction: <?= $i%2===1 ? 'row-reverse':'row' ?>">
                        <div class="desc-image">
                            <img src="<?=$blog->getBlogImage()?>" width="600px" alt="">
                        </div>
                        <div id="caption">
                            <div class="tagline"><?=$blog->getBlogTitle()?></div>
                            <span class="desc">
                        <?=$blog->getBlogContent()?>
                    </span>
                        </div>
                    </div>
                </div>
            </section>
    <?php
            $i++;
        endforeach;
    endif;
    ?>

    <section id="service-panel" class="panel">
        <div class="sub-panel d-flex-row">
            <div class="d-flex flex-column align-items-center w-100 justify-content-center gap-1">
                    <div class="text-xl font-bold p-3 bg-white border-radius-10">Our Major Services</div>
                    <div class="d-flex flex-wrap align-items-center justify-content-center text-dark">
                        <div class="card">
                            <div class="card-header flex-column">
                                <img src="/public/images/realtime.png" alt="" width="200px">
                                <div class="text-xl">Donor Management</div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header flex-column">
                                    <img src="/public/images/24hour.png" alt="" width="200px">
                                <div class="text-xl">Blood transfusion management</div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header flex-column">
                                    <img src="/public/images/24hour.png" alt="" width="200px">
                                <div class="text-xl">Reporting and analytics</div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header flex-column">
                                    <img src="/public/images/24hour.png" alt="" width="200px">
                                <div class="text-xl">Mobile and web access</div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header flex-column">
                                    <img src="/public/images/24hour.png" alt="" width="200px">
                                <div class="text-xl">Communication and notification</div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header flex-column">
                                    <img src="/public/images/24hour.png" alt="" width="200px">
                                <div class="text-xl">Compliance and regulatory support</div>
                            </div>
                        </div>

                    </div>
                </div>
        </div>
    </section>
    <section id="contact-us-panel" class="panel">
        <div class="sub-panel d-flex-row">
            <div class="intro">
                <div class="desc-image">
                    <img src="/public/images/contact-us.png" width="400px" alt="">
                </div>
                <div id="caption">
                    <div class="tagline">Contact Us</div>
                    <div class="cu-form">
                        <form action="" method="post">
                            <div class="content">
                                <label for="subject"></label>
                                <input id="subject" type="text" name="subject" placeholder="Subject">
                                <label for="message"></label>
                                <textarea id="message" name="message" placeholder="Message"></textarea>
                                <button type="submit" class="btn btn-primary">Send</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

</div>

