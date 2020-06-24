<?php
/**
 * Sea to Sky Rapids functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Sea_to_Sky_Rapids
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

if ( ! function_exists( 'seatosky_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function seatosky_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Sea to Sky Rapids, use a find and replace
		 * to change 'seatosky' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'seatosky', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// Add custom styles to block editor

		add_theme_support( 'editor-styles' );

		// Enqueue editor styles.
		add_editor_style( 'css/editor-style.css' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus(
			array(
				'header' => esc_html__( 'Header Menu Location', 'seatosky' ),
				'footer' => esc_html__( 'Footer Menu Location', 'seatosky' ),
				'social' => esc_html__( 'Social Menu Location', 'seatosky' ),
				
			)
		);

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'style',
				'script',
			)
		);

		// Set up the WordPress core custom background feature.
		add_theme_support(
			'custom-background',
			apply_filters(
				'seatosky_custom_background_args',
				array(
					'default-color' => 'ffffff',
					'default-image' => '',
				)
			)
		);

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support(
			'custom-logo',
			array(
				 'height'      => 80,
				'width'       => 80,
				'flex-width'  => true,
				'flex-height' => true,
			)
		);
	}
endif;
add_action( 'after_setup_theme', 'seatosky_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function seatosky_content_width() {
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters( 'seatosky_content_width', 640 );
}
add_action( 'after_setup_theme', 'seatosky_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function seatosky_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'seatosky' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'seatosky' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'seatosky_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function seatosky_scripts() {
	wp_enqueue_style( 'seatosky-style', get_stylesheet_uri(), array(), _S_VERSION );
	wp_style_add_data( 'seatosky-style', 'rtl', 'replace' );

	wp_enqueue_script( 'seatosky-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );

	wp_enqueue_script( 'seatosky-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), _S_VERSION, true );


	// JS files
    wp_enqueue_script( 'seatosky-slickslider', get_template_directory_uri().'/js/slick.min.js', array('jquery'), '20200527', true );

	wp_enqueue_script( 'seatosky-slickslider-settings', get_template_directory_uri().'/js/slick-settings.js', array('jquery', 'seatosky-slickslider'), '20200527', true );

	wp_enqueue_script( 'seatosky-accordion', get_template_directory_uri() . '/js/accordion.js', array(), '20200611', true );

	wp_enqueue_script('twd-scroll-js', get_template_directory_uri().'/js/scroll-to-top.js', true);

	if ( is_page (39) ) {
		wp_enqueue_script( 'google-map', 'https://maps.googleapis.com/maps/api/js?key=xxx', array(), '3', true );

		wp_enqueue_script( 'google-map-init', get_template_directory_uri() . '/js/google-maps.js', array('google-map', 'jquery'), '0.1', true );
	}


	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'seatosky_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

// custom post types 

require get_template_directory() . '/inc/cpt-taxonomy.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

/**
 * Load WooCommerce compatibility file.
 */
if ( class_exists( 'WooCommerce' ) ) {
	require get_template_directory() . '/inc/woocommerce/woocommerce.php';
}

/**
 * Product page functions
 */
require get_template_directory() . '/inc/woocommerce/product-functions.php';

//restrict block editor
function my_allowed_block_types( $allowed_block_types, $post ) {
    if ( 20 === $post->ID || 35 === $post->ID ) {
       return array( 'core/paragraph' );
    } else {
       return $allowed_block_types;
    }
}
add_filter( 'allowed_block_types', 'my_allowed_block_types', 10, 2);

// Google Map API Key
function my_acf_google_map_api( $api ){
	$api['key'] = 'xxx';
	return $api;
   }
   add_filter('acf/fields/google_map/api', 'my_acf_google_map_api');

