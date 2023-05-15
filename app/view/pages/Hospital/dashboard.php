<link rel="stylesheet"  href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<?php
/* @var string $data */

use App\model\BloodBankBranch\BloodBank;
use App\model\Requests\BloodRequest;
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

$showRequests = new NavigationCard('/hospital/requests', '/public/images/icons/dashboard.png', 'Show Blood Requests', 'ViewBloodRequests', 'bg-primary');
$addNewRequest = new NavigationCard('#', '/public/images/icons/bloodDrop.png', 'Add Blood Requests', 'AddBloodRequests', 'bg-success');
$history = new NavigationCard('/hospital/history', '/public/images/icons/calender.png', 'View History', 'ViewHistory', 'bg-warning');
$donateBlood = new NavigationCard('#' , '/public/images/donation.png', 'Donate Blood', 'DonateBlood', 'bg-danger');

echo cardgroup::CardPanel();
echo $showRequests;
echo $addNewRequest;
echo $history;
echo $donateBlood;
echo cardgroup::CloseCardPanel();


?>

<script>
    const AddBloodRequest= document.getElementById('AddBloodRequests');
    AddBloodRequest.addEventListener("click", function (e){
        e.preventDefault()
        AddRequest();
    });
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
                    <label for="requestFrom">Request From</label>
                    <select class="form-control" id='requestFrom' name="RequestFrom">
                        <?php
            /** @var $BloodBanks BloodBank[] */
            foreach($BloodBanks as $bloodBank){
                                echo "<option value='".$bloodBank->getBloodBankID()." '>".$bloodBank->getBankName()."</option>";
                            }
            ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="quantity">Quantity (In Pintes)</label>
                    <input type="number" min="1" class="form-control" id="quantity" placeholder="Quantity (In Pints)" name="Volume" value="0" required>
                </div>
                <div class="form-group">
                    <label for="remarks">Remarks</label>
                    <textarea class="form-control" id="remarks" rows="3" name="Remarks" required></textarea>
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

<script>
    const DonateBlood= document.getElementById('DonateBlood');
    DonateBlood.addEventListener("click", function (e){
        e.preventDefault()
        Donate();
    });



    const Donate = () =>{
        OpenDialogBox ({
            id: 'DonateBlood',
            title: 'Search Donor',
            content: `
<!--                <form class="form" action="/hospital/searchDonor" method="post" id="form">-->
                <div class = "form-group">
                    <label for="search">Search</label>
                    <input type="text" class="form-control" id="search" placeholder="Search" name="Search" onkeyup="SearchDonor()" required>
                </div>
                <div class="results" id="SearchResult">
                </div>
            `,
        })
    }

    function SearchDonor(){
        const Search = document.getElementsByName('Search')[0].value.trim();
        const formData = new FormData();
        if (Search.length === 0){
            document.getElementById('SearchResult').innerHTML = "";
            return;
        }
        formData.append('keyword', Search);
        fetch('/hospital/searchDonor', {
            method: 'POST',
            body: formData
        })
            .then(res => res.json())
            .then(data => {
                // console.log(data)
                // document.getElementById('userTable').innerHTML = data;
                document.getElementById('SearchResult').innerHTML = "";
                Object.values(data).forEach(value=>{
                    // console.log(value);
                    let newRow= document.createElement('input');
                    newRow.setAttribute('type', 'text');
                    newRow.classList.add('cursor');
                    newRow.onclick = function (){
                        SelectDonor(value['Donor_ID']);
                    }
                    newRow.readOnly = true;
                    newRow.value = value['First_Name']+" " + value['Last_Name'] + " " + value['Blood_Group'] + " " + value['Email'] + " " + value['Contact_No'] + " "+ value['NIC'];
                    document.getElementById('SearchResult').appendChild(newRow);
                    if (document.getElementById('SearchResult').childNodes.length > 10){
                        document.getElementById('SearchResult').removeChild(document.getElementById('SearchResult').childNodes[0]);
                    }
                    // console.log(newRow);
                })
                // console.log(data);
                // for (let i = 0; i < 10; i++) {
                //
                // }

            })
    }

    function SelectDonor(Donor_ID){
        // console.log(Donor_ID);
        window.location.href = "/hospital/takeBlood?Donor_ID="+Donor_ID;
    }
</script>
<!---->
<!--<a href="/hospital/takeBlood" id="button" class="d-flex align-items-center gap-1 btn btn-outline-success"  style="-->
<!--        background-color: white;-->
<!--        color: black;-->
<!--        border: 1px solid black;-->
<!--        padding: 1vw 2vw;-->
<!--        border-radius: 20px;-->
<!--        font-size: large;-->
<!--        position: absolute;-->
<!--        top: 15vh;-->
<!--        right: 2vh;-->
<!--        z-index: 100;">-->
<!--    <img src="/public/icons/blood-bag-svgrepo-com.svg" width="24" alt=""/>-->
<!--    <span class=" font-bold">Take New Donation</span>-->
<!--</a>-->
<!--<style>-->
<!--    #button:hover{-->
<!--        background-color: var(--primary)!important;-->
<!--        color: white;-->
<!--    }-->
<!--</style>-->