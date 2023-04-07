const ResetPassword = (id)=>{
    OpenDialogBox({
        title: "Reset Password",
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
                    children[i].children[0].classList.remove('bg-accent');
                    children[i].children[0].classList.add('bg-primary');
                }else{
                    children[i].children[0].classList.remove('bg-primary');
                    children[i].children[0].classList.add('bg-accent');
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
// const AddNewUser = () => {
//     OpenDialogBox(
//         id = 'addNewUser',
//
//     )
// }
