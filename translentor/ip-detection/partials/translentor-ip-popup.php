<div class="translentor_model_container" id="translentor_translentor_modal_container" style="display: none" data-no-dynamic-translation data-no-translation>
    <?php
    $translentor                = translentor_Translentor::get_translentor_instance();

    $this->translentor_languages = $translentor->get_translentorelements('languages');
    $languages_to_display = get_option('translentor_settings_elementor')['translentor_lang'];
    $published_languages = $this->translentor_languages->get_language_names( $languages_to_display );
   
    ?>
    <div class="translentor_translentor_modal" id="translentor_translentor_modal_popup">
            <div id="translentor_translentor_popup_text"></div>

        <div class="translentor_translentor_select_and_button">
            <div class="translentor_ip_container">
            <div class="translentor-language-switcher translentor-language-switcher-container"  id="translentor_translentor_popup_select_container" data-no-translation <?php echo ( isset( $_GET['translentor-edit-translation'] ) && $_GET['translentor-edit-translation'] == 'preview' ) ? 'data-translentor-unpreviewable="translentor-unpreviewable"' : '' ?>>
               
                <div class="translentor-ls-shortcode-current-language" id="translentor_translentor_popup_current_language" data-translentor-translentor-selected-language= "<?php echo esc_attr(get_option('translentor_settings_elementor')['translentor-default-language']); ?>">
                    <?php echo esc_attr(get_option('translentor_settings_elementor')['translentor-default-language']); /* phpcs:ignore */ /* escaped inside the function that generates the output */ ?>
                </div>
                <div class="translentor-lp-shortcode-language">
                    <div style='display:none;' class="translentor-ip-popup-select" id="translentor_translentor_no_text_popup_select_current_language" data-translentor-translentor-selected-language = "<?php echo esc_attr(get_option('translentor_settings_elementor')['translentor-default-language']);?>">
                    <?php echo esc_attr(get_option('translentor_settings_elementor')['translentor-default-language']); /* phpcs:ignore */ /* escaped inside the function that generates the output */ ?>
                     
                    </div>
                    <?php foreach ( $published_languages as $code => $name ){
                            ?>
                            <div class="translentor-ip-popup-select" id="<?php echo esc_attr($code); ?>" data-translentor-translentor-selected-language = "<?php echo esc_attr($code); ?>">
                            <img
                            class="translentor-flag-image"
                            src="<?php echo plugin_dir_url( __DIR__ ) . 'flags/'; ?><?php echo wp_kses_post( $name ); ?>.svg"
                            alt="<?php echo $name; ?>"><span style="    vertical-align: super;">   
                            <?php echo $name; /* phpcs:ignore */ /* escaped inside the function that generates the output */ ?>
                    </span>    
                        </div>
                    <?php } ?>
                </div>
            </div>
            </div>


            <div class="translentor_translentor_button">
            <button id="translentor_translentor_popup_change_language"></button>
            </div>
         </div>
        <div id="translentor_translentor_x_button_and_textarea"> <button id="translentor_translentor_x_button"></button><span id="translentor_translentor_x_button_textarea"></span></div>
    </div>
</div>
