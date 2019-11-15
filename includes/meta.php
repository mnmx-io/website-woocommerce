<?php
/**
 * Meta boxes and fields
 */

function conserv_product_page_options_meta_box() {

    $cmb = new_cmb2_box( array(
        'id' => 'conserv_product_page_options_meta_box',
        'title' => esc_html__( 'Product Page Options', 'conserv' ),
        'object_types' => array( 'product' ),
    ) );

    $cmb->add_field( array(
        'name' => esc_html__( 'Override Page Title', 'conserv' ),
        'id' => 'page_title_override',
        'type' => 'text',
    ) );

    $cmb->add_field( array(
        'name' => esc_html__( 'Secondary Pane', 'conserv' ),
        'id' => 'show_secondary_pane',
        'type' => 'checkbox',
        'desc' => esc_html__( 'Show secondary pane next to product descrpition', 'conserv' ),
    ) );

    $cmb->add_field( array(
        'name' => esc_html__( 'Secondary Pane Content', 'conserv' ),
        'id' => 'secondary_pane',
        'type' => 'wysiwyg',
    ) );

}
add_action( 'cmb2_admin_init', 'conserv_product_page_options_meta_box' );

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

    $cmb->add_field( array(
        'name' => esc_html__( 'Footer CTA', 'conserv' ),
        'id' => 'footer_cta',
        'type' => 'wysiwyg',
    ) );

    $header_ctas = $cmb->add_field( array(
        'id' => 'header_ctas',
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
