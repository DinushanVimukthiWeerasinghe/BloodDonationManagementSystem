<?php

namespace Core;

class forbiddenRoute
{
    private array $forbiddenRoutes=[];

    /**
     * @return array
     */
    public function getForbiddenRoutes(): array
    {
        return $this->forbiddenRoutes;
    }
    public function isForbidden(): bool
    {
        foreach ($this->forbiddenRoutes as $key=>$forbiddenRoute) {
            if($key==Application::getRole()) {
                if(in_array(ltrim(Application::$app->request->getPath(),'/'),$forbiddenRoute)) {
                    return true;
                }
            }
        }
        return false;
    }
    /**
     * @param array $forbiddenRotes
     */
    public function setForbiddenRotes(array $forbiddenRotes): void
    {
        $this->forbiddenRoutes = $forbiddenRotes;
    }
}