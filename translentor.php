<?php
/**
 * Plugin Name: Translentor
 * Plugin URI: https://translentor.com
 * Description: This plugin adds a language translator widget to the Elementor Page Builder.
 * Version: 1.6.1
 * Author: Translentor
 * Author URI: https://translentor.com
 * Domain Path: translentor
 * @package Translentor
 */

define( 'translentor_DIR_Main', plugin_dir_path( __FILE__ ) ); 
define( 'translentor_URL', plugin_dir_url( __FILE__ ) );
define( 'translentor_VERSION', '1.5' );
define( 'translentor_slug', 'translentor' );
define('translentor_category_icon', 'fa fa-plug');
define('translentor_category', 'Translator');
use Elementor\Plugin;



function cyb_activation_redirect( $plugin ) {
if( $plugin == plugin_basename( __FILE__ ) ) {
exit( wp_redirect( admin_url( 'admin.php?page=translentor-module' ) ) );
}
}
add_action( 'elementor/elements/categories_registered', function () 
            {
            	$elementsManager = Plugin::instance()->elements_manager;
				
            	$elementsManager->add_category
            	(
            		'translentor-category',
            			array(
            				'title' => translentor_category,
            				'icon'  => translentor_category_icon,
            			)
            	);
            });
//require_once translentor_DIR_Main .'translentor/translentor.php';


require_once translentor_DIR_Main .'widgets/index.php';
   
    function translentor_admin_notices() {
        
    if(!class_exists( 'Elementor\Plugin' ) )
    {
        
        ?>
        <div class="notice notice-warning is-dismissible">
            <p><strong>Warning</strong>: Translentor work with Elementor Plugin. Please Activate Elementor Plugin</p>
        </div>
        <?php
    }
        
    }
   
    add_action('admin_notices', 'translentor_admin_notices');
    
    
