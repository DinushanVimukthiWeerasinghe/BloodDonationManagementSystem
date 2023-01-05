<?php
?>

<div class="g-flex">
    <div class="container">
        <form action="/admin/register" method="post">
            <label for="email"></label><input id="email" name="email" placeholder="email" type="email"/>
            <div class="g-flex">
                <label for="firstname"></label><input id="firstname" name="firstname" placeholder="firstname" type="text"/>
                <label for="lastname"></label><input id="lastname" name="lastname" placeholder="lastname" type="text"/>
            </div>
            <div class="g-flex">
                <label for="username"></label><input id="username" name="username" placeholder="username" type="text"/>
                <label for="NIC"></label><input id="NIC" name="NIC" placeholder="NIC" type="text"/>
            </div>
            <div class="g-flex">
                <label for="password"></label><input id="password" name="password" placeholder="password" type="password"/>
                <label for="confirmPassword"></label><input id="confirmPassword" name="confirmPassword" placeholder="confirmPassword" type="password"/>
            </div>
            <div class="g-flex">
                <label for="address1"></label><input id="address1" name="address1" placeholder="address1" type="text"/>
                <label for="address2"></label><input id="address2" name="address2" placeholder="address2" type="text"/>
            </div>
            <div class="g-flex">
                <label for="city"></label><input id="city" name="city" placeholder="city" type="text"/>
                <label for="postalCode"></label><input id="postalCode" name="postalCode" placeholder="postalCode" type="text"/>
            </div>
            <div class="g-flex">
                <input type="submit" value="Submit">
                <input type="reset" value="Reset">
            </div>

        </form>
    </div>

</div>


