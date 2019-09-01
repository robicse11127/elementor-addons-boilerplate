<?php 
/**
 * =========================================================
 * All Shortcodes
 * ---------------------------------------------------------
 * =========================================================
 */

 class PluginName_Shortcodes {

    /**
     * Construct Function
     */
    public function __construct() {
        add_shortcode( 'shortcode_name', array($this, 'shortcode_function') );
    }

    /**
     * Selected Portfolios
     * Shortcode: [selected-portfolio ids=""]
     */
    public function shortcode_function( $atts, $content=null ) {
        $options = extract(shortcode_atts(array(
            'ids'   => ''
        ), $atts));
    }
 } 

 new PluginName_Shortcodes();
