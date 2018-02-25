<?php

namespace Ardiran\Core\Wp\View\Twig\Extension;

use \Twig_Extension;
use \Twig_SimpleFunction;

class WpExtension extends Twig_Extension {

    public function __construct(){ }

    /**
     * Define the extension name.
     *
     * @return string
     */
    public function getName(){
        return 'ardiranWp';
    }

    /**
     * Register a global "fn" which can be used
     * to call any WordPress or core PHP functions.
     *
     * @return array
     */
    public function getGlobals(){

        return [
            'fn' => $this
        ];

    }

    /**
     * Allow developers to call core php and WordPress functions
     * using the `fn` namespace inside their templates.
     * Linked to the global call only...
     *
     * @param string $name
     * @param array  $arguments
     *
     * @return mixed
     */
    public function __call($name, array $arguments){
        return call_user_func_array($name, $arguments);
    }

    /**
     * Register a list of functions available into Twig templates.
     *
     * @return array|\Twig_SimpleFunction[]
     */
    public function getFunctions(){

        return [

            new Twig_SimpleFunction('fn', function ($functionName) {

                $args = func_get_args();

                // By default, the function name should always be the first argument.
                // This remove it from the arguments list.
                array_shift($args);

                if (is_string($functionName)) {
                    $functionName = trim($functionName);
                }

                return call_user_func_array($functionName, $args);

            }),

            new Twig_SimpleFunction('wp_head', 'wp_head'),

            new Twig_SimpleFunction('wp_footer', 'wp_footer'),

            new Twig_SimpleFunction('get_bloginfo', function ($show = '', $filter = 'raw') {
                return get_bloginfo($show, $filter);
            }),

            new Twig_SimpleFunction('body_class', function ($class = '') {
                return body_class($class);
            }),

            new Twig_SimpleFunction('__', function ($text, $domain = 'default') {
                return __($text, $domain);
            }),

            new Twig_SimpleFunction('_e', function ($text, $domain = 'default') {
                return _e($text, $domain);
            }),

            new Twig_SimpleFunction('_n', function ($single, $plural, $number, $domain = 'default') {
                return _n($single, $plural, $number, $domain);
            }),

            new Twig_SimpleFunction('_x', function ($text, $context, $domain = 'default') {
                return _x($text, $context, $domain);
            }),

            new Twig_SimpleFunction('_ex', function ($text, $context, $domain = 'default') {
                return _ex($text, $context, $domain);
            }),

            new Twig_SimpleFunction('_nx', function ($single, $plural, $number, $context, $domain = 'default') {
                return _nx($single, $plural, $number, $context, $domain);
            }),

            new Twig_SimpleFunction('_n_noop', function ($singular, $plural, $domain = 'default') {
                return _n_noop($singular, $plural, $domain);
            }),

            new Twig_SimpleFunction('_nx_noop', function ($singular, $plural, $context, $domain = 'default') {
                return _nx_noop($singular, $plural, $context, $domain);
            }),

            new Twig_SimpleFunction('translate_nooped_plural', function ($nooped_plural, $count, $domain = 'default') {
                return translate_nooped_plural($nooped_plural, $count, $domain);
            }),

        ];

    }

}