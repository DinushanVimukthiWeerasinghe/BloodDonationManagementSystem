<!--<link rel="stylesheet" href="/public/css/framework/utils.css">-->
<!--<link rel="stylesheet" href="/public/css/components/cardPane/index.css">-->
<!--<script src="/public/scripts/index.js"></script>-->
<?php
/* @var string $firstName */
/* @var array $SponsorshipRequests */
/* @var SponsorshipRequest $SponsorshipRequest */

/* @var string $lastName */
/* @var string $campaigns */

use App\model\Requests\SponsorshipRequest;
use App\model\users\Organization;
use App\model\Utils\Date;
use App\view\components\ResponsiveComponent\Alert\FlashMessage;
use App\view\components\ResponsiveComponent\CardPane\CardPane;
use App\view\components\ResponsiveComponent\ImageComponent\BackGroundImage;
use App\view\components\ResponsiveComponent\NavbarComponent\AuthNavbar;

//echo Loader::GetLoader();
$background = new BackGroundImage();
$navbar = new AuthNavbar('Donation Campaigns', '/organization/near', '/public/images/icons/user.png', false);

echo $navbar;
echo $background;


function GetImage($imageURL)
{
    if ($imageURL == null) {
        return '/public/images/icons/user1.png';
    } else {
        return $imageURL;
    }
}

FlashMessage::RenderFlashMessages();
?>

<div id="detail-pane" class="detail-pane">
        <div id="card-pane" class="card-pane">
            <?php
            if (empty($SponsorshipRequests)){
                ?>
                <div class="card detail-card">
                    <div class="card-image">
                        <img src="/public/images/icons/organization/dashboard/campaign.png" alt="">
                    </div>
                    <div class="card-body">
                        <div class="card-title">
                            No Campaigns Found
                        </div>
                    </div>
                </div>
            <?php } ?>
            <?php foreach ($SponsorshipRequests as $SponsorshipRequest){
                $Needed_Amount = $SponsorshipRequest->getNeededAmount();
                ?>
            <div class="card ">
                <div class="card-body d-flex flex-column gap-0-5 flex-center">
<!--                    <div class="card-image" style="text-align: center;margin-left: 100px;width: 100px;height: 100px;margin-top: -50px;"><img src="/public/images/donation.png" alt="hello"></div>-->
                    <div class="font-bold text-xl"> <?php  echo $SponsorshipRequest->getCampaignName(); ?></div>
                    <div class="card-description"><?= Date::GetProperDate($SponsorshipRequest->getCampaignDate()); ?></div>
                    <div class="card-description bg-yellow-7 border-radius-10 p-1" style="font-size: 1.2em;font-weight: bolder;">LKR. <?= $SponsorshipRequest->getToBeSponsoredAmount() ?></div>
                    <div class="d-flex gap-0-5">
                            <button class="btn btn-success w-100 mt-1" onclick="SponsorForCampaign('<?=$SponsorshipRequest->getSponsorshipID()?>','<?= $SponsorshipRequest->getToBeSponsoredAmount() ?>')">Sponsor</button>
                        <button class="btn btn-outline-info w-100 mt-1" onclick="ViewCampaignRequest('<?=$SponsorshipRequest->getCampaignID()?>')">View Campaign</button>
                    </div>
                </div>
            </div>
            <?php
            }
            ?>
        </div>
    </div>
    <?php
    echo CardPane::GetJS('/organization/received/search');
    ?>
