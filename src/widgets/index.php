<?php

/**
 * Register Translentor Widget with Elementor
 * Using modern Elementor API (elementor/widgets/register hook)
 */
add_action( 'elementor/widgets/register', function( $widgets_manager ) {
    
    // Load widget class file
    require_once translentor_DIR_Main . 'translentor/website-translator/widget.php';
    
    // Register the widget with Elementor using modern API
    $widgets_manager->register( new \translentor_elementor_widget() );
    
});
  
    //  function load_styles() 
    // {
        // Register Widget Styles
        add_action( 'elementor/frontend/after_enqueue_styles', function(){
            wp_enqueue_style( 'translentor-website-translator-css', translentor_URL .  'translentor/assets/css/translentor-css.min.css',array(),
            translentor_VERSION );
            wp_enqueue_style( 'translentor-website-translator-toast-css', translentor_URL .  'translentor/assets/css/jquery.toast.min.css',array(),
            translentor_VERSION );
          
           
        }  );
        
   // }
   

    //  function load_scripts()
    // {
        add_action( 'elementor/frontend/after_register_scripts',function(){
            wp_enqueue_script( 'translentor-website-translator-js', translentor_URL .  'translentor/assets/js/translentor-js.js' , ['jquery'], '1.0.0', true );
            wp_enqueue_script( 'translentor-website-translator-toast-js', translentor_URL .  'translentor/assets/js/jquery.toast.min.js', ['jquery'], '1.0.0', true );
        }  );
        
    //}
    
   
?>