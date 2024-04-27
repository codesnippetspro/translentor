<?php
// add conditional language shortcode
add_shortcode( 'translentor_language', 'translentor_language_content');

/* ---------------------------------------------------------------------------
 * Shortcode [translentor_language language="en_EN"] [/translentor_language]
 * --------------------------------------------------------------------------- */

function translentor_language_content( $attr, $content = null ){
    extract(shortcode_atts(array(
        'language' => '',
    ), $attr));

    $current_language = get_locale();

    if( $current_language == $language ){
        $output = do_shortcode($content);
    }else{
        $output = "";
    }

    return $output;
}