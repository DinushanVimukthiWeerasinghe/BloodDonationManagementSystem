<?php

namespace App\view\components\WebComponent\Card;

class NavigationCard
{
    private string $NavigationURL;
    private string $ImageURL;
    private string $Title;
    private string $id;

    /**
     * @param string $NavigationURL
     * @param string $ImageURL
     * @param string $Title
     *  @param string $id
     */
    public function __construct(string $NavigationURL, string $ImageURL, string $Title, string $id)
    {
        $this->NavigationURL = $NavigationURL;
        $this->ImageURL = $ImageURL;
        $this->Title = $Title;
        $this->id = $id;
    }

    public function __toString(): string
    {
        return <<<HTML
            <div class="card nav-card bg-white text-dark" id="$this->id" onclick="Redirect('$this->NavigationURL')">
                    <div class="card-header">
                        <div class="card-header-img">
                            <img src="$this->ImageURL" alt="Donor" width="100px">
                        </div>
                        <div class="card-title">
                            <h3>$this->Title</h3>
                        </div>
                    </div>
                </div>
            HTML;

    }

}
?>