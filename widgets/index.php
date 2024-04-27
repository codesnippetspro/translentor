<?php
use Elementor\Plugin;

        if(get_option('clickablecolumn')=="yes")
    {
        
        require_once translentor_DIR .'clickablecolumn/index.php';
    }
    if(get_option('downloadasimage')=="yes")
    {
        add_action( 'elementor/editor/before_enqueue_scripts',function(){
            wp_enqueue_script( 'img_canvas', translentor_URL .'downloadasimage/js/html2canvas.js', ['jquery'], '1.0.0', true );
          
            wp_enqueue_script( 'translentor_downloadasimage',translentor_URL.'downloadasimage/js/downloadasimage.js', array( 'jquery', 'elementor-editor' ), '1.6', true );
            
    
        
        });
    }
   
    
   
?>