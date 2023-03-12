<!--<script src="/public/scripts/customAlert.js"></script>-->
<!--<link href="/public/styles/alert.css" rel="stylesheet">-->
<?php
///* @var string $firstName */
///* @var string $lastName */
//
///* @var MedicalOfficer $model */

use App\model\BloodBankBranch\BloodBank;
use App\model\users\MedicalOfficer;
use App\view\components\ResponsiveComponent\ImageComponent\BackGroundImage;
use App\view\components\ResponsiveComponent\NavbarComponent\AuthNavbar;

$Date = date("Y-m-d");
$background = new BackGroundImage();
$navbar = new AuthNavbar('Create Campaign', '#', '/public/images/icons/navbar/bell.png');
//echo AuthNavbar::getNavbarCSS();
echo $navbar;
echo $background;
?>
<div class=" d-flex align-item-center justify-content-center p-1 w-100 h-100">
    <form action="create" method="post" class="d-flex flex-column p-3 bg-white-0-7 border-radius-10 text-xl w-50 gap-1">
        <div class="bg-dark py-0-5 px-2 text-center text-white"> Fill Campaign Details</div>
        <div class="d-flex text-center flex-column gap-0-5 w-100">
            <div class="form-group w-100">
                <label class="w-40" for="CampaignName">Campaign Name</label>
                <input type="text" id="CampaignName" class="form-control w-60" name="Campaign_Name" placeholder="Eg :- Suwasahana Blood Campaign" required>
            </div>
<!--            <div class="form-group">-->
<!--                <label class="w-40">Campaign Description</label>-->
<!--                <textarea class="form-textarea" name="Campaign_Description" required></textarea>-->
<!--            </div>-->
            <div class="form-group">
                <label class="w-40" for="CampaignDate">Campaign Date</label>
                <input type="date" id="CampaignDate" class="form-date" name="Campaign_Date" min= "<?php echo date("Y-m-d", strtotime($Date.'+ 8days')) ?>" required style="border-radius: 50px;padding-left: 10px;padding-right: 10px">
            </div>
            <div class="form-group">
                <label class="w-40" for="Venue">Venue</label>
                <input type="text" id="Venue" class="form-control w-20" name="Venue" required style="width: 70%"  placeholder="Eg :- Sugatharamaya, Kirulapone">
                <button class="btn btn-info d-flex gap-0-5 align-items-center justify-content-center" type="button" id="SelectLocationBtn" onclick="SelectLocation()">
                    <img src="/public/icons/location.svg" alt="map" class="invert-100" style="width: 20px; height: 20px;">
                    <span class="ms-1">Select on Map</span>
                </button>
            </div>
            <div class="form-group">
                <label class="w-40">Nearest City</label>
                <input type="text" class="form-control" name="Nearest_City"  required  placeholder="Eg :- Nugegoda">
            </div>
            <div class="form-group">
                <label class="w-40" for="NearestBloodBank">Nearest Blood Bank</label>
                <select id="NearestBloodBank" class="form-select w-40" name="Nearest_BloodBank">
                    <?php /** @var array $banks */
                        /** @var BloodBank $bank */
                    foreach ($banks as $bank){ ?>
                    <option value="<?= $bank->getBloodBankID() ?>"><?= $bank->getBankName() ?></option>
                    <?php } ?>
                </select>
            </div>
            <input type="hidden" id="Latitude" name="Latitude">
            <input type="hidden" id="Longitude" name="Longitude">
            <input type="hidden" id="Agreed" name="Agreed">
            <div class="form-group" style="justify-content: flex-start;align-items: flex-start">
                <label class="w-40" for="CampaignDescription">Campaign Description</label>
                <textarea class="form-control w-60" id="CampaignDescription" name="Campaign_Description" rows="3" placeholder="Campaign Description" required style="border: none;height: 120px;padding:10px;font-size: 1rem;border-radius: 10px" maxlength="300"></textarea>
            </div>

        </div>
        <div class="d-flex align-items-center justify-content-center gap-2">
            <button class="btn btn-success w-25" id="button" value="Create"> Create </button>
            <button class="btn btn-danger w-25" id="button" value="Cancel"> Cancel </button>
        </div>
    </form>
