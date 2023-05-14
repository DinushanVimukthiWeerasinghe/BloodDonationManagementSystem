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
    if ((data.length === 0)){
        newTable.innerHTML = `<label>No Matching Banks</label>`;
    }
    for (const bank of data) {
    const newTr = document.getElementById('bankTable').appendChild(document.createElement('tr'));
    newTr.className = 'bg-white-0-7 tableRows';
    newTr.id = bank['id'];
    for (const values in bank) {
    const newTd = newTr.appendChild(document.createElement('td'));
    newTd.innerHTML = bank[values];
    // console.log(bank[values]);
    //     console.log(newTd.lastChild);
}
    // console.log(newTr.lastChild)
        if(newTr.lastChild.firstChild.nodeValue === '1'){
            // console.log('branch');
            newTr.lastChild.firstChild.nodeValue = 'Branch';
        }else if(newTr.lastChild.firstChild.nodeValue === '2'){
            newTr.lastChild.firstChild.nodeValue = 'Main';
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
                            <input type="text" id="BankName" name="BankName" placeholder="Bank Name">
                            <label for="address">Address</label>
                            <input type="text" id="Address1" name="Address1" placeholder="Address Line 01">
                            <input type="text" id="Address2" name="Address2" placeholder="Address Line 02">
                            <label for="city">City</label>
                            <input type="text" id="City" name="City" placeholder="City">
                            <label for="telephone">Telephone</label>
                            <input type="text" id="Telephone_No" name="Telephone_No" placeholder="Telephone Number">
                            <label for="numberOfDoctors">Number of Doctors</label>
                            <input type="text" id="No_Of_Doctors" name="No_Of_Doctors" placeholder="Number Of Doctors" value="1">
                            <label for="numberOfNurses">Number Of Nurses</label>
                            <input type="text" id="No_Of_Nurses" name="No_Of_Nurses" placeholder="Number Of Nurses" value="1">
                            <label for="numberOfBeds">Number Of Beds</label>
                            <input type="text" id="No_Of_Beds" name="No_Of_Beds" placeholder="Number Of Beds" value="1">
                            <label for="numberOfStorages">Number Of Storages</label>
                            <input type="text" id="No_Of_Storages" name="No_Of_Storages" placeholder="Number Of Storages" value="1">
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
        document.onkeyup = ()=>{
            let form =document.getElementById('addBankForm');
            let inputFields = form.querySelectorAll('input');
            inputFields.forEach((field)=>{
                field.classList.remove('border-primary');
            })

            let BankName = form.querySelector("#BankName");
            let Address1 = form.querySelector("#Address1");
            let Address2 = form.querySelector("#Address2");
            let City = form.querySelector("#City");
            let Telephone_NO = form.querySelector("#Telephone_No");
            let No_Of_Doctors = form.querySelector("#No_Of_Doctors");
            let No_Of_Nurses = form.querySelector("#No_Of_Nurses");
            let No_Of_Beds = form.querySelector("#No_Of_Beds");
            let No_Of_Storages = form.querySelector("#No_Of_Storages");
            let telFormat = /^(?:0|94|\+94|0094)?(?:(11|21|23|24|25|26|27|31|32|33|34|35|36|37|38|41|45|47|51|52|54|55|57|63|65|66|67|81|91)([0234579])|7([01245678])\d)\d{6}$/;
            let numberFormat = /^([1-9]\d*)$/;
            // console.log(inputFields);

            let flag = false;

            if (BankName.value === ''){
                // ShowToast({message:'ret', type:'error'});
                BankName.classList.add('border-primary');
            }else if (Address1.value === ''){
                Address1.classList.add('border-primary');
            }else if (Address2.value === ''){
                Address2.classList.add('border-primary');
            }else if (City.value === ''){
                City.classList.add('border-primary');
            }else if (!telFormat.test(Telephone_NO.value)){
                Telephone_NO.classList.add('border-primary');
            }else if(!numberFormat.test(No_Of_Doctors.value)){
                No_Of_Doctors.classList.add('border-primary');
            }else if (!numberFormat.test(No_Of_Nurses.value)){
                No_Of_Nurses.classList.add('border-primary');
            }else if(!numberFormat.test(No_Of_Beds.value)){
                No_Of_Beds.classList.add('border-primary');
            }else if(!numberFormat.test(No_Of_Storages.value)){
                No_Of_Storages.classList.add('border-primary');
            }else {
                flag = true;
            }

            let successBtn = document.getElementById('addBankPop').querySelector(".btn-outline-success");
            successBtn.disabled = !flag;
        };
        let addBankForm = document.getElementById('addBankForm');
}

    function editBnkData(tr){
//        document.getElementsByName(tr);
    let data = document.getElementById(tr).valueOf().innerText.split('\t');
    let bankID = document.getElementById(tr).id;
    // console.log(bankID);
    // console.log(data);
    // for (let i in data){
    //      console.log(data[i]);
    // }
    //console.log(tr);        //console.log(id);
    OpenDialogBox({
    id: 'editBankPop',
    title: 'Edit Data',
    content: `<form id="editBankForm" action="/admin/dashboard/manageBanks/edit" method="post">
                            <input type="hidden" name="BloodBank_ID" value="${bankID}">
                            <label for="bank_name">Bank Name</label>
                            <input type="text" id="BankName" name="BankName" value="${data[1]}">
                            <label for="address">Address</label>
                            <input type="text" id="Address1" name="Address1" value="${data[2].split(', ')[0]}">
                            <input type="text" id="Address2" name="Address2" value="${data[2].split(', ')[1]}">
                            <label for="city">City</label>
                            <input type="text" id="City" name="City" value="${data[3]}">
                            <label for="telephone">Telephone</label>
                            <input type="text" id="Telephone_No"  name="Telephone_No" value="${data[4]}">
                            <label for="numberOfDoctors">Number of Doctors</label>
                            <input type="text" id="No_Of_Doctors" name="No_Of_Doctors" value="${data[5]}">
                            <label for="numberOfNurses">Number Of Nurses</label>
                            <input type="text" id="No_Of_Nurses" name="No_Of_Nurses" value="${data[6]}">
                            <label for="numberOfBeds">Number Of Beds</label>
                            <input type="text" id="No_Of_Beds" name="No_Of_Beds" value="${data[7]}">
                            <label for="numberOfStorages">Number Of Storages</label>
                            <input type="text" id="No_Of_Storages" name="No_Of_Storages" value="${data[8]}">
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


        document.onkeyup = ()=>{
            let form =document.getElementById('editBankForm');
            let inputFields = form.querySelectorAll('input');
            inputFields.forEach((field)=>{
                field.classList.remove('border-primary');
            })

            let BankName = form.querySelector("#BankName");
            let Address1 = form.querySelector("#Address1");
            let Address2 = form.querySelector("#Address2");
            let City = form.querySelector("#City");
            let Telephone_NO = form.querySelector("#Telephone_No");
            let No_Of_Doctors = form.querySelector("#No_Of_Doctors");
            let No_Of_Nurses = form.querySelector("#No_Of_Nurses");
            let No_Of_Beds = form.querySelector("#No_Of_Beds");
            let No_Of_Storages = form.querySelector("#No_Of_Storages");
            let telFormat = /^(?:0|94|\+94|0094)?(?:(11|21|23|24|25|26|27|31|32|33|34|35|36|37|38|41|45|47|51|52|54|55|57|63|65|66|67|81|91)([0234579])|7([01245678])\d)\d{6}$/;
            let numberFormat = /^([1-9]\d*)$/;
            // console.log(inputFields);

            let flag = false;

            if (BankName.value === ''){
                // ShowToast({message:'ret', type:'error'});
                BankName.classList.add('border-primary');
            }else if (Address1.value === ''){
                Address1.classList.add('border-primary');
            }else if (Address2.value === ''){
                Address2.classList.add('border-primary');
            }else if (City.value === ''){
                City.classList.add('border-primary');
            }else if (!telFormat.test(Telephone_NO.value)){
                Telephone_NO.classList.add('border-primary');
            }else if(!numberFormat.test(No_Of_Doctors.value)){
                No_Of_Doctors.classList.add('border-primary');
            }else if (!numberFormat.test(No_Of_Nurses.value)){
                No_Of_Nurses.classList.add('border-primary');
            }else if(!numberFormat.test(No_Of_Beds.value)){
                No_Of_Beds.classList.add('border-primary');
            }else if(!numberFormat.test(No_Of_Storages.value)){
                No_Of_Storages.classList.add('border-primary');
            }else {
                flag = true;
            }

            let successBtn = document.getElementById('editBankPop').querySelector(".btn-outline-success");
            successBtn.disabled = !flag;
        };


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