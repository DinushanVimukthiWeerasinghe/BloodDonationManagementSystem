function AddNewManager() {
    let Banks = [];
    const XHR = new XMLHttpRequest();
    XHR.open("GET", "/api/bbank/getall", true);
    XHR.setRequestHeader("Content-Type", "application/json");
    XHR.send();
    XHR.onload = function () {
        const bankList = JSON.parse(this.responseText);
        // console.log(Object.keys(bankList));
        Banks = Object.keys(bankList);
        // console.log(Banks);
        OpenDialogBox({
            title: "Add New Manager",
            content: `
                <div class="form-group">
                    <form action="/admin/manageBanks/addManager" method="post" id="addNewManagerForm">
                        <select class="" id="bank" name="bank">
                            <option value="0">Select Blood Bank</option>
                        </select>
                        <input type="email" name="Email" id="email" placeholder="E-Mail for Blood Bank Manager" required>
                        <input type="password" name="password" id="password" placeholder="Password" required>
                        <input type="text" name="First_Name" id="fName" placeholder="Identification Name For Manager" required>
                        <input type="text" name="Last_Name" id="lName" placeholder="Identification Name For Manager" required>
                        <input type="text" name="Address1" id="address1" placeholder="Address Line 1" required>
                        <input type="text" name="Address2" id="address2" placeholder="Address Line 2" required>
                        <input type="text" name="City" id="city" placeholder="City" required>
                        <input type="tel" name="Contact_No" id="contactNo" placeholder="Contact Number" required>
                    </form>
                </div>
                `,
            successBtnAction: function () {
                const addNewManagerForm = document.getElementById('addNewManagerForm');
                const bank = document.getElementById("bank").value;

                // const email = document.getElementById("email").value;
                // const password = document.getElementById("password").value;
                // const fName = document.getElementById("fName").value;
                // const lName = document.getElementById("lName").value;
                // const address1 = document.getElementById("address1").value;
                // const address2 = document.getElementById("address2").value;
                // const city = document.getElementById("city").value;
                // const contactNo = document.getElementById("contactNo").value;

                if (bank !== 0) {
                    console.log(addNewManagerForm);
                    addNewManagerForm.submit();

                    // window.location.href = "/admin/manageBanks/addManager?id=" + bank;

                    // console.log([bank, email, password, fName, lName, address1, address2, city, contactNo]);
                    // const formData = new FormData();
                    // formData.append('email', email);
                    // formData.append('password', password);
                    // formData.append('bank', bank);
                    // formData.append('fName', fName);
                    // formData.append('lName', lName);
                    // formData.append('address1', address1);
                    // formData.append('address2', address2);
                    // formData.append('city', city);
                    // formData.append('contactNo', contactNo);
                    // fetch('/admin/manageBanks/addManager', {
                    //     method: 'POST',
                    //     body: formData
                    // }).then(r => {console.log(r.json())})
                }
                // console.log(bank);
                CloseDialogBox();
            }
        });
        Banks.forEach((bank)=>{
            let option = document.createElement("option");
            option.value = bankList[bank].id;
            option.innerText = bank;
            document.getElementById('bank').appendChild(option);
        });
    }
}