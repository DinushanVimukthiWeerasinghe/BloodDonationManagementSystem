const ResetPassword = (id)=>{
    OpenDialogBox({
        title: "Reset Password",
        titleClass:' bg-dark text-white text-center',
        content: "Are you sure you want to reset the password of this user ?",
        successBtnText: "Yes",
        cancelBtnText: "No",
        successBtnAction: ()=>{
            const formData = new FormData();
            formData.append('id', id);
            fetch('/user/resetPassword', {
                method: 'POST',
                body: formData
            })
                .then(res => res.json())
                .then(data => {
                    if(data.status === true){
                        ShowToast({
                            message: data.message,
                            type: 'success',
                            timeout:6000
                        })
                    }else{
                        ShowToast({
                            message: data.message,
                            type: 'danger',
                            timeout:6000
                        })
                    }
                })
            CloseDialogBox();
        },
        cancelBtnAction: ()=>{
            CloseDialogBox();
        }
    })

}


const ViewUser = (type="Donor")=>{
    const url = "/admin/dashboard/manageUsers?Role="+type;
    fetch(url,{
        method: "GET",
        headers: {
            'Content-Type': 'text/html'
        }
    })
        .then(response => response.text())
        .then(async (data) => {
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
            const Role = document.querySelectorAll('[id="Role"]');
            const TotalActiveUsers = document.getElementById('TotalActive');
            const TotalDeactivatedUsers = document.getElementById('TotalDeactivated');
            const TotalBannedUsers = document.getElementById('TotalBanned');
            const Search = document.getElementById('Search');
            TotalActiveUsers.innerHTML = doc.getElementById('TotalActive').innerHTML;
            TotalDeactivatedUsers.innerHTML = doc.getElementById('TotalDeactivated').innerHTML;
            TotalBannedUsers.innerHTML = doc.getElementById('TotalBanned').innerHTML;
            Search.innerHTML = doc.getElementById('Search').innerHTML;

            for(let i=0; i<Role.length; i++){
                Role[i].innerHTML = type;
            }
            document.getElementById('userTable').innerHTML = doc.getElementById('userTable').innerHTML;
            const addBtn = document.getElementById('addNewUser');
            if(type==='Hospital'){
                addBtn.hidden=false;
                addBtn.classList.remove('none')
                addBtn.innerHTML = '<i class="fa-solid fa-plus"></i> Add New ' + type;
                addBtn.onclick = addNewHospital;
            }else if(type==='Manager'){
                addBtn.hidden=false;
                addBtn.classList.remove('none')
                addBtn.innerHTML = '<i class="fa-solid fa-plus"></i>Add New ' + type;
                addBtn.onclick = AddNewManager;
            }else{
                addBtn.hidden=true;
                addBtn.classList.add('none')
            }
        })
}

const fun2 = ()=>{
    ShowToast({
        message: 'This is a toast message',
        type: 'success'
    });
}

const ReActivateUser = (id)=>{
    OpenDialogBox({
        title: "Re-Activate User",
        titleClass:' bg-dark text-white text-center',
        content: "Are you sure you want to re-activate this user ?",
        successBtnText: "Yes",
        cancelBtnText: "No",
        successBtnAction: ()=>{
            const formData = new FormData();
            formData.append('id', id);
            fetch('/user/reActivateUser', {
                method: 'POST',
                body: formData
            })
                .then(res => res.json())
                .then(data => {
                    if(data.status === true){
                        if (data.role){
                            ViewUser(data.role);
                        }

                        ShowToast({
                            message: data.message,
                            type: 'success',
                            timeout:6000
                        })
                    }else{
                        ShowToast({
                            message: data.message,
                            type: 'danger',
                            timeout:6000
                        })
                    }
                })
            CloseDialogBox();
        }
    })
}

