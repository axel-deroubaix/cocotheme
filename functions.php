<?php

/*
** Remove emojis
*/

remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
remove_action( 'admin_print_styles', 'print_emoji_styles' );

/*
** Contact page css
*/

add_action( 'wp_head', 'cocolo_contact_page_css' );

function cocolo_contact_page_css() {
	global $post;

	$title = get_the_title($post->ID);

	if ( $title == "Contact" ) {
		?><style type="text/css">#primary{display:none;}.woocommerce-breadcrumb{margin-bottom: 0;}</style><?php
	}

}

/*
** Google adsense
*/

add_action( 'wp_head', 'cocolo_adsense', 999 );

function cocolo_adsense() {
	?>
	<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
	<script>
		(adsbygoogle = window.adsbygoogle || []).push({
			google_ad_client: "ca-pub-5188961776742095",
			enable_page_level_ads: true
		});
	</script>
	<?php
}

/*
** Change wooommerce image size
*/

add_filter( 'storefront_woocommerce_args', 'cocolo_storefront_woocommerce_args' );

function cocolo_storefront_woocommerce_args( $args ) {
    $args['single_image_width'] = 960;
    return $args;
}

/*
** Dequeue storefront fonts
*/
add_action( 'wp_enqueue_scripts', 'cocolo_dequeue_storefront_font', 999);

function cocolo_dequeue_storefront_font() {
	wp_dequeue_style('storefront-fonts');
}

/**
 * Load theme tweaks
 */

add_action( 'after_setup_theme', 'cocolo_theme_hooks' );

function cocolo_theme_hooks() {

	// Header
	remove_action( 'storefront_header', 'storefront_site_branding', 20 );
	remove_action( 'storefront_header', 'storefront_secondary_navigation', 30 );
	remove_action( 'storefront_header', 'storefront_product_search', 40 );
	remove_action( 'storefront_header', 'storefront_header_cart', 60 );
	add_action( 'storefront_header', 'cocolo_branding', 20 );
	add_action( 'storefront_header', 'cocolo_header_search', 20 );
	add_action( 'storefront_before_content', 'cocolo_hero', 5 );
	add_filter( 'wp_nav_menu_items', 'cocolo_nav_menu_items', 10, 2);

	// Homepage
	remove_action( 'homepage', 'storefront_homepage_content', 10 );
	remove_action( 'homepage', 'storefront_product_categories', 20 );
	remove_action( 'homepage', 'storefront_recent_products', 30 );
	remove_action( 'homepage', 'storefront_popular_products', 50 );
	remove_action( 'homepage', 'storefront_on_sale_products', 60 );
	remove_action( 'homepage', 'storefront_best_selling_products', 70 );
	add_action( 'storefront_homepage_after_featured_products_title', 'cocolo_see_all_products_link' );
	add_filter( 'storefront_featured_products_args', 'cocolo_featured' );

	// Footer
	remove_action( 'storefront_footer', 'storefront_credit', 20 );
	remove_action( 'storefront_footer', 'storefront_handheld_footer_bar', 999 );
	add_action( 'storefront_before_footer', 'cocolo_why', 10 );
	add_action( 'storefront_before_footer', 'cocolo_team', 20 );
	add_action( 'storefront_before_footer', 'cocolo_contact', 30 );
	add_action( 'storefront_before_footer', 'cocolo_clouds', 40 );
	add_action( 'storefront_footer','cocolo_footer_branding', 20 );
	add_action( 'wp_footer','cocolo_scripts' );
}

/*
** Branding in header
*/

function cocolo_branding() {
	if ( is_front_page() ) {
	?>
	<div class="site-branding">
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="custom-logo-link" rel="home" itemprop="url">
			<picture>
				<source media="(min-width: 990px)" srcset="<?php echo get_stylesheet_directory_uri(); ?>/img/cocolotravel-logo.svg">
				<source media="(min-width: 750px)" srcset="<?php echo get_stylesheet_directory_uri(); ?>/img/cocolo-logo-small.svg">
				<img src="<?php echo get_stylesheet_directory_uri(); ?>/img/cocolotravel-logo.svg" alt="Logo">
			</picture>
		</a>
	</div>
	<?php
	} else {
	?>
	<div class="small-branding">
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="custom-logo-link" rel="home" itemprop="url">
			<picture>
				<source media="(min-width: 750px)" srcset="<?php echo get_stylesheet_directory_uri(); ?>/img/cocolo-logo-small.svg">
				<img src="<?php echo get_stylesheet_directory_uri(); ?>/img/cocolotravel-logo.svg" alt="Logo">
			</picture>
		</a>
	</div>
	<?php
	}
}

