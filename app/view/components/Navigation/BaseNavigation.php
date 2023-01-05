<?php

namespace App\view\components\Navigation;

abstract class BaseNavigation
{
    private array $navItems =[];

    /**
     * @param array $navItems
     */
    public function __construct(array $navItems)
    {
        $this->navItems = $navItems;
    }

    public function render(): string
    {
        return "<div class='nav'>
                    <ul>
                        {$this->renderItems()}
                    </ul>
                </div>";

    }

    private function renderItems(): string
    {
        $items='';
        foreach ($this->navItems as $item)
        {
            $items.="<li><a href='{$item['url']}'>{$item['title']}</a></li>";
        }
        return $items;
    }


}