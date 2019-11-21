<?php
/**
 * Meta boxes and fields
 */

/**
 * Theme options
 */
function conserv_options_meta() {

    $cmb = new_cmb2_box( array(
        'id' => 'conserv_options_meta',
        'title' => esc_html__( 'Conserv', 'conserv' ),
        'object_types' => array( 'options-page' ),
        'option_key' => 'conserv_options',
        'parent_slug' => 'themes.php',
    ) );

    $header_ctas = $cmb->add_field( array(
        'id' => 'header_ctas',
        'name' => esc_html__( 'Header Buttons', 'conserv' ),
        'type' => 'group',
        'options' => array(
            'group_title' => esc_html__( 'Button {#}', 'conserv' ),
            'add_button' => esc_html__( 'Add Button', 'conserv' ),
            'remove_button' => esc_html__( 'Remove Button', 'conserv' ),
            'sortable' => true,
        ),
    ) );

    $cmb->add_group_field( $header_ctas, array(
        'name' => esc_html__( 'URL', 'conserv' ),
        'id' => 'url',
        'type' => 'text_url',
    ) );

    $cmb->add_group_field( $header_ctas, array(
        'name' => esc_html__( 'Button Text', 'conserv' ),
        'id' => 'button_text',
        'type' => 'text',
    ) );

    $cmb->add_group_field( $header_ctas, array(
        'name' => esc_html__( 'Button Style', 'conserv' ),
        'id' => 'transparent_button',
        'type' => 'checkbox',
        'desc' => esc_html__( 'Transparent Button', 'conserv' ),
    ) );

}
add_action( 'cmb2_admin_init', 'conserv_options_meta' );
