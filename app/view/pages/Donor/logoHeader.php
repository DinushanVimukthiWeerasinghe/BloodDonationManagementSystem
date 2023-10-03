<?php

use App\view\components\Image\GeneralImage;

$logo = new GeneralImage("/public/images/logo.png", "Home Image", "logo", "50rem");
echo '<a class="logo-container" href="/donor" >';
echo $logo->render();
echo '</a>';