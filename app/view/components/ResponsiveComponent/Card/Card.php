<?php

namespace App\view\components\ResponsiveComponent\Card;

use App\model\users\MedicalOfficer;

class Card
{
    public static function DetailCard($value): string
    {
        /* @var MedicalOfficer $value*/
        $id = $value->getUid();
        $imageURL = $value->getProfileImage();
        $firstName = $value->getFirstName();

        $lastName = $value->getLastName();
        $fullName=$firstName.' '.$lastName;
        $position = $value->getPosition();

        return <<<HTML
            <div class="detail-card" id="{$id}" onclick="RedirectID('{$id}')">
                    <div class="card-image" >
                        <img src='{$imageURL}' alt="" width="80px" height="80px">
                    </div>
                    <div class="card-body">
                        <div class="card-title">{$fullName}</div>
                        <div class="card-title">{$fullName}</div>
                        <div class="card-title">{$fullName}</div>
                        <ul class="detail-list">
                            <li class="detail">{$position}</li>
                        </ul>
                    </div>
                </div>
        HTML;


    }
    public static function DetailCards(string $id,array $body,string $image): string
    {
        $card_body='';
        foreach ($body as $key=>$value){
            if ($key===0){
                $card_body.='<div class="card-title">'.$value.'</div>';
            }
            else{
                $card_body.='<div class="card-description">'.$value.'</div>';
            }

        }

        return <<<HTML
            <div class="card none detail-card" id="{$id}" onclick="RedirectID('{$id}')">
                    <div class="card-image" >
                        <img src='{$image}' alt="">
                    </div>
                    <div class="card-body">
                        {$card_body}
                    </div>
                </div>
        HTML;


    }
}