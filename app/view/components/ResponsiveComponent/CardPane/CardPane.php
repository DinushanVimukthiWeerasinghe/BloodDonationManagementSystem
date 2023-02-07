<?php

namespace App\view\components\ResponsiveComponent\CardPane;

use App\model\users\MedicalOfficer;
use App\view\components\ResponsiveComponent\Card\Card;

class CardPane
{

    public static function Loader()
    {

        return <<<HTML
        <div class="pane-loader">
            <img src="/public/loading2.svg" alt="" width="200px">
        </div>
        HTML;
    }

    public static function GetCSS(): string
    {
        return <<<HTML
            <link rel="stylesheet" href="/public/css/components/cardPane/index.css">
        HTML;

    }

    public static function AddLoader(): string
    {
        return <<<HTML
            <div class="card-loader ">
                    <img src="/public/loading2.svg" alt="" width="200px">
            </div>
        HTML;

    }
    public static function CreateCardPane(bool $EnableLoader=true): string
    {
        $loader='';
        if ($EnableLoader){
            $loader=self::Loader();
        }
        return <<<HTML
            <div id="card-pane" class="card-pane">
            $loader
        HTML;
    }

    public static function CreateCards(array $data,$clz,$id,array $cardBody,string $image="getProfileImage"): string
    {
        if (empty($data))
        {
            return <<<HTML
                <div class="empty-card card none">
                    <div class="card-body">
                        <div class="card-title"><img src="/public/images/icons/not-found.png" alt=""></div>
                        <div class="card-title">No Officers Yet!</div>
                    </div>
                </div>
            HTML;

        }
        $cards='';

        foreach ($data as $value){
            $ids=[$value,$id]();
            $body=[];
            foreach ($cardBody as $key=>$item){
                $body[$key]=[$value,$item]();
            }
            $imageURL=[$value,$image]();
            $cards.=Card::DetailCards($ids,$body,$imageURL);
        }
        return $cards;
    }

    public static function FilterPane($total_pages,$current_page,$q="",$text="Search"): string
    {
        $pages='';
        for ($i=1;$i<=$total_pages;$i++){
            if ($i==$current_page){
                $pages.="<a href='?page=$i' class='disabled'> <div class='page-number active'>$i</div></a>";
            }
            else{
                $pages.=" <a href='?page=$i'><div class='page-number'>$i</div></a>";
            }
        }
        $nextHidden='';
        $prevHidden='';
        $NextPage=$current_page+1;
        $PrevPage=$current_page-1;
        if ($current_page==$total_pages){
            $nextHidden='disabled';
            $NextPage=$total_pages;
        }
        if ($current_page==1){
            $prevHidden='disabled';
            $PrevPage=1;
        }

        return <<<HTML
            <div id="filter-pane" class="filter-pane">
                <div class="search-input">
                    <label class="search">{$text}
                        <input class="search-box" name="search" id="search" onkeyup="SearchFunction()">
                    </label>
                    <div class="search-icon" id="search-btn" onclick="SearchFunction()">
                        <img src="/public/images/icons/search.png" alt="">
                    </div>
                </div>
                <div class="filter-card">
                    <div class="card-navigation">
                        <a class="$prevHidden" href="?page=$PrevPage"><img class="nav-btn" src="/public/images/icons/previous.png" alt=""></a>
                        <div class="page-numbers">
                        $pages
                        </div>
                        <a class="$nextHidden" href="?page=$NextPage"><img class="nav-btn" src="/public/images/icons/next.png" alt=""></a>
                    </div>
                </div>
            </div>
        HTML;


    }

    public static function CloseCardPane()
    {
        return <<<HTML
            </div>
        HTML;

    }

    public static function GetLoaderJS(): string
    {
        return <<<JS
        const PaneLoader=document.getElementsByClassName('pane-loader')[0];
        window.addEventListener('load',()=>{
                setTimeout(()=>{
                   const Cards=document.getElementsByClassName('card');
                   console.log(Cards);
                for (let i=0;i<Cards.length;i++){
                    Cards[i].classList.remove('none');
                }
                PaneLoader.classList.add('none');
                },500);
            });
JS;

    }

    public static function GetJS($url): string
    {
        $loaderJS=static::GetLoaderJS();
        return <<<HTML
        <script>
            const Search=document.getElementById('search');
            const SearchBtn=document.getElementById('search-btn');
            const CardPane=document.getElementById('card-pane');
            const DetailPane=document.getElementById('detail-pane');
            $loaderJS
           
          
            function SearchFunction(){
                const Search=document.getElementById('search');
                const text= Search.value;
                showUser(text);
            }
            function showUser(name){
                    PaneLoader.classList.remove('none');
                    // document.querySelector('.loader').style.display = 'flex';
                    const XML=new XMLHttpRequest();
                    XML.onreadystatechange=function () {
                        const CardPane=document.getElementById('card-pane');
                        const PageNumbers=document.getElementsByClassName('page-numbers')[0];
                        if (this.readyState === 4 && this.status === 200) {
                            console.log(this.responseText);
                        
                            // CardPane.innerHTML=this.responseText;
        
                            const DOMParse = new DOMParser();
                            const Doc =DOMParse.parseFromString(this.responseText, 'text/html');
                 
                            
                            filterPane=Doc.getElementsByClassName('page-numbers')[0];
                            
                            setTimeout(()=>{
                                const PaneLoader=document.getElementsByClassName('pane-loader')[0];
                                const Cards=document.getElementsByClassName('card');
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
                        }
                    }
                    XML.open('GET','$url?q='+name,true);   
                    XML.send();
            }
        </script>
HTML;

    }
}