<?php
/*
 * Text Module Customization
 */

if( !class_exists('Ivan_VC_Text') ) {
	class Ivan_VC_Text {

		// H1 Selectors
		public $selectors = array(
			'h1_css' => array(
				// Font
				'font-family' => 'h1',
				'font-weight' => 'h1',
				'font-size' => 'h1',
				'line-height' => 'h1',
				'color' => 'h1',
				// Spacing
				'margin-top' => 'h1',
				'margin-right' => 'h1',
				'margin-bottom' => 'h1',
				'margin-left' => 'h1',
				'padding-top' => 'h1',
				'padding-right' => 'h1',
				'padding-bottom' => 'h1',
				'padding-left' => 'h1',
				// Bg
				'background-color' => 'h1',
				// Border
				'border-width-top' => 'h1',
				'border-width-right' => 'h1',
				'border-width-bottom' => 'h1',
				'border-width-left' => 'h1',
				'border-style' => 'h1',
				'border-color' => 'h1',
				// Hovers
				//'color-hover' => 'a:hover',
				//'border-color-hover' => 'a:hover',
				//'background-color-hover' => 'a:hover',
			),
			'h2_css' => array(
				// Font
				'font-family' => 'h2',
				'font-weight' => 'h2',
				'font-size' => 'h2',
				'line-height' => 'h2',
				'color' => 'h2',
				// Spacing
				'margin-top' => 'h2',
				'margin-right' => 'h2',
				'margin-bottom' => 'h2',
				'margin-left' => 'h2',
				'padding-top' => 'h2',
				'padding-right' => 'h2',
				'padding-bottom' => 'h2',
				'padding-left' => 'h2',
				// Bg
				'background-color' => 'h2',
				// Border
				'border-width-top' => 'h2',
				'border-width-right' => 'h2',
				'border-width-bottom' => 'h2',
				'border-width-left' => 'h2',
				'border-style' => 'h2',
				'border-color' => 'h2',
				// Hovers
				//'color-hover' => 'a:hover',
				//'border-color-hover' => 'a:hover',
				//'background-color-hover' => 'a:hover',
			),
			'h3_css' => array(
				// Font
				'font-family' => 'h3',
				'font-weight' => 'h3',
				'font-size' => 'h3',
				'line-height' => 'h3',
				'color' => 'h3',
				// Spacing
				'margin-top' => 'h3',
				'margin-right' => 'h3',
				'margin-bottom' => 'h3',
				'margin-left' => 'h3',
				'padding-top' => 'h3',
				'padding-right' => 'h3',
				'padding-bottom' => 'h3',
				'padding-left' => 'h3',
				// Bg
				'background-color' => 'h3',
				// Border
				'border-width-top' => 'h3',
				'border-width-right' => 'h3',
				'border-width-bottom' => 'h3',
				'border-width-left' => 'h3',
				'border-style' => 'h3',
				'border-color' => 'h3',
				// Hovers
				//'color-hover' => 'a:hover',
				//'border-color-hover' => 'a:hover',
				//'background-color-hover' => 'a:hover',
			),
			'h4_css' => array(
				// Font
				'font-family' => 'h4',
				'font-weight' => 'h4',
				'font-size' => 'h4',
				'line-height' => 'h4',
				'color' => 'h4',
				// Spacing
				'margin-top' => 'h4',
				'margin-right' => 'h4',
				'margin-bottom' => 'h4',
				'margin-left' => 'h4',
				'padding-top' => 'h4',
				'padding-right' => 'h4',
				'padding-bottom' => 'h4',
				'padding-left' => 'h4',
				// Bg
				'background-color' => 'h4',
				// Border
				'border-width-top' => 'h4',
				'border-width-right' => 'h4',
				'border-width-bottom' => 'h4',
				'border-width-left' => 'h4',
				'border-style' => 'h4',
				'border-color' => 'h4',
				// Hovers
				//'color-hover' => 'a:hover',
				//'border-color-hover' => 'a:hover',
				//'background-color-hover' => 'a:hover',
			),
			'h5_css' => array(
				// Font
				'font-family' => 'h5',
				'font-weight' => 'h5',
				'font-size' => 'h5',
				'line-height' => 'h5',
				'color' => 'h5',
				// Spacing
				'margin-top' => 'h5',
				'margin-right' => 'h5',
				'margin-bottom' => 'h5',
				'margin-left' => 'h5',
				'padding-top' => 'h5',
				'padding-right' => 'h5',
				'padding-bottom' => 'h5',
				'padding-left' => 'h5',
				// Bg
				'background-color' => 'h5',
				// Border
				'border-width-top' => 'h5',
				'border-width-right' => 'h5',
				'border-width-bottom' => 'h5',
				'border-width-left' => 'h5',
				'border-style' => 'h5',
				'border-color' => 'h5',
				// Hovers
				//'color-hover' => 'a:hover',
				//'border-color-hover' => 'a:hover',
				//'background-color-hover' => 'a:hover',
			),
			'h6_css' => array(
				// Font
				'font-family' => 'h6',
				'font-weight' => 'h6',
				'font-size' => 'h6',
				'line-height' => 'h6',
				'color' => 'h6',
				// Spacing
				'margin-top' => 'h6',
				'margin-right' => 'h6',
				'margin-bottom' => 'h6',
				'margin-left' => 'h6',
				'padding-top' => 'h6',
				'padding-right' => 'h6',
				'padding-bottom' => 'h6',
				'padding-left' => 'h6',
				// Bg
				'background-color' => 'h6',
				// Border
				'border-width-top' => 'h6',
				'border-width-right' => 'h6',
				'border-width-bottom' => 'h6',
				'border-width-left' => 'h6',
				'border-style' => 'h6',
				'border-color' => 'h6',
				// Hovers
				//'color-hover' => 'a:hover',
				//'border-color-hover' => 'a:hover',
				//'background-color-hover' => 'a:hover',
			),
			'p_css' => array(
				// Font
				'font-family' => 'p',
				'font-weight' => 'p',
				'font-size' => 'p',
				'line-height' => 'p',
				'color' => 'p',
				// Spacing
				'margin-top' => 'p',
				'margin-right' => 'p',
				'margin-bottom' => 'p',
				'margin-left' => 'p',
				'padding-top' => 'p',
				'padding-right' => 'p',
				'padding-bottom' => 'p',
				'padding-left' => 'p',
				// Bg
				//'background-color' => 'p',
				// Border
				//'border-width-top' => 'p',
				//'border-width-right' => 'p',
				//'border-width-bottom' => 'p',
				//'border-width-left' => 'p',
				//'border-style' => 'p',
				//'border-color' => 'p',
				// Hovers
				//'color-hover' => 'a:hover',
				//'border-color-hover' => 'a:hover',
				//'background-color-hover' => 'a:hover',
			),
			'link_css' => array(
				// Font
				'font-family' => 'a',
				'font-weight' => 'a',
				'font-size' => 'a',
				'line-height' => 'a',
				'color' => 'a',
				// Spacing
				//'margin-top' => 'p',
				//'margin-right' => 'p',
				//'margin-bottom' => 'p',
				//'margin-left' => 'p',
				//'padding-top' => 'p',
				//'padding-right' => 'p',
				//'padding-bottom' => 'p',
				//'padding-left' => 'p',
				// Bg
				//'background-color' => 'p',
				// Border
				//'border-width-top' => 'p',
				//'border-width-right' => 'p',
				//'border-width-bottom' => 'p',
				//'border-width-left' => 'p',
				//'border-style' => 'p',
				//'border-color' => 'p',
				// Hovers
				'color-hover' => 'a:hover',
				//'border-color-hover' => 'a:hover',
				//'background-color-hover' => 'a:hover',
			),
			'list_css' => array(
				// Font
				'font-family' => 'li',
				'font-weight' => 'li',
				'font-size' => 'li',
				'line-height' => 'li',
				'color' => 'ul, ol, li',
				// Spacing
				'margin-top' => 'li',
				'margin-right' => 'li',
				'margin-bottom' => 'li',
				'margin-left' => 'li',
				'padding-top' => 'p',
				'padding-right' => 'p',
				'padding-bottom' => 'p',
				'padding-left' => 'p',
				// Bg
				//'background-color' => 'p',
				// Border
				//'border-width-top' => 'p',
				//'border-width-right' => 'p',
				//'border-width-bottom' => 'p',
				//'border-width-left' => 'p',
				//'border-style' => 'p',
				//'border-color' => 'p',
				// Hovers
				//'color-hover' => 'a:hover',
				//'border-color-hover' => 'a:hover',
				//'background-color-hover' => 'a:hover',
			),
		);

		public $prefix = '';

		// Contructor
		public function __construct() {

			// Enqueue scripts and styles if necessary
			add_action( 'admin_enqueue_scripts', array($this, 'admin_scripts') );

			// Customization Init
			add_action( 'admin_init', array($this, 'init') );

			// Apply filter to output custom markup
			add_filter( 'ivan_custom_text_shortcode_before', array($this, 'shortcode_before'), 15, 3 );

			// Apply filter to component class name
			add_filter( 'vc_shortcodes_css_class', array($this, 'custom_class'), 15, 2 );

		}

		public function custom_class($classes, $base) {
			if( 'vc_column_text' == $base ) {
				$classes .= ' ' . str_replace('.', '', $this->prefix);
			}

			return $classes;
		}

		// Shortcode
		public function shortcode_before($output, $atts, $content) {
			global $ivan_custom_css;
			// Extract shortcode attributes
			//extract( shortcode_atts( array(
			//), $atts) );

			$output = '';

			foreach ($this->selectors as $key => $value) {
				if( isset($atts[$key]) && '' != $atts[$key]) {
					preg_match("!\{\s*([^\}]+)\s*\}!", $atts[$key], $match);
					if( !empty($match[0]) ) {
						$this->prefix = str_replace(array('{', '}'), '', $match[0]) . ' ';
						$atts[$key] = str_replace( $match[0], "", $atts[$key] );
					}
				}
			}

			$style = '';

			foreach ($this->selectors as $key => $value) {
				if( isset($atts[$key]) && '' != $atts[$key]) {
					$style .= ivan_vc_customizer_get_style( $atts[$key], $this->selectors[$key], $this->prefix );
				}
			}

			// Print style
			if(is_admin()) {
				$output .= '<style type="text/css">'
				. $style
				. '</style>';
			}
			else {
				/*ob_start();
				var_dump($style);
				$ivan_custom_css .= ob_get_clean();*/
				$ivan_custom_css .= $style;
			}
			
			return $output;
		}

		// Init
		function init() {

			vc_add_param("vc_column_text", array(
				"type" => "ivan_customizer",
				"class" => "",
				"heading" => __("H1 Customization", 'iv_js_composer'),
				"param_name" => "h1_css",
				"customize" => $this->selectors['h1_css'],
				"value" => "",
				"group" => __('H1', 'iv_js_composer'),
			));

			vc_add_param("vc_column_text", array(
				"type" => "ivan_customizer",
				"class" => "",
				"heading" => __("H2 Customization", 'iv_js_composer'),
				"param_name" => "h2_css",
				"customize" => $this->selectors['h2_css'],
				"value" => "",
				"group" => __('H2', 'iv_js_composer'),
			));

			vc_add_param("vc_column_text", array(
				"type" => "ivan_customizer",
				"class" => "",
				"heading" => __("H3 Customization", 'iv_js_composer'),
				"param_name" => "h3_css",
				"customize" => $this->selectors['h3_css'],
				"value" => "",
				"group" => __('H3', 'iv_js_composer'),
			));

			vc_add_param("vc_column_text", array(
				"type" => "ivan_customizer",
				"class" => "",
				"heading" => __("H4 Customization", 'iv_js_composer'),
				"param_name" => "h4_css",
				"customize" => $this->selectors['h4_css'],
				"value" => "",
				"group" => __('H4', 'iv_js_composer'),
			));

			vc_add_param("vc_column_text", array(
				"type" => "ivan_customizer",
				"class" => "",
				"heading" => __("H5 Customization", 'iv_js_composer'),
				"param_name" => "h5_css",
				"customize" => $this->selectors['h5_css'],
				"value" => "",
				"group" => __('H5', 'iv_js_composer'),
			));

			vc_add_param("vc_column_text", array(
				"type" => "ivan_customizer",
				"class" => "",
				"heading" => __("H6 Customization", 'iv_js_composer'),
				"param_name" => "h6_css",
				"customize" => $this->selectors['h6_css'],
				"value" => "",
				"group" => __('H6', 'iv_js_composer'),
			));

			vc_add_param("vc_column_text", array(
				"type" => "ivan_customizer",
				"class" => "",
				"heading" => __("Paragraph Customization", 'iv_js_composer'),
				"param_name" => "p_css",
				"customize" => $this->selectors['p_css'],
				"value" => "",
				"group" => __('Paragraph', 'iv_js_composer'),
			));

			vc_add_param("vc_column_text", array(
				"type" => "ivan_customizer",
				"class" => "",
				"heading" => __("Link Customization", 'iv_js_composer'),
				"param_name" => "link_css",
				"customize" => $this->selectors['link_css'],
				"value" => "",
				"group" => __('Link', 'iv_js_composer'),
			));

			vc_add_param("vc_column_text", array(
				"type" => "ivan_customizer",
				"class" => "",
				"heading" => __("List Customization", 'iv_js_composer'),
				"param_name" => "list_css",
				"customize" => $this->selectors['list_css'],
				"value" => "",
				"group" => __('List', 'iv_js_composer'),
			));

		}

		// Admin Scripts
		function admin_scripts() {

		}

		// Front End Scripts
		static function front_scripts() {

		}



	} // #end class

	// Ignition!
	$ivan_vc_text = new Ivan_VC_Text();

	if ( !function_exists( 'vc_theme_before_vc_column_text' ) ) {
		function vc_theme_before_vc_column_text($atts, $content = null) {
			return apply_filters( 'ivan_custom_text_shortcode_before', '', $atts, $content );
		}
	}

} // #end class check