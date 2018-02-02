<?php

namespace Ardiran\Core\Traits;

Trait Singleton {

    /**
    * Variable where the singleton object is stored.
    */
   private static $singleton = false;

   /**
    * Define an inaccessible constructor.
    */
   private function __construct() {
       $this->__instance();
   }

   /**
    * Get an instance of the class.
    */
   public static function getInstance() {

       if (self::$singleton === false) {
           self::$singleton = new self();
       }

       return self::$singleton;

   }
   
}