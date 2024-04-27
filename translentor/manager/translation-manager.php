<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
    <?php
        do_action( 'translentor_head' );
    ?>

    <title>translentor</title>
</head>
<body class="translentor-editor-body">

    <div id="translentor-editor-container">
        <translentor-editor
            ref='translentor_editor'
        >
        </translentor-editor>
    </div>

    <?php do_action( 'translentor_translation_manager_footer' ); ?>
</body>
</html>

<?php
