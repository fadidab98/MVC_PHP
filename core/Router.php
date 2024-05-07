<?php

namespace  app\core;
class Router
{
    public Request $request;
    public Response $response;
  protected  array  $routes =[];

    public function __construct( Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }


    public  function get($path, $callback)
  {
      $this->routes['get'][$path] = $callback;
  }
    public  function post($path, $callback)
    {
        $this->routes['post'][$path] = $callback;
    }
  public  function resolve()
  {
     $path =$this->request->getPath();
     $method = $this->request->getMethod();

     $callback = $this->routes[$method][$path] ?? false;
     if($callback === false)
     {
         $this->response->setStatusCode(404);
         return $this->renderView("layouts.user.main._404");
     }
     if(is_string($callback))
     {
         return $this->renderView($callback);
     }
     return call_user_func($callback);


  }

    public function renderView($view)
    {
        $rootView="";
        $rootLayout = "";

        $root=  explode(".",$view);

        if(count($root) ==1)
        {
            $rootView= $view;
        }else{
            for($i=0; $i<count($root); $i++)
            {
                if($i == count($root)-1)
                {
                    $rootView = $root[$i];
                }
                else{
                    $rootLayout = $rootLayout."/". $root[$i];                }
            }

        }

        $layoutContent = $this->layoutContent($rootLayout);
        $viewContent = $this->renderOnlyView($rootView);
        return str_replace('{{content}}', $viewContent, $layoutContent);
    }
    protected function layoutContent($rootLayout)
    {
        ob_start();
        include_once Application::$ROOT_DIR."/view/$rootLayout.php";
        return ob_get_clean();
    }
    protected function renderOnlyView($view)
    {
        ob_start();
        include_once Application::$ROOT_DIR."/view/$view.php";
        return ob_get_clean();
    }

    public function renderContent($viewContent)
    {
        $rootLayout= "layouts/user/main";

        $layoutContent = $this->layoutContent($rootLayout);
        return str_replace('{{content}}', $viewContent, $layoutContent);
    }

}