<?php

namespace App\view\components\ResponsiveComponent\Card;

class donationCard
{
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
    public function __construct(array $params, bool $popup = true){
        foreach($params as $key => $value){
            $this->{$key} = $value;
        }
        //echo $longDesc;
//        $this->longDescription = $longDesc;
        $this->popup = $popup;
    }
    public function render():string {

        return <<<HTML
        <!--        <link rel="stylesheet" href="public/css/framework/components/dialog-box/dialog-box.css">-->
        <a href="#" class="data-card" onclick="OpenDialogBoxtrigger({
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
            console.log(args);
                console.log(args);
                
                //var data  = text.split(",");
                //console.log(data);
                if(args['popup']){
                OpenDialogBox({
                                title: '<div style="color:black">' + args['title'] + '</div>',
                                content :`<div class="d-flex flex-center">
                                    <div id="map" style="height: 300px;width: 300px"></div>
                                    <div id="infowindow-content">
                                    Subtitle : `+ args['subtitle'] +`
                                    <br>
                                    Description : `+ args['description'] +`
                                    <br>
                                    Date : `+ args['date'] +`
                                    </div>
                                </div>`,
                                showCancelButton: false
                            })
                }else {
                    // document.getElementById('allDetailsLink').remove();
                }
                            initMap(parseFloat(args['latitude']),parseFloat(args['longitude']));
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

