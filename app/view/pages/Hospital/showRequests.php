<link rel="stylesheet"  href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<?php
/* @var string $data */

use App\model\Requests\BloodRequest;
use App\model\users\Hospital;
use App\view\components\ResponsiveComponent\Alert\FlashMessage;
use App\view\components\ResponsiveComponent\CardGroup\CardGroup;
use App\view\components\ResponsiveComponent\ImageComponent\BackGroundImage;
use App\view\components\ResponsiveComponent\NavbarComponent\AuthNavbar;


$navbar = new AuthNavbar('Take Donation', '/hospital', '/public/images/icons/user.png', true,false );
echo $navbar;
use App\view\components\WebComponent\Card\Card;

echo card::ImportJS();


FlashMessage::RenderFlashMessages();
$navbar = new AuthNavbar('Hospital Board', '/hospital', '/public/images/icons/user.png', true,false );
echo $navbar;

echo card::ImportJS();

/* @var Hospital $user */

use App\view\components\WebComponent\Card\NavigationCard;

$background = new BackGroundImage();

echo $background;

$table = new \App\view\components\Table\DetailTable(['Request ID','Blood Group', 'Requested At', 'Type', 'Status','Quantity (In Pints)','Remarks','Added By','Action'], $data );
echo $table->render("table");

/** @var int $total_pages */
/** @var int $current_page */
if ($data != null){

    echo BloodRequest::NavigationFooter($total_pages,$current_page);

}

?>

<script>
    function deleteRequest(id) {
        OpenDialogBox({
            id: 'deleteRequest',
            title: 'Delete Request',
            content: `
                <form action="/hospital/deleteRequest" method="post" id="form">
                    <input type="text" class="form-control" id="RequestId" placeholder="Request ID" name="RequestId" value="${id}" readonly required>
                </form>
                `,
            successBtnText: 'Delete',
            successBtnAction:()=>{
                document.getElementById('form').submit();
            }
        }
        );
    }
    function editRequest(id) {
        // window.location.href = "/hospital/editRequest/" + id;
        OpenDialogBox({
                id: 'editRequest',
                title: 'Edit Request',
                content: `
                <form action="/hospital/editRequest" method="post" id="form">
<!--                    <label for= "requestId">Request ID</label>-->
                    <input type="text" class="form-control" id="RequestId" placeholder="Request ID" name="RequestId" value="${id}" readonly required>
                    <div class="form-group">
                        <label for="quantity">Quantity (In Pintes)</label>
                        <input type="number" min="1" class="form-control" id="quantity" placeholder="Quantity (In Pints)" name="Volume" value="0" required>
                    </div>
                    <div class="form-group">
                        <label for="remarks">Remarks</label>
                        <textarea class="form-control" id="remarks" rows="3" name="Remarks" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="Name">Added By</label>
                        <textarea class="form-control" id="name" rows="3" name="Name" required></textarea>
                    </div>
                </form>
                `,
                successBtnText: 'Update',
                successBtnAction:()=>{
                    document.getElementById('form').submit();
                }
        }
        );
        // console.log(id);
    }
    var table = document.getElementById("table");
    var tbody=table.querySelector("tbody").children;
    // for (var i = 0; i < tbody.length; i++) {
    for (let i=0;i<tbody.length;i++){
        const td = document.createElement("td");
        td.classList.add("text-center","d-flex","justify-content-around","gap-0-5");
        const editButton = document.createElement("button");
        const deleteButton = document.createElement("button");
        editButton.innerHTML = '<i class="fas fa-edit"></i>';
        deleteButton.innerHTML = '<i class="fas fa-trash"></i>';
        editButton.classList.add("btn", "btn-primary", "btn-sm");
        deleteButton.classList.add("btn", "btn-danger", "btn-sm");
        editButton.addEventListener("click", function () {
            editRequest(tbody[i].children[0].innerHTML);
        });
        deleteButton.addEventListener("click", function () {
            deleteRequest(tbody[i].children[0].innerHTML);
        });
        td.appendChild(editButton);
        td.appendChild(deleteButton);
        tbody[i].appendChild(td);
    }
    console.log(tbody);

</script>

