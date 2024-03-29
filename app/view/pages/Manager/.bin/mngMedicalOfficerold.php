<?php

/* @var string $firstName */

/* @var string $lastName */

use App\model\users\MedicalOfficer;
use App\view\components\ResponsiveComponent\Alert\FlashMessage;
use App\view\components\ResponsiveComponent\CardPane\CardPane;
use App\view\components\ResponsiveComponent\ImageComponent\BackGroundImage;
use App\view\components\ResponsiveComponent\NavbarComponent\AuthNavbar;

//echo Loader::GetLoader();
$background = new BackGroundImage();
$navbar = new AuthNavbar('Manage Medical Officers', '/manager/profile', '/public/images/icons/user.png', true,false);


echo $navbar;
echo $background;
//echo new primaryTitle('Manage Medical Officers');
/* @var array $data */
/* @var MedicalOfficer $value */


function GetImage($imageURL)
{
    if ($imageURL == null) {
        return '/public/images/icons/user1.png';
    } else {
        return $imageURL;
    }
}

FlashMessage::RenderFlashMessages();
?>


<div class="add-card tooltip" onclick="Redirect('/manager/mngMedicalOfficer/add')">
    <div class="card-image">
        <img src="/public/images/icons/manager/manageMedicalOfficer/doctor.png" alt="">
    </div>
</div>
<div class="add-card-mb">
    <div class="card-image">
        <img src="/public/images/icons/add-mo.png" alt="">
    </div>
</div>
<div id="detail-pane" class="min-w-80 max-w-90 min-h-80 d-flex justify-content-center flex-column align-items-center" >
    <div id="detail-pane" class="min-w-80 max-w-90 mt-10 min-h-80 d-flex justify-content-center flex-column align-items-center" style="margin-top: 6rem;">

        <div id="filter-pane" class="filter-pane">
            <div class="search-input">
                <label class="search text-white">Search
                    <input class="search-box" name="search" id="search" onkeyup="SearchFunction()">
                </label>
                <div class="search-icon" id="search-btn" onclick="SearchFunction()">
                    <img src="/public/images/icons/search.png" alt="">
                </div>
            </div>

        </div>
        <div class="filter-card">
            <div class="card-navigation">
                <a class="disabled" href="?page=1"><img class="nav-btn" src="/public/images/icons/previous.png"
                                                        alt=""></a>
                <div class="page-numbers">
                    <a href='?page=1' class='disabled'>
                        <div class='page-number active'>1</div>
                    </a>
                </div>
                <a class="disabled" href="?page=1"><img class="nav-btn" src="/public/images/icons/next.png" alt=""></a>
            </div>
        </div>
        <div id="card-pane" class="card-pane">
            <div class="pane-loader">
                <img src="/public/loading2.svg" alt="" width="200px">
            </div>
            <?php
            if (empty($data)){
                ?>
                <div class="card detail-card">
                    <div class="card-image">
                        <img src="/public/images/icons/manager/manageMedicalOfficer/doctor.png" alt="">
                    </div>
                    <div class="card-body">
                        <div class="card-title">
                            No Medical Officers
                        </div>
                    </div>
                </div>
                    <?php
            }
            foreach ($data as $value) {
                $id=$value->getID();
                $image=$value->getProfileImage();
                $name=$value->getFullName();
                $position=$value->getPosition();
                $NIC=$value->getNIC();
                $branch=$value->getBranchLocation();
                ?>
            <div class="detail-card none" id="MO7646" onclick="RedirectID('<?= $id?>')">
                <div class="card-image">
                    <img src='<?= $image?>' alt="">
                </div>
                <div class="card-body">
                    <div class="card-title"><?= $name ?></div>
                    <div class="card-description"><?= $position ?></div>
                    <div class="card-description"><?= $NIC ?></div>
                    <div class="card-description"><?= $branch ?></div>
                </div>
            </div>
            <?php
            }
            ?>

        </div
    </div>
    <?php
//    echo CardPane::GetJS('/manager/mngMedicalOfficer/search');
    ?>
    <script src="/public/scripts/manager/demo.js"></script>
    <script>
        const Search=document.getElementById('search');
        const SearchBtn=document.getElementById('search-btn');
        const CardPane=document.getElementById('card-pane');
        const DetailPane=document.getElementById('detail-pane');
        const PaneLoader=document.getElementsByClassName('pane-loader')[0];
        window.addEventListener('load',()=>{
            setTimeout(()=>{
                const Cards=document.getElementsByClassName('detail-card');
                for (let i=0;i<Cards.length;i++){
                    Cards[i].classList.remove('none');
                }
                PaneLoader.classList.add('none');
            },500);
        });
        function SearchFunction(path='/manager/mngMedicalOfficer/search'){
            const Search=document.getElementById('search');
            const text= Search.value;
            filter(text,path);
        }
        function filter(name,path){
            PaneLoader.classList.remove('none');
            fetch(path+'?q='+name,{
                method:'GET',
                headers:{
                    'Content-Type':'text/html'
                }
            }).then(response=>response.text())
                .then(data=>{
                    console.log(data)
                    const CardPane=document.getElementById('card-pane');
                    const PageNumbers=document.getElementsByClassName('page-numbers')[0];
                    const DOMParse = new DOMParser();
                    const Doc =DOMParse.parseFromString(data, 'text/html');

                    filterPane=Doc.getElementsByClassName('page-numbers')[0];

                    setTimeout(()=>{
                        const PaneLoader=document.getElementsByClassName('pane-loader')[0];
                        const Cards=document.getElementsByClassName('detail-card');
                        PaneLoader.classList.add('none');
                        for (let i=0;i<Cards.length;i++){
                            Cards[i].classList.remove('none');
                        }
                    },500);


                    cardPane=Doc.getElementById('card-pane');
                    CardPane.parentElement.replaceChild(cardPane,CardPane);
                    PageNumbers.parentElement.replaceChild(filterPane,PageNumbers);
                    const Search=document.getElementById('search');
                    Search.value=name;
                    Search.focus();
                });

            // document.querySelector('.loader').style.display = 'flex';
            // const XML=new XMLHttpRequest();
            // XML.onreadystatechange=function () {
            //     const CardPane=document.getElementById('card-pane');
            //     const PageNumbers=document.getElementsByClassName('page-numbers')[0];
            //     if (this.readyState === 4 && this.status === 200) {
            //
            //         const DOMParse = new DOMParser();
            //         const Doc =DOMParse.parseFromString(this.responseText, 'text/html');
            //
            //
            //         filterPane=Doc.getElementsByClassName('page-numbers')[0];
            //
            //         setTimeout(()=>{
            //             const PaneLoader=document.getElementsByClassName('pane-loader')[0];
            //             const Cards=document.getElementsByClassName('card');
            //             PaneLoader.classList.add('none');
            //             for (let i=0;i<Cards.length;i++){
            //                 Cards[i].classList.remove('none');
            //             }
            //         },500);
            //
            //
            //         cardPane=Doc.getElementById('card-pane');
            //         CardPane.parentElement.replaceChild(cardPane,CardPane);
            //         PageNumbers.parentElement.replaceChild(filterPane,PageNumbers);
            //         const Search=document.getElementById('search');
            //         Search.value=name;
            //         Search.focus();
            //     }
            // }
            // XML.open('GET','$url?q='+name,true);
            // XML.send();
        }
    </script>