<script>
    const Months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
    const ViewCampaignRequest = (id) =>{
        const url = '/sponsor/campaign/view?id='+id;
        const form = new FormData();
        form.append('id',id);
        fetch(url,{
            method : 'POST',
            body : form
        })
            .then((res)=>res.json())
            .then((data)=>{
                if (data.status) {
                    let SponsoringDetails = 'Not Verified';
                    if (data.approved && data.sponsorship) {
                        let sponsorshipAmount =data.sponsorship.remaining;
                        // Separate the amount into two parts and add commas
                        // 1000000 -> 1,000,000
                        // Convert the string to an array
                        sponsorshipAmount = sponsorshipAmount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");

                        SponsoringDetails = `
                        <div class="d-flex flex-column justify-content-center align-items-center">
                            <div class="d-flex flex-center flex-column gap-0-5">
                                <div class="d-flex">Requested Amount : ${data.sponsorship.Sponsorship_Amount}</div>
                                <div class="d-flex bg-success gap-1 px-1 py-0-5 text-white flex-center border-radius-10">More Needed : <span class="text-2xl"> LKR. ${sponsorshipAmount}.00</span></div>

                            </div>

                        </div>
                    `
                        const requestID = data.sponsorship.Sponsorship_ID;
                        OpenDialogBox({
                            id: 'viewCampaignRequest',
                            title: 'Campaign Request',
                            titleClass: 'bg-dark text-white py-0-5 px-2 text-center',
                            content: `
                    <div class="d-flex flex-column">
                        <div class="d-flex flex-column w-100 justify-content-center align-items-center">
                            <div class="d-flex font-bold mb-1 w-100 text-center justify-content-center align-items-center bg-dark py-1 px-2 text-center text-white">Campaign Details</div>
                            <div class="d-flex justify-content-center w-100 gap-1">
                                <div class="d-flex flex-column w-50 flex-center gap-0-5 bg-dark text-white border-radius-10">
                                    <div class="d-flex gap-0-5"><span class="font-bold">Campaign Name </span>: <span>${data.data.Campaign_Name}</span></div>
                                    <div class="d-flex gap-0-5"><span class="font-bold"> </span> Campaign Date: <span>${data.data.Campaign_Date}</div>
                                    <div class="d-flex gap-0-5"><span class="font-bold"> </span>Venue : <span>${data.data.Venue}</div>
                                    <div class="d-flex flex-column gap-0-5">
                                        <div class="font-bold">Description  </div> <div class="px-1" style="max-width: 400px">${data.data.Campaign_Description} Lorem ipsum dolor sit amet, consectetur adipisicing elit. Labore, non.</div>
                                    </div>
                                </div>
                                <div class="d-flex w-50 flex-center">
                                    <div id="map" style="height: 300px;width: 300px"></div>
                                    <div id="infowindow-content">

                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="d-flex flex-column w-100">
                            <div class="d-flex w-100 font-bold my-1 text-center justify-content-center align-items-center bg-dark py-1 px-2 text-center text-white">Sponsorship Details</div>
                            `+SponsoringDetails+`
                        </div>
                `,
                            successBtnText: 'Sponsor',
                            cancelBtnText: 'Close',
                            successBtnAction: () => {
                                SponsorForCampaign(requestID,data.sponsorship.remaining);
                            },
                        })
                        initMap(parseFloat(data.data.Latitude),parseFloat(data.data.Longitude));
                    }else if (data.rejected){
                        ShowToast({
                            title : 'Rejected',
                            message : 'Your request has been rejected',
                            type : 'danger'
                        })

                    }

                }
            })
    }

    const SponsorForCampaign = (SR_ID,Amount)=>{
        if (SR_ID.trim() === ''){
            ShowToast({
                title : 'Error',
                message : 'Invalid Request',
                type : 'danger'
            })
            return;
        }
        // Check if the amount is a number
        if (isNaN(Amount)) {
            if (Amount.trim() === '') {
                Amount = 0;
            } else {
                Amount = parseInt(Amount);
            }
        }
        if (Amount<1000){
            ShowToast({
                title : 'Error',
                message : 'You Only Can Sponsor More Than LKR 1,000.00',
                type : 'danger'
            })
            return;
        }
        OpenDialogBox({
            title : 'Sponsor',
            titleClass : 'bg-dark text-white py-0-5 px-2 text-center',
            popupOrder : 2,
            content : `
                <div class="d-flex flex-column gap-1">
                    <div class="d-flex flex-column gap-0-5">
                        <div class="d-flex font-bold">Sponsorship Type</div>
                        <div class="d-flex">
                            <select class="form-control" id="sponsorshipType" onclick="NotAvailable()" disabled>
                                <option value="1" selected>Cash</option>
                                <option value="2">Goods</option>
                            </select>
                        </div>
                    </div>
                    <div class="d-flex flex-column gap-0-5">
                        <div class="d-flex font-bold">Sponsorship Amount</div>
                        <div class="d-flex"><input type="number" class="form-control" id="sponsorshipAmount" value="${Amount}" placeholder="Enter Amount"></div>
                    </div>
                    <div class="d-flex flex-column gap-0-5">
                        <div class="d-flex font-bold">Sponsorship Description</div>
                        <div class="d-flex"><textarea class="form-control" id="sponsorshipDescription" style="height: 100px" maxlength="100" placeholder="Enter Description"></textarea></div>
                    </div>
                </div>
            `,
            successBtnText: 'Sponsor',
            successBtnAction : ()=>{
                const Amount = document.getElementById('sponsorshipAmount').value;
                const Description = document.getElementById('sponsorshipDescription').value;
                const Type = document.getElementById('sponsorshipType').value;
                if (Amount.trim() === '' || Description.trim() === ''){
                    ShowToast({
                        title : 'Error',
                        message : 'Please fill all the fields',
                        type : 'danger'
                    })
                    return;
                }

                const formData = new FormData();
                formData.append('Request',SR_ID);
                formData.append('Amount',Amount);
                formData.append('Description',Description);
                const url ='/sponsor/makePayment';
                fetch(url,{
                    method : 'POST',
                    body : formData
                }).then(response => response.json())
                    .then(data => {
                        if (data.status){
                            CloseDialogBox();
                            window.location.href = data.redirect;
                        }else{
                            ShowToast({
                                title : 'Error',
                                message : 'Something went wrong',
                                type : 'danger'
                            })
                        }
                    })
            }
        })
    }
    const NotAvailable = ()=>{
        ShowToast({
            title : 'Not Available',
            message : 'This feature is not available at the moment',
            type : 'danger'
        })
    }

    const initMap=(latitude,longitude)=> {
        const place = { lat: 6.8781340776734385, lng: 79.8833214428759 };
        if (latitude && longitude){
            place.lat = latitude;
            place.lng = longitude;
        }
        console.log(place)
        const mylating = { lat: 6.8781340776734385, lng: 79.8833214428759 };

        const map = new google.maps.Map(document.getElementById("map"), {
            zoom: 13,
            minZoom: 8,
            maxZoom: 16,
            center: place,
            restriction: {
                latLngBounds: {
                    north: 9.9,
                    south: 5.8,
                    west: 79.8,
                    east: 81.9,
                }
            },
        });
        const infowindow = new google.maps.InfoWindow();

        new google.maps.Marker({
            position: place,
            map,
            title: "Campaign Location",

        })
        // Create the initial InfoWindow.
        let infoWindow = new google.maps.InfoWindow({
            position: place,
            content: "Campaign Location",
        });
        const infowindowContent = document.getElementById("infowindow-content");
        let marker = new google.maps.Marker({
            map,
            anchorPoint: new google.maps.Point(0, -29),

        });
        infoWindow.open({
            anchor:marker,
            map
        });
    }
</script>









