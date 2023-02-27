<link rel="stylesheet"  href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<?php
/* @var string $data */

use App\model\users\Hospital;
use App\view\components\ResponsiveComponent\Alert\FlashMessage;
use App\view\components\ResponsiveComponent\CardGroup\CardGroup;
use App\view\components\ResponsiveComponent\ImageComponent\BackGroundImage;
use App\view\components\ResponsiveComponent\NavbarComponent\AuthNavbar;

$navbar = new AuthNavbar('Hospital Board', '/hospital', '/public/images/icons/user.png', true,false );
echo $navbar;

use App\view\components\WebComponent\Card\Card;

echo card::ImportJS();

/* @var Hospital $user */

use App\view\components\WebComponent\Card\NavigationCard;

$background = new BackGroundImage();

echo $background;

$table = new \App\view\components\Table\DetailTable(['Request ID', 'Blood Group', 'Requested At', 'Type', 'Status','Quantity (In Pints)','Remarks'], $data);
echo $table->render();
//print_r($data);
//exit();

?>

<div class="d-flex align-items-center gap-1 btn btn-outline-success" onclick="AddRequest()">
    <img src="/public/icons/person-add.svg" width="24" alt=""/>
    <span class=" font-bold">Add New Request</span>
</div>

<script>
    const AddRequest = () =>{
        OpenDialogBox({
            id:'AddNewRequest',
            title: 'Add New Request',
            content: `
            <form class="form" action="/hospital/request" method="post" id="form">
                <div class="form-group">
                    <label for="bloodGroup">Blood Group</label>
                    <select class="form-control" id="bloodGroup" name="bloodGroup">
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
                    <select class="form-control" id="type" name="type">
                        <option value="2">Emergency</option>
                        <option value="1">Normal</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="quantity">Quantity</label>
                    <input type="number" class="form-control" id="quantity" placeholder="Quantity (In Pints)" name="quantity">
                </div>
                <div class="form-group">
                    <label for="remarks">Remarks</label>
                    <textarea class="form-control" id="remarks" rows="3" name="remarks"></textarea>
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
