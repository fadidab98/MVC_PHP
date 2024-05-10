<?php

namespace  app\core;
use Couchbase\View;

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
     $method = $this->request->method();

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
     if(is_array($callback))
     {
         $callback[0] = new $callback[0]();
     }
     return call_user_func($callback, $this->request);


  }

    public function renderView($view,$params=[])
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
        $viewContent = $this->renderOnlyView($rootView,$params);
        return str_replace('{{content}}', $viewContent, $layoutContent);
    }
    protected function layoutContent($rootLayout)
    {
        ob_start();
        include_once Application::$ROOT_DIR."/view/$rootLayout.php";
        return ob_get_clean();
    }
    protected function renderOnlyView($view,$params)
    {
        foreach($params as $key=>$value)
        {
            $$key = $value;
        }
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