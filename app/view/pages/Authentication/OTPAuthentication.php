<?php
?>
<div class="d-flex">
    <div>
        <h1 class="text-4xl">OTP Authentication</h1>
        <p class="text-xl">Enter the OTP sent to your mobile number</p>
    </div>
</div>
<div class="d-flex">
    <div class="card box border-primary" style="height: 100px;width: 100px;border-radius: 5px">
        <label for="char1"></label>
        <input type="text" id="char1" class="text-center text-xl border-none border-bottom-3-primary" maxlength="1"
               style="width: 100%;height: 100%;font-size: 3rem">
    </div>
    <div class="card box border-primary" style="height: 100px;width: 100px;border-radius: 5px">
        <label for="char2"></label>
        <input type="text" id="char2" class="text-center text-xl border-none border-bottom-3-primary " maxlength="1"
               style="width: 100%;height: 100%;font-size: 3rem">
    </div>
    <div class="card box border-primary" style="height: 100px;width: 100px;border-radius: 5px">
        <label for="char3"></label>
        <input type="text" id="char3" class="text-center text-xl border-none border-bottom-3-primary " maxlength="1"
               style="width: 100%;height: 100%;font-size: 3rem">
    </div>
    <div class="card box border-primary" style="height: 100px;width: 100px;border-radius: 5px">
        <label for="char4"></label>
        <input type="text" id="char4" class="text-center text-xl border-none border-bottom-3-primary " maxlength="1"
               style="width: 100%;height: 100%;font-size: 3rem">
    </div>
    <div class="card box border-primary" style="height: 100px;width: 100px;border-radius: 5px">
        <label for="char5"></label>
        <input type="text" id="char5" class="text-center text-xl border-none border-bottom-3-primary " maxlength="1"
               style="width: 100%;height: 100%;font-size: 3rem">
    </div>
</div>
<div class="d-flex">
    <div id="resendOtp">
        <p class="text-xl">Didn't receive OTP? <a onclick="RegenerateOTP()" class="text-primary">Resend OTP</a></p>
    </div>
</div>
<div class="d-flex">
    <div>
        <button class="btn btn-lg btn-success mt-1" onclick="ValidateOTP()">Verify</button>
    </div>
</div>


<script>
    const OTPBox = document.querySelectorAll('.box');
    OTPBox.forEach((input) => {
        input.addEventListener('keyup', (e) => {
            const nextID = parseInt(e.target.id.substring(4, 5)) + 1;
            if (e.target.value.length === 1) {
                if (nextID <= 5) {
                    document.getElementById('char' + nextID).focus();
                } else {
                    // ValidateOTP();
                }
            } else if (e.key === 'Backspace') {
                const prevID = parseInt(e.target.id.substring(4, 5)) - 1;
                if (prevID >= 1) {
                    document.getElementById('char' + prevID).focus();
                    if (prevID !== 4) {
                        document.getElementById('char' + prevID).value = '';
                    } else {
                        document.getElementById(e.target.id).value = '';
                        document.getElementById('char' + prevID).focus();
                    }
                }
            }
        });
    });
    const ValidateOTP = () => {
        const char1 = document.getElementById('char1').value;
        const char2 = document.getElementById('char2').value;
        const char3 = document.getElementById('char3').value;
        const char4 = document.getElementById('char4').value;
        const char5 = document.getElementById('char5').value;
        const otp = char1 + char2 + char3 + char4 + char5;
        const url = '/otp/validate';
        const formData = new FormData();
        formData.append('otp', otp);
        const options = {
            method: 'POST',
            body: formData
        };
        fetch(url, options)
            .then(response => response.json())
            .then(data => {
                if (data.status) {
                    window.location.href = data.redirect;
                } else {
                    OpenDialogBox({
                        id: 'error',
                        title: 'Error',
                        content: data.message,
                        successBtnText: 'Resend OTP',
                        successBtnAction: () => {
                            CloseDialogBox('error');
                            fetch('/otp/validate?regenerate=true')
                                .then(response => response.json())
                                .then(data => {
                                    if (data.status) {
                                        console.log(data.message);
                                    } else {
                                        alert(data.message)
                                    }
                                });
                        }
                    })
                }
            });
    };

    function RegenerateOTPRequest() {
        fetch('/otp/validate?regenerate=true')
            .then(response => response.json())
            .then(data => {
                if (data.status) {
                    console.log(data.message);
                } else {
                    alert(data.message)
                }
            });
    }

    const RegenerateOTP = () => {
        OpenDialogBox({
            id: 'regenerate',
            title: 'Regenerate OTP',
            content: 'Are you sure you want to regenerate OTP?',
            successBtnText: 'Yes',
            successBtnAction: () => {
                CloseDialogBox('regenerate');
                RegenerateOTPRequest();
            }
        })
    }
</script>
