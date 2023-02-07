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