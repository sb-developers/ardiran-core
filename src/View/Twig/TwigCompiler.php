<?php

namespace Ardiran\Core\View\Twig;

use \Twig_Extension_Debug;
use Ardiran\Core\Wp\View\Twig\Extension\WpExtension;

class TwigCompiler{

    private $compiler;

    public function __construct($filesystem, $pathToCompiledTemplates){

        $this->compiler = new \Twig_Environment($filesystem, [
            'auto_reload' => true,
            'cache' => $pathToCompiledTemplates . '/twig',
        ]);

        $this->extensions();

    }

    private function extensions(){

        // Add the dump Twig extension.
        $this->compiler->addExtension(new Twig_Extension_Debug());

        // Provides WordPress functions and more to Twig templates.
        $this->compiler->addExtension(new WpExtension());

    }

    public function getCompiler(){
        return $this->compiler;
    }

}