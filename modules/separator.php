<?php
/***
 * Extension > Separator
 *
 * This is an extension of default VC Component
 *
 **/

if( !class_exists('Ivan_VC_Separator') ) {
	class Ivan_VC_Separator {

		// Contructor
		function __construct() {

			// Apply filter to output custom markup
			add_filter( 'ivan_vc_separator_shortcode_before', array($this, 'shortcode_before'), 10, 3 );
			add_filter( 'ivan_vc_separator_shortcode_after', array($this, 'shortcode_after'), 15, 3 );

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

			$output = '<div class="ivan-separator-wrap '.str_replace('.', '', $this->prefix).'">';
			
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

			$output = '</div>';

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
			'separator_css' => array(
				// Font
				//'font-family' => 'p',
				//'font-weight' => 'p',
				'font-size' => 'h4',
				//'line-height' => 'p',
				//'text-transform' => 'p',
				'color' => 'h4',
				// Spacing
				'margin-top' => '.vc_separator',
				'margin-right' => 'h4',
				'margin-bottom' => '.vc_separator',
				'margin-left' => 'h4',
				'padding-top' => 'h4',
				'padding-right' => 'h4',
				'padding-bottom' => 'h4',
				'padding-left' => 'h4',
				// Bg
				//'background-color' => 'p',
				// Border Radius
				//'border-top-left-radius' => 'p',
				//'border-top-right-radius' => 'p',
				//'border-bottom-left-radius' => 'p',
				//'border-bottom-right-radius' => 'p',
				// Border
				//'border-top-width' => 'p',
				//'border-right-width' => 'p',
				//'border-bottom-width' => 'p',
				//'border-left-width' => 'p',
				//'border-style' => 'p',
				//'border-color' => 'p',
				// Hovers
				//'color-hover' => 'a:hover',
				//'border-color-hover' => 'label:hover',
				//'background-color-hover' => 'label:hover',
			),	
		);

		public $prefix = '';

	} // #end class

	// Ignition!
	global $ivan_vc_separator;
	$ivan_vc_separator = new Ivan_VC_Separator();

	if ( !function_exists( 'vc_theme_before_vc_text_separator' ) ) {
		function vc_theme_before_vc_text_separator($atts, $content = null) {
			return apply_filters( 'ivan_vc_separator_shortcode_before', '', $atts, $content );
		}
	}

	if ( !function_exists( 'vc_theme_after_vc_text_separator' ) ) {
		function vc_theme_after_vc_text_separator($atts, $content = null) {
			return apply_filters( 'ivan_vc_separator_shortcode_after', '', $atts, $content );
		}
	}

} // #end class check