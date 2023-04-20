<?php
/* @var string $Campaign_Name */
/* @var Campaign $campaign */
/* @var string $Venue */
use App\model\Campaigns\Campaign;
use App\model\Utils\Date;
use App\view\components\ResponsiveComponent\Alert\FlashMessage;
use App\view\components\ResponsiveComponent\CardGroup\CardGroup;
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
    @media only screen and (max-width: 394px) {
        .intro{
            display: flex;
            flex-direction: column;
            text-align: center;
        }
    }
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
</style>
<div class="d-flex flex-column w-90  p-1" style="overflow-y: scroll;">
<!--    <div class="d-flex text-xl w-100 align-items-center justify-content-center bg-dark px-2 py-0-5 text-white font-bold" style="font-size: 1.8rem">--><?php //=$campaign->getCampaignName(); ?><!--</div>-->
        <div class="d-flex bg-white-0-3 p-2 gap-2 details w-100 justify-content-center" style="flex-wrap: wrap;">
            <div class="text-xl d-flex flex-column justify-content-center align-items-center w-50 bg-white border-radius-10 gap-1 p-3 mt-3"  id="Campaign_Detail" style="flex-wrap: wrap;">
                <div class="d-flex justify-content-between w-100 intro" id="Campaign_Name">
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
                    $CampaignStatus =$campaign->getVerified();
                    if($CampaignStatus === Campaign::NOT_VERIFIED): ?>
                        <div class="font-bold bg-yellow-10 py-0-5 px-1 border-radius-10 text-white intro" >Pending Approval</div>
                    <?php elseif($CampaignStatus === Campaign::VERIFIED): ?>
                        <div class="font-bold bg-green-6 py-0-5 px-1 border-radius-10 text-white intro">Campaign Approved</div>
                    <?php elseif($CampaignStatus === 'Rejected'): ?>
                        <div class="font-bold bg-red-6 py-0-5 px-1 border-radius-10 text-white intro">Campaign Rejected</div>
                    <?php endif;
//                    ?>
                    </div>
                </div>
                <div class="d-flex flex-column w-100 justify-content-between gap-1 intro" id="Campaign_Date">
                    <div class="">Description </div>
                    <div class="font-bold px-1 ">
                        <?=$campaign->getCampaignDescription(); ?>
                    </div>
                </div>

