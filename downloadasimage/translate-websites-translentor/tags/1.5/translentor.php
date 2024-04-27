<?php
/**
 * Plugin Name: Translentor
 * Plugin URI: https://translentor.com
 * Description: This plugin adds a language translator widget to the Elementor Page Builder.
 * Version: 1.5
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

add_action('admin_enqueue_scripts', function(){
    wp_register_style( 'translentor_admin_css', translentor_URL . 'admin/assets/css/translentor-admin.min.css', array(),translentor_VERSION );
    wp_enqueue_style( 'translentor_admin_css' );

    wp_register_script( 'translentor_admin_js', translentor_URL . 'admin/assets/js/translentor-admin.min.js' , array( 'jquery' ),
    translentor_VERSION,true);

    wp_enqueue_script( 'translentor_admin_js' );
} );
add_action( 'admin_menu','admin_menu' , 9 );
function admin_menu() 
{
if(class_exists( 'Elementor\Plugin' ) ){
$menu = 'add_menu_' . 'page';
$menu(
'translentor_panel',
esc_html__( 'Translentor', translentor_slug ),
esc_html__( 'Translentor', translentor_slug ),
'translentor_page',
NULL,
translentor_URL . 'translentor/assets/logo/menu-icon.png',
100
);

add_submenu_page(
'translentor_page', 
esc_html__( 'Plugin Options', translentor_slug ),
esc_html__( 'Plugin Options', translentor_slug ), 
'manage_options', 
'translentor-module', 
'translentor_module' 
);
if(get_option('translentor')=="yes")
{
//........

}else{
update_option('google_translation','no');
update_option('deepl_translation','no');
update_option('manual_translation','no');
}
}
}

function translentor_module()
{
require_once translentor_DIR_Main .'admin/module/translentor-module.php';
}
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
        if (!class_exists( 'WooCommerce' )){
            update_option('woomentorcurrency','no');
      ?>
	<div class="notice notice-warning is-dismissible">
		<p><strong>Warning</strong>: Woomentor work with Woocommerce Plugin. Please Activate Woocommerce Plugin</p>
	</div>
	<?php
        }
    if(!class_exists( 'Elementor\Plugin' ) )
    {
        update_option('translentor','no');
        update_option('woomentorcurrency','no');
        update_option('texthightlight','no');
        update_option('iconstroke','no');
        ?>
        <div class="notice notice-warning is-dismissible">
            <p><strong>Warning</strong>: Translentor work with Elementor Plugin. Please Activate Elementor Plugin</p>
        </div>
        <?php
    }
        
    }
   
    add_action('admin_notices', 'translentor_admin_notices');
    
    
