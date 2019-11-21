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

    // Product page

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
                'fallback_cb' => false,
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
        'footer-secondary' => __( 'Footer Secondary Menu', 'conserv2' ),
    );

}
add_filter( 'storefront_register_nav_menus', 'conserv_reigster_nav_menus' );

// Meta fields
require_once dirname( __FILE__ ) . '/includes/meta.php';


// Add multiple products to cart via URL
function woocommerce_maybe_add_multiple_products_to_cart( $url = false ) {
	// Make sure WC is installed, and add-to-cart qauery arg exists, and contains at least one comma.
	if ( ! class_exists( 'WC_Form_Handler' ) || empty( $_REQUEST['add-to-cart'] ) || false === strpos( $_REQUEST['add-to-cart'], ',' ) ) {
		return;
	}

	// Remove WooCommerce's hook, as it's useless (doesn't handle multiple products).
	remove_action( 'wp_loaded', array( 'WC_Form_Handler', 'add_to_cart_action' ), 20 );

	$product_ids = explode( ',', $_REQUEST['add-to-cart'] );
	$count       = count( $product_ids );
	$number      = 0;

	foreach ( $product_ids as $id_and_quantity ) {
		// Check for quantities defined in curie notation (<product_id>:<product_quantity>)
		// https://dsgnwrks.pro/snippets/woocommerce-allow-adding-multiple-products-to-the-cart-via-the-add-to-cart-query-string/#comment-12236
		$id_and_quantity = explode( ':', $id_and_quantity );
		$product_id = $id_and_quantity[0];

		$_REQUEST['quantity'] = ! empty( $id_and_quantity[1] ) ? absint( $id_and_quantity[1] ) : 1;

		if ( ++$number === $count ) {
			// Ok, final item, let's send it back to woocommerce's add_to_cart_action method for handling.
			$_REQUEST['add-to-cart'] = $product_id;

			return WC_Form_Handler::add_to_cart_action( $url );
		}

		$product_id        = apply_filters( 'woocommerce_add_to_cart_product_id', absint( $product_id ) );
		$was_added_to_cart = false;
		$adding_to_cart    = wc_get_product( $product_id );

		if ( ! $adding_to_cart ) {
			continue;
		}

		$add_to_cart_handler = apply_filters( 'woocommerce_add_to_cart_handler', $adding_to_cart->get_type(), $adding_to_cart );

		// Variable product handling
		if ( 'variable' === $add_to_cart_handler ) {
			woo_hack_invoke_private_method( 'WC_Form_Handler', 'add_to_cart_handler_variable', $product_id );

		// Grouped Products
		} elseif ( 'grouped' === $add_to_cart_handler ) {
			woo_hack_invoke_private_method( 'WC_Form_Handler', 'add_to_cart_handler_grouped', $product_id );

		// Custom Handler
		} elseif ( has_action( 'woocommerce_add_to_cart_handler_' . $add_to_cart_handler ) ){
			do_action( 'woocommerce_add_to_cart_handler_' . $add_to_cart_handler, $url );

      // Simple Products
      } else {
      // woo_hack_invoke_private_method( 'WC_Form_Handler', 'add_to_cart_handler_simple', $product_id );
      WC()->cart->add_to_cart($product_id, $_REQUEST['quantity']);
      }
	}
}

// Fire before the WC_Form_Handler::add_to_cart_action callback.
add_action( 'wp_loaded', 'woocommerce_maybe_add_multiple_products_to_cart', 15 );


/**
 * Invoke class private method
 *
 * @since   0.1.0
 *
 * @param   string $class_name
 * @param   string $methodName
 *
 * @return  mixed
 */
function woo_hack_invoke_private_method( $class_name, $methodName ) {
	if ( version_compare( phpversion(), '5.3', '<' ) ) {
		throw new Exception( 'PHP version does not support ReflectionClass::setAccessible()', __LINE__ );
	}

	$args = func_get_args();
	unset( $args[0], $args[1] );
	$reflection = new ReflectionClass( $class_name );
	$method = $reflection->getMethod( $methodName );
	$method->setAccessible( true );

	$args = array_merge( array( $class_name ), $args );
	return call_user_func_array( array( $method, 'invoke' ), $args );
}

 // Fire before the WC_Form_Handler::add_to_cart_action callback.
 add_action( 'wp_loaded',        'woocommerce_maybe_add_multiple_products_to_cart', 15 );


 // Remove link to product page in cart

add_filter( 'woocommerce_cart_item_permalink', '__return_null' );

// Remove "added to cart" messaging
add_filter( 'wc_add_to_cart_message', 'remove_add_to_cart_message' );

function remove_add_to_cart_message() {
    return;
}

//add desciption in cart
add_filter( 'woocommerce_get_item_data', 'customizing_cart_item_data', 10, 2 );
function customizing_cart_item_data( $cart_data, $cart_item ) {

    $custom_items = array();
    $label = __( 'Description', 'woocommerce' );

    // Get the product description
    $description = $cart_item['data']->get_description();

    // For product variations when description is empty
    if( $cart_item['data']->is_type('variation') && empty( $description ) ){
        // Get the parent variable product object
        $product = wc_get_product( $cart_item['data']->get_parent_id() );
        // Get the variable product description
        $description = $product->get_description();
    }

    // If product or variation description exists we display it
    if( ! empty( $description ) ){
        $custom_items[] = array(
            'key'      => $label,
            'display'  => $description,
        );
    }

    // Merging description and product variation attributes + values
    if( ! empty( $cart_data ) ) $custom_items = array_merge( $custom_items, $cart_data );

    return $custom_items;
}
