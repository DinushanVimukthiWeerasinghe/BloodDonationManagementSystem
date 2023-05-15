
<div class="dark-bg"></div>
<?php
/** @var $Blogs Blog[]*/

use App\model\Blog\Blog;
use App\view\components\ResponsiveComponent\Alert\FlashMessage;
use App\view\components\ResponsiveComponent\NavbarComponent\AuthNavbar;
use App\view\components\ResponsiveComponent\NavbarComponent\Navbar;

$navbar= new Navbar([
    'Home'=>'/home',
    'Services'=>'#service-panel',
    'Contact'=>'#contact-us-panel',
    'Login'=>'/login'
],'#','/public/images/icons/user.png','');
echo $navbar;
//echo AuthNavbar::getNavbarJS();
FlashMessage::RenderFlashMessages();
?>

<style>
    
</style>


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
                    <div class="text-xl font-bold p-1 bg-white border-radius-10">OUR SERVICES</div>
                    <div class="d-flex flex-wrap align-items-center gap-1 justify-content-center text-dark">
                        <div class="d-flex justify-content-around gap-3 w-70">
                            <div class="card relative flex-center" style="background: url('/public/images/BloodDonorManagement.jpg');background-size: cover;height: 500px;width:500px;background-clip: content-box">
                                <div class="absolute font-extraBold text-xl w-95 h-95 d-flex align-items-center justify-content-end text-white flex-column border-radius-10" style="background: rgba(0,0,0,0.3)">
                                    <div class="text-4xl ">Donor</div>
                                    <div class="text-3xl mb-2">Management</div>
                                </div>
                            </div>
                            <div class="card relative flex-center" style="background: url('/public/images/DonationManagement.jpg');background-size: cover;height: 500px;width:500px;background-clip: content-box">
                                <div class="absolute font-extraBold text-xl w-95 h-95 d-flex align-items-center justify-content-end text-white flex-column border-radius-10" style="background: rgba(0,0,0,0.3)">
                                    <div class="text-4xl ">Blood Donation</div>
                                    <div class="text-3xl mb-2">Management</div>
                                </div>
                            </div>
                            <div class="card relative flex-center" style="background: url('/public/images/DonationCampaign.jpg') no-repeat;background-size: cover;height: 500px;width:500px;background-clip: content-box;background-position-x: 50%;">
                            <div class="absolute font-extraBold text-xl w-95 h-95 d-flex align-items-center justify-content-end text-white flex-column border-radius-10" style="background: rgba(0,0,0,0.3)">
                                <div class="text-4xl ">Blood Campaign</div>
                                <div class="text-3xl mb-2">Management</div>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
        </div>
    </section>
    <section id="sponsor-panel" class="panel">
        <div class="sub-panel d-flex-row" style="flex-direction: column !important;justify-content: flex-start">
            <div class="d-flex  relative flex-column align-items-center w-100 justify-content-start gap-1">
                <div class="font-bold text-xl bg-white px-2 py-0-5 border-radius-10 ">
                    Help us to help others
                </div>
                <div class="d-flex">
                    <div class="absolute left-0 cursor bg-dark border-radius-50" id="prev-nav" style="top: 40%;z-index: 9;" onclick="PreviousCampaign()">
                        <i class="fa-solid text-white fa-circle-left" style="font-size: 5rem;z-index: 9;left: -100px;"></i>
                    </div>
                    <div class="d-flex gap-0-5 justify-content-center" id="campaigns-container">

                    </div>

                    <div class="absolute right-0 cursor bg-dark border-radius-50" id="next-nav" style="top: 40%;z-index: 9;" onclick="NextCampaign()">
                        <i class="fa-solid text-white fa-circle-right" style="font-size: 5rem;z-index: 9;right: -100px;"></i>
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

