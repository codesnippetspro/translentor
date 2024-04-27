<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
    <?php
    do_action( 'translentor_string_translation_editor_head' );
    ?>
    <title>translentor - <?php esc_html_e('String Translation Editor', 'translentor'); ?> </title>
</head>
<body class="translentor-editor-body">

    <div id="translentor-editor-container">
        <translentor-string-translation
            ref="translentor_string_translation_editor"
        >
        </translentor-string-translation>
    </div>

    <?php do_action( 'translentor_string_translation_editor_footer' ); ?>
</body>
</html>

<?php
