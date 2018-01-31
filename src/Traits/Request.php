<?php

namespace Ardiran\Core\Traits;

trait Request {

    protected $request;

    public function has($key){

		if(isset($this->request[$key])){
			return TRUE;
		}

		return FALSE;

    }
    
    public function get($key, $default = NULL, $stripslashes = TRUE){

		if($this->has($key)){
			if($stripslashes){
				return stripslashes($this->request[$key]);
			}
			return $this->request[$key];
		}

		return $default;

    }
    
    public function requestType($requestType = NULL){

		if(!is_null($requestType)){

			if(is_array($requestType)){
				return in_array($_SERVER['REQUEST_METHOD'], array_map('strtoupper', $requestType));
			}

			return ($_SERVER['REQUEST_METHOD'] === strtoupper($requestType));
		}

		return $_SERVER['REQUEST_METHOD'];

	}

}