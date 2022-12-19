<?php
$post = $args['post'];
$cfc = CFFE();
$cfc_widgets = $cfc->get_widgets_with_category();

$desc_link = wpcf7_link(
__( 'https://contactform7.com/editing-form-template/', 'contact-form-7' ),
__( 'Editing form template', 'contact-form-7' ) );
$description = __( "You can edit the form template here. For details, see %s.", 'contact-form-7' );
$description = sprintf( esc_html( $description ), $desc_link );

?>

<h2><?php echo esc_html( __( 'Form', 'contact-form-7' ) ); ?></h2>

<fieldset>
    <legend><?php echo $description; ?></legend>
</fieldset>

<div class="cfc-wrapper-tabs">
    <div class="cfc-wrapper-tabs__header">
        <div class="cfc-wrapper-tabs__title active"><?php esc_html_e('Flex editor', 'cffe'); ?></div>
        <div class="cfc-wrapper-tabs__title"><?php esc_html_e('Code', 'cffe'); ?></div>
        <div class="cfc-wrapper-tabs__title"><?php esc_html_e('Widgets data', 'cffe'); ?></div>
    </div>

    <div class="cfc-wrapper-tabs__body">
        <div class="cfc-wrapper-tabs__content">

            <div class="cfc-editor-notice" data-notice-type="mixed-content">
                <h3><span class="icon-in-circle" aria-hidden="true">!</span><?php esc_html_e('Mixed content', 'cffe'); ?></h3>
                <p><?php esc_html_e('We found content that is not related to Flex editor. In order to keep the editor working as expected, we put all third-party content in the "Code" widget.
                    To undo this behavior, don\'t save the form, disable the editor on the plugins page and go back to editing the form already without the editor. 
                    Or just delete widget with old code. The ability to disable the editor on the form will be added soon. Stay with us.', 'cffe'); ?></p>
                <a href="#" data-action="hide"><?php esc_html_e('Thanks!', 'cffe'); ?></a>
            </div>

            <div class="cfc">
                <div class="cfc-container" id="cfc-container">
                    <?php echo $post->prop( 'form' ); ?>
                </div>

                <div class="cfc-panel">
                    <div class="cfc-panel__mover"></div>

                    <div class="cfc-panel__tabs">
                        <div class="cfc-panel__tabs-head f">
                            <div class="cfc-panel__tab-head widgets active"><?php esc_html_e('Widgets', 'cffe'); ?></div>

                            <div class="cfc-panel__tab-head content">
                                <div class="back f aic jcc">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--! Font Awesome Pro 6.2.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M41.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l192 192c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L109.3 256 278.6 86.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-192 192z"/></svg>
                                </div>

                                <span><?php esc_html_e('Settings', 'cffe'); ?></span>
                            </div>
                        </div>

                        <!--Панель со всеми виджетами-->
                        <div class="cfc-panel__tab cfc-panel__tab-widgets" id="cfc-widgets">
                            <?php foreach ($cfc_widgets as $category => $widgets): ?>
                                <?php if ( ! count($widgets) ) continue ?>

                                <h2 class="cfc-panel__tab__category"><?php echo $cfc->get_category_label($category) ?></h2>

                                <div class="cfc-panel__tab__widgets">
                                    <?php foreach ($widgets as $widget) : ?>
                                        <div class="cfc-widget f fdc g5 aic jcc" data-widget-name="<?php echo $widget->get_name() ?>">
                                            <?php echo $widget->get_title() ?>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <div class="cfc-panel__tab cfc-panel__tab-content" id="cfc-settings">
                            <!--here append settings of current widget by js-->
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="cfc-wrapper-tabs__content">
            <div class="cfc-notice f g15">
                <div class="cfc-notice-icon">
                    <span class="icon-in-circle" aria-hidden="true">!</span>
                </div>

                <div class="cfc-notice-content f fdc">
                    <h4><?php esc_html_e('Warning!', 'cffe'); ?></h4>
                    <p><?php _e('This is a service tab. 
                    It is designed to adjust and eliminate excess parts of the code directly. 
                    Changes made here will be able to apply after maintaining the form.', 'cffe') ?></p>
                </div>
            </div>

            <textarea id="wpcf7-form" name="wpcf7-form" cols="100" rows="24" class="large-text code" data-config-field="form.body"><?php echo esc_textarea($post->prop( 'form' )); ?></textarea>
        </div>

        <div class="cfc-wrapper-tabs__content">

            <div class="cfc-notice f g15">
                <div class="cfc-notice-icon">
                    <span class="icon-in-circle" aria-hidden="true">!</span>
                </div>

                <div class="cfc-notice-content f fdc">
                    <h4><?php esc_html_e('Warning!', 'cffe'); ?></h4>
                    <p><?php _e('This is a service tab. 
                    It is designed to adjust and eliminate excess parts of the code directly. 
                    Changes made here will be able to apply after maintaining the form.', 'cffe') ?></p>
                </div>
            </div>

            <textarea name="cffe_widgets_data" id="cfc-widgets-settings" cols="30" rows="10"><?php echo esc_textarea($post->prop( 'cffe_widgets_data' ) ) ?></textarea>
        </div>
    </div>
</div>

<template id="admin-controls">
    <div class="admin-controls">
        <div class="move">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                <path d="M160 96L256 0l96 96v32H288v96h96V160h32l96 96-96 96-32 0V288H288v96h64v32l-96 96-96-96V384h64V288H128v64H96L0 256l96-96h32v64h96V128H160V96z"/>
            </svg>
        </div>

        <div class="delete">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                <path d="M160 400C160 408.8 152.8 416 144 416C135.2 416 128 408.8 128 400V192C128 183.2 135.2 176 144 176C152.8 176 160 183.2 160 192V400zM240 400C240 408.8 232.8 416 224 416C215.2 416 208 408.8 208 400V192C208 183.2 215.2 176 224 176C232.8 176 240 183.2 240 192V400zM320 400C320 408.8 312.8 416 304 416C295.2 416 288 408.8 288 400V192C288 183.2 295.2 176 304 176C312.8 176 320 183.2 320 192V400zM317.5 24.94L354.2 80H424C437.3 80 448 90.75 448 104C448 117.3 437.3 128 424 128H416V432C416 476.2 380.2 512 336 512H112C67.82 512 32 476.2 32 432V128H24C10.75 128 0 117.3 0 104C0 90.75 10.75 80 24 80H93.82L130.5 24.94C140.9 9.357 158.4 0 177.1 0H270.9C289.6 0 307.1 9.358 317.5 24.94H317.5zM151.5 80H296.5L277.5 51.56C276 49.34 273.5 48 270.9 48H177.1C174.5 48 171.1 49.34 170.5 51.56L151.5 80zM80 432C80 449.7 94.33 464 112 464H336C353.7 464 368 449.7 368 432V128H80V432z"/>
            </svg>
        </div>
    </div>
</template>
