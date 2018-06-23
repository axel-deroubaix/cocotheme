<?php

/*
** Remove emojis
*/
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
remove_action( 'admin_print_styles', 'print_emoji_styles' );

/* Google adsense and Tag manager*/
add_action( 'wp_head', 'cocolo_tag_manager_header', 1);
add_action( 'storefront_before_site', 'cocolo_tag_manager_body', 1);
add_action( 'wp_head', 'cocolo_adsense', 999 );

function cocolo_tag_manager_header() {
	?>
	<!-- Google Tag Manager -->
	<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
	new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
	j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
	'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
	})(window,document,'script','dataLayer','GTM-KD9K4P8');</script>
	<!-- End Google Tag Manager -->
	<?php
}

function cocolo_tag_manager_body() {
	?>
	<!-- Google Tag Manager (noscript) -->
	<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-KD9K4P8"
	height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
	<!-- End Google Tag Manager (noscript) -->
	<?php
}

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
** Change image sizes
*/
add_filter( 'storefront_woocommerce_args', 'cocolo_storefront_woocommerce_args' );

function cocolo_storefront_woocommerce_args( $args ) {
  $args['single_image_width'] = 640;
  return $args;
}

/*
** Dequeue storefront fonts
*/
add_action( 'wp_enqueue_scripts', 'cocolo_dequeue_storefront_font', 999);

function cocolo_dequeue_storefront_font() {
	wp_dequeue_style('storefront-fonts');
}

/*
** Contact page css
*/
add_action( 'wp_head', 'cocolo_contact_page_css' );

function cocolo_contact_page_css() {
	global $post;

	$title = get_the_title($post->ID);

	if ( $title == "Contact" ) {
		?><style type="text/css">#primary{display:none;}.storefront-breadcrumb{margin-bottom:0;}</style><?php
	}

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
	remove_action( 'storefront_header', 'storefront_primary_navigation_wrapper', 42 );
	remove_action( 'storefront_header', 'storefront_primary_navigation', 50 );
	remove_action( 'storefront_header', 'storefront_header_cart', 60 );
	remove_action( 'storefront_header', 'storefront_primary_navigation_wrapper_close', 68 );
	add_action( 'storefront_header', 'cocolo_branding', 20 );
	add_action( 'storefront_header', 'storefront_primary_navigation', 40 );
	//add_action( 'storefront_header', 'cocolo_header_search', 20 );
	add_action( 'storefront_before_content', 'cocolo_hero', 5 );
	add_filter( 'wp_nav_menu_items', 'cocolo_nav_menu_items', 10, 2);

	// Homepage
	remove_action( 'homepage', 'storefront_homepage_content', 10 );
	remove_action( 'homepage', 'storefront_product_categories', 20 );
	remove_action( 'homepage', 'storefront_recent_products', 30 );
	remove_action( 'homepage', 'storefront_popular_products', 50 );
	remove_action( 'homepage', 'storefront_on_sale_products', 60 );
	remove_action( 'homepage', 'storefront_best_selling_products', 70 );
	//add_action( 'storefront_homepage_after_featured_products_title', 'cocolo_see_all_products_link' );
	add_filter( 'storefront_featured_products_args', 'cocolo_featured' );

	// Why and about page
	add_action( 'storefront_before_footer', 'cocolo_why', 10 );
	add_action( 'storefront_before_footer', 'cocolo_team', 10 );
	add_action( 'storefront_before_footer', 'cocolo_office', 20 );
	add_action( 'storefront_before_footer', 'cocolo_company_data', 30 );
	add_action( 'storefront_before_footer', 'cocolo_booknow', 40 );


	// Footer
	remove_action( 'storefront_footer', 'storefront_credit', 20 );
	remove_action( 'storefront_footer', 'storefront_handheld_footer_bar', 999 );
	add_action( 'storefront_before_footer', 'cocolo_contact', 30 );
	add_action( 'storefront_before_footer', 'cocolo_clouds', 40 );
	add_action( 'storefront_footer','cocolo_footer_branding', 20 );
	add_action( 'wp_footer','cocolo_scripts' );
	add_action( 'wp_footer','cocolo_font' );
}

/*
** Cocolo Google Font
*/

