<?php

namespace Ardiran\Core\Ajax;

class Request{

    /**
     * HTTP request.
     *
     * @var $_REQUEST
     */
    private $request;

    /**
     * Constructor
     *
     * @param $_REQUEST $request
     */
    public function __construct($request){ 

      $this->request = $request;

    }

    /**
     * Check if there is a specific parameter in the request.
     *
     * @param string $key
     * @return boolean
     */
    public function has($key){

      if(isset($this->request[$key])){
        return true;
      }

      return false;

    }

    /**
     * Gets the value of the parameter.
     *
     * @param string $key
     * @param null $default
     * @param boolean $stripslashes
     * @return $default | string 
     */
    public function get($key, $default = null, $stripslashes = true){

      if($this->has($key)){
        if($stripslashes){
          return stripslashes($this->request[$key]);
        }
        return $this->request[$key];
      }

      return $default;

    }

    /**
     * Returns the type of the request (GET, POST, PUT, UPDATE, DELETE)
     * Given a type, it returns true or false if the request is of the same type.
     *
     * @param string $requestType
     * @return boolean | string
     */
    public function requestType($requestType = null){

      if(!is_null($requestType)){

        if(is_array($requestType)){
          return in_array($_SERVER['REQUEST_METHOD'], array_map('strtoupper', $requestType));
        }

        return ($_SERVER['REQUEST_METHOD'] === strtoupper($requestType));
      }

      return $_SERVER['REQUEST_METHOD'];

	  }

}