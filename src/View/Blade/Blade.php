<?php

namespace Ardiran\Core\View\Blade;

use Ardiran\Core\Application\Container;
use Ardiran\Core\View\Blade\Directive\WpDirective;
use Illuminate\Events\Dispatcher;
use Illuminate\Filesystem\Filesystem;
use Illuminate\View\Compilers\BladeCompiler;
use Illuminate\View\Engines\CompilerEngine;
use Illuminate\View\Engines\EngineResolver;
use Illuminate\View\Engines\PhpEngine;
use Illuminate\View\Factory;
use Illuminate\View\FileViewFinder;

class Blade{

    /**
     * Instance of Laravel Container.
     *
     * @var Container
     */
    private $container;

    /**
     * Directories where the Blade templates will be found.
     *
     * @var array
     */
    private $pathsToTemplates;

    /**
     * Directory where the compiled templates are stored.
     *
     * @var string
     */
    private $pathToCompiledTemplates;

    /**
     * Filesystem
     *
     * @var Filesystem
     */
    private $filesystem;

    /**
     * Event dispatcher
     *
     * @var Dispatcher
     */
    private $eventDispatcher;

    /**
     * View resolver
     *
     * @var EngineResolver
     */
    private $viewResolver;

    /**
     * Blade Compiler
     *
     * @var BladeCompiler
     */
    private $bladeCompiler;

    /**
     * View finder
     *
     * @var FileViewFinder
     */
    private $viewFinder;

    /**
     * View factory
     *
     * @var Factory
     */
    private $viewFactory;

    /**
     * Constructor
     *
     * @param Container $container
     * @param array $pathsToTemplates
     * @param string $pathToCompiledTemplates
     */
    public function __construct( $container, $pathsToTemplates, $pathToCompiledTemplates ){

        $this->container = $container;
        $this->pathsToTemplates = $pathsToTemplates;
        $this->pathToCompiledTemplates = $pathToCompiledTemplates;

        $this->setup();
        $this->extend();

    }

    /**
     * Load all dependencies and generate the Blade compiler
     *
     * @return void
     */
    private function setup(){

        $this->filesystem = new Filesystem();

        $this->eventDispatcher = new Dispatcher( $this->container );

        $this->viewResolver = new EngineResolver();

        $this->bladeCompiler = new BladeCompiler($this->filesystem, $this->pathToCompiledTemplates);

        $bladeCompiler = $this->bladeCompiler;

        $filesystem = $this->filesystem;

        $this->viewResolver->register('blade', function () use ( $bladeCompiler, $filesystem ) {
            return new CompilerEngine( $bladeCompiler, $filesystem );
        });

        $this->viewResolver->register('php', function () {
            return new PhpEngine();
        });

        $this->viewFinder = new FileViewFinder($this->filesystem, $this->pathsToTemplates);
        
        $this->viewFactory = new Factory($this->viewResolver, $this->viewFinder, $this->eventDispatcher);

    }

    /**
	 * Extend blade with some custom directives
	 *
	 * @return void
	 */
	private function extend() {

        (new WpDirective())->extend($this->bladeCompiler);
 
    }

    /**
	 * Renders a given template
	 *
	 * @param string  $template Path to the template
	 * @param array   $with     Additional args to pass to the tempalte
	 * @return string           Compiled template
	 */
	public function view( $template, $with = array() ) {

        $html = $this->viewFactory->make( $template, $with )->render();
        
        return $html;
        
	}

}