<script>
    const Campaigns = <?=json_encode($campaigns)?>;
    let index = 0;
    let count = 4;
    const Card = (Campaign,i)=>{
        console.log(Campaign);
        const {name, location, amount,id} = Campaign;
        return `
            <div class="card d-flex gap-0-5" style="height: 65vh;justify-content: normal">
                <div class="" style="height: 40vh;">
                    <div id="map-${i}" class="border-radius-10" style="height: 100%; width: 100%;"></div>
                </div>
                        <div class="card-header">
                            <div class="text-xl font-bold">
                                ${name}
                            </div>
                        </div>
                        <div class="card-body d-flex flex-column gap-1">
                            <div class="d-flex text-xl text-center">
                                    Sri Piyarathana Maha Vidyalaya, Padukka
                            </div>
                            <div class="text-center font-bold text-2xl">
                                    LKR 100,000
                            </div>
                            <div class="d-flex justify-content-center">
                                <button class="btn btn-primary" onclick="Donate('${id}')">Donate</button>
                            </div>
                   </div>
            </div>
        `
    }

    const Donate = (campaignID)=>{
        const FullAmount = 100000;
        OpenDialogBox({
            id: "donate-dialog",
            title: "Donate",
            titleClass:"bg-dark text-white text-center py-1 px-2",
            content:`
                <div class="d-flex w-100 flex-column gap-1 flex-center text-center">
                    <div class="text-xl font-bold">
                        Do you want to donate full amount?
                    </div>
                    <div class="d-flex flex-center gap-1">
                        <input type="radio" onclick="Visible(${FullAmount})" id="full-amount" checked name="Amount" class="form-control p-1" value="1" placeholder="Yes">
                        <label for="full-amount">
                            Yes
                        </label>
                        <input type="radio" id="custom-amount" onclick="Visible(${FullAmount})" class="form-control" name="Amount" value="2" placeholder="No">
                        <label for="custom-amount">
                            No
                        </label>
                    </div>
                    <div class="d-flex flex-center gap-1">
                        <label for="full-amount">
                            Email
                        </label>
                        <input type="email" class="form-control" id="Email" placeholder="Enter your Email">
                    </div>
                    <div class="d-flex flex-center gap-1 mt-1">
                        <label for="full-amount">
                            Amount
                        </label>
                        <input type="number" disabled class="form-control" id="CustomAmount" placeholder="${FullAmount}">
                    </div>
                </div>
            `,
            successBtnText: "Sponsor",
            successBtnAction: ()=>{
                const Amount = document.getElementsByName("Amount");
                const Email = document.getElementById("Email");
                const CustomAmount = document.getElementById("CustomAmount");
                let amount = 0;
                if(Amount[0].checked){
                    amount = parseInt(FullAmount);
                }else{
                    amount = parseInt(CustomAmount.value);
                }
                if(amount > 0) {
                    const id = campaignID;
                    const url = "/donate"
                    const formData = new FormData();
                    formData.append("CampaignID", id);
                    formData.append("amount", amount.toString());
                    formData.append("email", Email.value);


                    fetch(url,{
                        method: "POST",
                        body: formData
                    }).then(res=>res.json())
                        .then(data=>{
                            if (data.status){
                                ShowToast({
                                    title: "Success",
                                    message: "Donation Successful",
                                    type: "success"
                                });
                                setTimeout(()=>{
                                    window.location.href = data.redirect;
                                },1000);
                            }else{
                                ShowToast({
                                    title: "Error",
                                    message: data.message,
                                    type: "error"
                                });
                            }
                        })
                }

            }
        })
    }

    const Visible = (fullAmount) =>{
        const Amount = document.getElementsByName("Amount");
        const CustomAmount = document.getElementById("CustomAmount");
        if(Amount[0].checked){
            CustomAmount.placeholder = `${fullAmount}`;
            CustomAmount.disabled = true;
        }else{
            CustomAmount.placeholder = "Enter Amount";
            CustomAmount.disabled = false;
        }
    }
    const RenderMap = (Campaign,i)=>{
        const {latitude, longitude} = Campaign;
        let map = new google.maps.Map(document.getElementById(`map-${i}`), {
            center: { lat: parseFloat(latitude
                ), lng: parseFloat(longitude) },
            zoom: 8,
        });
        console.log(map)
        let marker = new google.maps.Marker({
            position: { lat: parseFloat(latitude
                ), lng: parseFloat(longitude) },
            map: map,
        });
    }

    const NextCampaign = ()=> {
        if (Object.keys(Campaigns).length <= count) return;
        const CampaignsContainer = document.getElementById("campaigns-container");
        index += count;
        if (index > Object.keys(Campaigns).length - count) index = Object.keys(Campaigns).length - count;
        CampaignsContainer.innerHTML = "";
        for (let i = index; i < index + count; i++) {
            CampaignsContainer.innerHTML += Card(Campaigns[i],i);
        }
        for (let i = index; i < index + count; i++) {
            RenderMap(Campaigns[i],i);
        }
    }
    const PreviousCampaign = ()=>
    {
        if (Object.keys(Campaigns).length <= count) return;
        const CampaignsContainer = document.getElementById("campaigns-container");
        index -= count;
        if (index < 0) index = 0;
        CampaignsContainer.innerHTML = "";
        for (let i = index; i < index + count; i++) {
            CampaignsContainer.innerHTML += Card(Campaigns[i],i);
        }
        for (let i = index; i < index + count; i++) {
            RenderMap(Campaigns[i],i);
        }
    }
    const LoadCampaigns = ()=>{
        const CampaignsContainer = document.getElementById("campaigns-container");
        const NoOfCampaigns = Object.keys(Campaigns).length;
        if (NoOfCampaigns === 0){
            CampaignsContainer.innerHTML = `
                <div class="card d-flex gap-0-5" style="height: 50vh;justify-content: normal">
                <div class="border-radius-10" style="height: 40vh; background: url('/public/images/Blood-Donation-Campaign.jpg');background-size: cover;background-position-x: 90%">
                </div>
                        <div class="card-header">
                            <div class="text-xl font-bold">
                                No Campaigns Available
                            </div>
                        </div>

                   </div>
            </div>
            `
            const NextBtn = document.getElementById("next-nav");
            const PreviousBtn = document.getElementById("prev-nav");
            NextBtn.disabled = true;
            PreviousBtn.disabled = true;
            NextBtn.addEventListener("click",()=>{});
            PreviousBtn.addEventListener("click",()=>{});
            NextBtn.classList.add("none");
            PreviousBtn.classList.add("none");
        }else {
            for (let i = index; i < index + count; i++) {
                CampaignsContainer.innerHTML += Card(Campaigns[i], i);
            }
            for (let i = index; i < index + count; i++) {
                RenderMap(Campaigns[i], i);
            }
        }
    }
    window.addEventListener("load", ()=>{
        LoadCampaigns();
    })




</script>


