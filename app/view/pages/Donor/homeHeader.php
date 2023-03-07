<?php
$home = new \App\view\components\Image\GeneralImage("/public/images/home.png", "Home Image", "home", "50rem");
echo '<a class="home-container" href="/donor" style="float: right">';
echo $home->render();
echo '</a>';