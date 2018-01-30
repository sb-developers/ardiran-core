<?php

namespace Ardiran\Core\Ajax;

use Ardiran\Core\Ajax\Traits\Request;
use Ardiran\Core\Ajax\Traits\Response;

abstract class AjaxController{

    use Request, Response;

    protected $action;

    public function __construct(){ 

		$this->request = $_REQUEST;

    }

    abstract protected function run();

    public static function listen($public = true){

		$actionName = Self::getActionName();
		$className = Self::getClassName();

		add_action("wp_ajax_{$actionName}", [$className, 'boot']);
		
		if($public){
			add_action("wp_ajax_nopriv_{$actionName}", [$className, 'boot']);
		}

	}
	
	public static function boot(){ 	

		$class = Self::getClassName();
		$action = new $class;
		$action->run();

		die();
		
	}
    
    public static function getClassName(){
		return get_called_class();
	}

	public static function getActionName(){
		
		$class = Self::getClassName();
		$reflection = new \ReflectionClass($class);
		$action = $reflection->newInstanceWithoutConstructor();

		if(!isset($action->action)){
			throw new \Exception("Public property \$action not provied");
		}

		return $action->action;
		
	}

}