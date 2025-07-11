<?php
use Elementor\Plugin;



    // load_styles();
    // load_scripts();
 
        add_action( 'elementor/widgets/widgets_registered', function() 
            {
               
                    require_once translentor_DIR_Main . 'translentor/website-translator/widget.php';
                
            }
		);
  
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