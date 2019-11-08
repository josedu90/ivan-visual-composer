<?php
/***
 * Module > Tweet
 *
 * This module extends default VC class, turning easy extend it with custom functions!
 *
 **/

if(class_exists('WPBakeryShortCode')) {

	// Class
	class WPBakeryShortCode_ivan_tweet extends WPBakeryShortCode {

		function ivan_only_one_tweet($args) {

			$args['count'] = "1";

			return $args;
		}

		protected function content( $atts, $content = null ) {
			global $ivan_custom_css;
			// Extract  atts and setup initial vars
			extract( shortcode_atts( array(
				'el_class' => '',
			), $atts) );

			$output = '';
			$classes = '';

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

			// Add custom classes provided by users
			if('' != $el_class)
				$classes .= ' ' . $el_class;

			// Output Form
			ob_start();
			?>
			<div class="ivan-tweet-wrap <?php echo str_replace('.', '', $this->prefix); ?>">
				<div class="ivan-tweet <?php echo $classes; ?>">
					<?php if ( function_exists( "display_tweets" ) ) {
						add_filter('displaytweets_args', array($this, 'ivan_only_one_tweet'));
						display_tweets(); 
						remove_filter('displaytweets_args', array($this, 'ivan_only_one_tweet'));
					} ?>
				</div>
			</div>
			<?php
			$output .= ob_get_clean();

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
			'tweet_css' => array(
				// Font
				'font-family' => 'p',
				'font-weight' => 'p',
				'font-size' => 'p',
				'line-height' => 'p',
				'text-transform' => 'p',
				'color' => 'p, a',
				// Spacing
				'margin-top' => 'p',
				'margin-right' => 'p',
				'margin-bottom' => 'p',
				'margin-left' => 'p',
				//'padding-top' => 'p',
				//'padding-right' => 'p',
				//'padding-bottom' => 'p',
				//'padding-left' => 'p',
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
				'color-hover' => 'a:hover',
				//'border-color-hover' => 'label:hover',
				//'background-color-hover' => 'label:hover',
			),
			'meta_css' => array(
				// Font
				'font-family' => 'small',
				'font-weight' => 'small',
				'font-size' => 'small',
				'line-height' => 'small',
				'text-transform' => 'small',
				'color' => 'small',
				// Spacing
				'margin-top' => 'small',
				'margin-right' => 'small',
				'margin-bottom' => 'small',
				'margin-left' => 'small',
				//'padding-top' => 'p',
				//'padding-right' => 'p',
				//'padding-bottom' => 'p',
				//'padding-left' => 'p',
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

	}// #class end

	// Init global var to store this module data
	global $ivan_vc_tweet;
	$ivan_vc_tweet = new WPBakeryShortCode_ivan_tweet( array('name' => 'Tweet', 'base' => 'ivan_tweet') );

} // #end class check