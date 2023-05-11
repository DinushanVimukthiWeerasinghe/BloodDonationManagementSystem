<?php
/* @var $role string*/

use App\model\users\User;
use App\view\components\ResponsiveComponent\Alert\FlashMessage;
use App\view\components\ResponsiveComponent\ImageComponent\BackGroundImage;
use App\view\components\ResponsiveComponent\NavbarComponent\AuthNavbar;
use App\view\components\ResponsiveComponent\NavbarComponent\Navbar;

$navbar= new Navbar([
    'Home'=>'/home',
    'About'=>'/about',
    'Contact Us'=>'/contact',
    'Log In'=>'/login'
],'#','/public/images/icons/user.png','');
echo $navbar;
$background=new BackGroundImage();
echo $background;
FlashMessage::RenderFlashMessages();
?>
<div class="d-flex bg-white-0-3 border-radius-10 gap-1 p-2">
    <div class="d-flex ">
        <img src="/public/images/RegisterImage/<?= $role?>RegImg.jpg" class="border-radius-10" alt="" width="500rem">
    </div>
    <div class="d-flex bg-white border-radius-10 p-2" >
        <div>
            <div class="text-2xl mb-1 font-bold text-dark w-100 text-center">
                <?= $role ?> Registration
            </div>
            <input type="hidden" name="role" value="<?=$role?>">
            <div class="form-group">
                <label for="email" class="w-30">Email</label>
                <input type="email" name="Email" id="email" class="form-control border-1 w-60">
            </div>
            <div class="form-group">
                <label for="password" class="w-30">Password</label>
                <input type="password" name="Password" id="password" class="form-control w-60">
            </div>
            <div class="form-group">
                <label for="confirmPassword" class="w-30">Confirm Password</label>
                <input type="password" name="ConfirmPassword" id="confirmPassword" class="form-control w-60">
            </div>
            <div class="form-group flex-column">
                <?php
                if ($role=== User::DONOR || $role=== User::ORGANIZATION) :
                    ?>
                <div class="d-flex justify-content-center w-100 mt-1">
                    <?php
                    if ($role === User::DONOR) :
                    ?>
                    <span class="font-bold">Want to Host a campaign?</span> &nbsp;<a href="/register?role=organization" class="text-primary">Campaign Registration</a>
                    <?php
                    elseif ($role=== User::ORGANIZATION) :
                    ?>
                    <span class="font-bold">Want to Donate?</span> &nbsp;<a href="/register?role=donor" class="text-primary">Donor Registration</a>
                    <?php
                    endif;
                    ?>
                </div>
                <?php
                endif;
                ?>
                <div class="d-flex justify-content-center w-100">
                    Already have an account? &nbsp;<a href="/login" class="text-primary">Log In</a>
                </div>
            </div>

            <div class="form-group" style="justify-content:center;">
                <button class="btn btn-success w-40" type="submit"name="register" onclick="Register();">Register</button>
<!--                <button class="btn btn-danger w-40" type="reset" value="Reset" name="register">Reset</button>-->
            </div>


        </div>
    </div>
