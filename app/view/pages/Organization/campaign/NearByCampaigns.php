
<?php

use App\view\components\ResponsiveComponent\ImageComponent\BackGroundImage;
use App\view\components\ResponsiveComponent\NavbarComponent\AuthNavbar;

$background = new BackGroundImage();
$navbar = new AuthNavbar('Nearby Campaigns', '/organization/near', '/public/images/icons/user.png', true,false);

echo $navbar;
echo $background;
?>


<div class="d-flex justify-content-center align-items-center w-100 h-100 m-2">
    <div class="d-flex w-100" style="height: 95vh;margin-top: 10vh">
        <div style="display: none;">
            <label for="pac-input"></label>
            <input
                    id="pac-input"
                    style="width:40%;font-size: large;text-align: center"
                    type="text"
                    placeholder="Enter a location"
            />
        </div>
        <div class="absolute bg-white w-40 p-0-5 right-5 top-8 border-radius-2" style="z-index: 9;margin-top: 8px;">
            <div class="d-flex">
                <div class="form-group">
                    <label for="DateRangeSelector" class="w-40">Date Range</label>
                    <input type="date" class="form-control w-30" id="DateRangeSelectorFrom" style="width: 50% !important;">
                    <span>To</span>
                    <input type="date" class="form-control w-30" id="DateRangeSelectorTo" style="width: 50% !important;">
                    <button class="d-flex align-items-center justify-content-center gap-0-5 btn btn-outline-info" style="padding-left: 5px;padding-right: 5px" onclick="FilterCampaigns()">
                        <img src="/public/icons/filter.svg" alt="" width="18">
                        <span>Filter</span>
                    </button>
                </div>
            </div>
        </div>
        <div id="loader" class="absolute w-100 d-flex justify-content-center align-items-center p-1" style="z-index: 9;background: rgba(0,0,0,0.7);height: 95vh;">
            <img src="/public/loading2.svg" alt="" width="100px">
        </div>
        <div id="map" class="w-100 " style="height: 95vh;position: absolute;top: 8vh"></div>
    </div>
</div>

