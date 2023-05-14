<?php

namespace App\view\components\ResponsiveComponent\Card;

class donationCard
{
    protected string $userID = '';
    protected string $ID = '';
    protected string $title = '';
    protected string $subtitle = '';
    protected string $description = '';
    protected string $date = '';
    protected string $latitude = '';
    protected string $longitude = '';
    protected bool $popup = true;
    //    protected string $longDescription  = '';

//    protected array $allData;
//    protected string $organization;
    public function __construct(array $params, string $userID ,bool $popup = true){
        foreach($params as $key => $value){
            $this->{$key} = $value;
        }
        //echo $longDesc;
//        $this->longDescription = $longDesc;
        $this->popup = $popup;
        $this->userID = $userID;
    }
    public function render():string {

        return <<<HTML
        <!--        <link rel="stylesheet" href="public/css/framework/components/dialog-box/dialog-box.css">-->
        <a href="#" class="data-card" onclick="OpenDialogBoxtrigger({
        'userID':`$this->userID`,
        'campaignID':`$this->ID`,
        'title':`$this->title`,
        'subtitle':`$this->subtitle`,
        'description':`$this->description`,
        'date':`$this->date`,
        'latitude':`$this->latitude`,
        'longitude':`$this->longitude`,
        'popup':`$this->popup`
        })">
            <h3>$this->title</h3>
            <h4>$this->subtitle</h4>
            <p>$this->description</p>
            <span class="link-text popLabel">
                View All Details
                <svg width="25" height="16" viewBox="0 0 25 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M17.8631 0.929124L24.2271 7.29308C24.6176 7.68361 24.6176 8.31677 24.2271 8.7073L17.8631 15.0713C17.4726 15.4618 16.8394 15.4618 16.4489 15.0713C16.0584 14.6807 16.0584 14.0476 16.4489 13.657L21.1058 9.00019H0.47998V7.00019H21.1058L16.4489 2.34334C16.0584 1.95281 16.0584 1.31965 16.4489 0.929124C16.8394 0.538599 17.4726 0.538599 17.8631 0.929124Z" fill="#753BBD"/>
                </svg>
            </span>
        </a>

        
        <script>
        function OpenDialogBoxtrigger(args) {
            // console.log(args);
            // console.log(args);
            const XHR = new XMLHttpRequest();
            XHR.open("GET", "/api/campaign/checkattendance?userID="+args['userID']+"&campaignID="+args['campaignID'], true);
            XHR.setRequestHeader("Content-Type", "application/json");
            XHR.send();
            XHR.onload = function () {
            const attendance = JSON.parse(this.responseText);
            console.log(attendance);
            // console.log(Object.keys(bankList));
            // Banks = Object.keys(bankList);
            // console.log(Banks);
            // OpenDialogBox({})
            
                //var data  = text.split(",");
                //console.log(data);
            OpenDialogBox({
                                title: '<div style="color:black">' + args['title'] + '</div>',
                                id :'nearbyCampaignView',
                                content :`<div class="d-flex flex-center">
                                    <div id="map" style="height: 300px;width: 300px"></div>
                                    <div id="infowindow-content">
                                    Subtitle : `+ args['subtitle'] +`
                                    <br>
                                    Description : `+ args['description'] +`
                                    <br>
                                    Date : `+ args['date'] +`
                                    </div>
                                </div>
                                <div id="attendanceMsg">Do You want to recieve notifications about this campaign</div>`,
                                showCancelButton: true,
                                successBtnText : 'Yes',
                                successBtnAction : () =>{
                                    // console.log(args['campaignID']);
                                    // console.log(args['userID']);
                                    let attendanceMarkResult;
                                    if (attendance){
                                        attendanceMarkResult = removeAttendance(args['campaignID'],args['userID']);
                                    }else {
                                        attendanceMarkResult = markAttendance(args['campaignID'],args['userID']);
                                    }
                                    CloseDialogBox();
                                    // console.log(attendanceMarkResult);
                                    if (attendanceMarkResult){
                                        ShowToast(
                                            {
                                            message:'Prefence Changed Successfully',
                                            type: 'success',
                                            timeout: 3000,
                                            });
                                    }else {
                                        ShowToast(
                                            {
                                            message: "Error Occured Try Again", 
                                            type: 'error',
                                            timeout: 3000,
                                            }
                                        );
                                    }
                                }
                            });
            
            initMap(parseFloat(args['latitude']),parseFloat(args['longitude']));
            
            let attendanceMsg = document.getElementById('attendanceMsg');
            let dialogBox = document.getElementById('nearbyCampaignView');
            
            let successBtn =dialogBox.firstChild.lastChild.firstChild;
            
            if(attendance === true){
                // console.log('Attendance');
                attendanceMsg.innerText = 'You are recieving notifications about this campaign';
                successBtn.innerText = 'Stop';
                // console.log(successBtn)
            }
        }
        }
        
        async function markAttendance(campaignID, donorID){
            let result = false;
            const XHR = new XMLHttpRequest();
            XHR.open("GET", "/donor/campaign/markAttendance?userID="+donorID+"&campaignID="+campaignID, true);
            XHR.setRequestHeader("Content-Type", "application/json");
            XHR.send();
            XHR.onload = await async function () {
                result = await JSON.parse(this.responseText);
                // return result;
            }
                console.log(result);
            // console.log(result);
            return result;
        }       
        
        async function removeAttendance(campaignID, donorID){
            let result = false;
            const XHR = new XMLHttpRequest();
            XHR.open("GET", "/donor/campaign/removeAttendance?userID="+donorID+"&campaignID="+campaignID, true);
            XHR.setRequestHeader("Content-Type", "application/json");
            XHR.send();
            XHR.onload = await async function () {
                result = await JSON.parse(this.responseText);
                // return result;
            }
                console.log(result);
            return result;
        }       
        
        
        
        const initMap=async (latitude,longitude)=> {
            
              const { Map } = await google.maps.importLibrary("maps");
        const place = { lat: 6.8781340776734385, lng: 79.8833214428759 };
        if (latitude && longitude){
            place.lat = latitude;
            place.lng = longitude;
        }
        console.log(place)
        const mylating = { lat: 6.8781340776734385, lng: 79.8833214428759 };

        const map = new Map(document.getElementById("map"), {
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

        HTML;
        }
}

