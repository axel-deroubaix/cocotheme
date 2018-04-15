<div class="<?php if ( 1 == $required ) echo 'required-product-addon'; ?> product-addon product-addon-<?php echo sanitize_title( $name ); ?>">

	<?php do_action( 'wc_product_addon_start', $addon ); ?>

	<?php if ( $name ) : ?>
		<label class="label addon-label"><?php echo wptexturize( $name ); ?> <?php if ( 1 == $required ) echo '<abbr class="required" title="' . __( 'Required field', 'woocommerce-product-addons' ) . '">*</abbr>'; ?></label>
	<?php endif; ?>

	<?php if ( $description ) : ?>
		<?php echo '<div class="addon-description"><ul style="list-style: none;margin: 0 0 .5em 0;line-height: 1.4em;"><li>' . wptexturize( $description ) . '</li></ul></div>'; ?>
	<?php endif; ?>

	<?php do_action( 'wc_product_addon_options', $addon ); ?>
