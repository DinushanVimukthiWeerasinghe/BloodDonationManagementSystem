const Loader=document.getElementById('loader');
const Months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
const Search = (path,type='')=>{
    const url=path;
    const q=document.getElementById('search').value;
    const Form = new FormData();
    Form.append('q',q)
    Form.append('type',type)
    fetch(path,{
        method : 'POST',
        body : Form

    })
        .then((res)=>res.text())
        .then((data)=>{
            console.log(data)
            Loader.classList.remove('none');
            const DP = new DOMParser();
            const Doc = DP.parseFromString(data,'text/html');
            document.getElementById('content').innerHTML=Doc.getElementById('content').innerHTML;
            if (type ==='assign'){

            }
            setTimeout(()=>{
                Loader.classList.add('none')
            },500)
        })

}
window.onload = () => {
    if (Loader) {
        setTimeout(() => {
            Loader.classList.add('none')
        }, 500)
    }
}
const ShowLoader = () => {
    Loader.classList.remove('none')
}
const HideLoader = () => {
    Loader.classList.add('none')
}

const ViewCampaignRequest = (id) =>{
    const url = '/manager/mngCampaign/view?id='+id;
    const form = new FormData();
    form.append('id',id);
    fetch(url,{
        method : 'POST',
        body : form
    })
        .then((res)=>res.json())
        .then((data)=>{

            if (data.status) {
                let VerificationDetails = 'Not Verified';
                console.log(data.data)
                if (data.approved) {
                    const date = new Date(data.approved.Approved_At);
                    const year = date.getFullYear();
                    const month = Months[date.getMonth()];
                    const day = date.getDate();
                    const hours = date.getHours();
                    const minutes = date.getMinutes();
                    data.approved.Approved_At = `${year} - ${month} - ${day} ${hours}:${minutes}`;

                    VerificationDetails = `
                        <div class="d-flex flex-column justify-content-center align-items-center">
                            <div class="d-flex">
                                Verified At : ${data.approved.Approved_At}
                            </div>
                            <div class="d-flex">
                                Remarks : ${data.approved.Remarks}
                            </div>
                        </div>
                    `
                }else if (data.rejected){
                    const date = new Date(data.rejected.Rejected_At);
                    const year = date.getFullYear();
                    const month = Months[date.getMonth()];
                    const day = date.getDate();
                    const hours = date.getHours();
                    const minutes = date.getMinutes();
                    data.rejected.Rejected_At = `${year} - ${month} - ${day} ${hours}:${minutes}`;

                    VerificationDetails = `
                        <div class="d-flex flex-column justify-content-center align-items-center">
                            <div class="d-flex">
                                Rejected At : ${data.rejected.Rejected_At}
                            </div>
                            <div class="d-flex">
                                Remarks : ${data.rejected.Remarks}
                            </div>
                        </div>
                    `
                }
                console.log(data)
                OpenDialogBox({
                    id: 'viewCampaignRequest',
                    title: 'Campaign Request',
                    content: `
                    <div class="d-flex flex-column">
                        <div class="d-flex flex-column w-100 justify-content-center align-items-center">
                            <div class="d-flex font-bold my-1 w-100 text-center justify-content-center align-items-center bg-dark py-1 px-2 text-center text-white">Campaign Details</div>
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
                        <div class="d-flex flex-column w-100 justify-content-center align-items-center">
                            <div class="d-flex w-100 font-bold my-1 text-center justify-content-center align-items-center bg-dark py-1 px-2 text-center text-white">Organization Details</div>
                            <div class="d-flex">
                                        <span class="font-bold">Organization Name </span> : <span>${data.org.Organization_Name}</span>
                            </div>
                            <div class="d-flex">
                                        City : ${data.org.City}
                            </div>
                            <div class="d-flex">
                                        Contact : ${data.org.Contact_No}
                            </div>
                            <div class="d-flex">
                                        Email : ${data.org.Organization_Email}
                            </div>
                        </div>
                        <div class="d-flex flex-column w-100">
                            <div class="d-flex w-100 font-bold my-1 text-center justify-content-center align-items-center bg-dark py-1 px-2 text-center text-white">Verification Details</div>
                            `+VerificationDetails+`
                        </div>
                `,
                    showSuccessButton: false,
                    cancelBtnText: 'Close',
                })
                initMap(parseFloat(data.data.Latitude),parseFloat(data.data.Longitude));
            }
        })
}