/*
** Search in header
*/

function cocolo_header_search() {
    if ( !is_front_page() ) {
	?>
    <div class="header-search not-in-mobile">
		<?php echo do_shortcode( '[wcas-search-form]' );?>
	</div>
	<?php
    }
}

/*
** Hero template
*/

function cocolo_hero() {
	if ( is_front_page() ) {
	?>
	<div id="hero" class="site-hero" role="complementary">
		<div class="col-full">
			<div class="hero">
				<p class="site-description"><?php _e( 'Create your Japan story', 'cocotheme') ?></p>
				<p class="sub-description"><?php _e( 'Book our curated experiences and become the storyteller of your travel', 'cocotheme') ?></p>
				<?php echo do_shortcode( '[wcas-search-form]' );?>
				<p class="sub-description" style="margin: 1em 0 0 0;"><a href="#reasons">Why travel with us?</a></p>
				<div id="koi1" class="kois" style="background-image:url(<?php echo get_stylesheet_directory_uri(); ?>/img/koi1.svg);"></div>
				<div id="koi2" class="kois" style="background-image:url(<?php echo get_stylesheet_directory_uri(); ?>/img/koi2.svg);"></div>
			</div>
		</div>
	</div>
	<?php
    }
}

/*
** Featured products tweaks
*/

function cocolo_featured( $args ) {
	$args = array(
		'limit' 			=> 100,
		'columns' 			=> 3,
		'child_categories' 	=> 0,
		'orderby' 			=> 'rand',
		'order'				=> 'ASC',
		'title'				=> __( 'Featured', 'cocotheme' ),
	);
	return $args;
}

/*
** See ecverything link
*/

function cocolo_see_all_products_link() {
	?>
    <p>
        <a href="<?php echo get_permalink( woocommerce_get_page_id( 'shop' ) ); ?>" class="more-link"><?php _e( 'See everything', 'eyetheme') ?></a>
    </p>
	<?php
}

/*
** log in and currency converter in main navigation
*/

function cocolo_nav_menu_items($items, $args ) {
	global $woocommerce;

	$user			=	wp_get_current_user();
	$name			=	$user->display_name;
	$cc				=	do_shortcode('[woocommerce_currency_converter currency_display="select"]');
	$account_url	=	get_permalink( get_option('woocommerce_myaccount_page_id') );

	if ( isset( $args ) && $args->theme_location === 'primary' ) {
  	if( is_user_logged_in() ) {
			$items	.=	'<li class="menu-item menu-item-type-post_type menu-item-object-page"><a href="'. $account_url .'" class="menu-item-logged-user">'. $name. '</a></li>';
		}
		else {
			$items	.=	'<li class="menu-item menu-item-type-post_type menu-item-object-page"><a href="'. $account_url .'" class="menu-item-sign-in">Sign In</a></li>';
		}
		//$items .= '<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-currency-converter">' . $cc . '</li>';
	}

	return $items;
}

/*
** Toggle booking form JS
*/

function cocolo_scripts() {
	global $product;

	if ( is_wc_booking_product( $product ) ) {
	?>
	<script>
	jQuery(document).ready(function () {
		jQuery(".start-booking-button").click(function () {
			jQuery('.cart').slideToggle("slow");
		});
	});
	</script>
	<?php
	}
}

/*
** Team template
*/

