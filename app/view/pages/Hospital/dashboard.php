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

$table = new \App\view\components\Table\DetailTable(['Request ID', 'Blood Group', 'Requested At', 'Type', 'Status','Quantity','Remarks'], $data);
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
            <div class="form">
                <div class="form-group">
                    <label for="bloodGroup">Blood Group</label>
                    <select class="form-control" id="bloodGroup">
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
                    <select class="form-control" id="type">
                        <option value="Emergency">Emergency</option>
                        <option value="Normal">Normal</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="quantity">Quantity</label>
                    <input type="number" class="form-control" id="quantity" placeholder="Quantity">
                </div>
                <div class="form-group">
                    <label for="remarks">Remarks</label>
                    <textarea class="form-control" id="remarks" rows="3"></textarea>
                </div>
            </div>
            `,
            footer: `<div id="error" class="text-danger">Hello</div>`,
            successBtnText: 'Add',
            successBtnAction : ()=>{
                const error=document.getElementById('error');
                const form = new FormData();
                    form.append('bloodGroup', document.getElementById('bloodGroup').value);
                    form.append('type', document.getElementById('type').value);
                    form.append('quantity', document.getElementById('quantity').value);
                    form.append('remarks', document.getElementById('remarks').value);

                    fetch('/hospital/addRequest',{
                        method: 'POST',
                        body: form
                    }).then(res=>res.json()).then(data=>{
                        if(data.status){
                            CloseDialogBox();
                            location.reload();
                        }else{
                            if (data.errors) {
                                console.log(data.errors)
                                for (const [key, value] of Object.entries(data.errors)) {
                                    console.log(key, value)
                                    const element = document.getElementsByName(key)[0];
                                    element.classList.add('border-danger');
                                    element.classList.add('text-danger');
                                }
                            }
                            ShowToast({
                                title: 'Error',
                                message: data.message,
                                type: 'danger'
                            })
                        }
                    })
            }
        })
    }
</script>