function initMap(latitude,longitude) {
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
const AssignTeam=(id) =>{
    window.location.href = "/manager/mngCampaign/assign-team?campId="+id;
}

const AssignTeamLeader = (id) =>{
    const url = "/manager/mngCampaign/assign-team/get-members";
    const formData = new FormData();
    formData.append('campId', id);
    fetch(url, {
        method: 'POST',
        body: formData
    }).then(response => response.json())
        .then(data => {
            if (data.status) {
                console.log(data)
                let options = '';
                data.data.forEach((member) => {
                    options += `<option value="${member.Member_ID}">${member.Name} - ${member.NIC}</option>`
                })
                OpenDialogBox({
                    id: 'assignTeamLeader',
                    title: 'Assign Team Leader',
                    titleClass: 'bg-dark text-white',
                    content: `
            <div class="d-flex flex-column justify-content-center align-items-center">
            <div class="form-group">
                <label for="teamLeader" class="w-40">Team Leader</label>
                <select class="form-control w-60" id="teamLeader">
                    ${options}
                </select>
            </div>
            `,
                    successBtnText: 'Assign',
                    successBtnClass: 'btn-success',
                    successBtnAction: () => {
                        const url = '/manager/mngCampaign/assign-team/assign-leader';
                        const form = new FormData();
                        form.append('campId', id);
                        form.append('teamLeaderId', document.getElementById('teamLeader').value);
                        fetch(url, {
                            method: 'POST',
                            body: form
                        }).then(response => response.json())
                            .then(data => {
                                CloseDialogBox('assignTeamLeader');
                                if (data.status){
                                    ShowToast({
                                        type: 'success',
                                        message: data.message
                                    })
                                }else{
                                    ShowToast({
                                        type: 'error',
                                        message: data.message
                                    })
                                }
                            })
                    }
                })
            }
        })

}

const AcceptCampaignRequest = (id) =>{
    OpenDialogBox({
        id: 'acceptCampaignRequest',
        title: 'Accept Campaign Request',
        titleClass: 'bg-dark text-white',
        content: `
            <div class="d-flex flex-column justify-content-center align-items-center">
            <div class="form-group">
                <label for="remarks">Remarks</label>
                <textarea style="height: 150px" class="form-control" id="remarks" rows="3"></textarea>
            </div>
            `,
        successBtnText: 'Accept',
        successBtnClass: 'btn-success',
        successBtnAction: () => {
            const url = '/manager/mngCampaign/accept';
            const form = new FormData();
            form.append('id',id);
            form.append('remarks',document.getElementById('remarks').value);
            fetch(url,{
                method : 'POST',
                body : form
            })
                .then((res)=>res.json())
                .then((data)=>{
                    if (data.status){
                        CloseDialogBox('acceptCampaignRequest');
                        ShowToast({
                            title: 'success',
                            message: data.message,
                        })
                        setTimeout(()=>{
                            window.location.reload();
                        },2000)
                    }else{
                        CloseDialogBox('acceptCampaignRequest');
                        ShowToast({
                            title: 'error',
                            message: data.message,
                        });
                    }
                })
        }
    })
}
const RejectCampaignRequest = (id) =>{
    OpenDialogBox({
        id: 'rejectCampaignRequest',
        title: 'Reject Campaign Request',
        content: `
            <div class="d-flex flex-column justify-content-center align-items-center">
                <div class="form-group">
                    <label for="remarks">Remarks</label>
                    <textarea style="height: 150px" class="form-control" id="remarks" rows="3"></textarea>
                </div>
            </div>
            `,
        successBtnText: 'Reject',
        successBtnClass: 'btn-danger',
        successBtnAction: () => {
            const url = '/manager/mngCampaign/reject?id='+id;
            const form = new FormData();
            form.append('id',id);
            form.append('remarks',document.getElementById('remarks').value);
            fetch(url,{
                method : 'POST',
                body : form
            })
                .then((res)=>res.json())
                .then((data)=>{
                    if (data.status) {
                        CloseDialogBox('rejectCampaignRequest');
                        ShowToast({
                            title: 'success',
                            message: data.message,
                        })
                        setTimeout(()=>{
                            window.location.reload();
                        },2000)
                    }
                })
        }
    })
}