<!--                --><?php //if(isset($expired) &&  $expired== 1) { ?>
<!--                <div class="d-flex gap-6" id="Campaign_Status">-->
<!--                    <div class="">Received Income</div>-->
<!--                    <div class="font-bold" style="padding: 0 5px "></div>-->
<!--                </div>-->
<!--                <div class="d-flex gap-6" id="Campaign_Status">-->
<!--                    <div class="">Donor Participation</div>-->
<!--                    <div class="font-bold" style="padding: 0 5px "></div>-->
<!--                </div>-->
<!--                --><?php //} ?>
                <?php if($campaign->getVerified() === Campaign::NOT_VERIFIED) {?>
                    <div style="text-align: center;display: flex;flex-direction: row;gap: 20px;margin-left: 30vh;">
                        <a href="/organization/campaign/updateCampaign?id=<?php echo $campaign->getCampaignID()?>"><button class="btn btn-success w-100">Update Campaign</button></a>
                        <a href="" id="delete"><button class="btn btn-danger w-100" onclick="del()">Delete Campaign</button></a>
                    </div>
                <?php } ?>
            </div>
            <div id="Map" class="bg-red-1 mt-5" style="width: 500px;height: 300px;"></div>
        </div>
    <?php if($campaign->getVerified()===Campaign::VERIFIED && !$expired) { ?>
        <div class="d-flex flex-wrap cards justify-content-center bg-white-0-3 py-1">
        <div class="d-flex cards text-center  reqcards" style="margin-top: -10px;flex-wrap: wrap">
            <div class="card nav-card bg-white text-dark" onclick="RequestSponsorship()">
                <div class="card-header">
                    <div class="card-header-img">
                        <img src="/public/images/icons/organization/campaignDetails/request.png" alt="Request" width="100px">
                    </div>
                    <div class="card-title">
                        <h3>Request Sponsorship</h3>
                    </div>
                </div>
            </div>
            <div class="card nav-card bg-orange-10 text-dark">
                <div class="card-header">
<!--                    <div class="card-header-img">-->
<!--                        <img src="/public/images/icons/organization/campaignDetails/received.png" alt="Received" width="100px">-->
<!--                    </div>-->
                    <div class="card-title">
                        <h3 style="color: whitesmoke">You have Received <span class="bg-warning fa fa-1x p-1 " style="color: #0b0000">LKR. <?php echo $pack_price ?></span></h3>
                    </div>
                </div>
            </div>
            <div class="card nav-card bg-green-3 text-dark">
                <div class="card-header">
                    <div class="card-title">
                        <h3 style="color: whitesmoke"> No. of Accepted Donors<br> <span class="bg-warning fa fa-1x p-1 " style="color: #0b0000"><?php echo $donor ?></span></h3>
                    </div>
                </div>
            </div>
            <div class="card nav-card bg-white text-dark" onclick="informDonors()">
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
</div>
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
    const RequestSponsorship = ()=>{
        const url ='/organization/getBankDetails';
        fetch(url,{
            method:'POST',
        }).then(res=>res.json())
            .then((data)=>{
                let bankName = "";
                let bankAccountNumber = "";
                let bankAccountName = "";
                let bankBranch = "";
                if (data.status){
                    console.log(data)
                    if (data.data && Object.keys(data.data).length > 0){
                        bankName = data.data.BankName;
                        bankAccountNumber = data.data.BankAccountNumber;
                        bankAccountName = data.data.BankAccountName;
                        bankBranch = data.data.BankBranch;
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
                    }else{
                        ShowToast({
                            message:'Please Add Bank Details to Request Sponsorship',
                            type:'danger'
                        })
                    }
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
        });
    }
    window.addEventListener('load', initMap);

    const del = (event)=>{
     event.preventDefault();
    OpenDialogBox({
    // id:'sendEmail',
    title:'Delete Confirmation',
    content :`Are You Sure You Want to Delete Details? This Action Cannot be Undone.`,
    successBtnText:'Yes',
    successBtnAction : ()=>{
        window.location.href = "/organization/campaign/deleteCampaign?id=<?php echo $campaign->getCampaignID(); ?>"
    },

    });
    }
    document.getElementById('delete').addEventListener('click', del);

    //const inform = (event)=>{
    //    alert('Hi');
    //    event.preventDefault();
    //    OpenDialogBox({
    //        // id:'sendEmail',
    //        title:'Delete Confirmation',
    //        content :`Are You Sure You Want to Delete Details? This Action Cannot be Undone.`,
    //        successBtnText:'Yes',
    //        successBtnAction : ()=>{
    //            window.location.href = "/organization/campaign/deleteCampaign?id=<?php //echo $campaign->getCampaignID(); ?>//"
    //        },
    //
    //    });
    //}

    // const inform = (event)=>{
    //                     OpenDialogBox({
    //                         id:'inform Donors',
    //                         title:'Request Sponsorship',
    //                         titleClass:'text-center bg-dark text-white px-2 py-1',
    //                         content :`<div class="d-flex flex-column gap-1">
    //                     <div class="d-flex flex-column gap-0-5">
    //                         <label for="Message" class="form-label">Expected Amount</label>
    //                         <input type="text" class="form-control" name="Message" id="Message" placeholder="Message">
    //                     </div>
    //                     <div class="d-flex flex-column gap-1">
    //                         <label for="Message_Type" class="form-label">Mesage Type</label>
    //                         <select class="form-select Message_Type">
    //                             <option value="1">Urgent</option>
    //                             <option value="2">Not Urgent</option>
    //                         </select>
    //
    //                     </div>
    //                     </div>
    //         `,
    //                         successBtnText:'Inform',
    //                         successBtnAction:()=>{
    //                             const Message = document.getElementById('Message').value;
    //                             const Type = document.getElementById('Message_Type').value;
    //
    //                             //     Validate
    //                             if (Message === ""){
    //                                 ShowToast({
    //                                     message:'Please Enter Message',
    //                                     type:'danger'
    //                                 })
    //                                 return;
    //                             }
    //                             if (Type === ""){
    //                                 ShowToast({
    //                                     message:'Please Select Message Type',
    //                                     type:'danger'
    //                                 })
    //                                 return;
    //                             }
    //                             const formData = new FormData();
    //                             formData.append('Message',Message);
    //                             formData.append('Type',Message_Type);
    //                             const url = '/organization/inform';
    //                             fetch(url,{
    //                                 method:'POST',
    //                                 body:formData,
    //                                 headers:{
    //                                     'enctype':'multipart/form-data'
    //                                 }
    //                             }).then(res=>res.json())
    //                                 .then((data)=>{
    //                                     if (data.status){
    //                                         ShowToast({
    //                                             message:'Sponsorship Requested Successfully',
    //                                             type:'success'
    //                                         })
    //                                         CloseDialogBox('RequestSponsorship')
    //                                     }else{
    //                                         ShowToast({
    //                                             message:data.message,
    //                                             type:'danger'
    //                                         })
    //                                         setTimeout(()=>{
    //                                             CloseDialogBox('RequestSponsorship')
    //                                             window.location.reload()
    //                                         },2000)
    //                                     }
    //                                 })
    //                         }
    //                     })
    //                 }
    //             }
    //
    //         })
    // }
    function informDonors(){
       OpenDialogBox({
           id : 'informDonors',
           title : 'Inform Donors',
           content :`<div class="d-flex flex-column gap-0-5" >
                            <label for="message" class="form-label">Message</label>
                            <textarea class="form-control text-center" name="message" id="message" placeholder="Message" style="height: 200px;"></textarea>
                        </div>
                        <div class="d-flex flex-column gap-1">
                            <label for="type" class="form-label">Message Type</label>
                            <select class="form-select" name="type" id="type">
                                <option value="1">Urgent</option>
                                <option value="2">Not Urgent</option>
                            </select>
                        </div>`,
           successBtnText:'Inform',
           successBtnAction:()=>{
               let message = document.getElementById('message').value;
               let type = document.getElementById('type').value;
               if(message === ''){
                   ShowToast({
                       message:'Message Cannot be Empty',
                       type : 'danger',
                   })
                   return;
               }
               const formData = new FormData();
               formData.append('Message',message);
               formData.append('Type',type);
               const url = '/organization/inform';
               fetch(url,{
                   method:'POST',
                   body:formData,
                   headers:{
                       'enctype':'multipart/form-data'
                   }
               }).then(res=>res.json())
                   .then((data)=>{
                       console.log(data);
                       if (data.status){
                           ShowToast({
                               message:'Message Sent Successfully',
                               type:'success'
                           });
                           setTimeout(()=>{
                               CloseDialogBox('informDonors')
                               window.location.reload()
                           },2000);
                       }else{
                           ShowToast({
                               message:data.message,
                               type:'danger'
                           });
                           setTimeout(()=>{
                               CloseDialogBox('informDonors')
                               window.location.reload()
                           },2000);
                       }
                   });
           }
        });
    }
</script>