function cocolo_team() {
  if ( is_front_page() ) {
	  ?>
  	<div id="team" role="complementary">
  		<div class="col-full site-main">
  		<section class="team" aria-label="Meet the team">
  			<h2 class="section-title"><?php echo __( 'Meet the team', 'cocotheme' ); ?></h2>
  			<p>
  				<a href="<?php echo site_url( '/about/' ); ?>" class="more-link"><?php _e( 'About us', 'eyetheme') ?></a>
  			</p>
  			<div class="woocommerce columns-4">
  				<ul class="team-mates products columns-4">
  					<li class="team-mate product first">
  						<a href="<?php echo site_url( '/about/' ); ?>">
  						<img src="http://dev.cocolotravel.com/wp-content/uploads/axel-300x300.jpg" alt="" width="300" height="300" class="alignnone size-medium wp-image-243" />
  						<h3><?php _e( 'Axel', 'cocotheme'); ?></h3>
  						</a>
  					</li>
  					<li class="team-mate product">
  						<a href="<?php echo site_url( '/about/' ); ?>">
  						<img src="http://dev.cocolotravel.com/wp-content/uploads/axel-300x300.jpg" alt="" width="300" height="300" class="alignnone size-medium wp-image-243" />
  						<h3><?php _e( 'Axel', 'cocotheme'); ?></h3>
  						</a>
  					</li>
  					<li class="team-mate product">
  						<a href="<?php echo site_url( '/about/' ); ?>">
  						<img src="http://dev.cocolotravel.com/wp-content/uploads/axel-300x300.jpg" alt="" width="300" height="300" class="alignnone size-medium wp-image-243" />
  						<h3><?php _e( 'Axel', 'cocotheme'); ?></h3>
  						</a>
  					</li>
  					<li class="team-mate product last">
  						<a href="<?php echo site_url( '/about/' ); ?>">
  						<img src="http://dev.cocolotravel.com/wp-content/uploads/axel-300x300.jpg" alt="" width="300" height="300" class="alignnone size-medium wp-image-243" />
  						<h3><?php _e( 'Axel', 'cocotheme'); ?></h3>
  						</a>
  					</li>
  				</ul>
  			</div>
  		</section>
  		</div>
  	</div>
  	<?php
  }
}

/*
** Contact form
*/

function cocolo_contact() {
	?>
	<div id="contact-form" role="contact">
		<div class="col-full">
		<section class="contact-area" aria-label="Contact">
			<div id="contact-area">
				<h2 class="section-title"><?php echo __( 'Get in touch', 'cocotheme' ); ?></h2>
				<p>
					<?php _e( 'Do you have something special in mind? Email or call us at', 'cocotheme'); ?> <a href="tel:+81344057955">+81344057955</a>
				</p>
				<?php $from = do_shortcode('[contact]'); echo $from; ?>
			</div>
		</section>
		</div>
	</div>
	<?php
}

/*
** Clouds
*/

function cocolo_clouds() {
	?>
	<div id="clouds" role="banner">
		<img src="<?php echo get_stylesheet_directory_uri(); ?>/img/kumo1.svg" alt="Cloud 1" class="clouds cloud1 not-in-mobile">
		<img src="<?php echo get_stylesheet_directory_uri(); ?>/img/kumo1.svg" alt="Cloud 1" class="clouds cloud2 not-in-mobile">
		<img src="<?php echo get_stylesheet_directory_uri(); ?>/img/kumo1.svg" alt="Cloud 1" class="clouds cloud3 not-in-mobile">
		<img src="<?php echo get_stylesheet_directory_uri(); ?>/img/kumo2.svg" alt="Cloud 2" class="clouds cloud4 not-in-mobile">
		<img src="<?php echo get_stylesheet_directory_uri(); ?>/img/kumo3.svg" alt="Cloud 3" class="clouds cloud5">
	</div>
	<?php
}

/*
** Branding in footer
*/

function cocolo_footer_branding() {
	?>
	<img src="<?php echo get_stylesheet_directory_uri(); ?>/img/cocolotravel-logo.svg" alt="Cocolo logo" class="footer-branding">
	<?php
}

/*
** Why Cocolo
*/

function cocolo_why() {
    if ( is_front_page() ) {
	?>
	<div id="reasons" role="complementary">
		<div class="col-full">
		<section class="reasons" aria-label="Why travel with Cocolo?">
			<h2 class="section-title"><?php echo __( 'Why travel with Cocolo?', 'cocotheme' ); ?></h2>
			<div>
				<h3>It's more than travel it's your story</h3>
				<h4>Human & personal</h4>
				<p>( No app,  )</p>
				<h4>Unique & elegant</h4>
				<p>All our services are crafted following our standards.</p>
				<h4>Simple & curated</h4>
				<p>Are you overwhelmed by the abundance of choice? Not sure what is worth your time? We make it easy for you.</p>
			</div>
		</section>
		</div>
	</div>
	<?php
	}
}
