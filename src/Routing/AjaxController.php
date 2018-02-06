<?php

namespace Ardiran\Core\Routing;

use Ardiran\Core\Ardiran;
use Ardiran\Core\Http\Request;
use Ardiran\Core\Routing\Controller;

abstract class AjaxController extends Controller {

	/**
	 * Name of the action that will be registered in WordPress.
	 *
	 * @var String
	 */
    protected $action;

	/**
	 * Constructor.
	 */
    public function __construct(){ }

	/**
	 * Function where the HTTP request will be redirected.
	 *
	 * @param Request $request
	 * @return void
	 */
    abstract protected function run($request);

	/**
	 * Function registered by the controller within WordPress in order to receive the request.
	 *
	 * @param boolean $public
	 * @return void
	 */
    public static function listen($public = true){

		$actionName = Self::getAttribute('action');
		$className = Self::getClassName();

		add_action("wp_ajax_{$actionName}", [$className, 'boot']);
		
		if($public){
			add_action("wp_ajax_nopriv_{$actionName}", [$className, 'boot']);
		}

	}
	
	/**
	 * Function to which the registered action in WordPress will call.
	 * This function will instantiate the controller and call the run method.
	 *
	 * @return void
	 */
	public static function boot(){

        $container = Ardiran::getInstance();

        $request = $container->container('ardiran.request');

		$classObj = Self::getClassName();
		$class = new $classObj;
		
		$class->run($request);

		die();
		
	}

	/**
	 * Returns the name of the class.
	 *
	 * @return string
	 */
    public static function getClassName(){
		return get_called_class();
	}

	/**
	 * Returns the value of an attribute of the class.
	 *
	 * @param string $attribute
	 * @return any
	 */
	public static function getAttribute($attribute){

		$className = Self::getClassName();
		$reflection = new \ReflectionClass($className);
		$class = $reflection->newInstanceWithoutConstructor();

		if(!isset($class->{$attribute})){
			throw new \Exception("Public property \$attribute not provied");
		}

		return $class->{$attribute};

	}

}