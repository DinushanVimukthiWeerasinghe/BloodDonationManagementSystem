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
use App\model\inform\informDonors;
use App\view\components\WebComponent\Card\NavigationCard;
/* @var informDonors $inform */
$background = new BackGroundImage();
echo $background;
FlashMessage::RenderFlashMessages();
?>
<style>
    .container{
        flex-wrap: wrap;
    }
    .buttons{
        display: flex;
        flex-direction: row;
        text-align: center;
        margin-top: -150px;
        padding: 10px;

    }
    form{
        height: 80vh;
        width: 100vw;
        padding: 1000px;
    }
    textarea{
        /*max-width: 700px;*/
        /*min-width: 600px;*/
        min-height: 200px;
        max-width: 100%;
        background-color: #9089cc;
        border-radius: 10px;
    }
    textarea::placeholder{
        color: whitesmoke;
    }
    /*@media only screen and (max-width: 1690px)  {*/
    /*    form{*/
    /*        height: 50vh;*/
    /*    }*/
    /*    */
    /*}*/
    @media only screen and (max-width: 376px) {
        h1{
            color: red;
        }
        form{
            background-color: black;
        }
    }
    @media only screen and (max-width: 700px){
        .buttons{
            display: flex;
            flex-direction: column;
        }
    }
    @media only screen and (max-width: 294px){
        textarea::placeholder{
            font-size: 8pt;
            line-height: 30px;
        }
        /*.form-title{*/
        /*    width: 100%;*/
        /*}*/
    }
</style>
<link rel="stylesheet" href="/public/css/components/form/index2.css">
<link rel="stylesheet" href="/public/css/framework/util/border/border-radius.css">
<link rel="stylesheet" href="/public/css/fontawesome/fa.css">
<div class="container w-60" style="margin-top: 80px;">
    <form action="inform?id=<?php echo $_GET['id'] ?>" method="post" class="form-column max-h-15" enctype="multipart/form-data">
        <h1 class="form-title">Inform Donors</h1>
        <div class="form-entity mt-1">
            <label class="form-label">Your Message</label><br>
<!--            <input type="text" class="form-input" name="Message" style="padding: 50px;" required>-->
            <textarea name="Message"  class="fa fa-1 text-center" id="Message" placeholder="Your Message must contains at least 20 Characters."></textarea>
        </div>
    </form>
    <div class="gap-1 buttons" style=" justify-content: center;position: center">
        <button class="btn btn-success" onclick="inform()" id="sub">Inform</button>
        <button value="cancel" class="btn btn-dark" onclick="back()">Cancel</button>
    </div>
</div>

<script>
    const back = (event) => {

        OpenDialogBox({
            title: 'Cancel',
            content: 'Are You Sure You want to cancel the informing Donors?',
            cancelBtnText: 'No',
            successBtnText : 'Yes',

            successBtnAction : () => {
                window.location.href = "/organization/campDetails?id=<?php echo $_GET['id'] ?>"
            },
        });
    }
    const inform = (e)=>{

        messages = document.getElementById('Message').value.trim();

        if(messages.length === 0 ){
            ShowToast({
                message : 'Message Cannot be Empty',
                type : 'danger',
            });

        }
        else if(messages.length < 20){
            ShowToast({
                message: 'You Must include at least 20 Characters in the Message',
                type: 'danger',
            });
        }
        else {

            OpenDialogBox({
                title: 'Inform Confirmation',
                content: 'Are You Sure You want to Inform Donors?',
                successBtnText: 'Yes',
                cancelBtnText: 'NO',

                successBtnAction: () => {

                     document.querySelector('form').submit();
                     ShowToast({
                         message : 'Message Sent Successfully',
                         type : 'success',

                     });
                },

            });

        }
        e.preventDefault();
    };
</script>
