<?php

namespace App\view\components\WebComponent\Card;

class BaseCard
{
    private string $title;
    private string $content;
    private string $footer;
    private string $class;

    public function __construct($title, $content, $footer)
    {
        $this->title = $title;
        $this->content = $content;
        $this->footer = $footer;
    }

    public function render(): string
    {
        if (trim($this->title)=="")
        {
            return "
        <div class='card min-w-200 max-w-200 mx-20'>
            <div class='card-body'>
                $this->content
            </div>
            <div class='card-footer'>
                $this->footer
            </div>
        </div>
        ";
        }else {
            return "
        <div class='card min-w-200 max-w-200 mx-20'>
            <div class='card-header'>
                <h3 class='card-title'>$this->title</h3>
            </div>
            <div class='card-body'>
                $this->content
            </div>
            <div class='card-footer'>
                $this->footer
            </div>
        </div>
        ";
        }
    }


}