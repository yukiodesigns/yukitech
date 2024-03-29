<?php
// namespace Framework; -For the composer install

use App\Controllers\ErrorController;

class Router{
    protected $routes = [];
     /** 
     * Add a new route
     * @param string $method
     * @param string $uri
     * @param string $action
     * @return void
     */
    public function registerRoute($method,$uri, $action){
        list($controller, $controllerMethod)=$arr = explode('@', $action);
        $this->routes[] = [
            'method'=>$method,
            'uri'=> $uri,
            'controller'=>$controller,
            'controllerMethod'=>$controllerMethod
        ];

    }
    /** 
     * Add a GET route
     * @param string $uri
     * @param string $controller
     * @return void
     */
    public function get($uri, $controller){
        $this -> registerRoute('GET', $uri, $controller);
    }

    /** 
     * Add a POST route
     * @param string $uri
     * @param string $controller
     * @return void
     */
    public function post($uri, $controller){
        $this -> registerRoute('POST', $uri, $controller);    
    }

     /** 
     * Add a PUT route
     * @param string $uri
     * @param string $controller
     * @return void
     */
    public function put($uri, $controller){
        $this -> registerRoute('PUT', $uri, $controller);    
    }

     /** 
     * Add a DELETE route
     * @param string $uri
     * @param string $controller
     * @return void
     */
    public function delete($uri, $controller){
        $this -> registerRoute('DELETE', $uri, $controller);   
    }
   
    /** 
     * Route the request
     * @param string $uri
     * @param string $method
     * @return  void
     */
    public function route($uri){
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        foreach($this->routes as $route){
            // Split uri into segments
            $uriSegments=explode('/', trim($uri, '/'));

            // Split the route uri into segments
            $routeSegments=explode('/', trim($route['uri'], '/'));
            $match = true;

            // Check if number of segments matches
            if (count($uriSegments) == count($routeSegments) && strtoupper($route['method']=== $requestMethod)){
                $params=[];
                $match = true;
                for($i=0; $i<count($uriSegments); $i ++){
                    // If uris dont match and there is no params,
                    if($routeSegments[$i] !== $uriSegments[$i] && !preg_match('/\{(.+?)\}/', $routeSegments[$i])){
                        $match=false;
                        break;
                    }

                    if(preg_match('/\{(.+?)\}/', $routeSegments[$i], $matches)){
                        $params[$matches[1]]= $routeSegments[$i];
                    }
                }
                if($match){
                   // Extract controller and method
                    $controller = 'App\\Controllers\\'.$route['controller'];
                    $controllerMethod = $route['controllerMethod'];

                    // Instanciate controller and call method
                    $controllerInstance = new $controller();
                    $controllerInstance->$controllerMethod($params);
                    return; 
                }
            }
            // if ($route['uri']=== $uri && $route['method']===$method){
                
            //     // Extract controller and method
            //     $controller = 'App\\Controllers\\'.$route['controller'];
            //     $controllerMethod = $route['controllerMethod'];

            //     // Instanciate controller and call method
            //     $controllerInstance = new $controller();
            //     $controllerInstance->$controllerMethod();
            //     return;

            // }
        }
        ErrorController::notFound();
        
    }

}
