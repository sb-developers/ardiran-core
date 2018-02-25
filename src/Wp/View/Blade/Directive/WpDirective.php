<?php

namespace Ardiran\Core\Wp\View\Blade\Directive;

class WpDirective{

    /**
     * Add the Wordpress directives to the Blade compiler.
     *
     * @param [type] $compiler
     * @return void
     */
    public function extend( &$compiler ){

        /*
         * Add the '@wp_head' directive
         */
        $compiler->directive('wp_head', function () {
            return '<?php wp_head(); ?>';
        });

        /*
         * Add the '@wp_footer' directive
         */
        $compiler->directive('wp_footer', function () {
            return '<?php wp_footer(); ?>';
        });

        /*
         * Add the '@get_bloginfo' directive
         */
        $compiler->directive('get_bloginfo', function ($show = '', $filter = '"raw"') {
            return '<?php echo get_bloginfo(' . $show . ', ' . $filter . '); ?>';
        });

        /*
         * Add the '@body_class' directive
         */
        $compiler->directive('body_class', function ($class = '') {
            return '<?php echo body_class(' . $class .'); ?>';
        });

        /*
         * Add the '@loop' directive.
         */
        $compiler->directive('loop', function () {
            return '<?php if(have_posts()) { while(have_posts()) { the_post(); ?>';
        });

        /*
         * Add the '@endloop' directive.
         */
        $compiler->directive('endloop', function () {
            return '<?php }} ?>';
        });

        /*
         * Add the '@__' directive
         */
        $compiler->directive('__', function ($text, $domain = '"default"') {
            return '<?php echo __(' . $text . ', ' . $domain . '); ?>';
        });

        /*
         * Add the '@_e' directive
         */
        $compiler->directive('_e', function ($text, $domain = '"default"') {
            return '<?php echo _e(' . $text . ', ' . $domain . '); ?>';
        });

        /*
         * Add the '@_n' directive
         */
        $compiler->directive('_n', function ($single, $plural, $number, $domain = '"default"') {
            return '<?php echo _n(' . $single . ', ' . $plural . ', ' . $number . ', ' . $domain . '); ?>';
        });

        /*
         * Add the '@_x' directive
         */
        $compiler->directive('_x', function ($text, $context, $domain = '"default"') {
            return '<?php echo _x(' . $text . ', ' . $context . ', ' . $domain . '); ?>';
        });

        /*
         * Add the '@_ex' directive
         */
        $compiler->directive('_ex', function ($text, $context, $domain = '"default"') {
            return '<?php echo _ex(' . $text . ', ' . $context . ', ' . $domain . '); ?>';
        });

        /*
         * Add the '@_nx' directive
         */
        $compiler->directive('_nx', function ($text, $plural, $number, $context, $domain = '"default"') {
            return '<?php echo _nx(' . $text . ', ' . $plural . ', ' . $number . ', ' . $context . ', ' . $domain . '); ?>';
        });

        /*
         * Add the '@_n_noop' directive
         */
        $compiler->directive('_n_noop', function ($singular, $plural, $domain) {
            return '<?php echo _n_noop(' . $singular . ', ' . $plural . ', ' . $domain . '); ?>';
        });

        /*
         * Add the '@_nx_noop' directive
         */
        $compiler->directive('_nx_noop', function ($singular, $plural, $context, $domain) {
            return '<?php echo _nx_noop(' . $singular . ', ' . $plural . ', ' . $context . ', ' . $domain . '); ?>';
        });

        /*
         * Add the '@translate_nooped_plural' directive
         */
        $compiler->directive('translate_nooped_plural', function ($nooped_plural, $count, $domain) {
            return '<?php echo translate_nooped_plural(' . $nooped_plural . ', ' . $count . ', ' . $domain . '); ?>';
        });

    }

}