function cocolo_font() {
	?>
	<link href="https://fonts.googleapis.com/css?family=Playfair+Display|Roboto:300" rel="stylesheet">
	<?php
}

/*
** Branding in header
*/

function cocolo_branding_with_search() {
	// this branding only works when we have the AJAx search plugin
	if ( is_front_page() ) {
	?>
	<div class="site-branding">
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="custom-logo-link" rel="home" itemprop="url">
			<picture>
				<source media="(min-width: 990px)" srcset="<?php echo get_stylesheet_directory_uri(); ?>/img/cocolo-logo.svg">
				<source media="(min-width: 750px)" srcset="<?php echo get_stylesheet_directory_uri(); ?>/img/cocolo-logo-small.svg">
				<img src="<?php echo get_stylesheet_directory_uri(); ?>/img/cocolo-logo.svg" alt="Logo">
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
				<img src="<?php echo get_stylesheet_directory_uri(); ?>/img/cocolo-logo.svg" alt="Logo">
			</picture>
		</a>
	</div>
	<?php
	}
}

function cocolo_branding() {
	?>
	<div class="site-branding">
		<h1 class="logo">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="custom-logo-link" rel="home" itemprop="url">
				<img src="<?php echo get_stylesheet_directory_uri(); ?>/img/cocolo-logo.svg" alt="Logo">
			</a>
		</h1>
	</div>
	<?php
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
					<p class="hero-title"><?php _e( 'The Art of Travel', 'cocotheme') ?></p>
					<p class="hero-subtitle"><?php _e( 'We help you plan original tours and experiences in Japan', 'cocotheme') ?></p>
					<?php //echo do_shortcode( '[wcas-search-form]' );?>
					<p class="hero-subtitle"><a href="<?php echo site_url( '/contact/' ); ?>"><?php _e( 'Let\'s plan together!', 'cocotheme'); ?></a></p>
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
		'limit' 						=> 100,
		'columns' 					=> 3,
		'child_categories' 	=> 0,
		'orderby' 					=> 'rand',
		'order'							=> 'ASC',
		'title'							=> __( 'Experiences', 'cocotheme' ),
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

	$user					=	wp_get_current_user();
	$name					=	$user->display_name;
	$cc						=	do_shortcode('[woocommerce_currency_converter currency_display="select"]');
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

	if ( is_product( $product ) ) { //script to toggle the check Availability button
		?>
		<script>
		jQuery(document).ready(function () {
			jQuery(".start-booking-button").click(function () {
				jQuery('.cart').slideToggle("slow");
			});
		});
		jQuery(document).ready(function () {
		    jQuery(".addon-checkbox").click(function () {
		        jQuery('.product-addon-hotel-name').slideToggle("slow");
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
	global $post;

	$title = get_the_title($post->ID);

	if ( $title == "About" ) {
		?>
		<section id="shout" class="section" aria-label="Cocolo means heart" style="padding-top:0;">
			<div class="col-full">
				<h1 class="hero-title" style="text-align:center;"><?php echo __( 'Cocolo means heart', 'cocotheme' ); ?></h1>
				<p class="hero-subtitle" style="text-align:center;"><?php _e( 'We love Japan and are 100% true to it. We only sell Japan and are based here.', 'cocotheme') ?></p>
			</div>
		</section>
		<div style="background-color: #f5f5f5;">
			<div class="col-full">
				<section id="crew" class="team section" aria-label="Meet the team">
					<h2 class="section-title"><?php echo __( 'The Crew — meet the team', 'cocotheme' ); ?></h2>

					<div class="cocolo-columns">
						<div class="column-content">
							<figure class="cocolo-caption">
								<img class="feature" src="<?php echo get_stylesheet_directory_uri(); ?>/img/staff/maki.jpg" alt="Maki" width="300" height="300" />
								<figcaption class="cocolo-caption-text"><?php _e( 'Maki', 'cocotheme'); ?></figcaption>
							</figure>
						</div>
						<div class="column-content column-speech">
							<p class="speech"><?php _e( 'Born and raised in Tokyo, I first traveled on my own at the age of 5 when I visited my grandma’s house. She lived ona Japanese tropical island in the Pacific ocean. It was my first time flying a propeller plane. For the little girl I was, this memorable experience sparked my lifelong passion for travel and my thirst for discovery. I started backpacking from the east to the west in my 20’s and I landed in New York working as a designer. There, I later met my husband. Now, I feel so fortunate to be able share our passion for traveling and introduce my country. I since rediscovered Japan’s rich history and culture. Fresh sushi makes me happy, and strolling in the secluded gardens of Kyoto give me a great deal of inspiration.', 'cocotheme'); ?></p>
						</div>
					</div>
					<div class="cocolo-columns">
						<div class="column-content">
							<figure class="cocolo-caption">
								<img src="<?php echo get_stylesheet_directory_uri(); ?>/img/staff/aiko.jpg" alt="Aiko" width="300" height="300" />
								<figcaption class="cocolo-caption-text"><?php _e( 'Aiko', 'cocotheme'); ?></figcaption>
							</figure>
						</div>
						<div class="column-content column-speech">
							<p class="speech"><?php _e( 'I was born and raised in Japan. After 7 years experience in banking, I’ve got a chance to live in Hong Kong, China for my husband’s work. Even though I lived there just for 2 years, it was enough time to open my eyes. The experience living abroad made me realize how unique and beautiful my home country is. I feel so blessed to work for this team and introduce Japan to the world. My favorite Japanese food is Tofu and my favorite thing to do in Japan is walking local shopping street.', 'cocotheme'); ?></p>
						</div>
					</div>
					<div class="cocolo-columns">
						<div class="column-content">
							<figure class="cocolo-caption">
								<img class="feature" src="<?php echo get_stylesheet_directory_uri(); ?>/img/staff/pierre.jpg" alt="Pierre" width="300" height="300"/>
								<figcaption class="cocolo-caption-text"><?php _e( 'Pierre', 'cocotheme'); ?></figcaption>
							</figure>
						</div>
						<div class="column-content column-speech">
							<p class="speech"><?php _e( 'Born and raised in French Alps close to the Italian border. Being part Scottish from my Mom, I benefited from a multicultural background who make my interest about other cultures raised. After High-school I left my lovely mountains for Japan in 2004  and fell in love of this country. Thanks to my fisrt experience their I obtain a university degree of Japanese civilisation “with honor” at Lyon and Waseda university Tokyo. In 2011 I obtain a Master degree of LCE at Lyon after an internship at Tokyo. I am living in Kyoto since then. I will share with you my passion of this city and give you specific keys to understand this sophisticated and fabulous culture. My hobbies are to found interesting and undiscovered spot in Japan and share it with friends, photography, movies and food! I will gave you my favorite ramen’s spot in Kyoto ! ', 'cocotheme'); ?></p>
						</div>
					</div>
					<div class="cocolo-columns">
						<div class="column-content">
							<figure class="cocolo-caption">
								<img class="feature" src="<?php echo get_stylesheet_directory_uri(); ?>/img/staff/axel.jpg" alt="Axel" width="300" height="300"/>
								<figcaption class="cocolo-caption-text"><?php _e( 'Axel', 'cocotheme'); ?></figcaption>
							</figure>
						</div>
						<div class="column-content column-speech">
							<p class="speech"><?php _e( 'I was born and raised between France and Belgium. From age 21 I started living in Spain and later in the USA. I finally settled in Japan in 2008 where I fell in love with the country and my wife. I am lucky enough that travel, my lifelong passion, is my work. After gaining experience at several travel companies in Japan I co-founded EYExplore: an agency specialized in travel photography lessons. I am now proud to offer meaningful travel experiences at Cocolo Travel. My favourite Japanese food is Ramen (the thick soup ones). My number 1 thing to do in Japan: relaxing in an Onsen hot spring baths.', 'cocotheme'); ?></p>
						</div>
					</div>
				</section>
			</div>
		</div>
		<?php
	}
}

/*
** Office template
*/

function cocolo_office() {
	global $post;

	$title = get_the_title($post->ID);

	if ( $title == "About" ) {
		?>
	  	<div class="col-full">
			<section id="office" class="office section" aria-label="The office">
				<h2 class="section-title"><?php echo __( 'Our office — Nakagin Capsule Tower', 'cocotheme' ); ?></h2>
				<div class="cocolo-columns">
					<div class="column-content content-office">
						<img src="<?php echo get_stylesheet_directory_uri(); ?>/img/nakagin-office.jpg" alt="office" width="300" />
					</div>
					<div class="column-content content-map">
						<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3336.3755860824626!2d139.7611710469609!3d35.667263142384435!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x214d237e3bb7f649!2sNakagin+Capsule+Tower!5e0!3m2!1sen!2sjp!4v1525395592211" width="900" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
					</div>
				</div>
			</section>
		</div>
		<?php
	}
}

/*
** Company data
*/

function cocolo_company_data() {
	global $post;

	$title = get_the_title($post->ID);

	if ( $title == "About" ) {
	  ?>
		<div style="background-color: #f5f5f5;">
			<div class="col-full">
				<section id="data" class="data section" aria-label="Company Data">
					<h2 class="section-title"><?php echo __( 'The facts — company data', 'cocotheme' ); ?></h2>
					<table>
						<tbody>
							<tr>
								<td>
									<p><?php _e( 'Corporate name', 'cocotheme'); ?></p>
								</td>
								<td>
									<p><?php _e( 'Cocolo Travel Llc.', 'cocotheme'); ?></p>
								</td>
							</tr>
							<tr>
								<td>
									<p><?php _e( 'Purpose', 'cocotheme'); ?></p>
								</td>
								<td>
									<p>
										<?php _e( 'Consulting and booking for travel agencies', 'cocotheme'); ?><br>
										<?php _e( 'Travel related staff training', 'cocotheme'); ?><br>
										<?php _e( 'All other activities incidental or related to each of the above', 'cocotheme'); ?>
									</p>
								</td>
							</tr>
							<tr>
								<td>
									<p><?php _e( 'Head office', 'cocotheme'); ?></p>
								</td>
								<td>
									<p><?php _e( 'Nakagin Capsule Tower, 8-16-10 Ginza Chuo Tokyo, 104-0061 Japan', 'cocotheme'); ?></p>
								</td>
							</tr>
							<tr>
								<td>
									<p><?php _e( 'Founded', 'cocotheme'); ?></p>
								</td>
								<td>
									<p><?php _e( 'February 28, 2017', 'cocotheme'); ?></p>
								</td>
							</tr>
							<tr>
								<td>
									<p><?php _e( 'Capital', 'cocotheme'); ?></p>
								</td>
								<td>
									<p><?php _e( 'JPY 3,000,000', 'cocotheme'); ?></p>
								</td>
							</tr>
							<tr>
								<td>
									<p><?php _e( 'Staff', 'cocotheme'); ?></p>
								</td>
								<td>
									<p><?php _e( '3 full-time, 1 part-time', 'cocotheme'); ?></p>
								</td>
							</tr>
							<tr>
								<td>
									<p><?php _e( 'Board members', 'cocotheme'); ?></p>
								</td>
								<td>
									<p><?php _e( 'Axel Deroubaix, Maki Deroubaix', 'cocotheme'); ?></p>
								</td>
							</tr>
							<tr>
								<td>
									<p><?php _e( 'Travel agency licence', 'cocotheme'); ?></p>
								</td>
								<td>
									<p><?php _e( '20071', 'cocotheme'); ?></p>
								</td>
							</tr>
						</tbody>
					</table>
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
	global $post;

	$title = get_the_title($post->ID);

	if ( $title == "Contact" ) {
		?>
		<div id="contact-form" role="contact">
			<div class="col-full">
				<section class="contact-area section" aria-label="Contact">
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
		<img src="<?php echo get_stylesheet_directory_uri(); ?>/img/kumo3.svg" alt="Cloud 3" class="clouds cloud5 not-in-mobile">
	</div>
	<?php
}

/*
** Branding in footer
*/

function cocolo_footer_branding() {
	?>
	<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="custom-logo-link" rel="home" itemprop="url"><img src="<?php echo get_stylesheet_directory_uri(); ?>/img/cocolo-logo.svg" alt="Cocolo logo" class="footer-branding"></a>
	<?php
}

/*
** Why Cocolo
*/

function cocolo_why() {
	global $post;

	$title = get_the_title($post->ID);

	if ( $title == "Why" ) {
		?>
		<div id="reasons" role="complementary">
			<section class="section" aria-label="Why travel with Cocolo?" style="padding-top:0;">
				<div class="col-full">
					<h1 class="hero-title" style="text-align:center;"><?php echo __( 'Original experiences in Japan', 'cocotheme' ); ?></h1>
					<p class="hero-subtitle" style="text-align:center;"><?php _e( 'Curated, non-mass-market travel experiences in Japan', 'cocotheme') ?></p>
				</div>
			</section>
			<section aria-label="Reasons">
				<div class="reasons off-color">
					<div class="col-full">
						<span class="reason-right">
							<img src="<?php echo get_stylesheet_directory_uri(); ?>/img/why1.svg" alt="why1" style="float:right;">
						</span>
						<span class="reason-left">
							<h2 style="font-family: 'Playfair Display', serif;font-weight: 600;"><?php _e( 'Slow travel — No tourist burnout', 'cocotheme'); ?></h2>
							<p><?php _e( 'Have you ever come home from a vacation feeling more exhausted than you were before you left? Have you ever felt like you had no time to get to know the area enough?', 'cocotheme'); ?></p>
							<p><?php _e( 'We take a slow approach to travel and favor quality time over quantity of places visited. Take time to discover Japan with us.', 'cocotheme'); ?></p>
							<blockquote><?php _e( '"All traveling becomes dull in exact proportion to its rapidity." ―John Ruskin', 'cocotheme'); ?></blockquote>
						</span>
					</div>
				</div>
				<div class="reasons">
					<div class="col-full">
						<span class="reason-left">
							<img src="<?php echo get_stylesheet_directory_uri(); ?>/img/why2.svg" alt="why2">
						</span>
						<span class="reason-right">
							<h2 style="font-family: 'Playfair Display', serif;font-weight: 600;"><?php _e( 'Curated — No planning headache', 'cocotheme'); ?></h2>
							<p><?php _e( 'Are you overwhelmed by the abundance of choice? Not sure what is worth your time?', 'cocotheme'); ?></p>
							<p><?php _e( 'We make it easy for you selecting only the experiences in Japan that match our standards: exclusive, memorable and elegant', 'cocotheme'); ?></p>
							<blockquote><?php _e( '"All journeys have secret destination of which the traveler is unaware." ―Martin Buber ', 'cocotheme'); ?></blockquote>
						</span>
					</div>
				</div>
				<div class="reasons off-color">
					<div class="col-full">
						<span class="reason-right">
							<img src="<?php echo get_stylesheet_directory_uri(); ?>/img/why3.svg" alt="why3" style="float:right;">
						</span>
						<span class="reason-left">
							<h2 style="font-family: 'Playfair Display', serif;font-weight: 600;"><?php _e( 'People centered — Meet new friends', 'cocotheme'); ?></h2>
							<p><?php _e( 'Have you ever stayed somewhere yet never connected with the people around? Do you want a deeper meaning to your travel than just ticking a places-to-go list?', 'cocotheme'); ?></p>
							<p><?php _e( 'We\'ve got you covered! Human interaction is at the center of our selection process.' , 'cocotheme'); ?></p>
							<blockquote><?php _e( '"The real voyage of discovery consists not in seeking new landscapes, but in having new eyes" ―Marcel Proust', 'cocotheme'); ?></blockquote>
						</span>
					</div>
				</div>
			</section>
		</div>
		<?php
	}
}

/*
** Book now section
*/

function cocolo_booknow() {
	global $post;

	$title = get_the_title($post->ID);

	if ( $title == "Why" || $title == "About" ) {
		?>
		<div id="booknow" role="complementary">
			<section class="booknow col-full" style="padding:5em 0 3em 0;text-align:center;color:#ffffff;" aria-label="Book now">
				<p class="hero-subtitle">
				<a href="<?php echo get_permalink( woocommerce_get_page_id( 'shop' ) ); ?>"><?php _e( 'Book now', 'eyetheme') ?></a>
				</p>
			</section>
		</div>
		<?php
	}
}
