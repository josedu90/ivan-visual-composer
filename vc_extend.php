<?php
/*
Plugin Name: Visual Composer Customizer Add-on
Plugin URI: http://code9rs.com/
Description: Extend Visual Composer with useful modules and customizer capabilities.
Version: 1.1
Author: CodeNiners
Author URI: http://code9rs.com/
*/

/*
This example/starter plugin can be used to speed up Visual Composer plugins creation process.
More information can be found here: http://kb.wpbakery.com/index.php?title=Category:Visual_Composer

In this example all plugin related functions will have a "vc_extend" prefix, make sure to use unique prefix
in your plugin. Otherwise, you (or your users) may experience "Cannot redaclare function" error.
*/

// don't load directly
if (!defined('ABSPATH')) die('-1');

/*
Display notice if Visual Composer is not installed or activated.
*/

add_action('init','ivan_vc_init_addons', 5);
function ivan_vc_init_addons()
{
	$required_vc = '3.7';
	if(defined('WPB_VC_VERSION')){
		if( version_compare( $required_vc, WPB_VC_VERSION, '>' )){
			add_action( 'admin_notices', 'ivan_vc_admin_notice_for_version');
			define('IVAN_VC_NOT_ENABLED', true);
		}
	} else {
		define('IVAN_VC_NOT_ENABLED', true);
		add_action( 'admin_notices', 'ivan_vc_admin_notice_for_vc_activation');
	}
}// end init_addons
function ivan_vc_admin_notice_for_version()
{
	echo '<div class="updated"><p>The <strong>Ivan Customizer Visual Composer</strong> plugin requires <strong>Visual Composer</strong> version 3.7.2 or greater.</p></div>';
}
function ivan_vc_admin_notice_for_vc_activation()
{
	echo '<div class="updated"><p>The <strong>Ivan Customizer Visual Composer</strong> plugin requires <strong>Visual Composer</strong> Plugin installed and activated.</p></div>';
}

// Define contants used to register and enqueue styles/scripts and require our files as well
define('IVAN_VC_DIR', plugin_dir_path( __FILE__ ) );
define('IVAN_VC_URL', plugins_url('', __FILE__ ) );

// Start custom global variable used by our customizer to output the CSS at page end!
global $ivan_custom_css;

// Global init action to require our frontend codes
function ivan_vc_cpt_init() {
	// Include Custom Post Types
	require_once IVAN_VC_DIR . 'cpt.php';
}
add_action('setup_theme', 'ivan_vc_cpt_init');


function ivan_vc_cpt_flush() {
    // First, we "add" the custom post type via the above written function.
    // Note: "add" is written with quotes, as CPTs don't get added to the DB,
    // They are only referenced in the post_type column with a post entry, 
    // when you add a post of this CPT.
    ivan_vc_cpt_init();

    // ATTENTION: This is *only* done during plugin activation hook
    // You should *NEVER EVER* do this on every page load!!
    flush_rewrite_rules();
}
register_activation_hook( __FILE__, 'ivan_vc_cpt_flush' );


// Global init action to require our frontend codes
function ivan_vc_init() {
	if(!defined('IVAN_VC_NOT_ENABLED')) {

		// Include Customizer functions and libs necessary to the use of Customizer.
		require_once IVAN_VC_DIR . 'param/ivan_customizer.php';

		// Require Modules
		//require_once IVAN_VC_DIR . 'modules/row.php';
		require_once IVAN_VC_DIR . 'modules/text.php';
		require_once IVAN_VC_DIR . 'modules/projects.php';
		require_once IVAN_VC_DIR . 'modules/posts.php';
		require_once IVAN_VC_DIR . 'modules/image_block.php';
		require_once IVAN_VC_DIR . 'modules/carousel.php';
		require_once IVAN_VC_DIR . 'modules/pricing_table.php';
		require_once IVAN_VC_DIR . 'modules/contact_form.php';
		require_once IVAN_VC_DIR . 'modules/title_wrapper.php';
		require_once IVAN_VC_DIR . 'modules/testimonial.php';
		require_once IVAN_VC_DIR . 'modules/staff.php';
		require_once IVAN_VC_DIR . 'modules/info_box.php';
		require_once IVAN_VC_DIR . 'modules/button.php';
		require_once IVAN_VC_DIR . 'modules/table.php';
		require_once IVAN_VC_DIR . 'modules/woo.php';
		require_once IVAN_VC_DIR . 'modules/tweet.php';

		require_once IVAN_VC_DIR . 'modules/separator.php';
		require_once IVAN_VC_DIR . 'modules/toggle.php';
		require_once IVAN_VC_DIR . 'modules/tabs.php';
		require_once IVAN_VC_DIR . 'modules/tour.php';
		require_once IVAN_VC_DIR . 'modules/accordion.php';
		require_once IVAN_VC_DIR . 'modules/call_to_action.php';

		// Require map of shortcodes
		require_once IVAN_VC_DIR . 'map.php';

		// Useful Icon Shortcode
		add_shortcode('iv_icon', 'iv_code_icon_func');
	}
}
add_action('init', 'ivan_vc_init', 100);

