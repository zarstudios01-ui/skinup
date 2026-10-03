<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

function skinup_rf_product_tab( $tabs ) {
    $tabs['skinup'] = array(
        'label'    => 'SkinUp',
        'target'   => 'skinup_product_data',
        'class'    => array(),
        'priority' => 65,
    );
    return $tabs;
}
add_filter( 'woocommerce_product_data_tabs', 'skinup_rf_product_tab' );

function skinup_rf_product_panel() {
    echo '<div id="skinup_product_data" class="panel woocommerce_options_panel">';
    woocommerce_wp_text_input( array( 'id' => '_skinup_size', 'label' => 'Size', 'placeholder' => 'e.g. 100 ml' ) );
    woocommerce_wp_textarea_input( array( 'id' => '_skinup_benefits', 'label' => 'Benefits', 'description' => 'One per line.', 'desc_tip' => true ) );
    woocommerce_wp_textarea_input( array( 'id' => '_skinup_ingredients', 'label' => 'Key ingredients', 'description' => 'One per line. Leave empty until verified.', 'desc_tip' => true ) );
    woocommerce_wp_textarea_input( array( 'id' => '_skinup_how_to_use', 'label' => 'How to use' ) );
    woocommerce_wp_select( array(
        'id'      => '_skinup_when_to_use',
        'label'   => 'When to use',
        'options' => array( '' => 'Select', 'am' => 'Morning', 'pm' => 'Evening', 'both' => 'Morning and evening' ),
    ) );
    woocommerce_wp_textarea_input( array( 'id' => '_skinup_who_for', 'label' => "Who it's for" ) );
    echo '</div>';
}
add_action( 'woocommerce_product_data_panels', 'skinup_rf_product_panel' );

function skinup_rf_save_product_fields( $post_id ) {
    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }
    if ( isset( $_POST['_skinup_size'] ) ) {
        update_post_meta( $post_id, '_skinup_size', sanitize_text_field( wp_unslash( $_POST['_skinup_size'] ) ) );
    }
    foreach ( array( '_skinup_benefits', '_skinup_ingredients', '_skinup_how_to_use', '_skinup_who_for' ) as $key ) {
        if ( isset( $_POST[ $key ] ) ) {
            update_post_meta( $post_id, $key, sanitize_textarea_field( wp_unslash( $_POST[ $key ] ) ) );
        }
    }
    if ( isset( $_POST['_skinup_when_to_use'] ) ) {
        $when = sanitize_key( wp_unslash( $_POST['_skinup_when_to_use'] ) );
        update_post_meta( $post_id, '_skinup_when_to_use', in_array( $when, array( 'am', 'pm', 'both' ), true ) ? $when : '' );
    }
}
add_action( 'woocommerce_process_product_meta', 'skinup_rf_save_product_fields' );
