<?php
/**
 * Plugin Name: SkinUp Routine Finder
 * Description: Skincare taxonomies, product fields and the Routine Finder for SkinUp.
 * Version: 0.1.0
 * Text Domain: skinup-routine-finder
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

define( 'SKINUP_RF_DIR', plugin_dir_path( __FILE__ ) );

require_once SKINUP_RF_DIR . 'includes/taxonomies.php';
require_once SKINUP_RF_DIR . 'includes/product-fields.php';

register_activation_hook( __FILE__, function () {
    skinup_rf_register_taxonomies();
    skinup_rf_seed_terms();
    flush_rewrite_rules();
} );