<!--    <div class="w-40 d-flex justify-content-center flex-column align-items-center gap-1 bg-white border-radius-10 p-1 m-1">-->
<!--        <h3> Read the Guidelines </h3>-->
<!--        <p class="p-1">-->
<!--            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusantium adipisci aliquid autem corporis dolorum eaque-->
<!--            eum fugiat harum iusto nam nesciunt nihil non nostrum placeat possimus quia quibusdam quod similique, temporibus unde-->
<!--            velit veniam vitae. Aliquam consequuntur, culpa dicta ducimus ea eos explicabo harum impedit iste libero magni nesciunt-->
<!--            nostrum odit officia optio praesentium quia rem repellat, rerum sed sequi similique sint suscipit tempora tempore ut vitae-->
<!--            voluptate. Aspernatur autem delectus deserunt dicta dolor doloribus dolorum eum inventore itaque pariatur quaerat quia quibusdam-->
<!--            quisquam repellendus, reprehenderit tenetur voluptatum! A ad animi, aspernatur cum cumque cupiditate doloremque eius illo labore minima neque odio-->
<!--            perspiciatis quam quasi quia quisquam quo quod totam veniam voluptatem. Ab aliquid animi at consequuntur dolor est et eveniet fuga-->
<!--            id itaque laborum maxime necessitatibus nihil nulla omnis, quaerat, quia, quisquam ratione repellendus similique sit tempore totam.-->
<!--            Accusantium aperiam asperiores aut dicta eaque earum, eligendi eum facere nisi, quasi sit, tempore! Architecto, autem commodi deleniti-->
<!--            dolorum eveniet id iusto nihil quibusdam? Aliquid aspernatur culpa dicta magni, molestiae nam placeat repellat sapiente sunt voluptatem!-->
<!--            Distinctio doloremque dolores dolorum, eaque earum expedita explicabo fuga harum hic illum impedit, modi nisi nulla suscipit vitae! Ad-->
<!--            deleniti excepturi fugit, natus quae veniam!-->
<!--        </p>-->
<!--    </div>-->
</div>
<script>
    function read(){
        let select = document.getElementById('error');
        if(select.selectedIndex === 1){
            document.getElementById('errors').style.visibility = 'visible';
            document.getElementById('button').disabled = true;
            document.getElementById('button').style.backgroundColor = '#F5F5F5';
            document.getElementById('button').style.color = 'black';
        }else{
            document.getElementById('errors').style.visibility = 'hidden';
            document.getElementById('button').disabled = false;
            document.getElementById('button').style.backgroundColor = 'rgba(251, 0, 0, 0.7)';
            document.getElementById('button').style.color = 'white';
        }
    }
    let map;
    function initMap() {
        const colombo = { lat: 6.8781340776734385, lng: 79.8833214428759 };
        var sriLankaBounds = {
            north: 9.9355,
            south: 5.575,
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

        const input = document.getElementById("pac-input");
        const searchBox = new google.maps.places.SearchBox(input);
        // Change CSS of search box
        input.style.border = "0.5px solid black";
        input.style.marginTop = "10px";
        map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

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
        // Configure the click listener.
        const marker = new google.maps.Marker({
            map: map,
        });

        map.addListener("click", (mapsMouseEvent) => {
            const lat = mapsMouseEvent.latLng.lat();
            const lng = mapsMouseEvent.latLng.lng();
            document.getElementById('Latitude').value = lat;
            document.getElementById('Longitude').value = lng;
            marker.setPosition(mapsMouseEvent.latLng);
        });

    }

    function SelectLocation(){
        OpenDialogBox({
            id: 'location',
            title: 'Select Campaign Location',
            titleClass: 'bg-dark text-white',
            content: `
                    <div style="display: none;">
                        <label for="pac-input"></label>
                        <input
                                id="pac-input"
                                style="width:40%;font-size: large;text-align: center"
                                type="text"
                                placeholder="Enter a location"
                        />
                    </div>
                    <div class="" id="map" style="height: 400px; width: 100%;"></div>
                `,
            successBtnText: 'Select',
            successBtnAction: function () {
                const lat = document.getElementById('Latitude').value;
                const lng = document.getElementById('Longitude').value;
                if(lat === '' || lng === ''){
                    ShowToast({
                        type: 'error',
                        message: 'Please select a location'
                    })
                }else{
                    const button = document.getElementById('SelectLocationBtn');
                    button.classList.remove('btn-info');
                    button.classList.add('btn-success');
                    button.getElementsByTagName('span')[0].innerHTML = 'Location Selected';
                    button.getElementsByTagName('img')[0].src = '/public/icons/addedLocation.svg';
                    CloseDialogBox('location');

                }
            },
        })
        initMap();

    }
    function AcceptGuidelines() {
        OpenDialogBox({
            id: 'guidelines',
            title: 'Accept the Guidelines',
            titleClass: 'bg-dark text-white',
            content: `
                    <div class="w-100 d-flex justify-content-center flex-column align-items-center gap-1">
                        <div class="bg-dark text-center text-white px-2 py-1">
                            <h5> Lorem ipsum dolor sit amet, consectetur adipisicing elit. </h5>
                        </div>
                        <p class="p-1">
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusantium adipisci aliquid autem corporis dolorum eaque
                            eum fugiat harum iusto nam nesciunt nihil non nostrum placeat possimus quia quibusdam quod similique, temporibus unde
                            velit veniam vitae. Aliquam consequuntur, culpa dicta ducimus ea eos explicabo harum impedit iste libero magni nesciunt
                            nostrum odit officia optio praesentium quia rem repellat, rerum sed sequi similique sint suscipit tempora tempore ut vitae
                            voluptate. Aspernatur autem delectus deserunt dicta dolor doloribus dolorum eum inventore itaque pariatur quaerat quia quibusdam
                            quisquam repellendus, reprehenderit tenetur voluptatum! A ad animi, aspernatur cum cumque cupiditate doloremque eius illo labore minima neque odio
                            perspiciatis quam quasi quia quisquam quo quod totam veniam voluptatem. Ab aliquid animi at consequuntur dolor est et eveniet fuga
                            id itaque laborum maxime necessitatibus nihil nulla omnis, quaerat, quia, quisquam ratione repellendus similique sit tempore totam.
                            Accusantium aperiam asperiores aut dicta eaque earum, eligendi eum facere nisi, quasi sit, tempore! Architecto, autem commodi deleniti
                            dolorum eveniet id iusto nihil quibusdam? Aliquid aspernatur culpa dicta magni, molestiae nam placeat repellat sapiente sunt voluptatem!
                            Distinctio doloremque dolores dolorum, eaque earum expedita explicabo fuga harum hic illum impedit, modi nisi nulla suscipit vitae! Ad
                            deleniti excepturi fugit, natus quae veniam!
                        </p>
                        <p class="p-1">
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusantium adipisci aliquid autem corporis dolorum eaque
                            eum fugiat harum iusto nam nesciunt nihil non nostrum placeat possimus quia quibusdam quod similique, temporibus unde
                            velit veniam vitae. Aliquam consequuntur, culpa dicta ducimus ea eos explicabo harum impedit iste libero magni nesciunt
                            nostrum odit officia optio praesentium quia rem repellat, rerum sed sequi similique sint suscipit tempora tempore ut vitae
                            voluptate. Aspernatur autem delectus deserunt dicta dolor doloribus dolorum eum inventore itaque pariatur quaerat quia quibusdam
                            quisquam repellendus, reprehenderit tenetur voluptatum! A ad animi, aspernatur cum cumque cupiditate doloremque eius illo labore minima neque odio
                            perspiciatis quam quasi quia quisquam quo quod totam veniam voluptatem. Ab aliquid animi at consequuntur dolor est et eveniet fuga
                            id itaque laborum maxime necessitatibus nihil nulla omnis, quaerat, quia, quisquam ratione repellendus similique sit tempore totam.
                            Accusantium aperiam asperiores aut dicta eaque earum, eligendi eum facere nisi, quasi sit, tempore! Architecto, autem commodi deleniti
                            dolorum eveniet id iusto nihil quibusdam? Aliquid aspernatur culpa dicta magni, molestiae nam placeat repellat sapiente sunt voluptatem!
                            Distinctio doloremque dolores dolorum, eaque earum expedita explicabo fuga harum hic illum impedit, modi nisi nulla suscipit vitae! Ad
                            deleniti excepturi fugit, natus quae veniam!
                        </p>
                        <p class="p-1">
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusantium adipisci aliquid autem corporis dolorum eaque
                            eum fugiat harum iusto nam nesciunt nihil non nostrum placeat possimus quia quibusdam quod similique, temporibus unde
                            velit veniam vitae. Aliquam consequuntur, culpa dicta ducimus ea eos explicabo harum impedit iste libero magni nesciunt
                            nostrum odit officia optio praesentium quia rem repellat, rerum sed sequi similique sint suscipit tempora tempore ut vitae
                            voluptate. Aspernatur autem delectus deserunt dicta dolor doloribus dolorum eum inventore itaque pariatur quaerat quia quibusdam
                            quisquam repellendus, reprehenderit tenetur voluptatum! A ad animi, aspernatur cum cumque cupiditate doloremque eius illo labore minima neque odio
                            perspiciatis quam quasi quia quisquam quo quod totam veniam voluptatem. Ab aliquid animi at consequuntur dolor est et eveniet fuga
                            id itaque laborum maxime necessitatibus nihil nulla omnis, quaerat, quia, quisquam ratione repellendus similique sit tempore totam.
                            Accusantium aperiam asperiores aut dicta eaque earum, eligendi eum facere nisi, quasi sit, tempore! Architecto, autem commodi deleniti
                            dolorum eveniet id iusto nihil quibusdam? Aliquid aspernatur culpa dicta magni, molestiae nam placeat repellat sapiente sunt voluptatem!
                            Distinctio doloremque dolores dolorum, eaque earum expedita explicabo fuga harum hic illum impedit, modi nisi nulla suscipit vitae! Ad
                            deleniti excepturi fugit, natus quae veniam!
                        </p>

                    </div>
            `,
            showCloseButton: true,
            showCancelButton: true,
            cancelButtonText: 'Reject',
            successBtnText: 'Accept',
            successBtnAction:()=>{
                document.getElementById('Agreed').value = 'true';
                CloseDialogBox();
                const form = document.getElementById('form');
                form.submit();
            }
        })
    }
</script>

