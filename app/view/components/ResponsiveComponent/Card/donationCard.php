<?php

namespace App\view\components\ResponsiveComponent\Card;

class donationCard
{
    protected string $title = '';
    protected string $subtitle = '';
    protected string $description = '';
//    protected string $organization;
    public function __construct(array $params){
        foreach($params as $key => $value){
            $this->{$key} = $value;
        }
    }
    public function render():string {
            return <<<HTML
        <a href="#" class="data-card">
            <h3>$this->title</h3>
            <h4>$this->subtitle</h4>
            <p>$this->description</p>
            <span class="link-text">
                View All Details
                <svg width="25" height="16" viewBox="0 0 25 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M17.8631 0.929124L24.2271 7.29308C24.6176 7.68361 24.6176 8.31677 24.2271 8.7073L17.8631 15.0713C17.4726 15.4618 16.8394 15.4618 16.4489 15.0713C16.0584 14.6807 16.0584 14.0476 16.4489 13.657L21.1058 9.00019H0.47998V7.00019H21.1058L16.4489 2.34334C16.0584 1.95281 16.0584 1.31965 16.4489 0.929124C16.8394 0.538599 17.4726 0.538599 17.8631 0.929124Z" fill="#753BBD"/>
                </svg>
            </span>
        </a>
        HTML;
        }

}

