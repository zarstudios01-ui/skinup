<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

function skinup_rf_register_taxonomies() {
    $defs = array(
        'skin_type'    => array( 'Skin types', 'Skin type', 'skin-type' ),
        'skin_concern' => array( 'Skin concerns', 'Skin concern', 'concern' ),
        'routine_step' => array( 'Routine steps', 'Routine step', 'routine' ),
    );
    foreach ( $defs as $slug => $d ) {
        register_taxonomy( $slug, 'product', array(
            'labels'            => array( 'name' => $d[0], 'singular_name' => $d[1] ),
            'hierarchical'      => true,
            'public'            => true,
            'show_admin_column' => true,
            'show_in_rest'      => true,
            'rewrite'           => array( 'slug' => $d[2] ),
        ) );
    }
}
add_action( 'init', 'skinup_rf_register_taxonomies' );

function skinup_rf_seed_terms() {
    $terms = array(
        'skin_type'    => array( 'Oily', 'Dry', 'Combination', 'Normal' ),
        'skin_concern' => array( 'Acne', 'Oiliness', 'Dryness', 'Dark spots', 'Uneven texture', 'General skin health' ),
        'routine_step' => array( 'Clean', 'Treat', 'Hydrate', 'Protect', 'Night' ),
    );
    foreach ( $terms as $taxonomy => $names ) {
        foreach ( $names as $name ) {
            if ( ! term_exists( $name, $taxonomy ) ) {
                wp_insert_term( $name, $taxonomy );
            }
        }
    }
    $core = array( 'clean', 'hydrate', 'protect' );
    foreach ( array( 'clean', 'treat', 'hydrate', 'protect', 'night' ) as $slug ) {
        $term = get_term_by( 'slug', $slug, 'routine_step' );
        if ( $term && ! metadata_exists( 'term', $term->term_id, 'skinup_core' ) ) {
            update_term_meta( $term->term_id, 'skinup_core', in_array( $slug, $core, true ) ? '1' : '0' );
        }
    }
}

function skinup_rf_core_field_add() {
    echo '<div class="form-field"><input type="hidden" name="skinup_core_present" value="1">';
    echo '<label><input type="checkbox" name="skinup_core" value="1"> Part of the core routine</label></div>';
}
add_action( 'routine_step_add_form_fields', 'skinup_rf_core_field_add' );

function skinup_rf_core_field_edit( $term ) {
    $checked = checked( get_term_meta( $term->term_id, 'skinup_core', true ), '1', false );
    echo '<tr class="form-field"><th scope="row">Core step</th><td>';
    echo '<input type="hidden" name="skinup_core_present" value="1">';
    echo '<label><input type="checkbox" name="skinup_core" value="1" ' . $checked . '> Part of the core routine</label>';
    echo '</td></tr>';
}
add_action( 'routine_step_edit_form_fields', 'skinup_rf_core_field_edit' );

function skinup_rf_core_field_save( $term_id ) {
    if ( ! current_user_can( 'manage_categories' ) || ! isset( $_POST['skinup_core_present'] ) ) {
        return;
    }
    update_term_meta( $term_id, 'skinup_core', isset( $_POST['skinup_core'] ) ? '1' : '0' );
}
add_action( 'created_routine_step', 'skinup_rf_core_field_save' );
add_action( 'edited_routine_step', 'skinup_rf_core_field_save' );
