const Loader=document.getElementById('loader');
const Search = (path,type='')=>{
    console.log(this);
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
                if (data.data.Verified == 1) {
                    VerificationDetails = `
                        <div class="d-flex flex-column justify-content-center align-items-center">
                            <div class="d-flex">
                                Verified At : ${data.data.Verified_At}
                            </div>
                            <div class="d-flex">
                                Remarks : ${data.data.Remarks}
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
                            <div class="d-flex font-bold my-1 w-100 text-center justify-content-center align-items-center">Campaign Details</div>
                            <div class="d-flex">
                                        Name : ${data.data.Campaign_Name}
                                    </div>
                            <div class="d-flex">
                                        Date : ${data.data.Campaign_Date}
                                    </div>
                            <div class="d-flex">
                                        Description : ${data.data.Campaign_Description}
                                    </div>
                            <div class="d-flex">
                                        Venue : ${data.data.Venue}
                                    </div>
                            <div class="d-flex">
                                        Description : ${data.data.Campaign_Description}
                                    </div>
                        </div>
                        <div class="d-flex flex-column w-100">
                            <div class="d-flex w-100 font-bold my-1 text-center justify-content-center align-items-center">Verification Details</div>
                            `+VerificationDetails+`
                        </div>
                        <div class="d-flex flex-column w-100 justify-content-center align-items-center">
                            <div class="d-flex w-100 font-bold my-1 text-center justify-content-center align-items-center">Organization Details</div>
                            <div class="d-flex">
                                        Name : ${data.org.Organization_Name}
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
                `,
                })
            }
        })
}

const AssignTeam = (id) =>{
    window.location.href = '/manager/mngCampaign/assignTeam?campId='+id;
}

const AcceptCampaignRequest = (id) =>{
    console.log("Accept Campaign Request")
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
                        window.location.reload();
                    }
                })
        }
    })
}

