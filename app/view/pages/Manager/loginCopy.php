<?php
?>
<link rel="stylesheet" href="/public/styles/loginCopy.css">
<div class="container">
    <div class="top"></div>
    <div class="bottom"></div>
    <div class="center">
        <h2>Manager Sign In</h2>
        <form action="/manager/login" method="post">
            <label for="email"></label><input id="email" name="email" placeholder="email" type="email"/>
            <label>
                <input id="password" name="password" placeholder="password" type="password"/>
            </label>
            <div class="buttons">
                <input class="btn-hover color-11" type="submit" value="LogIn"/>
                <input class="btn-hover color-9" type="reset" value="Reset"/>
            </div>
        </form>

        <h2>&nbsp;</h2>
    </div>
</div>


