<?php

?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="/public/styles/orgcreate.css">
</head>
<body>
<!-- profile banner-->
<section class="profileBanner">
    <h1>Create New Campaign</h1>
</section>
<!--profile banner end-->
<!--campaign form start-->
<div class="container">
    <div class="row">

    </div>
</div>
<!--campaign form end-->
<script>
    function avoid(){
        document.getElementById("hide1").style.display = "block";
        document.getElementById("hide2").style.backgroundColor = "red";
        document.getElementById("hide2").disabled = true;
    }
    function ok(){
        document.getElementById("hide1").style.display = "none";
        document.getElementById("hide2").style.display = "block";
        document.getElementById("hide2").style.backgroundColor = "black";
        document.getElementById("hide2").disabled = false;
    }
</script>
</body>
</html>


