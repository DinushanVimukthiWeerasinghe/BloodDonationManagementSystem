<!--
Make Google Map Location Maker
-->

<!--<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.657127085989!2d106.8151583147693!3d-6.175667995496071!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f0f2f2f2f2f2%3A0x2e69f0f2f2f2f2f2!2sJl.+Kebon+Jeruk+No.1%2C+RT.1%2FRW.1%2C+Klp.+Dua%2C+Kec.+Kby.+Baru%2C+Kota+Jakarta+Selatan%2C+Daerah+Khusus+Ibukota+Jakarta+12160!5e0!3m2!1sid!2sid!4v1530000000000" width="600" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>-->
<script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
<link rel="stylesheet" href="/public/css/framework/utils.css">

<h3>My Google Maps Demo</h3>
<button onclick="ViewMap()">Try It</button>
<button onclick="ViewMapS()">Try It 2</button>
<!--The div element for the map -->

<script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCvbYq82SFP1JVqiFXWTMKAfwpUWQUtaPs&callback=initMap&v=weekly&libraries=places"
        defer
></script>
<script>
    const ViewMap = ()=>{
        OpenDialogBox({
            id: 'mapDialog',
            title: 'Google Map',
            content: `
                    <div id="map" class="w-100 h-50"></div>
                    <div id="place"></div>
            `,
            successBtnText: 'Save',
            successBtnAction: () => {
                console.log('Save');
            },
        });
        initMap();

    }
    const ViewMapS = ()=>{
        OpenDialogBox({
            id: 'mapDialog',
            title: 'Google Map',
            contentSize:80,
            content: `
                    <div style="display: none">
                         <input
                                            id="pac-input"
                                            style="width: 30%;text-align: center;left: 35%"
                                            type="text"
                                            placeholder="Enter a location"
                         />

                    </div>
                    <div id="map" class="w-100 h-50"></div>
                    <div id="infowindow-content">
                      <span id="place-name" class="title"></span><br />
                      <strong>Place ID:</strong> <span id="place-id"></span><br />
                      <span id="place-address"></span>
                    </div>

            `,
            successBtnText: 'Save',
            successBtnAction: () => {
                console.log('Save');
            },
        });
        initMap();

    }

    function initMap() {
        const colombo = { lat: 6.8781340776734385, lng: 79.8833214428759 };
        const mylating = { lat: 6.8781340776734385, lng: 79.8833214428759 };

        const map = new google.maps.Map(document.getElementById("map"), {
            zoom: 10,
            minZoom: 8,
            maxZoom: 16,
            center: colombo,
            restriction: {
                latLngBounds: {
                    north: 9.9,
                    south: 5.8,
                    west: 79.8,
                    east: 81.9,
                }
            },
        });
        const input = document.getElementById("pac-input");
        // Specify just the place data fields that you need.
        const autocomplete = new google.maps.places.Autocomplete(input, {
            fields: ["place_id", "geometry", "formatted_address", "name"],
        });
        autocomplete.bindTo("bounds", map);
        map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function (position) {
                initialLocation = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
                map.setCenter(initialLocation);
            });
        }
        // The map, centered at Colombo and restricted to the given sri lanka



        // Create the initial InfoWindow.
        let infoWindow = new google.maps.InfoWindow();
        const marker = new google.maps.Marker({
            map,
        });

        infoWindow.open(map);
        // Configure the click listener.
        map.addListener("click", (mapsMouseEvent) => {
            // Close the current InfoWindow.
            infoWindow.close();
            const place= mapsMouseEvent.latLng;
            const placeJSON= JSON.stringify(mapsMouseEvent.latLng.toJSON(), null, 2);
            // Create a new InfoWindow.
            infoWindow = new google.maps.InfoWindow({
                position: place,
            });
            marker.setPosition(place);
            marker.setTitle("Set Locations");


            infoWindow.setContent(
                'Campaign Is here!'
            );
            infoWindow.open({
                anchor:marker,
                map
            });
        });
    }
    function initMapWithPlacesSearch(){
        const map = new google.maps.Map(document.getElementById("map"), {
            center: { lat: -33.8688, lng: 151.2195 },
        zoom: 13,
        });
        const input = document.getElementById("pac-input");
        // Specify just the place data fields that you need.
        const autocomplete = new google.maps.places.Autocomplete(input, {
            fields: ["place_id", "geometry", "formatted_address", "name"],
        });

        autocomplete.bindTo("bounds", map);
        map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

        const infowindow = new google.maps.InfoWindow();
        const infowindowContent = document.getElementById("infowindow-content");

        infowindow.setContent(infowindowContent);

        const marker = new google.maps.Marker({ map: map });

        marker.addListener("click", () => {
            console.log("g")
            infowindow.open(map, marker);
        });
        autocomplete.addListener("place_changed", () => {
            infowindow.close();

            const place = autocomplete.getPlace();
            console.log(place);

            if (!place.geometry || !place.geometry.location) {
                return;
            }

            if (place.geometry.viewport) {
                map.fitBounds(place.geometry.viewport);
            } else {
                map.setCenter(place.geometry.location);
                map.setZoom(17);
            }

            // Set the position of the marker using the place ID and location.
            // @ts-ignore This should be in @typings/googlemaps.
            marker.setPlace({
                placeId: place.place_id,
                location: place.geometry.location,
            });
            marker.setVisible(true);
            infowindowContent.children.namedItem("place-name").textContent = place.name;
            infowindowContent.children.namedItem("place-id").textContent =
                place.place_id;
            infowindowContent.children.namedItem("place-address").textContent =
                place.formatted_address;
            infowindow.open(map, marker);
        });
        window.initMap = initMap;
    }


</script>
<script src="/public/js/components/dialog-box/dialog-box.js"></script>
