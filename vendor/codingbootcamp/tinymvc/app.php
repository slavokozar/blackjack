<?php

namespace codingbootcamp\tinymvc;

class app
{
    public static function run()
    {
        // get the array of controller name and action name from routing
        // (based on the current URL)
        $controller_action = static::getControllerActionFromRequest();

        // run the proper controller's action based on the retrieved 
        // information
        static::runControllerAction(
            $controller_action['controller'], 
            $controller_action['action']
        );

        // send the current response object's content
        response::sendResponse();
    }

    // gets the array with controller name and action name based
    // on the current request (URL)
    protected static function getControllerActionFromRequest()
    {
        // initialize $routes as an empty array
        $routes = [];

        // include the file with the routes (contains $routes array as well)
        include ROUTES_DIR . '/web.php';

        // at this point $routes contains all the routes from web.php
        // get the current route parameter or 'homepage' if no route is set
        $current_route = request::get('route', 'homepage');

        // if the retrieved value of $route exists within the list of $routes
        if(array_key_exists($current_route, $routes)) // also possible: if(isset($routes[$current_route]))
        {
            // return the value from $routes
            return $routes[$current_route];
        }
        else // otherwise
        {
            // return the errorController's error404 action
            return [
                'controller' => 'errorController',
                'action' => 'error404'
            ];
        }
    }

    // run an action of a controller
    protected static function runControllerAction($controller_name, $action_name)
    {
        // require the correct controller file
        require APP_DIR . '/controllers/'.$controller_name.'.php';

        // change the controller class into FQN
        $controller_name = '\\app\\controllers\\'.$controller_name;

        // create an object instance of the controller class
        $controller = new $controller_name();
        // call the index method of the controller and echo the result
        $controller_output = $controller->$action_name();

        $response = response::getInstance();

        $response->setContent($controller_output);
    }
}