</div>
<script>
    const SendOTP = (Email)=>{
        if (Email.trim() === ''){
            ShowToast({
                message: 'Email cannot be empty',
                type: 'danger'
            });
            return;
        }
        const url = '/register/send-otp';
        const formData = new FormData();
        formData.append('Email', Email);
        fetch(url, {
            method: 'POST',
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                if (data.status){
                    ShowToast({
                        message: "OTP sent to your email",
                        type: 'success'
                    });
                } else {
                    ShowToast({
                        message: data.message,
                        type: 'danger'
                    });
                }
            })
            .catch((error) => {
                ShowToast({
                    message: error,
                    type: 'danger'
                });
            });
    }

    const Register = ()=>{
        const Email = document.getElementById('email').value;
        const Password = document.getElementById('password').value;
        const ConfirmPassword = document.getElementById('confirmPassword').value;
        const Role = document.getElementsByName('role')[0].value;
        if (Email.trim() === '' || Password.trim() === '' || ConfirmPassword.trim() === ''){
            ShowToast({
                message: 'Please fill all the fields',
                type: 'danger'
            });
            return;
        }
        // Check if the password has at least 8 characters
        if (Password.length < 8){
            ShowToast({
                message: 'Password must be at least 8 characters',
                type: 'danger'
            });
            return;
        }
        // Check if the password has at least 1 number
        if (!Password.match(/\d/)){
            ShowToast({
                message: 'Password must contain at least 1 number',
                type: 'danger'
            });
            return;
        }
        // Check if the password has at least 1 uppercase letter
        if (!Password.match(/[A-Z]/)){
            ShowToast({
                message: 'Password must contain at least 1 uppercase letter',
                type: 'danger'
            });
            return;
        }
        // Check if the password has at least 1 lowercase letter
        if (!Password.match(/[a-z]/)){
            ShowToast({
                message: 'Password must contain at least 1 lowercase letter',
                type: 'danger'
            });
            return;
        }
        // Check if the password has at least 1 special character
        if (!Password.match(/[!@#$%^&*(),.?":{}|<>]/)){
            ShowToast({
                message: 'Password must contain at least 1 special character',
                type: 'danger'
            });
            return;
        }
        // Check if the password and confirm password match
        if (Password !== ConfirmPassword){
            ShowToast({
                message: 'Password and Confirm Password does not match',
                type: 'danger'
            });
            return;
        }
        // Check if the email is valid
        if (!Email.match(/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/)){
            ShowToast({
                message: 'Please enter a valid email',
                type: 'danger'
            });
            return;
        }
        const url = '/register/send-otp';
        const formData = new FormData();
        formData.append('Email', Email);

        fetch(url, {
            method: 'POST',
            body: formData
        }).then(response => response.json())
            .then(data => {
                if (data.status){
                    ShowToast({
                        message: data.message,
                        type: 'success'
                    });
                    OpenDialogBox({
                        title: 'Enter OTP',
                        titleClass: 'text-center bg-dark py-1 text-white font-bold px-2',
                        content: `
                <div class="d-flex flex-column justify-content-center align-items-center gap-1">
                    <div class="d-flex">One Time Password is being sent to ${Email}</div>
                    <div class="d-flex font-bold">Enter OTP Below</div>
                    <div class="d-flex ml-2 w-100">
                        <div class="d-flex w-100 justify-content-center gap-1">
                            <input type="text" name="OTP[]" id="otp" class="" maxlength="1" style="height: 50px;width: 50px;border-radius: 10px;border:2px solid black;font-size: larger;text-align: center">
                            <input type="text" name="OTP[]" id="otp" class="" maxlength="1" style="height: 50px;width: 50px;border-radius: 10px;border:2px solid black;font-size: larger;text-align: center">
                            <input type="text" name="OTP[]" id="otp" class="" maxlength="1" style="height: 50px;width: 50px;border-radius: 10px;border:2px solid black;font-size: larger;text-align: center">
                            <input type="text" name="OTP[]" id="otp" class="" maxlength="1" style="height: 50px;width: 50px;border-radius: 10px;border:2px solid black;font-size: larger;text-align: center">
                            <input type="text" name="OTP[]" id="otp" class="" maxlength="1" style="height: 50px;width: 50px;border-radius: 10px;border:2px solid black;font-size: larger;text-align: center">
                        </div>
                    </div>
                    <div class="d-flex flex-column align-items-center justify-content-center">
                        <p>Didn't receive OTP?</p>
                        <button class="btn btn-success" name="register" onclick="SendOTP('${Email}')">Send OTP Again!</button>
                    </div>
                </div>
            `,
                        successBtnAction : ()=>{
                            const OTP = document.getElementsByName('OTP[]');
                            let OTPString = '';
                            for (let i = 0; i < OTP.length; i++){
                                OTPString += OTP[i].value;
                            }
                            if (OTPString.trim() === ''){
                                ShowToast({
                                    message: 'Please enter OTP',
                                    type: 'danger'
                                });
                                return;
                            }
                            const formData = new FormData();
                            formData.append('Email', Email);
                            formData.append('Role', Role);
                            formData.append('OTP', OTPString);
                            const ValidateOTPUrl = '/register/validate-otp';
                            fetch(ValidateOTPUrl, {
                                method: 'POST',
                                body: formData
                            }).then(response => response.json())
                                .then(data => {
                                    console.log(data)
                                    if (data.status){
                                        const formData = new FormData();
                                        formData.append('Email', Email);
                                        formData.append('Password', Password);
                                        formData.append('ConfirmPassword',ConfirmPassword);
                                        formData.append('Role', Role);
                                        const RegisterUrl = '/register';
                                        fetch(RegisterUrl, {
                                            method: 'POST',
                                            body: formData
                                        }).then(response => response.json())
                                            .then(data => {
                                                if (data.status){
                                                    console.log(data)
                                                    let redirect = data.redirect;
                                                    window.location.href = redirect;

                                                }else{
                                                    ShowToast({
                                                        message: data.message,
                                                        type: 'danger'
                                                    });
                                                }
                                            })
                                    }else{
                                        ShowToast({
                                            message: data.message,
                                            type: 'danger'
                                        });
                                    }
                                })
                        }
                    })

                }else{
                    ShowToast({
                        message: data.message,
                        type: 'error'
                    });
                }
            })
    }
</script>