<script>
    window.onload = function () {
        initMap();
        setTimeout(function () {
            document.getElementById("loader").style.display = "none";
        }, 2000);
    };
    async function initMap() {
        console.log("Function Called")
        const getCampaignCoordinate = "/organization/getCampaignCoordinate";
        fetch(getCampaignCoordinate,{
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },
        })
            .then((response) => response.json())
            .then((data) => {
                const Campaigns = data.Campaigns;
                console.log(Campaigns)
                const colombo = { lat: 6.8781340776734385, lng: 79.8833214428759 };
                const mylating = { lat: 6.8781340776734385, lng: 79.8833214428759 };
                var sriLankaBounds = {
                    north: 9.9355,
                    south: 5.875,
                    east: 81.8815,
                    west: 79.6524,
                };

                const map = new google.maps.Map(document.getElementById("map"), {
                    zoom: 10,
                    minZoom: 8,
                    maxZoom: 20,
                    center: colombo,
                    mapTypeId: "roadmap",
                    streetViewControl: false,
                    fullscreenControl: false,
                    zoomControl: true,
                    zoomControlOptions: {
                        position: google.maps.ControlPosition.LEFT_CENTER,
                    },
                    backgroundColor: "#fff",
                    restriction: {
                        latLngBounds: sriLankaBounds,
                        strictBounds: false,
                    },
                });
                if(Campaigns.length === 0){
                    ShowToast({
                        type : "danger",
                        message :"No Campaigns Found"
                    })
                    return;
                }
                else {
                    for (let i = 0; i < Campaigns.length; i++) {
                        const marker = new google.maps.Marker({
                            position: {
                                lat: parseFloat(Campaigns[i].Latitude),
                                lng: parseFloat(Campaigns[i].Longitude),
                            },
                            map: map,
                            title: Campaigns[i].name,
                        });
                        const infowindow = new google.maps.InfoWindow({
                            content: `
                            Campaign Name: ${Campaigns[i].Campaign_Name} <br>
                            Campaign Date: ${Campaigns[i].Campaign_Date} <br>
                            Campaign Venue: ${Campaigns[i].Venue} <br>
                        `
                        });

                        marker.addListener("click", () => {
                            map.setZoom(15);
                            map.setCenter(marker.getPosition());
                            infowindow.open(map, marker);
                        });

                    }
                }
                const input = document.getElementById("pac-input");
                const searchBox = new google.maps.places.SearchBox(input);
                // Change CSS of search box
                input.style.border = "0.5px solid black";
                input.style.marginTop = "10px";
                map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

                // Bias the SearchBox results towards current map's viewport.
                map.addListener("bounds_changed", () => {
                    searchBox.setBounds(map.getBounds());
                });
                let markers = [];
                // Listen for the event fired when the user selects a prediction and retrieve
                // more details for that place.
                searchBox.addListener("places_changed", () => {
                    const places = searchBox.getPlaces();

                    if (places.length == 0) {
                        return;
                    }
                    // Clear out the old markers.
                    markers.forEach((marker) => {
                        marker.setMap(null);
                    });
                    markers = [];
                    // For each place, get the icon, name and location.
                    const bounds = new google.maps.LatLngBounds();
                    places.forEach((place) => {
                        if (!place.geometry || !place.geometry.location) {
                            console.log("Returned place contains no geometry");
                            return;
                        }
                        const icon = {
                            url: place.icon,
                            size: new google.maps.Size(71, 71),
                            origin: new google.maps.Point(0, 0),
                            anchor: new google.maps.Point(17, 34),
                            scaledSize: new google.maps.Size(25, 25),
                        };
                        // Create a marker for each place.
                        markers.push(
                            new google.maps.Marker({
                                map,
                                icon,
                                title: place.name,
                                position: place.geometry.location,
                            })
                        );

                        if (place.geometry.viewport) {
                            // Only geocodes have viewport.
                            bounds.union(place.geometry.viewport);
                        } else {
                            bounds.extend(place.geometry.location);
                        }
                    });
                    map.fitBounds(bounds);
                });
                // Create the initial InfoWindow.
                let infoWindow = new google.maps.Info
                Window({
                    content: "Click the map to get Lat/Lng!",
                    position: colombo,
                });
                infoWindow.open(map);
                // Configure the click listener.

                map.addListener("click", (mapsMouseEvent) => {
                    // Close the current InfoWindow.
                    infoWindow.close();
                    // Create a new InfoWindow.
                    infoWindow = new google.maps.InfoWindow({
                        position: mapsMouseEvent.latLng,
                    });
                    infoWindow.setContent(
                        JSON.stringify(mapsMouseEvent.latLng.toJSON(), null, 2)
                    );
                    infoWindow.open(map);
                });
            //     Set Marker in map

            })
            .catch((error) => {
                console.error("Error:", error);
            })



    }

    const FilterCampaigns = ()=> {
        const timeFrom = document.getElementById("DateRangeSelectorFrom").value;
        const timeTo = document.getElementById("DateRangeSelectorTo").value;
        if (timeFrom === "" || timeTo === "") {
            ShowToast({
                type: "danger",
                message: "Please Select Date Range"
            })
            return;
        }
        if (timeFrom > timeTo) {
            ShowToast({
                type: "danger",
                message: "Please Select Valid Date Range"
            })
            return;
        }
        const loader = document.getElementById("loader");
        loader.style.display = "flex";
        const getCampaignCoordinate = "/organization/getCampaignCoordinate";
        const formData = new FormData();
        formData.append("CampaignDateFrom", timeFrom);
        formData.append("CampaignDateTo", timeTo);
        fetch(getCampaignCoordinate, {
            method: "POST",
            body: formData,
        })
            .then((response) => response.json())
            .then((data) => {
                setTimeout(() => {
                    loader.style.display = "none";
                }, 2000)
                if (data.status){
                    const Campaigns = data.Campaigns;
                    console.log(Campaigns)
                    const colombo = {lat: 6.8781340776734385, lng: 79.8833214428759};
                    const mylating = {lat: 6.8781340776734385, lng: 79.8833214428759};

                    const map = new google.maps.Map(document.getElementById("map"), {
                        zoom: 10,
                        minZoom: 8,
                        maxZoom: 16,
                        center: colombo,
                    });

                    for (let i = 0; i < Campaigns.length; i++) {
                        const marker = new google.maps.Marker({
                            position: {
                                lat: parseFloat(Campaigns[i].Latitude),
                                lng: parseFloat(Campaigns[i].Longitude),
                            },
                            map: map,
                            title: Campaigns[i].name,
                        });
                        const infowindow = new google.maps.InfoWindow({
                            content: `
                            Campaign Name: ${Campaigns[i].Campaign_Name} <br>
                            Campaign Date: ${Campaigns[i].Campaign_Date} <br>
                            Campaign Venue: ${Campaigns[i].Venue} <br>
                        `
                        });

                        marker.addListener("click", () => {
                            map.setZoom(15);
                            map.setCenter(marker.getPosition());
                            infowindow.open(map, marker);
                        });
                    }
                    const input = document.getElementById("pac-input");
                    const searchBox = new google.maps.places.SearchBox(input);
                    // Change CSS of search box
                    input.style.border = "0.5px solid black";
                    input.style.marginTop = "10px";
                    map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

                    // Bias the SearchBox results towards current map's viewport.
                    map.addListener("bounds_changed", () => {
                        searchBox.setBounds(map.getBounds());
                    });
                    let markers = [];
                    // Listen for the event fired when the user selects a prediction and retrieve
                    // more details for that place.
                    searchBox.addListener("places_changed", () => {
                        const places = searchBox.getPlaces();

                        if (places.length == 0) {
                            return;
                        }
                        // Clear out the old markers.
                        markers.forEach((marker) => {
                            marker.setMap(null);
                        });
                        markers = [];
                        // For each place, get the icon, name and location.
                        const bounds = new google.maps.LatLngBounds();
                        places.forEach((place) => {
                            if (!place.geometry || !place.geometry.location) {
                                console.log("Returned place contains no geometry");
                                return;
                            }
                            const icon = {
                                url: place.icon,
                                size: new google.maps.Size(71, 71),
                                origin: new google.maps.Point(0, 0),
                                anchor: new google.maps.Point(17, 34),
                                scaledSize: new google.maps.Size(25, 25),
                            };
                            // Create a marker for each place.
                            markers.push(
                                new google.maps.Marker({
                                    map,
                                    icon,
                                    title: place.name,
                                    position: place.geometry.location,
                                })
                            );

                            if (place.geometry.viewport) {
                                // Only geocodes have viewport.
                                bounds.union(place.geometry.viewport);
                            } else {
                                bounds.extend(place.geometry.location);
                            }
                        });
                        map.fitBounds(bounds);
                    });
                    // Create the initial InfoWindow.
                    let infoWindow = new google.maps.Info
                    Window({
                        content: "Click the map to get Lat/Lng!",
                        position: colombo,
                    });
                    infoWindow.open(map);
                    // Configure the click listener.

                    map.addListener("click", (mapsMouseEvent) => {
                        // Close the current InfoWindow.
                        infoWindow.close();
                        // Create a new InfoWindow.
                        infoWindow = new google.maps.InfoWindow({
                            position: mapsMouseEvent.latLng,
                        });
                        infoWindow.setContent(
                            JSON.stringify(mapsMouseEvent.latLng.toJSON(), null, 2)
                        );
                        infoWindow.open(map);
                    });
                    //     Set Marker in map
                }else{
                    ShowToast({
                        type: "danger",
                        message: data.message
                    })
                }


            })
            .catch((error) => {
                console.error("Error:", error);
            })

    }

</script>