    const SearchBank = ()=>{
    const Search = document.getElementsByName('Search')[0].value.trim();
    const formData = new FormData();
    formData.append('Search', Search);
    console.log(formData);
    fetch('/admin/dashboard/manageBanks/search', {
    method: 'POST',
    body: formData
})
    .then(res => res.json())
    .then(data => {
    document.getElementById('bankTable').remove();
    const newTable = document.getElementById('div1').appendChild(document.createElement('table'));
    newTable.id = 'bankTable';
    newTable.innerHTML=
    `<tr>
                    <th>Blood Bank ID</th>
                    <th>Blood Bank Name</th>
                    <th>Address</th>
                    <th>City</th>
                    <th>Telephone Number</th>
                    <th>Number Of Doctors</th>
                    <th>Number Of Nurses</th>
                    <th>Number Of Beds</th>
                    <th>Number Of Storages</th>
                    <th>Type</th>
                    <th>Edit Bank</th>
                </tr>`;
    for (const bank of data) {
    const newTr = document.getElementById('bankTable').appendChild(document.createElement('tr'));
    newTr.className = 'bg-white-0-7 tableRows';
    newTr.id = bank['id'];
    for (const values in bank) {
    const newTd = newTr.appendChild(document.createElement('td'));
    newTd.innerHTML = bank[values];
    // console.log(bank[values]);
}
    newTr.appendChild(document.createElement('td')).innerHTML =`
                    <button type="button" class="btn btn-success" onclick="editBnkData('${bank['id']}')">
                        <img src="/public/icons/edit.png" width="24px" alt="">
                    </button>`;
}
})
}

    function addNewBank() {
    OpenDialogBox({
            id: 'addBankPop',
            title: 'Add Bank',
            content: `<form id="addBankForm" action="/admin/dashboard/manageBanks/add" method="post">
                            <label for="bank_name">Bank Name</label>
                            <input type="text" name="BankName" placeholder="Bank Name">
                            <label for="address">Address</label>
                            <input type="text" name="Address1" placeholder="Address Line 01">
                            <input type="text" name="Address2" placeholder="Address Line 02">
                            <label for="city">City</label>
                            <input type="text" name="City" placeholder="City">
                            <label for="telephone">Telephone</label>
                            <input type="text" name="Telephone_No" placeholder="Telephone Number">
                            <label for="numberOfDoctors">Number of Doctors</label>
                            <input type="text" name="No_Of_Doctors" placeholder="Number Of Doctors">
                            <label for="numberOfNurses">Number Of Nurses</label>
                            <input type="text" name="No_Of_Nurses" placeholder="Number Of Nurses">
                            <label for="numberOfBeds">Number Of Beds</label>
                            <input type="text" name="No_Of_Beds" placeholder="Number Of Beds">
                            <label for="numberOfStorages">Number Of Storages</label>
                            <input type="text" name="No_Of_Storages" placeholder="Number Of Storages">
                            <label for="type">Type</label>
<!--                            <input type="text" name="Type" placeholder="Type (0/1)">-->
                            <select id="type" name="Type">
                                <option value="1">Branch</option>
                                <option value="2">Main</option>
                            </select>
                        </form>`,
            //closeDialog,
            successBtnText: 'Add New Blood Bank',
            //cancelBtnText,
            //closeDialogBtn,
            successBtnAction:()=>{
                document.getElementById('addBankForm').submit();
            }
            //cancelBtnAction,
            //popupOrder,
            //showCancelButton
        }
    )
}

    function editBnkData(tr){
//        document.getElementsByName(tr);
    let data = document.getElementById(tr).valueOf().innerText.split('\t');
    // console.log(data);
    // for (let i in data){
    //      console.log(data[i]);
    // }
    //console.log(tr);        //console.log(id);
    OpenDialogBox({
    id: 'editBankPop',
    title: 'Edit Data',
    content: `<form id="editBankForm" action="/admin/dashboard/manageBanks/edit" method="post">
                            <input type="hidden" name="BloodBank_ID" value="${data[0]}">
                            <label for="bank_name">Bank Name</label>
                            <input type="text" name="BankName" value="${data[1]}">
                            <label for="address">Address</label>
                            <input type="text" name="Address1" value="${data[2].split(', ')[0]}">
                            <input type="text" name="Address2" value="${data[2].split(', ')[1]}">
                            <label for="city">City</label>
                            <input type="text" name="City" value="${data[3]}">
                            <label for="telephone">Telephone</label>
                            <input type="text" name="Telephone_No" value="${data[4]}">
                            <label for="numberOfDoctors">Number of Doctors</label>
                            <input type="text" name="No_Of_Doctors" value="${data[5]}">
                            <label for="numberOfNurses">Number Of Nurses</label>
                            <input type="text" name="No_Of_Nurses" value="${data[6]}">
                            <label for="numberOfBeds">Number Of Beds</label>
                            <input type="text" name="No_Of_Beds" value="${data[7]}">
                            <label for="numberOfStorages">Number Of Storages</label>
                            <input type="text" name="No_Of_Storages" value="${data[8]}">
                            <label for="type">Blood Bank Type</label>
                            <input type="text" name="typeSave" value="${data[9]}" id="typeSaver" disabled hidden="hidden">
                            <select id="typeSelector" name="Type">
                                <option value="1">Branch</option>
                                <option value="2">Main</option>
                            </select>
                        </form>`,
    //closeDialog,
    successBtnText: 'Save Changes',
    //cancelBtnText,
    //closeDialogBtn,
    successBtnAction:()=>{
    document.getElementById('editBankForm').submit();
},
    secondaryBtnText : 'Remove Bank',
    secondaryBtnAction : () => {
    OpenDialogBox({
    id: 'removeBankConfirmation',
    title: 'Warning',
    content: 'Are you sure you want to remove this bank it is irreversible',
    popupOrder: 10,
    successBtnAction:()=>{
    document.getElementById('editBankForm').action = "/admin/dashboard/manageBanks/delete";
    document.getElementById('editBankForm').submit();
}
})
},
    //cancelBtnAction,
    //popupOrder,
    //showCancelButton
}
    )
        let typeSelector = document.getElementById('typeSelector');
        let typeSaver = document.getElementById('typeSaver');
        // typeSelector.value = typeSaver.value;
        // console.log(typeSelector.value);
        if (typeSaver.value === 'Branch Blood Bank'){
            typeSelector.value = 1;
        }else if(typeSaver.value === 'Main Blood Bank'){
            typeSelector.value = 2;
        }
    }

    function ToggleSideBar(){
    let sideBar = document.querySelector('.side-bar');
    sideBar.classList.toggle('side-bar-compress');
    let topBar = document.querySelector('.top-bar');
    topBar.classList.toggle('top-bar-expand');
    let Content = document.querySelector('.content');
    Content.classList.toggle('content-expand');
}
    let timeoutId=0;
    function KeepLive(param){
    if (param.trim() === ''){
    param = '?layout=none';
}
    else {
    param ='/'+param
}
    let path='/admin/dashboard';
    timeoutId =setInterval(function(){
    let xhr = new XMLHttpRequest()
    xhr.onreadystatechange = function(){
    if(xhr.readyState === 4 && xhr.status === 200){
    console.log(xhr.responseText)
    document.querySelector('.content').innerHTML=this.responseText;
}
}
    xhr.open('GET',path+param);
    xhr.send();
},5000);
}
    function RenderPage(param='')
    {
        if (timeoutId!==0)
    {
        console.log("Cleared");
        clearInterval(timeoutId)
    }
        // KeepLive(param);
        let xhttp=new XMLHttpRequest();
        xhttp.onreadystatechange=function ()
    {
        if (this.readyState===4 && this.status===200)
    {
        if (param.trim()==='')
    {
        param='adminBoard';
    }
        const links=document.getElementsByClassName('side-bar-links')[0].children;
        for (let i=0;i<links.length;i++)
    {
        links[i].classList.remove('side-bar-link-active');
    }
        document.getElementById(param).classList.add('side-bar-link-active');
        document.querySelector('.content').innerHTML=this.responseText;
    }
    }
        Url='/admin/dashboard/'+param;
        if (param.trim()===''){
        Url='/admin/dashboard?layout=none';
        window.location.reload();
    }

        xhttp.open('GET',Url,true);
        xhttp.send();
    }