<link rel="stylesheet"  href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<?php
/* @var string $data */

use App\model\users\Hospital;
use App\view\components\ResponsiveComponent\Alert\FlashMessage;
use App\view\components\ResponsiveComponent\CardGroup\CardGroup;
use App\view\components\ResponsiveComponent\ImageComponent\BackGroundImage;
use App\view\components\ResponsiveComponent\NavbarComponent\AuthNavbar;

FlashMessage::RenderFlashMessages();
$navbar = new AuthNavbar('Hospital Board', '/hospital', '/public/images/icons/user.png', true,false );
echo $navbar;

use App\view\components\WebComponent\Card\Card;

echo card::ImportJS();

/* @var Hospital $user */

use App\view\components\WebComponent\Card\NavigationCard;

$background = new BackGroundImage();

echo $background;

$table = new \App\view\components\Table\DetailTable(['Request ID', 'Blood Group', 'Requested At', 'Type', 'Status','Quantity (In Pints)','Remarks'], $data);
echo $table->render("table");
//print_r($data);
//exit();

?>

<div id="button" class="d-flex align-items-center gap-1 btn btn-outline-success" onclick="AddRequest()" style="
        background-color: white;
        color: black;
        border: 1px solid black;
        padding: 1vw 2vw;
        border-radius: 20px;
        font-size: large;
        position: absolute;
        top: 15vh;
        left: 2vh;
        z-index: 100;">
    <img src="/public/icons/person-add.svg" width="24" alt=""/>
    <span class=" font-bold">Add New Request</span>
</div>
<style>
    #button:hover{
        background-color: var(--primary)!important;
        color: white;
    }
</style>

<script>
    const AddRequest = () =>{
        OpenDialogBox({
            id:'AddNewRequest',
            title: 'Add New Request',
            content: `
            <form class="form" action="/hospital/request" method="post" id="form">
                <div class="form-group">
                    <label for="bloodGroup">Blood Group</label>
                    <select class="form-control" id="bloodGroup" name="BloodGroup">
                        <option value="A+">A+</option>
                        <option value="A-">A-</option>
                        <option value="B+">B+</option>
                        <option value="B-">B-</option>
                        <option value="AB+">AB+</option>
                        <option value="AB-">AB-</option>
                        <option value="O+">O+</option>
                        <option value="O-">O-</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="type">Type</label>
                    <select class="form-control" id="type" name="Type">
                        <option value="2">Emergency</option>
                        <option value="1">Normal</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="quantity">Quantity (In Pintes)</label>
                    <input type="number" min="1" class="form-control" id="quantity" placeholder="Quantity (In Pints)" name="Quantity" value="0" required>
                </div>
                <div class="form-group">
                    <label for="remarks">Remarks</label>
                    <textarea class="form-control" id="remarks" rows="3" name="Remark" required></textarea>
                </div>
            </form>
            `,
            successBtnText: 'Add',
            successBtnAction:()=>{
                document.getElementById('form').submit();
            }
        })
    }
</script>

<div id="button" class="d-flex align-items-center gap-1 btn btn-outline-success" onclick="AddDonation()" style="
        background-color: white;
        color: black;
        border: 1px solid black;
        padding: 1vw 2vw;
        border-radius: 20px;
        font-size: large;
        position: absolute;
        top: 15vh;
        right: 2vh;
        z-index: 100;">
    <img src="/public/icons/blood-bag-svgrepo-com.svg" width="24" alt=""/>
    <span class=" font-bold">Take New Donation</span>
</div>
<style>
    #button:hover{
        background-color: var(--primary)!important;
        color: white;
    }
</style>

<script>
    const AddDonation = () =>{
        OpenDialogBox({
            id:'TakeNewDonation',
            title: 'Take New Donation',
            content: `
            
            `,
            successBtnText: 'Add',
            successBtnAction:()=>{
                document.getElementById('form').submit();
            }
        })
    }
</script>