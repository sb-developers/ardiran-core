<?php

namespace Ardiran\Core\View\Blade\Directive;

class WpDirective{

    /**
     * Add the Wordpress directives to the Blade compiler.
     *
     * @param [type] $compiler
     * @return void
     */
    public function extend( &$compiler ){

        /*
         * Add the "@wp_head" directive
         */
        $compiler->directive('wp_head', function () {
            return '<?php wp_head(); ?>';
        });

        /*
         * Add the "@wp_footer" directive
         */
        $compiler->directive('wp_footer', function () {
            return '<?php wp_footer(); ?>';
        });

        /*
         * Add the "@get_bloginfo" directive
         */
        $compiler->directive('get_bloginfo', function ($show = '', $filter = 'raw') {
            return '<?php echo get_bloginfo(' . $show . ', ' . $filter . '); ?>';
        });

        /*
         * Add the "@body_class" directive
         */
        $compiler->directive('body_class', function ($class = '') {
            return '<?php echo body_class(' . $class . '); ?>';
        });

    }

}