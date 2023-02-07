
    function AddNewManager(){
    var Banks = [];
    const XHR = new XMLHttpRequest();
    XHR.open("GET", "/api/bbank/getall", true);
    XHR.setRequestHeader("Content-Type", "application/json");
    XHR.send();
    XHR.onload = function () {
        var data = JSON.parse(this.responseText);
        console.log(data);
        data.forEach(function (item) {
            Banks.push(item.name);
        });
    }
        console.log(Banks);
    OpenDialogBox({
        title: "Add New Manager",
        content: `
                <div class="form-group">
                    <label for="name">Select Blood Bank</label>
                    <select class="" id="bank">
                        <option value="0">Select Blood Bank</option>
                <?php foreach($BloodBanks as $key=>$value)
                {?>
                        <option value="<?php $value->getBankName()?>">/option>
                    </select>
                </div>
                `,
        successBtnAction: function(){
            const bank =document.getElementById("bank").value;
            if(bank !== 0){
                window.location.href = "/admin/manageBanks/addManager?id="+bank;
            }
        }
    })
}