// Google Maps shortcode
function maps_shortcode() {
	if ( function_exists ( 'get_field') ) :
		$location = get_field( 'map' ); 

			if ( get_field( 'map') ) : 
			ob_start(); ?>
			<div class="acf-map">
				<div class="marker" data-lat="<?php echo esc_attr($location['lat']); ?>" data-lng="<?php echo esc_attr($location['lng']); ?>"></div>
			</div><!-- end acf-map -->

			<?php endif;

	endif; 

	return ob_get_clean(); 
}
add_shortcode('map', 'maps_shortcode');

/**
 * Lower Yoast SEO Metabox location
 */
function yoast_to_bottom(){
	return 'low';
}
add_filter( 'wpseo_metabox_prio', 'yoast_to_bottom' );

// Remove placeholder text in checkout
add_filter( 'woocommerce_checkout_fields' , 'custom_override_checkout_fields' );

// Our hooked in function - $fields is passed via the filter
function custom_override_checkout_fields( $fields ) {
     $fields['order']['order_comments']['placeholder'] = 'Include any notes we should know for your family and any dietary restrictions if your tour includes a lunch option.';
     return $fields;
}
// Custom Dashboard Widget :)
function add_custom_dashboard_widgets() {

	    wp_add_dashboard_widget(
	                 'wpexplorer_dashboard_widget',
	                 'Hello Sea To Sky Rapids! ', 
	                 'custom_dashboard_widget_content' 
			);
			
		wp_add_dashboard_widget(
			'wpexplorer_dashboard_widget_video',
			'Video Tutorials', 
			'custom_dashboard_video_widget_content' 
	   );
	}
// Custom Dashboard Widget Hook
	add_action( 'wp_dashboard_setup', 'add_custom_dashboard_widgets' );

function custom_dashboard_widget_content() {
	 echo "If you have any need of assistance, please don't hesitate to contact us at:
     <ul>
         <li>http://capstonedreamteam.com</li>
         <li>1-800-webdesign</li>
     </ul>
     ";
	}

function custom_dashboard_video_widget_content() { ?>
	<video controls src='<?php echo esc_url( home_url( '/wp-content/uploads/2020/06/add-staff-member.mp4' ) ); ?>' title='How to add a staff member'></video>
	<video controls src='<?php echo esc_url( home_url( '/wp-content/uploads/2020/06/add-faq.mp4' ) ); ?>' title='How to add FAQs'></video>
	<video controls src='<?php echo esc_url( home_url( '/wp-content/uploads/2020/06/add-a-tour.mp4' ) ); ?>' title='How to add a tour'></video>
	<video controls src='<?php echo esc_url( home_url( '/wp-content/uploads/2020/06/add-testimonial.mp4' ) ); ?>' title='How to add a testimonial'></video>
	<video controls src='<?php echo esc_url( home_url( '/wp-content/uploads/2020/06/adding-removing-content.mp4' ) ); ?>' title='How to edit, add, and remove content'></video>
	<video controls src='<?php echo esc_url( home_url( '/wp-content/uploads/2020/06/edit-orders.mp4' ) ); ?>' title='How to revise orders'></video>

	<?php }

// Custom Dashboard Menu for non-admins
function wpdocs_remove_menus(){
    if ( !current_user_can( 'manage_options' ) ) {
		  remove_menu_page( 'edit.php' );                   //Posts
		  remove_menu_page( 'edit-comments.php' );          //Comments
		  remove_menu_page( 'themes.php' );                 //Appearance
		  remove_menu_page( 'plugins.php' );                //Plugins
		  remove_menu_page( 'users.php' );                  //Users
		  remove_menu_page( 'tools.php' );                  //Tools
		  remove_menu_page( 'options-general.php' );        //Settings
    }
}
add_action( 'admin_menu', 'wpdocs_remove_menus' );

//custom Dashboard Footer
function remove_footer_admin () {
 
echo 'Custom Design & Code by <a href="http://bcitwebdeveloper.ca" target="_blank">TWD Dream Team - K * J * S * F * Z</a></p>';
 
}
 
add_filter('admin_footer_text', 'remove_footer_admin');

?>
