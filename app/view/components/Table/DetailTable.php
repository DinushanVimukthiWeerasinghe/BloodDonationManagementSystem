<?php

namespace App\view\components\Table;

class DetailTable
{
    private array $title;
    private array $content;
    public function __construct($title, $content)
    {
        $this->title = $title;
        $this->content = $content;
    }

    public function render(): string
    {
        $table = "<table class='table table-striped table-hover table-bordered'>";
        $table .= "<thead>";
        $table .= "<tr>";
        foreach ($this->title as $title) {
            $table .= "<th>$title</th>";
        }
        $table .= "</tr>";
        $table .= "</thead>";
        $table .= "<tbody>";
        foreach ($this->content as $content) {
            $table .= "<tr>";
            //print_r($content);
            foreach ($content as $lable => $item) {
                //echo $lable;
                $table .= "<td>$item</td>";
            }
            $table .= "</tr>";
        }
        $table .= "</tbody>";
        $table .= "</table>";
        return $table;
    }


}