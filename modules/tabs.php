<?php
/***
 * Extension > Tabs
 *
 * This is an extension of default VC Component
 *
 **/

if( !class_exists('Ivan_VC_Tabs') ) {
	class Ivan_VC_Tabs {

		// Contructor
		function __construct() {

			// Apply filter to output custom markup
			add_filter( 'ivan_vc_tabs_shortcode_before', array($this, 'shortcode_before'), 10, 3 );
			add_filter( 'ivan_vc_tabs_shortcode_after', array($this, 'shortcode_after'), 15, 3 );

			if(is_admin())
				add_filter('vc_shortcode_output', array($this, 'shortcode_admin'), 10, 2);

		}

		// Admin Shortcode
		public function shortcode_admin($output, $obj) {
			
			if('WPBakeryShortCode_VC_Tabs' == get_class($obj) ) {
				
				// Output customizer rules
				foreach ($this->selectors as $key => $value) {
					if( isset($atts[$key]) && '' != $atts[$key]) {
						preg_match("!\{\s*([^\}]+)\s*\}!", $atts[$key], $match);
						if( !empty($match[0]) ) {
							$this->prefix = str_replace(array('{', '}'), '', $match[0]) . ' ';
							$atts[$key] = str_replace( $match[0], "", $atts[$key] );
						}
					}
				}

				$output = str_replace('wpb_tabs wpb_content_element', 'wpb_tabs wpb_content_element ' . str_replace('.', '', $this->prefix), $output);
			}
			
			return $output;
		}

		// Shortcode
		public function shortcode_before($output, $atts, $content) {
			// Extract shortcode attributes
			/*
			extract( shortcode_atts( array(
				'row_width_style' => 'theme_default',
			), $atts) );
			*/
			
			// Output customizer rules
			foreach ($this->selectors as $key => $value) {
				if( isset($atts[$key]) && '' != $atts[$key]) {
					preg_match("!\{\s*([^\}]+)\s*\}!", $atts[$key], $match);
					if( !empty($match[0]) ) {
						$this->prefix = str_replace(array('{', '}'), '', $match[0]) . ' ';
						$atts[$key] = str_replace( $match[0], "", $atts[$key] );
					}
				}
			}

			$output = '';

			if(!is_admin())
				$output = '<div class="ivan-tabs-wrap '.str_replace('.', '', $this->prefix).'">';
			
			return $output;
		}

		// Shortcode
		public function shortcode_after($output, $atts, $content) {
			global $ivan_custom_css;
			// Extract shortcode attributes
			/*
			extract( shortcode_atts( array(
				'row_width_style' => 'theme_default',
			), $atts) );
			*/

			foreach ($this->selectors as $key => $value) {
				if( isset($atts[$key]) && '' != $atts[$key]) {
					preg_match("!\{\s*([^\}]+)\s*\}!", $atts[$key], $match);
					if( !empty($match[0]) ) {
						$this->prefix = str_replace(array('{', '}'), '', $match[0]) . ' ';
						$atts[$key] = str_replace( $match[0], "", $atts[$key] );
					}
				}
			}

			$output = '';

			if(!is_admin())
				$output .= '</div>';

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
				$ivan_custom_css .= $style;
			}

			return $output;
		}

		// H1 Selectors
		public $selectors = array(
			'tabs_css' => array(
				// Font
				'font-family' => '.wpb_tabs_nav a',
				'font-weight' => '.wpb_tabs_nav a',
				'font-size' => '.wpb_tabs_nav a',
				'line-height' => '.wpb_tabs_nav a',
				'text-transform' => '.wpb_tabs_nav a',
				'color' => '.wpb_tabs_nav a',
				// Spacing
				'margin-top' => '.wpb_tabs_nav',
				'margin-right' => '.wpb_tabs_nav li',
				'margin-bottom' => '.wpb_tabs_nav',
				'margin-left' => '.wpb_tabs_nav li',
				'padding-top' => '.wpb_tabs_nav a',
				'padding-right' => '.wpb_tabs_nav a',
				'padding-bottom' => '.wpb_tabs_nav a',
				'padding-left' => '.wpb_tabs_nav a',
				// Bg
				'background-color' => '.wpb_tabs_nav li, .wpb_tabs_nav a',
				// Border Radius
				'border-top-left-radius' => '.wpb_tabs_nav a',
				'border-top-right-radius' => '.wpb_tabs_nav a',
				'border-bottom-left-radius' => '.wpb_tabs_nav a',
				'border-bottom-right-radius' => '.wpb_tabs_nav a',
				// Border
				'border-top-width' => '.wpb_tabs_nav a',
				'border-right-width' => '.wpb_tabs_nav a',
				'border-bottom-width' => '.wpb_tabs_nav a',
				'border-left-width' => '.wpb_tabs_nav a',
				'border-style' => '.wpb_tabs_nav a',
				'border-color' => '.wpb_tabs_nav a',
				// Hovers
				'color-hover' => '.wpb_tabs_nav a:hover, .wpb_tabs_nav li.ui-tabs-active a, .wpb_tabs_nav li.ui-tabs-active',
				'border-color-hover' => '.wpb_tabs_nav a:hover, .wpb_tabs_nav li.ui-tabs-active a',
				'background-color-hover' => '.wpb_tabs_nav a:hover, .wpb_tabs_nav li.ui-tabs-active a',
			),
			'content_css' => array(
				// Font
				//'font-family' => 'p',
				//'font-weight' => 'p',
				//'font-size' => 'h4',
				//'line-height' => 'p',
				//'text-transform' => 'p',
				//'color' => '.wpb_toggle_content h1, .wpb_toggle_content h2, .wpb_toggle_content h3, .wpb_toggle_content h4, .wpb_toggle_content p, .wpb_toggle_content a, .wpb_toggle_content li',
				// Spacing
				'margin-top' => '.wpb_tab',
				'margin-right' => '.wpb_tab',
				'margin-bottom' => '.wpb_tab',
				'margin-left' => '.wpb_tab',
				'padding-top' => '.wpb_tab',
				'padding-right' => '.wpb_tab',
				'padding-bottom' => '.wpb_tab',
				'padding-left' => '.wpb_tab',
				// Bg
				'background-color' => '.wpb_tab',
				// Border Radius
				'border-top-left-radius' => '.wpb_tab',
				'border-top-right-radius' => '.wpb_tab',
				'border-bottom-left-radius' => '.wpb_tab',
				'border-bottom-right-radius' => '.wpb_tab',
				// Border
				'border-top-width' => '.wpb_tab',
				'border-right-width' => '.wpb_tab',
				'border-bottom-width' => '.wpb_tab',
				'border-left-width' => '.wpb_tab',
				'border-style' => '.wpb_tab',
				'border-color' => '.wpb_tab',
				// Hovers
				//'color-hover' => '.wpb_toggle_content a:hover',
				//'border-color-hover' => 'label:hover',
				//'background-color-hover' => 'label:hover',
			),	
		);

		public $prefix = '';

	} // #end class

	// Ignition!
	global $ivan_vc_tabs;
	$ivan_vc_tabs = new Ivan_VC_Tabs();

	if ( !function_exists( 'vc_theme_vc_tabs' ) ) {
		function vc_theme_before_vc_tabs($atts, $content = null) {
			return apply_filters( 'ivan_vc_tabs_shortcode_before', '', $atts, $content );
		}
	}

	if ( !function_exists( 'vc_theme_after_vc_tabs' ) ) {
		function vc_theme_after_vc_tabs($atts, $content = null) {
			return apply_filters( 'ivan_vc_tabs_shortcode_after', '', $atts, $content );
		}
	}

} // #end class check