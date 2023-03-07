<?php
include 'logoHeader.php';
?>

<head>
    <link rel="stylesheet" href='/public/styles/DonorRegister.css'/>
</head>

<div class="container">
    <h1>Register</h1>
    <div class="form-container">
        <form action="/donor/register" method="post" class="register-form" id="register">
            <input type="text" name="firstname" placeholder="First Name" required/>
            <input type="text" name="lastname" placeholder="Last Name" required/>
            <input type="text" name="NIC" placeholder="NIC" required/>
            <input type="email" name="email" placeholder="Email" required/>
            <input type="text" name="address1" placeholder="Address Line 1" required/>
            <input type="text" name="address2" placeholder="Address Line 2" required/>
            <input type="text" name="city" placeholder="City" required/>
            <input type="text" name="postalCode" placeholder="Postal Code" required/>
            <input type="text" name="contactNumber" placeholder="Mobile Number" required/>
            <input type="submit" name="submit" value="Register" required/>
        </form>
    </div>
</div>