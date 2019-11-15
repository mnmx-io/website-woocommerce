<?php

define( 'CONSERV_VERSION', '1.2.0' );

// CMB2
require_once dirname( __FILE__ ) . '/includes/CMB2/init.php';

/**
 * Add and remove actions in Storefront template
 */
function conserv_template_setup() {

    // Header
    remove_action( 'storefront_header', 'storefront_site_branding', 20 );
    add_action( 'storefront_header', 'conserv_site_branding', 20 );
    remove_action( 'storefront_header', 'storefront_secondary_navigation', 30 );
    remove_action( 'storefront_header', 'storefront_product_search', 40 );
    remove_action( 'storefront_header', 'storefront_primary_navigation_wrapper', 42 );
    remove_action( 'storefront_header', 'storefront_primary_navigation', 50 );
    remove_action( 'storefront_header', 'storefront_header_cart', 60 );
    remove_action( 'storefront_header', 'storefront_primary_navigation_wrapper_close', 68 );
    add_action( 'storefront_header', 'conserv_primary_navigation', 25 );
    add_action( 'storefront_header', 'conserv_header_ctas', 30 );

    remove_action( 'storefront_before_content', 'woocommerce_breadcrumb', 10 );

    // Footer
    remove_action( 'storefront_footer', 'storefront_credit', 20 );
    add_action( 'storefront_footer', 'conserv_footer_primary_nav', 10 );
    add_action( 'storefront_footer', 'conserv_footer_secondary_nav', 20 );
    add_action( 'storefront_footer', 'conserv_site_branding', 30 );
    remove_action( 'storefront_footer', 'storefront_handheld_footer_bar', 999 );

    // Before footer
    add_action( 'storefront_before_footer', 'conserv_footer_cta' );

    // Product page
    remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20 );
    remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );
    add_action( 'woocommerce_single_product_summary', 'conserv_show_product_description', 7 );
    remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
    add_action( 'woocommerce_before_single_product_summary', 'woocommerce_template_single_title', 5 );
    remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
    remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );

    if ( is_singular( 'product' ) ) {

        $title_override = get_post_meta( get_the_ID(), 'page_title_override', true );

        if ( !empty( $title_override ) ) {

            remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_template_single_title', 5 );
            add_action( 'woocommerce_before_single_product_summary', 'conserv_template_single_title_override', 5 );

        }

        $show_secondary_pane = get_post_meta( get_the_ID(), 'show_secondary_pane', true );

        if ( $show_secondary_pane ) {

            add_action( 'woocommerce_before_single_product_summary', 'conserv_open_product_description_wrapper', 999 );
            add_action( 'woocommerce_after_single_product_summary', 'conserv_close_product_description_wrapper', 8 );
            add_action( 'woocommerce_after_single_product_summary', 'conserv_product_secondary_pane', 4 );

        }

    }

}
add_action( 'wp_head', 'conserv_template_setup' );

/**
 * Site Branding
 */
function conserv_site_branding() {

    ?>

    <div class="site-branding">

        <?php

        $home_url = 'https://conserv.io';
        $logo = get_theme_mod( 'custom_logo' );

        if ( $logo ) {
            $logo_img = '<a href="' . esc_url( $home_url ) . '" rel="home">' . wp_get_attachment_image( $logo, 'full' ) . '</a>';
			$html = is_home() ? '<h1 class="logo">' . $logo_img . '</h1>' : $logo_img;
		} else {
			$tag = is_home() ? 'h1' : 'div';

			$html = '<' . esc_attr( $tag ) . ' class="beta site-title"><a href="' . esc_url( $home_url ) . '" rel="home">' . esc_html( get_bloginfo( 'name' ) ) . '</a></' . esc_attr( $tag ) . '>';

			if ( '' !== get_bloginfo( 'description' ) ) {
				$html .= '<p class="site-description">' . esc_html( get_bloginfo( 'description', 'display' ) ) . '</p>';
			}
		}

		echo $html;

        ?>

	</div>

    <?php

}

/**
 * Primary navigation
 */
function conserv_primary_navigation() {

    ?>

    <nav id="site-navigation" class="conserv-main-navigation" role="navigation" aria-label="<?php esc_html_e( 'Primary Navigation', 'storefront' ); ?>">
		<?php
		wp_nav_menu(
			array(
				'theme_location'  => 'primary',
				'container_class' => 'conserv-primary-navigation',
			)
		);
		?>
	</nav><!-- #site-navigation -->

    <?php

}

/**
 * Footer primary navigation
 */
function conserv_footer_primary_nav() {

    ?>

    <nav class="conserv-footer-primary-navigation" role="navigation" aria-label="<?php esc_html_e( 'Primary Navigation', 'storefront' ); ?>">
		<?php
		wp_nav_menu(
			array(
				'theme_location'  => 'footer-primary',
				'container_class' => 'conserv-footer-primary-navigation',
			)
		);
		?>
	</nav>

    <?php

}

