<?php

// Slider Post Type
require_once(dirname(__FILE__) . '/slider_post_type.php');

// Enqueue Flexslider Files
function slider_scripts() {
	wp_enqueue_script( 'jquery' );
	wp_enqueue_style( 'flex-style', get_stylesheet_directory_uri() . '/inc/responsive-slider/css/flexslider.css' );
	wp_enqueue_script( 'flex-script', get_stylesheet_directory_uri() . '/inc/responsive-slider/js/jquery.flexslider-min.js', array( 'jquery' ), false, true );
}
add_action( 'wp_enqueue_scripts', 'slider_scripts' );


// Initialize Slider	
function slider_initialize() { ?>
	<script type="text/javascript" charset="utf-8">
		jQuery(window).load(function() {
		  jQuery('.flexslider').flexslider({
		    animation: "fade",
		    direction: "horizontal",
	    	slideshowSpeed: 7000,
	    	animationSpeed: 600,
	    	controlNav: false
		  });
		});
	</script>
<?php }
add_action( 'wp_footer', 'slider_initialize' );
	

// Create Slider	
function slider_template() {
	// Query Arguments
	$args = array(
				'post_type' => 'slides',
				'posts_per_page'	=> 5
			);	
		
	// The Query
	$the_query = new WP_Query( $args );
		
	// Check if the Query returns any posts
	if ( $the_query->have_posts() ) {
		
	// Start the Slider ?>
	<div class="flexslider">
		<ul class="slides">
			
			<?php		
			// The Loop
			while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
				<li>

				<?php if (get_the_title() || get_the_content()) : ?>

					<div class="caption">

					<?php if (get_the_title()) : ?>
						<h2 class="title"> <?php echo get_the_title(); ?> </h2>
					<?php endif; ?>

					<?php if (get_the_content()) : ?>
						<p class="excerpt"> <?php echo shorten_text(get_the_content(), 25); ?> </p>
					<?php endif; ?>

					</div>

				<?php endif; ?>
					
				<?php // Check if there's a Slide URL given and if so let's a link to it
				if ( get_post_meta( get_the_id(), 'slideurl', true) != '' ) { ?>
					<a href="<?php echo esc_url( get_post_meta( get_the_id(), 'slideurl', true ) ); ?>">
				<?php }
					
				// The Slide's Image
				echo the_post_thumbnail('flex-slide');
					   
				// Close off the Slide's Link if there is one
				if ( get_post_meta( get_the_id(), 'slideurl', true) != '' ) { ?>
					</a>
				<?php } ?>
					
			    </li>
			<?php endwhile; ?>
		
		</ul><!-- .slides -->
	</div><!-- .flexslider -->
		
	<?php }
		
	// Reset Post Data
	wp_reset_postdata();
}

// Slider Shortcode
function slider_shortcode() {
	ob_start();
	slider_template();
	$slider = ob_get_clean();
	return $slider;
}
add_shortcode( 'slider', 'slider_shortcode' );

// Custom image size
add_image_size('flex-slide', 600, 350, true);