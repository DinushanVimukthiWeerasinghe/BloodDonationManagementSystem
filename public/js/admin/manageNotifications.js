function addNewHospitalNotification() {

    let Hospitals = [];
    const XHR = new XMLHttpRequest();
    XHR.open("GET", "/admin/hospital/getAll", true);
    XHR.setRequestHeader("Content-Type", "application/json");
    XHR.send();
    XHR.onload = function () {
        const hospitalList = JSON.parse(this.responseText);
        // console.log(Object.values(hospitalList));
        Hospitals = Object.keys(hospitalList);

        OpenDialogBox({
            title: "Add New Hospital Notification",
            titleClass:' bg-dark text-white text-center',
            content: `<form id="hospitalNotificationForm" action="/admin/dashboard/manageAlerts/add/hospitalNotification" method="post">
                          <label for="title">Title:</label>
                          <input type="text" id="title" name="title" required><br>
  
                          <label for="message">Message:</label>
                          <textarea id="message" name="message" required></textarea><br>
  
                          <label for="expiration-date">Expiration Date:</label>
                          <input type="date" id="expiration-date" name="expiration-date" required><br>
  
                          <label for="receiver">To</label>
                          <select name="hospitalId" id="hospitalId">
                            <option value="allHospitals" selected>All Hospitals</option>
                          </select>
                        </form>`,
            successBtnText: "Yes",
            successBtnAction: () => {
                document.getElementById('hospitalNotificationForm').submit();
                CloseDialogBox();
            },
            cancelBtnText: "No",
        });

        document.getElementById('expiration-date').min = getDate();


        Hospitals.forEach((hospital)=>{
            let option = document.createElement("option");
            option.value = hospitalList[hospital].HospitalID;
            option.innerText = hospitalList[hospital].HospitalName;
            document.getElementById('hospitalId').appendChild(option);
        });
        // console.log(document.getElementById('hospitalNotificationForm'));
    }
}

function addNewManagerNotification() {

    let Managers = [];
    const XHR = new XMLHttpRequest();
    XHR.open("GET", "/api/managers/getall", true);
    XHR.setRequestHeader("Content-Type", "application/json");
    XHR.send();
    XHR.onload = function () {
        const managerList = JSON.parse(this.responseText);
        // console.log(managerList);
        Managers = Object.keys(managerList);

        OpenDialogBox({
            title: "Add New Manager Notification",
            titleClass:' bg-dark text-white text-center',
            content: `<form id="managerNotificationForm" action="/admin/dashboard/manageAlerts/add/managerNotification" method="post">
                          <label for="title">Title:</label>
                          <input type="text" id="title" name="title" required><br>
  
                          <label for="message">Message:</label>
                          <textarea id="message" name="message" required></textarea><br>
  
                          <label for="expiration-date">Expiration Date:</label>
                          <input type="date" id="expiration-date" name="expiration-date" required><br>
                          
                          <label for="receiver">To</label>
                          <select name="managerId" id="managerId">
                            <option value="allManagers" selected>All Managers</option>
                          </select>
  
                        </form>`,
            successBtnText: "Yes",
            successBtnAction: () => {
                document.getElementById('managerNotificationForm').submit();
            },
            cancelBtnText: "No",
        });

        document.getElementById('expiration-date').min = getDate();

        Managers.forEach((manager)=>{
            let option = document.createElement("option");
            option.value = managerList[manager].id;
            option.innerText = managerList[manager].name;
            document.getElementById('managerId').appendChild(option);
        });
    }
}


const ViewNotification = (type="Manager")=>{
    const url = "/admin/dashboard/manageAlerts?Role="+type;
    fetch(url,{
        method: "GET",
        headers: {
            'Content-Type': 'text/html'
        }
    })
        .then(response => response.text())
        .then(async (data) => {
            // console.log(data);
            const UserCategory = document.getElementById('UserCategory');
            // Get the Children of UserCategory
            const children = UserCategory.children;
            // Loop through the children and remove the active class
            for(let i=0; i<children.length; i++){
                if(children[i].children[0].id===type+'Icon'){
                    children[i].classList.remove('bg-white');
                    children[i].classList.add('bg-primary');
                    children[i].children[1].classList.remove('text-black')
                    children[i].children[1].classList.add('text-white');
                }else{
                    children[i].classList.remove('bg-primary');
                    children[i].classList.add('bg-white');
                    children[i].children[1].classList.remove('text-white')
                    children[i].children[1].classList.add('text-black');
                }
            }

            const DOM = new DOMParser();
            const doc = DOM.parseFromString(data, 'text/html');
            // const Role = document.querySelectorAll('[id="Role"]');
            document.getElementById('ManageBloodBanks').innerHTML = doc.getElementById('ManageBloodBanks').innerHTML;
            // console.log(document.getElementById('ManageBloodBanks'));
            let addbtn =document.getElementById('addNewNotification');
            if (type === 'Hospital'){
                addbtn.onclick = addNewHospitalNotification;
            }else if (type === 'Manager'){
                addbtn.onclick = addNewManagerNotification;
            }
        })
}

// document.getElementById('expiration-date').min = getDate();

function getDate() {

    let d = new Date(),
        month = '' + (d.getMonth() + 1),
        day = '' + d.getDate(),
        year = d.getFullYear();
    if (month.length < 2) {
        month = '0' + month;
    }
    if (day.length < 2) {
        day = '0' + day;

    }
    return [year, month, day].join('-');

}
