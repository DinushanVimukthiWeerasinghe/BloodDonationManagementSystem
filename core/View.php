<?php
namespace Core;
class View
{
    public string $title='';
    public function renderView($view,$params=[])
    {
        $layoutContent=$this->layoutContent($params);
        $viewContent=$this->renderOnlyView($view,$params);
        return str_replace('{{content}}',$viewContent,$layoutContent);
    }



    private function renderContent($viewContent): array|bool|string
    {
        $layoutContent=$this->layoutContent('main');
        return str_replace('{{content}}',$viewContent,$layoutContent);
    }



    protected function layoutContent($params): bool|string
    {
        $layout=Application::$app->layout;
        if(Application::$app->controller)
        {
            $layout=Application::$app->controller->layout;
        }
        foreach ($params as $key=>$value){
            $$key=$value;
        }
        ob_start();
        include_once Application::$ROOT_DIR ."/app/view/layout/$layout.php";
        return ob_get_clean();
    }

    protected function renderOnlyView($view,$params): bool|string
    {
        foreach ($params as $key=>$value){
            $$key=$value;
        }
        ob_start();
        include_once Application::$ROOT_DIR ."/app/view/pages/$view.php";
        return ob_get_clean();
    }

}