// Global admin_init action to require back-end codes
function ivan_vc_admin_init() {
	if(!defined('IVAN_VC_NOT_ENABLED')) {

		// Add new VC param to our customizer
		vc_add_shortcode_param('ivan_customizer', 'ivan_vc_customizer_field', IVAN_VC_URL . '/assets/param/ivan_customizer.js');
	}
}
add_action('admin_init', 'ivan_vc_admin_init', 2);

/*
Load Customizer Styles
*/
if( (isset($_GET['vc_action']) && $_GET['vc_action'] === 'vc_inline') ) {
	add_action('admin_enqueue_scripts', 'ivan_customizer_styles');

	function ivan_customizer_styles() {
		wp_enqueue_style('ivan-vc-customizer', IVAN_VC_URL . '/assets/param/ivan_customizer.css');
	}
}

if( (isset($_GET['vceditor']) && $_GET['vceditor'] === 'true') ) {
	add_action('wp_enqueue_scripts', 'ivan_inline_styles');

	function ivan_inline_styles() {
		wp_enqueue_style('ivan-vc-inline', IVAN_VC_URL . '/assets/param/ivan_inline.css');
	}
}

// Adds custom class to body, this will be used by our scripts for a few checks.
function ivan_vc_add_body_classes($classes) {
	$classes[] = 'ivan-vc-enabled';

	return $classes;
}
add_filter( 'body_class', 'ivan_vc_add_body_classes');

// Output Customizer final CSS to footer (before all other styles as well!)
function ivan_vc_custom_css() {
	global $ivan_custom_css;
	echo '<style>' . $ivan_custom_css . '</style>';
}
add_action('wp_footer', 'ivan_vc_custom_css', 2);

/*
Load plugin css and javascript files
*/
add_action('wp_enqueue_scripts', 'vc_extend_js_css', 50);
add_action('admin_enqueue_scripts', 'vc_extend_js_css');
function vc_extend_js_css() {

	if( false == defined('IVAN_VC_LOCAL_STYLES') ) {
		wp_register_style( 'ivan_vc_modules', IVAN_VC_URL . '/assets/modules.css' );
		wp_enqueue_style( 'ivan_vc_modules' );
	}

	if( false == defined('IVAN_VC_LOCAL_FONTS') ) {
		// Register Font Awesome and enqueue it.
		// Source: http://fortawesome.github.io/Font-Awesome/
		wp_register_style( 'font-awesome', IVAN_VC_URL . '/assets/libs/font-awesome-css/font-awesome.min.css', array(), '4.1.0' );
		wp_enqueue_style( 'font-awesome' );

		// Register Elegant Icons and enqueue it.
		// Infos: 100 icons
		wp_register_style( 'elegant-icons', IVAN_VC_URL . '/assets/libs/elegant-icons/elegant-icons.css', array(), '1.0' );
		wp_enqueue_style( 'elegant-icons' );
	}

	// If you need any javascript files on front end, here is how you can load them.
	wp_register_script( 'ivan_vc_modules_js', IVAN_VC_URL . '/assets/modules.min.js', array('jquery') );
	wp_enqueue_script( 'ivan_vc_modules_js' );

	// Localize Args
	$localizeArgs = array( 
		'isAdmin' => is_admin(),
		'container' => apply_filters('ivan_vc_container_selector', 'window'),
	);

	wp_localize_script( 'ivan_vc_modules_js', 'ivan_vc', $localizeArgs );

	// Projects Assets
	if( false == defined('IVAN_VC_LOCAL_OWL') ) {
		wp_register_script( 'ivan_owl_carousel', IVAN_VC_URL . '/assets/owl-carousel/owl.carousel.min.js', array('jquery') );
		wp_register_style( 'ivan_owl_carousel', IVAN_VC_URL . '/assets/owl-carousel/owl.carousel.min.css' );
	}

	// Register Magnific Popup and enqueue it.
	// Source: http://github.com/dimsemenov/Magnific-Popup
	wp_register_style( 'magnific-popup', IVAN_VC_URL . '/assets/libs/magnific-popup/magnific-popup.min.css', array(), '0.9.9' );
	wp_enqueue_style( 'magnific-popup' );

	wp_register_script( 'ivan_vc_projects', IVAN_VC_URL . '/assets/projects.min.js', array('jquery') );
}

/* Define Support Social Icons by Staff */
function ivan_vc_staff_icons() {
	return apply_filters('ivan_vc_staff_icons', array(
		"envelope" => "Mail",
		"dribbble" => "Dribbble",
		"flickr" => "Flickr",
		"github" => "GitHub",
		"pinterest" => "Pinterest",
		"twitter" => "Twitter",
		"weibo" => "Weibo",
		"youtube" => "YouTube",
		"foursquare" => "FourSquare",
		"instagram" => "Instagram",
		"renren" => "RenRen",
		"facebook" => "Facebook",
		"google_plus" => "Google+",
		"linkedin" => "LinkedIn",
		"skype" => "Skype",
		"tumblr" => "Tumblr",
		"vimeo_square" => "Vimeo",
		"xing" => "Xing",
		"vk" => "VK",
	) );
}