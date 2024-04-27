<?php
use Elementor\Plugin;
 if(get_option('gradientbutton')=="yes")
 {
add_action( 'elementor/controls/controls_registered',function(){
	require  translentor_DIR_Main . 'gradientbutton/group_control/control-border-gradient.php';
	require  translentor_DIR_Main . 'gradientbutton/group_control/control-text-gradient.php';
	$controlsManager = Plugin::instance()->controls_manager;
	$controlsManager->add_group_control( 'translentor_text_gradient', new Group_Control_Text_Gradient() );
	$controlsManager->add_group_control( 'translentor_border_gradient', new Group_Control_Border_Gradient() );
}  );
 }
        add_action( 'elementor/widgets/widgets_registered', function() 
            {
                if(get_option('gradientbutton')=="yes")
                {
                 require_once translentor_DIR_Main .'gradientbutton/widget/button.php';
                }
                if(get_option('texthightlight')=="yes")
                {
                require_once translentor_DIR_Main .'widgets/index.php';
                }
                if(get_option('iconstroke')=="yes")
                {
                require_once translentor_DIR_Main .'iconstroke/widget/icon.php';
                }
                if(get_option('translentor')=="yes")
                {
                   // require_once translentor_DIR_Main . 'translentor/website-translator/widget/tanslentor_widget.php';
                    require_once translentor_DIR_Main.   'translentor/website-translator/widget/translentor_bottom_sheet_footer.php';
                    require_once translentor_DIR_Main.   'translentor/website-translator/widget/translentor_popup_model.php';
                }
            }
		);
        if(get_option('clickablecolumn')=="yes")
    {
        require_once translentor_DIR_Main .'clickablecolumn/index.php';
    }
    if(get_option('woomentorcurrency')=="yes" && get_option('WooCommerce_active')=="yes")
	{
     require_once translentor_DIR_Main .'woomentorcurrency/index.php';
    }
?>