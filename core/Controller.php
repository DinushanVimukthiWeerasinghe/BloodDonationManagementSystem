<?php
namespace Core;
class Controller
{
    public string $action='';
    public string $layout = 'main';
    private array $middlewares = [];
    public function setLayout($layout): void
    {
        $this->layout = $layout;
    }

    public static function render($view,$params = []): string
    {
        return Application::$app->view->renderView($view,$params);
    }


    public function registerMiddleware(BaseMiddleware $middleware): void
    {
        $this->middlewares[]=$middleware;

    }

    public function setFlashMessage($key,$message): void
    {
        Application::$app->session->setFlash($key,$message);
    }

    /**
     * @return array
     */
    public function getMiddlewares(): array
    {
        return $this->middlewares;
    }
}