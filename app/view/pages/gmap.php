<!--
Make Google Map Location Maker
-->

<!--<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.657127085989!2d106.8151583147693!3d-6.175667995496071!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f0f2f2f2f2f2%3A0x2e69f0f2f2f2f2f2!2sJl.+Kebon+Jeruk+No.1%2C+RT.1%2FRW.1%2C+Klp.+Dua%2C+Kec.+Kby.+Baru%2C+Kota+Jakarta+Selatan%2C+Daerah+Khusus+Ibukota+Jakarta+12160!5e0!3m2!1sid!2sid!4v1530000000000" width="600" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>-->
<script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
<link rel="stylesheet" href="/public/css/framework/utils.css">
<script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCvbYq82SFP1JVqiFXWTMKAfwpUWQUtaPs&callback=initMap&v=weekly&libraries=places"
        defer
></script>
<h3>My Google Maps Demo</h3>
<button onclick="ViewMap()">Try It</button>
<button onclick="clickMe()">Try It 2</button>

<!--The div element for the map -->


<script>
    let Latitude = 6.8781340776734385;
    let Longitude = 79.8833214428759;
    const clickMe = ()=>{
        OpenDialogBox({
            id: 'mapDialog',
            title: 'Google Map',
            content: `
                    <div style="display: none">
                        <input
                                id="pac-input"
                                style="width: 30%;text-align: center;left: 50%;top: 10px"
                                type="text"
                                placeholder="Enter a location"
                        />

                    </div>
                    <div id="map" class="w-100 h-50"></div>
                    <div id="infowindow-content">
                        <span id="place-name" class="title"></span><br/>
                        <strong>Place ID:</strong> <span id="place-id"></span><br/>
                        <span id="place-address"></span>
                    </div>
            `,
            successBtnText: 'Save',
            successBtnAction: () => {
                console.log('Latitude : '+Latitude);
                console.log('Longtitude :'+Longitude);
            },
        });
        initMap();
    }

    function initMap() {
        const colombo = { lat: 6.8781340776734385, lng: 79.8833214428759 };
        const map = new google.maps.Map(document.getElementById("map"), {
            center: colombo,
            zoom: 8,
        });
        const input = document.getElementById("pac-input");
        // Specify just the place data fields that you need.
        const autocomplete = new google.maps.places.Autocomplete(input, {
            fields: ["place_id", "geometry", "formatted_address", "name"],
        });
        const infowindow = new google.maps.InfoWindow();
        const marker = new google.maps.Marker({
            map,
        });


        autocomplete.bindTo("bounds", map);
        map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
        map.addListener("click", (mapsMouseEvent) => {
            // Close the current InfoWindow.
            infowindow.close();
            const place= mapsMouseEvent.latLng;
            const location =mapsMouseEvent;
            const placeJSON= JSON.stringify(mapsMouseEvent.latLng.toJSON(), null, 2);
            // Create a new InfoWindow.
            infoWindow = new google.maps.InfoWindow({
                position: place,
            });
            Latitude= mapsMouseEvent.latLng.lat()
            Longitude= mapsMouseEvent.latLng.lng()
            marker.setPosition(place);
            marker.setTitle("Set Locations");
            marker.setPlace({
                placeId: place.place_id,
            });

            infowindow.open({
                anchor:marker,
                map,
            });
        });


        marker.addListener("click", () => {
            console.log('Latitude : '+Latitude);
            infowindow.open(map, marker);
        });
        autocomplete.addListener("place_changed", () => {
            infowindow.close();

            const place = autocomplete.getPlace();

            if (!place.geometry || !place.geometry.location) {
                return;
            }

            if (place.geometry.viewport) {
                map.fitBounds(place.geometry.viewport);
            } else {
                map.setCenter(place.geometry.location);
                map.setZoom(17);
            }
            Latitude = place.geometry.location.lat();
            Longitude = place.geometry.location.lng();

            // Set the position of the marker using the place ID and location.
            // @ts-ignore This should be in @typings/googlemaps.
            marker.setPlace({
                placeId: place.place_id,
                location: place.geometry.location,
            });
            infowindow.open(map, marker);
        });

    }




</script>
<script src="/public/js/components/dialog-box/dialog-box.js"></script>
