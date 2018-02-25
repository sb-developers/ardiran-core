<?php

namespace Ardiran\Core\View;

use Ardiran\Core\Application\ServiceProvider;
use Ardiran\Core\Facades\Config;
use Ardiran\Core\View\Blade\BladeCompiler;
use Ardiran\Core\View\Twig\TwigCompiler;
use Ardiran\Core\View\Twig\TwigEngine;
use Ardiran\Core\View\ViewException;
use Illuminate\Filesystem\Filesystem;
use Illuminate\View\Engines\CompilerEngine;
use Illuminate\View\Engines\EngineResolver;
use Illuminate\View\Engines\PhpEngine;
use Illuminate\View\Factory;

class ViewServiceProvider extends ServiceProvider {

    /**
     * Register template compilers in the Laravel core.
     *
     * @return void
     */
    public function register(){

        $this->app->singleton('ardiran.filesystem', function ($container) {
            return new Filesystem();
        });

        $this->registerTwigEnvirorment();

        $this->registerBladeCompiler();

        $this->registerEngineResolver();

        $this->registerView();

    }

    private function registerBladeCompiler(){

        $this->app->singleton('ardiran.bladeCompiler', function ($container) {

            if( !Config::has('view.compiled')){
                throw new ViewException("You must add to the configuration the 'view.compiled' in config directory.");
            }

            $pathToCompiledTemplates = Config::get('view.compiled');
            $filesystem = $container['ardiran.filesystem'];

            $this->createCompiledDirectoryIfNotExist($filesystem, $pathToCompiledTemplates);

            return new BladeCompiler($filesystem , $pathToCompiledTemplates);
        });

    }

    private function registerTwigEnvirorment(){

        // Twig Filesystem loader.
        $this->app->singleton('ardiran.twigFilesystem', function () {
            return new \Twig_Loader_Filesystem();
        });

        // Twig
        $this->app->singleton('ardiran.twigCompiler', function ($container) {

            if( !Config::has('view.compiled')){
                throw new ViewException("You must add to the configuration the 'view.compiled' in config directory.");
            }

            $filesystem = $container['ardiran.filesystem'];
            $twigFilesystem = $container['ardiran.twigFilesystem'];
            $pathToCompiledTemplates = Config::get('view.compiled');

            $this->createCompiledDirectoryIfNotExist($filesystem, $pathToCompiledTemplates);

            $twigCompiler = new TwigCompiler($twigFilesystem, $pathToCompiledTemplates);

            return $twigCompiler->getCompiler();

        });

    }

    private function registerEngineResolver(){

        $this->app->singleton('ardiran.engineResolver', function ($container) {

            $engineResolver = new EngineResolver();

            $bladeCompiler = $container['ardiran.bladeCompiler'];
            $filesystem = $container['ardiran.filesystem'];

            $engineResolver->register('blade', function () use ($bladeCompiler, $filesystem ) {
                return new CompilerEngine($bladeCompiler, $filesystem);
            });

            $engineResolver->register('php', function () {
                return new PhpEngine();
            });

            $engineResolver->register('twig', function () use ($container){

                if( !Config::has('view.paths') ){
                    throw new ViewException("You must add to the configuration the 'view.paths' in config directory.");
                }

                $pathsToTemplates = Config::get('view.paths');

                $container['ardiran.twigFilesystem']->setPaths($pathsToTemplates);

                return new TwigEngine($container['ardiran.twigCompiler'], $container['ardiran.viewFinder']);

            });

            return $engineResolver;

        });

    }

    private function registerView(){

        $this->app->singleton('ardiran.viewFinder', function ($container) {

            if( !Config::has('view.paths') ){
                throw new ViewException("You must add to the configuration the 'view.paths' in config directory.");
            }

            $filesystem = $container['ardiran.filesystem'];
            $pathsToTemplates = Config::get('view.paths');

            return new FileViewFinder($filesystem, $pathsToTemplates, ['blade.php', 'twig', 'php']);
        });

        $this->app->singleton('ardiran.view', function ($container) {

            $engineResolver = $container['ardiran.engineResolver'];
            $viewFinder = $container['ardiran.viewFinder'];
            $eventDispatcher = $container['ardiran.events'];

            $factory = new Factory($engineResolver, $viewFinder, $eventDispatcher);

            $factory->setContainer($container);

            // Tell the factory to handle twig extension files and assign them to the twig engine.
            $factory->addExtension('twig', 'twig');

            // We will also set the container instance on this view environment since the
            // view composers may be classes registered in the container, which allows
            // for great testable, flexible composers for the application developer.
            $factory->setContainer($container);

            $factory->share('app', $container);


            return $factory;

        });

    }

    private function createCompiledDirectoryIfNotExist($filesystem, $pathToCompiledTemplates){

        if ( !$filesystem->isDirectory($pathToCompiledTemplates)){
            $filesystem->makeDirectory($pathToCompiledTemplates, 755, true, true);
        }

    }

}