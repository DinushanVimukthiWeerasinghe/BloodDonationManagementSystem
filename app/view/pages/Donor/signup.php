<?php
$logo = new \App\view\components\Image\GeneralImage("/public/images/logo.png", "Home Image", "logo","50rem");
?>
<head xmlns="http://www.w3.org/1999/html">
    <link rel="stylesheet" href='/public/styles/DonorSignup.css'>
</head>
<?php echo $logo->render();?>
<div class="container">
    <h1 class ="heading">Donor Signup</h1>
    <div class="sub-container">
        <h2>Create a new account</h2>
        <p>Let's save someone's life.</p>
        <form action = "/donor/signup" method = "post">
            <div class="form-group-name">
                <input id="firstname" name = "firstname" placeholder="First Name" type="text" required/>
                <input id="lastname" name = "lastname" placeholder="Last Name" type="text" required/>
            </div>
            <label for="email"></label><input id="email" name="email" placeholder="Email" type="email" required/>
            <label for="password"></label><input id="password" name="password" placeholder="Password" type="password" required/>
            <div class="condition-agree">
                <input type='checkbox' name="checkbox" required> I agree with the Terms of Use and Privacy Notice.
            </div>
            <input type="submit" name="submit" class="sub-btn" alt="submit form" value="Sign Up Now">
        </form>
    </div>
</div>