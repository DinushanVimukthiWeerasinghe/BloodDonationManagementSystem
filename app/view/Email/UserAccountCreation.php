<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>User Account Creation</title>
</head>
<body>
<div style="display: flex; flex-direction:column;justify-content:center;align-items: center;font-family: Poppins:sans-serif; ">
    <div style="display:table;margin-left: auto;margin-right: auto;">
        <div id="logo" style="margin-right: auto;margin-left: auto">
            <img src="cid:logo-img" alt="logo" style="width: 100px;height: 100px;">
        </div>
        <div id="title" style="display:flex;align-items: center;justify-content: center" class="test">
            <div style="display:flex;align-items:center;justify-content:center;font-size: 2rem;font-weight: bolder;color: darkred">BE POSITIVE</div>
        </div>
    </div>
    <div id="content" style="font-size:medium">
        <div style="">
            <div style="border: 2px solid black;margin: 1rem;padding: 1rem">
                <div style="text-align: left;font-size: large">
                    Hi <b>{{UserName}}</b><br>
                </div>
                <div>
                    Your account has been created successfully. Please click the link below to activate your account.
                </div>
                <div>
                    <b>
                        Change your password after logging in.
                    </b>
                </div>
                <div style="display:flex;justify-content: center;align-items: center;margin-top: 10px;">
                    <a href="{{Link}}" style="text-decoration: none;color: white;background-color: darkred;padding: 10px;border-radius: 5px;">Log In</a>
                </div>
            </div>
        </div>
        <br>

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
