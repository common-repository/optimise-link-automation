<?php
/**
 * Plugin Name: Optimise Link Automation
 * Plugin URI: https://knowledge.optimisemedia.com/docs/publishertools#link-automation
 * Description: Turbo-charge your Website with instant deeplinks via Link Automation. Publishers can use this tool to monetize content by easily converting your linkable assets with tracking links automatically.
 * Version: 1.0.3
 * Author: Optimise Media
 * Author URI: https://www.optimisemedia.com
 * Copyright: © 2021 Optimise Media Group Ltd.
 * License: GPLv2 or later
 */

function optimiselinkautomationscript() {
    $options = get_option( 'optimise_la_plugin_options' );
    if(!empty($options['aid'])) {
    ?>
    <script type="text/javascript">
    OAID=<?php echo esc_attr( $options['aid'] )?>;ORef=escape(window.parent.location.href);!function(){var a=document.createElement("script");a.type="text/javascript",a.async=!0,a.src="//track.omguk.com/la?aid="+OAID+"&ref="+ORef;var b=document.getElementsByTagName("body")[0];if(b)b.appendChild(a,b);else{var b=document.getElementsByTagName("script")[0];b.parentNode.insertBefore(a,b)}}();
    </script>
    <?php
    }
}

function optimise_la_add_settings_page() {
    add_options_page( 'Example plugin page', 'Optimise Linkables', 'manage_options', 'optimise-la-plugin', 'optimise_la_render_plugin_settings_page' );
}

function optimise_la_render_plugin_settings_page() {
    ?>
    <h2>Optimise Linkables Settings</h2>
    <p><img src="<?php echo plugins_url( 'optimise-logo.svg', __FILE__ ); ?>" height="50"/></p>
    <p>To configure Optimise Linkables enter your AID/PublisherId below. You can find your AID in Dashboard under the menu shown below.</p>
    <p><img src="<?php echo plugins_url( 'aid-location.png', __FILE__ ); ?>"/></p>
    <p>You can test that the Linkables is functioning correctly by using the <a href="https://chrome.google.com/webstore/detail/optimise-tag-inspector/ekiippaneofjfjgokhonnfbpjlmmajdc" target="_blank">Optimise Tag Inspector Chrome Extension</a></p>
    <form action="options.php" method="post">
        <?php
        settings_fields( 'optimise_la_plugin_options' );
        do_settings_sections( 'optimise_la_plugin' ); ?>
        <input name="submit" class="button button-primary" type="submit" value="<?php esc_attr_e( 'Save' ); ?>" />
    </form>
    <?php
}

function optimise_la_plugin__section_text() {

}

#function optimise_la_plugin_options_validate( $input ) {
#    $newinput['aid'] = trim( $input['aid'] );
#    if ( ! preg_match( '/^[a-z0-9]{32}$/i', $newinput['aid'] ) ) {
#        $newinput['aid'] = '';
#    }
#
#   return $newinput;
#}

function optimise_la_register_settings() {
    register_setting( 'optimise_la_plugin_options', 'optimise_la_plugin_options', 'optimise_la_plugin_options_validate' );
    add_settings_section( 'la_settings', 'Settings', 'optimise_la_plugin__section_text', 'optimise_la_plugin' );
    add_settings_field( 'optimise_la_plugin__setting_aid', 'AID', 'optimise_la_plugin__setting_aid', 'optimise_la_plugin', 'la_settings' );
}

function optimise_la_plugin__setting_aid() {
    $options = get_option( 'optimise_la_plugin_options' );
    echo "<input id='optimise_la_plugin__setting_aid' name='optimise_la_plugin_options[aid]' type='text' value='" . esc_attr( $options['aid'] ) . "' />";
}


add_action( 'admin_init', 'optimise_la_register_settings' );

add_action( 'admin_menu', 'optimise_la_add_settings_page' );

add_action( 'wp_head' , 'optimiselinkautomationscript' );

?>