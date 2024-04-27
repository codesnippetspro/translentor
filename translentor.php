<?php
/**
 * Plugin Name: Translentor Pro IP
 * Plugin URI: https://translentor.com
 * Description: This plugin adds a language translator widget to the Elementor Page Builder.
 * Version: 1.6
 * Author: Code Snippets
 * Author URI: https://translentor.com
 * Domain Path: translentor
 * @package Translentor
 */

define( 'translentor_VERSION', '1.6' );
define( 'translentor_DIR', plugin_dir_path( __FILE__ ) );
define( 'translentor_URL', plugin_dir_url( __FILE__ ) );
define( 'translentor_slug', 'translentor' );
define('translentor_category_icon', 'fa fa-plug');
define('translentor_category', 'Translator');
use Elementor\Plugin;
require_once(translentor_DIR.'widgets/index.php');
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

}
}
add_action('wp_ajax_globle_switcher', 'globle_switcher');
add_action('wp_ajax_nopriv_globle_switcher', 'globle_switcher');
function globle_switcher() {
$result = $_POST['result'];

// Perform actions based on the received parameter

// Send a response back
if($result==='checked')
{
update_option('globalSwitch','yes');
}else{
update_option('globalSwitch','no');

}
wp_die(); // Always use wp_die() to end the script properly
}
function translentor_module()
{
require_once translentor_DIR .'admin/module/settings.php';
require_once translentor_DIR .'admin/module/translentor-module.php';
}
function cyb_activation_redirect( $plugin ) {
if( $plugin == plugin_basename( __FILE__ ) ) {
exit( wp_redirect( admin_url( 'admin.php?page=translentor-module' ) ) );
}
}

add_action( 'activated_plugin', 'cyb_activation_redirect' );
if(  get_option('manual_translation')=='yes' || 
get_option('deepl_translation')=='yes' || get_option('google_translation')=='yes')
{
    
if ( translentor_enable_translentor() ) {
require_once translentor_DIR . 'translentor/load-translentor.php';

add_action( 'plugins_loaded', 'translentor_run_translentor_hooks', 1 );
}
}
function translentor_enable_translentor(){
$enable_translentor = true;
$current_php_version = apply_filters( 'translentor_php_version', phpversion() );

// 5.6.20 is the minimum version supported by WordPress
if ( $current_php_version !== false && version_compare( $current_php_version, '5.6.20', '<' ) ){
$enable_translentor = false;
add_action( 'admin_menu', 'translentor_translentor_disabled_notice' );
}

return apply_filters( 'translentor_enable_translentor', $enable_translentor );
}



function translentor_run_translentor_hooks(){

$translentor = translentor_Translentor::get_translentor_instance();
$translentor->run();

}

function translentor_translentor_disabled_notice(){
echo '<div class="notice notice-error"><p>' . wp_kses( sprintf( __( '<strong>Translentor</strong> requires at least PHP version 5.6.20+ to run. It is the <a href="%s">minimum requirement of the latest WordPress version</a>. Please contact your server administrator to update your PHP version.','translentor' ), 'https://wordpress.org/about/requirements/' ), array( 'a' => array( 'href' => array() ), 'strong' => array() ) ) . '</p></div>';
}
function translentor_in_dl_run(){

define( 'translentor_IN_DL_PLUGIN_VERSION', '1.0.5' );
define( 'translentor_IN_DL_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'translentor_IN_DL_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

require_once plugin_dir_path( __FILE__ ) . 'translentor/deepl/translentordeepl.php';
if ( class_exists( 'translentor_Translentor' ) ) {
new translentor_IN_DeepL();
}

}
if(get_option('deepl_translation') =='yes')
{
add_action( 'plugins_loaded', 'translentor_in_dl_run', 0 );
}



//This is for the DEV version
if( file_exists(plugin_dir_path( __FILE__ ) . '/index-dev.php') )
{
include_once( plugin_dir_path( __FILE__ ) . '/index-dev.php');
}

function translentor_in_translentor_run(){
define( 'translentor_IN_ALD_PLUGIN_VERSION', '1.0.9' );

require_once translentor_DIR . 'translentor/ip-detection/translentor-ip-detection.php';
if ( class_exists( 'translentor_Translentor' )) {

new translentor_IN_Automatic_Language_Detection();
}
}
if(isset(get_option('translentor_settings_elementor')['ip_detection_enabled']))
{

if(get_option('translentor_settings_elementor')['ip_detection_enabled'] =='yes')
{
add_action( 'plugins_loaded', 'translentor_in_translentor_run', 0 );
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


    function translentor_admin_notices() {
        
    if(!class_exists( 'Elementor\Plugin' ) )
    {
        update_option('translentor','no');
        ?>
        <div class="notice notice-warning is-dismissible">
            <p><strong>Warning</strong>: Translentor work with Elementor Plugin. Please Activate Elementor Plugin</p>
        </div>
        <?php
    }
        
    }
   
    add_action('admin_notices', 'translentor_admin_notices');
    
    
