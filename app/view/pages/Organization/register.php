<?php
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BDMS</title>
    <link rel="stylesheet" href="/public/styles/organization/Orgregister.css">
</head>
<body>
<div class="container">
    <h1 class="form-title">Organization Registration</h1>
    <form action="register" method="post" enctype="multipart/form-data">
        <div class="main-user-info">
            <div class="user-input-box">
                <label for="organizationName">Organization Name</label>
                <input type="text"
                       id="organizationName"
                       name="Organization_Name"
                       placeholder="Organization Name" required/>
            </div>
            <div class="user-input-box">
                <label for="address1">Address Line 1</label>
                <input type="text"
                       id="address1"
                       name="Address1"
                       placeholder="Address Line 1" required/>
            </div>
            <div class="user-input-box">
                <label for="address2">Address Line 2</label>
                <input type="text"
                       id="address2"
                       name="Address2"
                       placeholder="Address Line 2" required/>
            </div>
            <div class="user-input-box">
                <label for="city">City</label>
                <input type="text"
                       id="city"
                       name="City"
                       placeholder="City" required/>
            </div>
            <div class="user-input-box">
                <label for="tel">Telephone Number</label>
                <input type="text"
                       id="tel"
                       name="Contact_No"
                       placeholder="Telephone Number" required/>
            </div>
            <div class="user-input-box">
                <label for="email">E-mail</label>
                <input type="email"
                       id="email"
                       name="Email"
                       placeholder="E-mail" required/>
            </div>
            <div class="user-input-box">
                <label for="password">Password</label>
                <input type="password"
                       id="password"
                       name="Password"
                       placeholder="Password"  required/>
            </div>
            <input type="file" name="file">
        </div>
        <span style="color: red;font-size: 15pt;margin-left: 120px;"><?php echo $model->getFirstError('email') ?></span>
        <span style="color: red;font-size: 15pt;margin-left: 120px;"><?php echo $model->getFirstError('password') ?></span>
        <span style="color: red;font-size: 15pt;margin-left: 10px;" id="error"></span>
        <div class="form-submit-btn" id="but">
            <input type="submit" value="Register">
        </div>
    </form><br>
    <div class="back" style="border-radius: 5px;">
    <a href="../login"><button style="width: 100%;height: 50px;cursor: pointer;background-color:  rgb(0,0,255,0.5);border: none;font-size: 20px;color: white; cursor: pointer;" class="back">Back To Login</button></a>
    </div>
</div>
<script>
    function character(){
        let text = document.getElementById('password').value;
        let length = text.length;
        if(0<length<6){
            document.getElementById('but').style.visibility = 'hidden';
            document.getElementById('but').style.disabled ='Password Must contain at least 6 characters'
            document.getElementById('error').innerHTML ='Password Must contain at least 6 characters';

        }if(length===0){
            document.getElementById('error').innerHTML ='';
        }
        if(length>6){
            document.getElementById('error').innerHTML ='';
        }
    }
</script>
</body>

