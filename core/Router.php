<?php

namespace  app\core;
class Router
{
    public Request $request;
  protected  array  $routes =[];

    public function __construct( \app\core\Request $request)
    {
        $this->request = $request;
    }


    public  function get($path, $callback)
  {
      $this->routes['get'][$path] = $callback;
  }
  public  function resolve()
  {
     $path =$this->request->getPath();
     $method = $this->request->getMethod();

     $callback = $this->routes[$method][$path] ?? false;
     if($callback === false)
     {
          echo "Not found";
          exit;
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
            echo $rootView;

        $layoutContent = $this->layoutContent($rootLayout);
        $viewContent = $this->renderOnlyView($rootView);
        return str_replace('{{content}}', $viewContent, $layoutContent);
        include_once Application::$ROOT_DIR."/view/$rootView.php";
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



}