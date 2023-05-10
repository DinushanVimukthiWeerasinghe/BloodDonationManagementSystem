<?php
/* @var string $Campaign_Name */
/* @var Campaign $campaign */
/* @var string $Venue */
use App\model\Campaigns\Campaign;
use App\model\Utils\Date;
use App\model\Utils\Security;
use App\view\components\ResponsiveComponent\Alert\FlashMessage;
use App\view\components\ResponsiveComponent\ImageComponent\BackGroundImage;
use App\view\components\ResponsiveComponent\NavbarComponent\AuthNavbar;

$navbar = new AuthNavbar('Campaign Details', '/organization', '/public/images/icons/user.png', true,false );
echo $navbar;

use App\view\components\WebComponent\Card\Card;

echo Card::ImportJS();
//echo Card::ImportCSS();

/* @var Organization $user */

use App\model\users\Organization;
use App\view\components\WebComponent\Card\NavigationCard;
$background = new BackGroundImage();
echo $background;
FlashMessage::RenderFlashMessages();
?>
<style>
    .links{
        text-align: center;
        display: flex;
        flex-direction: row;
        gap: 20px;
        margin-left: 30vh;
    }
    @media only screen and (max-width: 1526px) {
        .links{
            margin-left: 10vh;
        }
    }
    @media only screen and (max-width: 1114px) {
        .links{
            display: flex;
            flex-direction: column;
            margin-left: -5vh;
        }
    }
    @media only screen and (max-width: 304px) {
        .links{
            width: 40vw;
            height: auto;
        }
        .links button{
            font-size: 8pt;
        }

    }
    @media only screen and (max-width: 413px) {
        .intro{
           margin-left: 10px;
        }
    }
    @media only screen and (max-width: 394px) {
        .intro{
            font-size: 12pt;
        }
    }
    @media only screen and (max-width: 281px) {
        .intro{
            font-size: 8pt;
            margin-left: -10px;
            flex-direction: column;
            row-gap: 10px;
        }
    }
    /*@media only screen and (max-width: 394px) {*/
    /*    .intro{*/
    /*        display: flex;*/
    /*        flex-direction: column;*/
    /*        text-align: center;*/
    /*    }*/
    /*}*/
    @media only screen and (max-width: 830px) {
        #Campaign_Detail {
            min-width: 50vw;
        }
    }
    @media only screen and (max-width: 455px) and (min-width: 310px) {
        #Campaign_Detail {
            min-width: 70vw;
        }
        .reqcards{
            margin-left: 50px;
        }
    }
    @media only screen and (max-width: 1025px) and (min-width: 1023px) {
        /*#Campaign_Detail {*/
        /*    min-width: 70vw;*/
        /*}*/
        .reqcards{
            margin-left: 100px;
        }
    }
    @media only screen and (max-width: 1281px) and (min-width: 1279px) {
        /*#Campaign_Detail {*/
        /*    min-width: 70vw;*/
        /*}*/
        .reqcards{
            margin-left: 80px;
        }
    }
    @media only screen and (max-width: 857px) and (min-width: 845px){
        .reqcards{
            margin-left: 200px;
        }
    }
    @media only screen and (max-width: 770px) and (min-width: 768px){
        .reqcards{
            margin-left: 100px;
        }
    }
    .back:hover{
        background-color: red;
    }
</style>

