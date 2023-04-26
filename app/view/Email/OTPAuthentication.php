<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>OTP Authentication</title>
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
        <div>
            <div style="text-align: left">Hi {{UserName}}</div><br>
            <div>OTP Authentication</div>
            <div>OTP: {{OTP1}} : {{OTP2}} : {{OTP3}} : {{OTP4}} : {{OTP5}} </div>
        </div>
    </div>

</body>
</html>