const DeactivateUser = (id)=>{
    OpenDialogBox({
        title: "Deactivate User",
        titleClass:' bg-dark text-white text-center',
        content: "Are you sure you want to deactivate this user ?",
        successBtnText: "Yes",
        cancelBtnText: "No",
        successBtnAction: ()=>{
            const formData = new FormData();
            formData.append('id', id);
            fetch('/user/deactivateUser', {
                method: 'POST',
                body: formData
            })
                .then(res => res.json())
                .then(data => {
                    if(data.status === true){
                        if (data.role){
                            ViewUser(data.role);
                        }
                        ShowToast({
                            message: data.message,
                            type: 'success',
                            timeout:6000
                        })
                    }else{
                        ShowToast({
                            message: data.message,
                            type: 'danger',
                            timeout:6000
                        })
                    }
                })
            CloseDialogBox();
        }
    })
}

const ActivateUser = (id)=>{
    OpenDialogBox({
        title: "Activate User",
        titleClass:' bg-dark text-white text-center',
        content: "Are you sure you want to activate this user ?",
        successBtnText: "Yes",
        cancelBtnText: "No",
        successBtnAction: ()=>{
            const formData = new FormData();
            formData.append('id', id);
            fetch('/user/activateUser', {
                method: 'POST',
                body: formData
            })
                .then(res => res.json())
                .then(data => {
                    if(data.status === true){
                        if (data.role){
                            ViewUser(data.role);
                        }
                        ShowToast({
                            message: data.message,
                            type: 'success',
                            timeout:6000
                        })
                    }else{
                        ShowToast({
                            message: data.message,
                            type: 'danger',
                            timeout:6000
                        })
                    }
                })
            CloseDialogBox();
        }
    })
}
const RemoveUser = (id)=>{
    OpenDialogBox({
            title: "Remove User",
            titleClass:' bg-dark text-white text-center',
            content: "Are you sure you want to remove this user ?",
            successBtnText: "Yes",
            cancelBtnText: "No",
            successBtnAction: () => {
                CloseDialogBox();
                OpenDialogBox({
                    title: "Dangerous Action",
                    content: "This action is irreversible. Are you really sure you want to remove this user ?",
                    successBtnText: "Yes",
                    cancelBtnText: "No",
                    popupOrder:1,
                    successBtnAction: () => {
                        const formData = new FormData();
                        formData.append('id', id);
                        fetch('/user/removeUser', {
                            method: 'POST',
                            body: formData
                        })
                            .then(res => res.json())
                            .then(data => {
                                if (data.status === true) {
                                    if (data.role){
                                        ViewUser(data.role);
                                    }
                                    ShowToast({
                                        message: data.message,
                                        type: 'success',
                                        timeout: 6000
                                    })
                                } else {
                                    ShowToast({
                                        message: data.message,
                                        type: 'danger',
                                        timeout: 6000
                                    })
                                }
                            })
                        CloseDialogBox();
                    },
                    cancelBtnAction: () => {
                        CloseDialogBox();
                    }
                })
            },
            cancelBtnAction: () => {
                CloseDialogBox();
            }
        })
}


const SearchUser = (role)=>{
    const Search = document.getElementsByName('Search')[0].value.trim();
    const formData = new FormData();
    formData.append('Search', Search);
    formData.append('Role', role);
    fetch('/user/searchUser', {
        method: 'POST',
        body: formData
    })
        .then(res => res.text())
        .then(data => {
            //console.log(data)
            document.getElementById('userTable').innerHTML = data;
        })
}
//
const addNewHospital = () => {
    OpenDialogBox({
        title: 'Add New Hospital',
        id: 'addNewHospital',
        content: `<form method="post" action="/admin/manageHospital/addHospital" id="addHospitalForm">
            <input type="email" name="Email" id="email" placeholder="E-Mail for Hospital">
            <input type="password" name="password" id="password" placeholder="Password">
            <input type="text" name="Hospital_Name" id="name" placeholder="Hospital Name">
            <input type="text" name="Address1" id="address1" placeholder="Address Line 1">
            <input type="text" name="Address2" id="address2" placeholder="Address Line 1">
            <input type="text" name="City" id="city" placeholder="City">
            <input type="tel" name="Contact_No" id="contactNo" placeholder="Contact Number">
        </form>`,
        successBtnAction: () => {
            document.getElementById('addHospitalForm').submit();
            CloseDialogBox();
        },
        cancelBtnAction: () => {
            CloseDialogBox();
        }
        })
}
// const addNewManager = () => {
//     OpenDialogBox({
//         title: 'Add New Manager',
//         id: 'addNewManager',
//     })
// }
