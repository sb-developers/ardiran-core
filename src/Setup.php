<?php

namespace Ardiran\Core;

use Ardiran\Core\Application\Container;
use Ardiran\Core\View\Blade\BladeProvider;
use Ardiran\Core\View\Blade\Blade;
use Ardiran\Core\Config\Config;

abstract class Setup{

    public static function registerConfig($app, $config = []){

        $defaults = [
            'theme' => [
                'dir' => get_theme_file_path(),
                'uri' => get_theme_file_uri(),
            ],
            'view' => [ 
                'paths' => [ 
                    get_theme_file_path().'/views',
                    get_parent_theme_file_path().'/views',
                ],
                'compiled' => wp_upload_dir()['basedir'] . '/cache',
                'namespaces' => [ ],
            ]
        ];

        $config = array_replace_recursive($defaults, $config);

        $app->bindIf('config', function() use ($config) {
            return new Config($config);
        }, true);

    }

    public static function registerBlade($app){

        $app->singleton('ardiran.blade', function (Container $container) {

            $cachePath = $container['config']->get('view.compiled');

            if (!file_exists($cachePath)) {
                wp_mkdir_p($cachePath);
            }

            (new BladeProvider($container))->register();

            return new Blade($container['view']);

        });

    }

}