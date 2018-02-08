<?php

namespace Ardiran\Core\View\Blade;

use Ardiran\Core\View\Blade\Directive\WpDirective;
use Illuminate\View\Compilers\BladeCompiler as IlluminateBladeCompiler;

class BladeCompiler extends IlluminateBladeCompiler{

    /**
     * Constructor.
     *
     * @param $filesystem
     * @param $pathToCompiledTemplates
     */
    public function __construct( $filesystem, $pathToCompiledTemplates ){

        parent::__construct($filesystem, $pathToCompiledTemplates);

        $this->directives();

    }

    /**
	 * Extend blade with some custom directives
	 *
	 * @return void
	 */
	private function directives() {

        (new WpDirective())->extend($this);
 
    }

}