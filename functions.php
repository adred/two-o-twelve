<?php
// CLIENT INTRODUCTION
function dashboard_customer_support_metabox() {

	function dashboard_customer_support_content() {
		echo "
			<iframe src='https://www.theportlandcompany.com/customer-support-metabox/' style='height: 510px; width: 100%;'>
			</iframe>
		";
	}
	wp_add_dashboard_widget( 'dashboard_customer_support_content', __( 'Customer Support' ), 'dashboard_customer_support_content' );
}
add_action('wp_dashboard_setup', 'dashboard_customer_support_metabox');

// Allows you to apply styles to the TinyMCE Visual Editor.
add_editor_style('css/editor-style.css');

function wordpress_shortcut_icon() {
	$shortcut_icon_url = get_stylesheet_directory_uri() . '/images/shortcut-icon.png';
	echo '<link rel="shortcut icon" href="' . $shortcut_icon_url . '" />';
}
add_action('admin_head', 'wordpress_shortcut_icon');


// WORDPRESS POINTERS FOR TUTORIAL DEVELOPMENT
function get_content_in_wp_pointer() {
	$pointer_content  = '<h3>' . __( 'Title', 'my_textdomain' ) . '</h3>';
	$pointer_content .= '<p>' . __( 'And sample content.', 'my_textdomain' ) . '</p>';
?>
	<script type="text/javascript">
	//<![CDATA[
	jQuery(document).ready( function($) {
		$('#wpadminbar').pointer({
			content: '<?php echo $pointer_content; ?>',
			position: {
				my: 'left top',
				at: 'center bottom',
				offset: '-565 85'
			},
			close: function() {
				setUserSetting( 'p1', '1' ); // This tells WordPress not to display the pointer after the user closes it the first time.
			}
		}).pointer('open');
	});
	//]]>
	</script>
<?php
}

function frontend_styles_scripts() {
	// Globals stylesheet
	wp_enqueue_style( 'globals', get_stylesheet_directory_uri() . '/css/globals.css', array(), '', 'all' );

	// Plugins styles
	wp_enqueue_style( 'plugins-styles', get_stylesheet_directory_uri() . '/css/plugins.css', array(), '', 'all' );

	// Open Sans font (Alternative for AvenirNext Regular)
	wp_enqueue_style( 'open-sans', 'http://fonts.googleapis.com/css?family=Open+Sans:400,300', array(), '', 'all' );

	// Styles
	wp_enqueue_script( 'flex-script', get_stylesheet_directory_uri() . '/javascripts/styles.js', array( 'jquery' ), false, true );
}
add_action( 'wp_enqueue_scripts', 'frontend_styles_scripts' );

// Slider Post Type
require_once(dirname(__FILE__) . '/inc/tpc-responsive-slider/slider_post_type.php');

// Slider Post Type
require_once(dirname(__FILE__) . '/inc/tpc-responsive-slider/slider.php');

// Register Navagition menu(s)
register_nav_menus( array(
	'primary' => __( 'Primary Menu', 'justntime' )
) );

add_image_size('featured-page', 205, 180, true);
add_image_size('sticky', 328, 170, true);

// Featured Pages
function featured_pages() {
	// post query args
	$args = array(
    	'post_type' => 'page',
    	'posts_per_page' => 4,
    	'post_status' => 'publish',
    	'meta_query' => array(
			'key'     => 'featured_page',
			'value'   => 1,
			'compare' => '='
		),
		'orderby' => 'menu_order',
		'order' => 'DESC'
 	);

    // markup
    $markup .= '<ul>';

    //the loop
    $loop = new WP_Query($args);
    while ($loop->have_posts()) {
        $loop->the_post();

        if (! has_post_thumbnail()) continue;

        $markup .= '<li>';
        $markup .= '<section>';
        $markup .= get_the_post_thumbnail( get_the_ID(), 'featured-page' );
        $markup .= '<h2>';
        $markup .= '<a href="'. get_permalink() .'"><span class="vertical-align">'. get_the_title() .'</span></a>';
        $markup .= '</h2>';
        $markup .= '</section>';
        $markup .= '</li>';
    }
    wp_reset_postdata();

    $markup .='</ul>';

    echo $markup;
}
add_action('featured_pages', 'featured_pages');

// Remove editor from the Frontpage
function hide_editor() {
	// Get the Post ID.
	$post_id = $_GET['post'] ? $_GET['post'] : $_POST['post_ID'] ;
	if( !isset( $post_id ) ) return;

 
    if($post_id == 5){ // edit the template name
    	remove_post_type_support('page', 'editor');
    }
}
add_action( 'admin_init', 'hide_editor' );

// Get latest sticky post
function latest_sticky_post() {
	/* Get all sticky posts */
	$sticky = get_option( 'sticky_posts' );

	/* Sort the stickies with the newest ones at the top */
	rsort( $sticky );

	/* Get the 2 newest stickies (change 2 for a different number) */
	$sticky = array_slice( $sticky, 0, 1 );

	$loop = new WP_Query( array( 'post__in' => $sticky, 'caller_get_posts' => 1 ) );

	while ($loop->have_posts()) {
        $loop->the_post();

        $markup .= '<section class="wrapper">';
        $markup .= '<a href="'. get_permalink() .'">'. get_the_post_thumbnail( get_the_ID(), 'sticky' ) .'</a>';
        $markup .= '<h2>';
        $markup .= '<a href="'. get_permalink() .'">'. get_the_title() .'</a>';
        $markup .= '</h2>';
        $markup .= '<span class="date">'. get_the_date() .'</span>';
        $markup .= '<p>'. shorten_text(get_the_content(), 200) .'</p>';
        $markup .= '</section>';
    }
    wp_reset_postdata();

    echo $markup;
}
add_action('latest_sticky_post', 'latest_sticky_post');

// UTILITY FUNCTION -- Shorten text
function shorten_text( $text, $length ) {
	$text = strip_tags( $text );

	if ( empty( $length ) || $length < 0 || $length > strlen( $text ) ) return $text;

	$subs_text = substr( $text, 0, $length );
	$arr = explode( ' ', $subs_text );
	$last_index = count( $arr ) - 1;
	if ( $arr[$last_index] != '' )
		return shorten_text( $text, ++$length );
	else
		return $subs_text . '...';
}