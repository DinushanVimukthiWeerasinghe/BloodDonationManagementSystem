const VerifyDonor = () => {
    OpenDialogBox({
        id: "verify-donor",
        title: "Verify Donor",
        content: `<div class="form-group">
            <label for="donor-id">Donor NIC</label>
            <input type="text" class="form-control" id="donor-nic" placeholder="Enter donor NIC">`,
        successBtnAction: () => {
            const NIC = document.getElementById("donor-nic").value
            const formData = new FormData()
            formData.append("nic", NIC)
            fetch("/medicalofficer/get-donor", {
                method: "POST",
                body: formData
            }).then(res => res.json())
                .then(data => {
                    if (data.status){
                        CloseDialogBox("verify-donor")
                        OpenDialogBox({
                            title: "Verify Details",
                            content: `
                            <div class="form-group">
                                <label class="w-40" for="donor-id">Donor Name</label>
                                <div class="form-control w-60 d-flex align-items-center justify-content-center">${data.donor.name}</div>
                            </div>
                            <div class="form-group">
                                <label class="w-40" for="donor-id">Donor NIC</label>
                                <div class="form-control w-60 d-flex align-items-center justify-content-center">${data.donor.nic}</div>
                            </div>
                            <div class="form-group">
                                <label class="w-40" for="donor-id">Donor Gender</label>
                                <div class="form-control w-60 d-flex align-items-center justify-content-center">${data.donor.gender}</div>
                            </div>
                            <div class="form-group">
                                <label class="w-40" for="donor-id">Donor Address</label>
                                <div class="form-control w-60 d-flex align-items-center justify-content-center">${data.donor.address}</div>
                            </div>
                            `,
                            successBtnText: "Verify",
                            cancelBtnText: "Cancel",
                                secondaryBtnText: "Reject",
                            secondaryBtnAction: () => {
                                console.log("reject")
                            },
                            successBtnAction: () => {
                                const formData = new FormData()
                                formData.append("nic", NIC)
                                fetch("/medicalofficer/verify-donor", {
                                    method: "POST",
                                    body: formData
                                }).then(res => res.json())
                                    .then(data => {
                                        if (data.success){
                                            OpenDialogBox({
                                                title: "Success",
                                                content: "Donor verified successfully",
                                                successBtnAction: () => {
                                                    location.reload()
                                                }
                                            })
                                        } else {
                                            OpenDialogBox({
                                                title: "Error",
                                                content: data.message
                                            })
                                        }
                                    })
                            }
                            
                            
                        }
                        )
                    }
                })
        }
    })
}

const SendEmail = () => {
    const email=document.getElementById('Email').value;
    OpenDialogBox({
        id: "send-email",
        title: "Send Email",
        content: `
            <div class="flex">
                <div class="form-group">
                    <label for='email' class=" w-30">Email</label>
                    <input type="email" class="form-control w-70" id="email" placeholder="Enter email" value="`+email+`">
                </div>
                <div class="form-group">
                    <label for='subject' class="w-30">Subject</label>
                    <input type="text" class="form-control w-70" id="subject" placeholder="Enter subject">
                </div>
                <div class="form-group">
                    <label for="content" class=" w-30">Content</label>
                    <textarea class="form-control w-70" style="height: 100px" id="content" placeholder="Enter Message"></textarea>
                </div>
            </div>`,
        successBtnText: 'Send Email',
        cancelBtnText: 'Cancel',
        successBtnAction : ()=>{
            console.log("Email Sent");
        }
    });
}

const EditOfficer = (e)=>{
    const form = document.querySelector('form')
    const Input = form.querySelectorAll('input')
    for (let i = 0; i < Input.length; i++) {
        Input[i].disabled = false
    }
    const editBtn = document.getElementById('edit-btn')
    editBtn.innerText = 'Save'
    editBtn.onclick = SaveOfficer
    editBtn.classList.remove('btn-primary')
    editBtn.classList.add('btn-success')

}

const SaveOfficer = (e)=>{
    ShowToast({
        type: "success",
        message: "Officer details updated successfully",
    })
}

const DeleteOfficer = (id)=>{
    OpenDialogBox({
        id: "delete-officer",
        title: "Delete Officer",
        content: "Are you sure you want to delete this officer?",
        successBtnText: "Delete",
        cancelBtnText: "Cancel",
        successBtnAction: () => {
            const url="/manager/mngMedicalOfficer/delete";
            const formData = new FormData();
            formData.append("id", id);
            fetch(url, {
                method: "POST",
                body: formData
            }).then(res => res.text())
                .then(data => {
                    console.log(data)
                    if (data.success){
                        OpenDialogBox({
                            title: "Success",
                            content: "Officer deleted successfully",
                            successBtnAction: () => {
                                // window.location.href = "/manager/mngMedicalOfficer"
                            }
                        })
                    } else {
                        OpenDialogBox({
                            title: "Error",
                            content: data.message
                        })
                    }
            })
        }
    })
}
