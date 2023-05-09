<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Password Reset</title>
</head>
<body>
<div style="display: flex; flex-direction:column;justify-content:center;align-items: center;font-family: Poppins:sans-serif; ">
    <div style="display: flex;align-items: center;justify-content:center;">
        <div id="logo" style="display: flex;align-items: center">
            <img src="cid:logo-img" alt="logo" style="width: 100px;height: 100px;">
        </div>

        <div id="title" style="display:flex;align-items: center" class="test">
            <div style="display:flex;align-items:center;justify-content:center;font-size: 2rem;font-weight: bolder;color: darkred">BE POSITIVE</div>
        </div>
    </div>
    <div id="content" style="">
        <div style="">
            <div style="text-align: left">Hi {{UserName}}</div><br>
            <div>This Email is sent to you because you requested to reset your password. If you did not request to reset your password, please ignore this email.</div>
        </div>
        <br>
        <div style="display:flex;justify-content: center;align-items: center;margin-top: 10px;">
            <a href="{{Link}}" style="text-decoration: none;color: white;background-color: darkred;padding: 10px;border-radius: 5px;">Reset Password</a>
        </div>
    </div>
</div>

</body>
<style>
    .test{
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        font-weight: bolder;
        color: darkred;
    }
</style>

</html>
