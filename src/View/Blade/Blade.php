<?php

namespace Ardiran\Core\View\Blade;

class Blade{

    private static $_instance;

    private $paths;

    private $compiled;

    private $factory;

    public function __construct($config) {

        if(!isset($config['paths']) && empty($config['paths'])){
            die('It is necessary to define the path of the Blade views');
        }

        if(!isset($config['compiled']) && empty($config['compiled'])){
            die('It is necessary to define the path of the cache directory of the Blade views');
        }

        $this->paths = $config['paths'];
        $this->compiled = $config['compiled'];

        $this->maybeCreateCacheDirectory();

        $this->factory = new Factory( $this->paths, $this->compiled );
        $this->extend();

    }

    /**
	 * Main Blade Instance.
	 *
	 * Ensures only one instance of Blade is loaded or can be loaded.
	 *
	 * @since 1.0
	 * @static
	 * @return Ardiran\Core\View\Blade
	 */
	public static function getInstance($config = []) {

		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self($config);
        }
        
        return self::$_instance;
        
	}

    /**
	 * Checks whether the cache directory exists, and if not creates it.
	 *
	 * @return boolean
	 */
	private function maybeCreateCacheDirectory() {

		if ( !is_dir( $this->compiled ) ) {
			if ( wp_mkdir_p( $this->compiled ) ) {
				return true;
			}
        }
        
        return false;
        
    }
    
    /**
	 * Extend blade with some custom directives
	 *
	 * @return void
	 */
	private function extend() {

        /*
         * Add the "@wp_head" directive
         */
        $this->factory->compiler()->directive('wp_head', function () {
            return '<?php wp_head(); ?>';
        });

        /*
         * Add the "@wp_footer" directive
         */
        $this->factory->compiler()->directive('wp_footer', function () {
            return '<?php wp_footer(); ?>';
        });

        /*
         * Add the "@get_bloginfo" directive
         */
        $this->factory->compiler()->directive('get_bloginfo', function ($show = '', $filter = 'raw') {
            return '<?php echo get_bloginfo(' . $show . ', ' . $filter . '); ?>';
        });

    }

    /**
	 * Renders a given template
	 *
	 * @param string  $template Path to the template
	 * @param array   $with     Additional args to pass to the tempalte
	 * @return string           Compiled template
	 */
	public function view( $template, $with = array() ) {

        $html = $this->factory->render( $template, $with );
        
        return $html;
        
	}

}