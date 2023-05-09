<?php

namespace App\view\components\Table;

use App\model\Requests\BloodRequest;

class DetailTable
{
    private array $title;
    private array $content;
    public function __construct($title, $content)
    {
        $this->title = $title;
        $this->content = $content;
    }

    public function render($id): string
    {
        if(count($this->content)==0)
        {
            return "<h1>No Data Found</h1>";
        }else{
            $table = "<table class='table table-striped table-hover table-bordered' id='$id'style='width: 90%; margin-top: 10vh'>";
            $table .= "<thead style='color: var(--primary);background: rgba(255, 255, 255, 0.2);'>";
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
}