<!--<button class="btn btn-info w-10 back" style="position: absolute;margin-top:-500px;margin-left: -1350px;" onclick="history.back()">Go Back</button>-->
<div class="d-flex flex-column w-90  p-1 mt-4" style="overflow-y: scroll;margin-left: 10vw">
        <div class="d-flex p-2 gap-2 details w-100 justify-content-center" style="flex-wrap: wrap;">
            <div class="text-xl d-flex flex-column justify-content-between align-items-center w-50 bg-white border-radius-10 gap-1 px-2 py-2 mt-3"  id="Campaign_Detail" style="flex-wrap: wrap;">
                <div class="bg-dark py-1 px-2 text-white text-center font-bold w-100 border-radius-10">Campaign Details</div>
                <div class="d-flex justify-content-between w-100 intro " id="Campaign_Name">
                    <div class="w-40">Campaign Name </div>
                    <div class="font-bold w-60 d-flex align-items-center justify-content-start text-right"><?=$campaign->getCampaignName(); ?></div>
                </div>
                <div class="d-flex w-100 justify-content-between intro" id="Campaign_Venue">
                    <div class="w-40">Venue </div>
                    <div class="font-bold w-60 d-flex align-items-center justify-content-start text-right"><?=$campaign->getVenue(); ?></div>
                </div>
                <div class="d-flex w-100 justify-content-between intro" id="Campaign_Date">
                    <div class="w-40">Date </div>
                    <div class="font-bold w-60 d-flex align-items-center justify-content-start text-right"><?= Date::GetProperDate($campaign->getCampaignDate()); ?></div>
                </div>
                <div class="d-flex w-100 justify-content-between intro" id="Campaign_Status">
                    <div class="w-40">Status </div>
                    <div class="font-bold w-60 d-flex align-items-center justify-content-start text-right">
                    <?php
                    $CampaignStatus =$campaign->getCampaignStatus();
                    ?>
                        <div class="font-bold bg-yellow-10 py-0-5 px-1 border-radius-10 text-white intro" ><?= $CampaignStatus ?></div>

                    </div>
                </div>
                <div class="d-flex flex-column w-100 justify-content-between gap-1 intro" id="Campaign_Description">
                    <div class="">Description </div>
                    <div class="font-bold px-1 text-center  border-1 border-primary p-0-5 border-radius-5">
                        <?=$campaign->getCampaignDescription(); ?>
                    </div>
                </div>
                <?php if($campaign->getVerified() === Campaign::NOT_VERIFIED) {?>
                    <div class="links">
                        <a class="btn btn-success d-flex flex-center gap-1" href="/organization/campaign/updateCampaign?id=<?php echo urlencode(Security::Encrypt($campaign->getCampaignID()))?>">
                            <i class="fa-regular fa-pen-to-square"></i>
                            Update Campaign
                        </a>
                        <button class="btn btn-danger d-flex flex-center gap-1" onclick="DeleteCampaign()">
                            <i class="fa-solid fa-trash"></i>
                            Delete Campaign
                        </button>
                    </div>
                <?php } ?>
            </div>
            <div id="Map" class="bg-white mt-5 border-radius-5" style="width: 500px;height: 500px;"></div>
        </div>

    <?php if($campaign->getVerified()===Campaign::VERIFIED && !$expired) { ?>
        <div class="d-flex cards flex-center text-center  reqcards" style="margin-top: -10px;flex-wrap: wrap">
            <?php if(!$bank || $campaign->IsRequestedSponsorship()) {?>
                <div class="card nav-card bg-white card-disabled text-dark">
                    <?php
                    if ($campaign->IsRequestedSponsorship()):
                    ?>
                    <div class="disable-text bg-white-0-7 py-2 px-1 font-bold absolute"  style="color: red">
                        Sponsorship Request is already sent
                    </div>
                    <?php else: ?>
                    <div class="disable-text bg-white-0-7 py-2 px-1 font-bold absolute"  style="color: red">
                        Sponsorship Request is not available until You Enter Your Bank details
                    </div>
                    <?php endif; ?>
                    <div class="card-header">
                        <div class="card-header-img">
                            <img src="/public/images/icons/organization/campaignDetails/request.png" alt="Request" width="100px">
                        </div>
                        <div class="card-title">
                            <h3>Request Sponsorship</h3>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <?php if($bank && !$campaign->IsRequestedSponsorship()) {?>
                <div class="card nav-card bg-white text-dark" onclick="RequestSponsorship('<?= $bank->getAccountNumber() ?>' , '<?= $bank->getAccountName() ?>' , '<?= $bank->getBankName() ?>' , '<?= $bank->getBranchName() ?>' )">
                    <div class="card-header">
                        <div class="card-header-img">
                            <img src="/public/images/icons/organization/campaignDetails/request.png" alt="Request" width="100px">
                        </div>
                        <div class="card-title">
                            <h3>Request Sponsorship</h3>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <div class="card nav-card bg-white text-dark">
                <div class="d-flex flex-center">
                    <div class="d-flex gap-1 flex-column">
                        <i class="fa-solid fa-hand-holding-dollar" style="font-size: 4rem"></i>
                        <div class="text-3xl">LKR.<?php echo $ReceivedAmount ?></div>
                        <div class="text-xl font-bold">Received Sponsors </div>
                    </div>
                </div>
            </div>
            <div class="card nav-card bg-white text-dark">
                <div class="card-header">
                    <div class="d-flex flex-column gap-1">
                        <i class="fa-solid fa-check-to-slot" style="font-size: 4rem"></i>
                        <div class="text-3xl"><?php echo $count ?></div>
                        <div class="text-xl"> Accepted Donors Count</div>
                    </div>
                </div>
            </div>
            <div class="card nav-card bg-white text-dark" onclick="informing('<?=Security::Encrypt($campaign->getCampaignID())?>')">
                <div class="d-flex flex-column gap-1">
                    <div class="card-header-img">
                        <i class="fa-solid fa-envelope" style="font-size: 4rem"></i>
                    </div>
                    <div class="card-title">
                        <h3>Inform Donors</h3>
                    </div>
                </div>
            </div>
        </div>
    <?php }
    else{?>
        <?php if($campaign->getVerified() === Campaign::NOT_VERIFIED) {?>
        <div class="d-flex justify-content-center cards mt-0 reqcards" style="flex-wrap: wrap">
            <div class="card nav-card bg-white card-disabled text-dark">
                <div class="disable-text bg-white-0-7 py-2 px-1 font-bold absolute"  style="color: red">
                    Sponsorship Request is not available until the campaign is approved
                </div>
                <div class="card-header">
                    <div class="card-header-img">
                        <img src="/public/images/icons/organization/campaignDetails/request.png" alt="Request" width="100px">
                    </div>
                    <div class="card-title">
                        <h3>Request Sponsorship</h3>
                    </div>
                </div>
            </div>
            <div class="card nav-card bg-white card-disabled text-dark">
            <div class="disable-text bg-white-0-7 py-2 px-1 font-bold absolute" style="color: red">
                Inform Donors is not available until the campaign is approved
            </div>
            <div class="card-header">
                <div class="card-header-img">
                    <img src="/public/images/icons/organization/campaignDetails/inform.png" alt="Inform" width="100px">
                </div>
                <div class="card-title">
                    <h3>Inform Donors</h3>
                </div>
            </div>
        </div>
        </div>
          <?php } ?>
    <?php } ?>
<script>

const ReceivedSponsorship = () =>{
    const url = '/organization/received';
    fetch(url,{
        method: 'POST',
    }).then(res=>res.json())
        .then((data)=> {
            let Sponsorship_Amount = "";
            if (data.status) {
                console.log(data);
            }
        })
}
const RequestSponsorship = (bankAccountNumber,bankAccountName,bankName,bankBranch)=>{

                    OpenDialogBox({
                        id:'RequestSponsorship',
                        title:'Request Sponsorship',
                        titleClass:'text-center bg-dark text-white px-2 py-1',
                        content :`<div class="d-flex flex-column gap-1">
                        <div class="d-flex flex-column gap-0-5">
                            <label for="SponsorshipAmount" class="form-label">Expected Amount</label>
                            <input type="number" class="form-control" name="SponsorshipAmount" id="SponsorshipAmount" placeholder="Sponsorship Amount">
                        </div>
                        <div class="d-flex flex-column gap-1">
                            <label for="SponsorshipDescription" class="form-label">Description</label>
                            <textarea class="form-control" id="SponsorshipDescription" name="Description" placeholder="Description" style="height: 150px"></textarea>
                        </div>
<!--                        Insert a Button to upload the Budget report-->
                        <div class="d-flex w-100% flex-center gap-1">
                            <label for="BudgetReport" class="form-label w-40">Budget Report</label>
                            <div class="d-flex flex-column ">
                                <input type="file" class="form-control" id="BudgetReport" placeholder="Budget Report" accept="application/pdf">
                                <span class="font-bold text-sm"> Only PDF files are allowed - Max Size 8MB</span>
                            </div>
                        </div>
                        <div class="d-flex px-1 py-0-5 flex-center text-white bg-dark w-100">
                            <span class="text-white">Bank Account Details</span>
                        </div>
                        <div class="d-flex gap-0-5 w-100">
                            <div class="d-flex align-items-center justify-content-center gap-0-5 w-50">
                                <label for="BankAccountNo" class="form-label w-50">Account No</label>
                                <input type="text" class="form-control" value="${bankAccountNumber}" id="BankAccountNo" disabled placeholder="Bank Account No">
                            </div>
                            <div class="d-flex align-items-center justify-content-center gap-0-5 w-50">
                                <label for="AccountName" class="form-label w-50">Account Name</label>
                                <input type="text" class="form-control" id="AccountName" value="${bankAccountName}" disabled placeholder="Account Name">
                            </div>
                        </div>
                        <div class="d-flex gap-0-5 w-100">
                            <div class="d-flex align-items-center justify-content-center gap-0-5 w-50">
                                <label for="BankName" class="form-label w-50">Bank Name</label>
                                <input type="text" class="form-control" value="${bankName}" disabled id="BankName" placeholder="Bank Name">
                            </div>
                            <div class="d-flex align-items-center justify-content-center gap-0-5 w-50">
                                <label for="BankBranch" class="form-label w-50">Bank Branch</label>
                                <input type="text" class="form-control" value="${bankBranch}" disabled id="BankBranch" placeholder="Bank Branch">
                            </div>
                        </div>
                    </div>
            `,
                        successBtnText:'Request',
                        successBtnAction:()=>{
                            const SponsorshipAmount = document.getElementById('SponsorshipAmount').value;
                            const SponsorshipDescription = document.getElementById('SponsorshipDescription').value;
                            const BudgetReport = document.getElementById('BudgetReport').files[0];

                            //     Validate
                            if (SponsorshipAmount === ""){
                                ShowToast({
                                    message:'Please Enter Sponsorship Amount',
                                    type:'danger'
                                })
                                return;
                            }
                            if (SponsorshipDescription === ""){
                                ShowToast({
                                    message:'Please Enter Sponsorship Description',
                                    type:'danger'
                                })
                                return;
                            }
                            if (BudgetReport === undefined){
                                ShowToast({
                                    message:'Please Upload Budget Report',
                                    type:'danger',
                                })
                                return;
                            }
                            // Check if the file is pdf and size is less than 8MB
                            if (BudgetReport.type !== 'application/pdf'){
                                ShowToast({
                                    message:'Only PDF files are allowed',
                                    type:'danger'
                                })
                                return;
                            }
                            if (SponsorshipAmount < 10000){
                                ShowToast({
                                    message:'Sponsorship Amount should be greater than 10,000',
                                    type:'danger'
                                })
                                return;
                            }
                            if (BudgetReport.size > 8000000){
                                ShowToast({
                                    message:'File size should be less than 8MB',
                                    type:'danger'
                                })
                                return;
                            }
                            const formData = new FormData();
                            formData.append('Sponsorship_Amount',SponsorshipAmount);
                            formData.append('Description',SponsorshipDescription);
                            formData.append('BudgetReport',BudgetReport);
                            console.log(BudgetReport)
                            const url = '/organization/requestSponsorship?id=<?php echo $campaign->getCampaignID() ?>';
                            fetch(url,{
                                method:'POST',
                                body:formData,
                                headers:{
                                    'enctype':'multipart/form-data'
                                }
                            }).then(res=>res.json())
                                .then((data)=>{
                                    if (data.status){
                                        ShowToast({
                                            message:'Sponsorship Requested Successfully',
                                            type:'success'
                                        })
                                        CloseDialogBox('RequestSponsorship')
                                    }else{
                                        ShowToast({
                                            message:data.message,
                                            type:'danger'
                                        })
                                        setTimeout(()=>{
                                            CloseDialogBox('RequestSponsorship')
                                            window.location.reload()
                                        },2000)
                                    }
                                })
                        }
                    })

}
    function initMap(){
        const Campaign = {lat: <?php echo $campaign->getLatitude()?>, lng: <?php echo $campaign->getLongitude()?>};
        // console.log(Campaign)
        const map = new google.maps.Map(document.getElementById("Map"), {
            zoom: 13,
            center: Campaign,
        });
        const marker = new google.maps.Marker({
            position: Campaign,
            map: map,
        });
        marker.addListener("click", () => {
            map.setZoom(16);
            map.setCenter(marker.getPosition());
            infoWindow.open(map,marker)
        });
        const infoWindow = new google.maps.InfoWindow({
            content : `
                Campaign Name : <?php echo $campaign->getCampaignName() ?> <br/>
                Campaign Date : <?php echo $campaign->getCampaignDate() ?> <br/>
                Campaign Status : <?php echo $campaign->getCampaignStatus() ?> <br/>
            `
        })
    }
    window.addEventListener('load', initMap);

    const DeleteCampaign = ()=>{
        OpenDialogBox({
            id:'delete-confirm',
            title:'Delete Confirmation',
            titleClass: "bg-dark text-white text-center",
            content :`
                <div class="d-flex flex-column gap-0-5">
                    <div class="text-center">
                        <strong>Are you sure you want to delete this Campaign?</strong>
                    </div>
                    <div class="text-center text-danger">
                        <strong>Warning : This Action is Irreversible</strong>
                    </div>
                </div>
                    `,
            successBtnText:'Yes',
            cancelBtnText:'No',
            successBtnAction : ()=>{
                window.location.href = "/organization/campaign/deleteCampaign?id=<?php echo $campaign->getCampaignID(); ?>"
            },
        });
    }

    //const inform= () =>{
    //   OpenDialogBox({
    //       id : 'inform',
    //       title : 'Inform Donors',
    //       content :`<div class="d-flex flex-column gap-0-5" >
    //                        <label for="message" class="form-label">Message</label>
    //                        <textarea class="form-control text-center" name="message" id="message" placeholder="Message" style="height: 200px;"></textarea>
    //                    </div>
    //                    <div class="d-flex flex-column gap-1">
    //                        <label for="type" class="form-label">Message Type</label>
    //                        <select class="form-select" name="type" id="type">
    //                            <option value="1">Urgent</option>
    //                            <option value="2">Not Urgent</option>
    //                        </select>
    //                    </div>`,
    //       successBtnText:'Inform',
    //       successBtnAction:()=>{
    //           let message = document.getElementById('message').value;
    //           let type = document.getElementById('type').value;
    //           if(message === ''){
    //               ShowToast({
    //                   message:'Message Cannot be Empty',
    //                   type : 'danger',
    //               })
    //               return;
    //           }
    //           const formData = new FormData();
    //           formData.append('Message',message);
    //           formData.append('Type',type);
    //           const url = '/organization/inform';
    //           fetch(url,{
    //               method:'POST',
    //               body:formData,
    //               headers:{
    //                   'enctype':'multipart/form-data'
    //               }
    //           }).then(res=>res.json())
    //               .then((data)=>{
    //                   console.log(data);
    //                   if (data.status){
    //                       ShowToast({
    //                           message:'Message Sent Successfully',
    //                           type:'success'
    //                       });
    //                       setTimeout(()=>{
    //                            CloseDialogBox('inform')
    //                            window.location.reload();
    //                       },2000);
    //                   }else{
    //                       ShowToast({
    //                           message:data.message,
    //                           type:'danger'
    //                       });
    //                       setTimeout(()=>{
    //                            CloseDialogBox('inform')
    //                           window.location.reload();
    //                       },2000);
    //                   }
    //               });
    //       }
    //    });
    //}
    function informing(CampaignID){
        const CampID = encodeURIComponent(CampaignID);
        window.location.href = "inform?id=" + CampID;
    }
</script>