/**
 * Footer secondary navigation
 */
function conserv_footer_secondary_nav() {

    ?>

    <nav class="conserv-footer-secondary-navigation" role="navigation" aria-label="<?php esc_html_e( 'Secondary Navigation', 'storefront' ); ?>">
		<?php
		wp_nav_menu(
			array(
				'theme_location'  => 'footer-secondary',
				'container_class' => 'conserv-footer-secondary-navigation',
			)
		);
		?>
	</nav>

    <?php

}

/**
 * Add header CTA
 */
function conserv_header_ctas() {

    $options = get_option( 'conserv_options' );

    if ( empty( $options['header_ctas'] ) ) {
        return;
    }

    $ctas = $options['header_ctas'];

    ?>

    <ul class="conserv-header-ctas">

        <?php foreach( $ctas as $cta ) : ?>

            <?php $classes = 'button'; ?>

            <?php if ( !empty( $cta['transparent_button'] ) ) $classes .= ' button-transparent'; ?>

            <li>
                <a href="<?php echo esc_url( $cta['url'] ); ?>" class="<?php echo $classes; ?>">
                    <?php echo $cta['button_text']; ?>
                </a>
            </li>

        <?php endforeach; ?>

        <li>
            <a href="https://shop.conserv.io/cart/">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="22"><g fill="#0E0E0E"><circle cx="19" cy="19.5" r="2.5"/><circle cx="9" cy="19.5" r="2.5"/><path d="M23.375 3.169A.501.501 0 0 0 23 3H5.01L4.49.402A.5.5 0 0 0 4 0H1a.5.5 0 0 0 0 1h2.59l2.437 12.187A3.51 3.51 0 0 0 9.459 16H21a.5.5 0 0 0 0-1H9.46a2.507 2.507 0 0 1-2.452-2.01L6.81 12h13.424a2.504 2.504 0 0 0 2.481-2.19l.781-6.248a.499.499 0 0 0-.121-.393z"/></g></svg>
            </a>
        </li>

    </ul>

    <?php

}

/**
 * Footer CTA
 */
function conserv_footer_cta() {

    $options = get_option( 'conserv_options' );

    if ( empty( $options['footer_cta'] ) ) {
        return;
    }

    ?>

    <div class="conserv-footer-cta">
        <div class="col-full">

            <?php echo wpautop( $options['footer_cta'] ); ?>

        </div> <!-- /.col-full -->
    </div> <!-- /.conserv-footer-cta -->

    <?php

}

/**
 * Add product description wrapper
 */
function conserv_open_product_description_wrapper() {
    echo '<div class="conserv-product-description-wrapper">';
}

/**
 * Product description wrapper close tag
 */
function conserv_close_product_description_wrapper() {
    echo '</div> <!-- /.conserv-product-description-wrapper -->';
}

function conserv_product_secondary_pane() {

    ?>

    <div class="conserv-product-secondary-pane">

        <?php echo wpautop( get_post_meta( get_the_ID(), 'secondary_pane', true ) ); ?>

    </div> <!-- /.conserv-product-secondary-pane -->

    <?php

}

/**
 * Product page title override
 */
function conserv_template_single_title_override() {

    $title_override = get_post_meta( get_the_ID(), 'page_title_override', true );

    echo '<h1 class="product_title entry-title">' . esc_html( $title_override ) . '</h1>';

}

/**
 * Show product description
 */
function conserv_show_product_description() {

    echo '<div class="product-description">';
    the_content();
    echo '</div>';

}

/**
 * Change 'sign-up fee' to 'hardware fee' in subscriptions
 *
 * @param string
 * @param object
 * @param array
 *
 * @return string
 */
function conserv_change_signup_fee_text( $subscription_string, $product, $include ) {

    if ( $include['sign_up_fee'] ) {

        $subscription_string = str_replace('sign-up fee', 'hardware fee', $subscription_string);

    }

    return $subscription_string;

}
add_filter( 'woocommerce_subscriptions_product_price_string', 'conserv_change_signup_fee_text', 20, 3 );

/**
 * Update registered nav menus
 *
 * @param array
 *
 * @return array
 */
function conserv_reigster_nav_menus( $menus ) {

    return array(
        'primary' => __( 'Primary Menu', 'conserv' ),
        'footer-primary' => __( 'Footer Primary Menu', 'conserv' ),
        'footer-secondary' => __( 'Footer Secondary Menu', 'conserv' ),
    );

}
add_filter( 'storefront_register_nav_menus', 'conserv_reigster_nav_menus' );

// Meta fields
require_once dirname( __FILE__ ) . '/includes/meta.php';
