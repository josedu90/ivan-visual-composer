<?php
//Your "container" content element should extend WPBakeryShortCodesContainer class to inherit all required functionality
if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {

	class WPBakeryShortCode_ivan_carousel extends WPBakeryShortCodesContainer {

		protected function content( $atts, $content = null ) {
			// Extract shortcode attributes
			extract( shortcode_atts( array(
				'ivan_columns' => '1',
					'ivan_columns_desktop' => '',
					'ivan_columns_desktop_small' => '',
					'ivan_columns_tablet' => '',
					'ivan_columns_mobile' => '',
				'ivan_carousel_nav' => 'no',
				'ivan_carousel_bullets' => 'yes',
					'ivan_bullets_h' => '',
					'ivan_bullets_v' => '',
				'arrows_hover' => '',
				'mouse_drag' => 'yes',
				'el_class' => '',
			), $atts) );

			//wp_enqueue_script( 'ivan_owl_carousel' );
			//wp_enqueue_style( 'ivan_owl_carousel' );

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

			if('' == $this->prefix) {
				$this->prefix = '.vc_custom_' . rand(25, 15000);
			}
				
			$output = '';

			$class = '';

			if(!is_admin())
				$class = 'owl-carousel';

			$class .= ' ' . $ivan_bullets_h;
			$class .= ' ' . $ivan_bullets_v;

			if('yes' == $arrows_hover)
				$class .= ' arrows-at-hover';

			if(is_admin())
				$output .= '<div class="ivan-carousel-preview preview-'. str_replace('.', '', $this->prefix) .'">Carousel: <a href="#" class="on">On</a><a href="#" class="off">Off</a></div>';

			$output .= '<div class="ivan-carousel '. $el_class . ' ' . str_replace('.', '', $this->prefix) .'"><div class="carousel-wrapper '.$class.'">';

				$output .= do_shortcode($content);

			$output .= '</div></div>';

			$carouselCode = '_this.owlCarousel({';

				// Items configuration
				$carouselCode .= 'items:' . $ivan_columns . ',';
				if($ivan_columns == '1')
					$carouselCode .= 'singleItem: true,';

				if('' != $ivan_columns_desktop)
					$carouselCode .= 'itemsDesktop:[1199,'.$ivan_columns_desktop.'],';

				if('' != $ivan_columns_desktop_small)
					$carouselCode .= 'itemsDesktopSmall:[980,'.$ivan_columns_desktop_small.'],';

				if('' != $ivan_columns_tablet)
					$carouselCode .= 'itemsTablet:[768,'.$ivan_columns_tablet.'],';

				if('' != $ivan_columns_mobile)
					$carouselCode .= 'itemsMobile:[479,'.$ivan_columns_mobile.'],';

				if('no' == $ivan_carousel_bullets)
					$carouselCode .= 'pagination : false,';

				if('yes' == $ivan_carousel_nav) {
				$carouselCode .= 'navigation: true,
					navigationText: [\'<i class="fa fa-angle-left"></i>\', \'<i class="fa fa-angle-right"></i>\'],';
				}

				if('no' == $mouse_drag)
					$carouselCode .= 'mouseDrag : false,';

			$carouselCode .= ' }); var _navH = 0;';

			// Arrows alignment logic
			if('yes' == $ivan_carousel_nav) {

				if('yes' == $ivan_carousel_bullets && '' == $ivan_bullets_v)
					$carouselCode .= '
					_this.find(".owl-controls").each(function() {
						_navH = jQuery(this).outerHeight(true) / 2;
					});
					';

				$carouselCode .= '
					_this.find(".owl-buttons div").each(function(){
						var _h = (jQuery(this).outerHeight() / 2);
						jQuery(this).css("margin-top", "-" + _h + "px" );
					});
				';
			}

			if( !is_admin() ) {
			$output .= '<script type="text/javascript">
				jQuery(document).ready(function() {

					var _this = jQuery("'.$this->prefix.' .carousel-wrapper");

					'.$carouselCode.'

				});
				</script>';
			} else {

				$output .= '
				<script type="text/javascript">
					jQuery(document).ready(function() {

						var _this = jQuery("'.$this->prefix.' .carousel-wrapper");

						';

						$output .= '
						
						// Destroy previous OwlCarousel Markup
						if(_this.find(".owl-wrapper-outer").length > 0) {
							var _originalItems = _this.find(".owl-item > .vc-element");

							_this.html("");

							_this.append(_originalItems);

							if(typeof jQuery.fn.owlCarousel == "function") {
								'.$carouselCode.'
							}
						} else {
							if(_this.children().length > 0 ) {
								
								setTimeout(function(){
									if(typeof jQuery.fn.owlCarousel == "function") {
										'.$carouselCode.'
									}
								}, 2000);

							}
						}';

				$output .= '
						jQuery(".preview-'. str_replace('.', '', $this->prefix) .' .on").click(function(e) {
							if(typeof jQuery.fn.owlCarousel == "function") {
								'.$carouselCode.'
							}
							e.preventDefault();
						});
						
						jQuery(".preview-'. str_replace('.', '', $this->prefix) .' .off").click(function(e) {

							if(_this.data("owlCarousel") != undefined)
								_this.data("owlCarousel").destroy();

							e.preventDefault();
						});

					});
				</script>';
			}

			// Display Custom Styles
			global $ivan_custom_css;
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
			'bullets_css' => array(
				// Font
				//'font-family' => '.ivan-vc-filters a',
				//'font-weight' => '.ivan-vc-filters a',
				//'font-size' => '.ivan-vc-filters a',
				//'line-height' => '.ivan-vc-filters a',
				//'text-transform' => '.ivan-vc-filters a',
				//'color' => '.owl-buttons div',
				// Spacing
				'margin-top' => '.owl-pagination',
				'margin-bottom' => '.owl-pagination',
				'margin-right' => '.owl-controls .owl-page span',
				'margin-left' => '.owl-controls .owl-page span',
				'padding-top' => '.owl-controls .owl-page span',
				'padding-right' => '.owl-controls .owl-page span',
				'padding-bottom' => '.owl-controls .owl-page span',
				'padding-left' => '.owl-controls .owl-page span',
				// Border Radius
				'border-top-left-radius' => '.owl-controls .owl-page span',
				'border-top-right-radius' => '.owl-controls .owl-page span',
				'border-bottom-left-radius' => '.owl-controls .owl-page span',
				'border-bottom-right-radius' => '.owl-controls .owl-page span',
				// Bg
				'background-color' => '.owl-controls .owl-page span',
				// Border
				'border-top-width' => '.owl-controls .owl-page span',
				'border-right-width' => '.owl-controls .owl-page span',
				'border-bottom-width' => '.owl-controls .owl-page span',
				'border-left-width' => '.owl-controls .owl-page span',
				'border-style' => '.owl-controls .owl-page span',
				'border-color' => '.owl-controls .owl-page span',
				// Hovers
				//'color-hover' => '.owl-controls .owl-page span:hover, .owl-controls .owl-page.active span',
				'border-color-hover' => '.owl-controls .owl-page span:hover, .owl-controls .owl-page.active span',
				'background-color-hover' => '.owl-controls .owl-page span:hover, .owl-controls .owl-page.active span',
			),
			'navigation_css' => array(
				// Font
				//'font-family' => '.ivan-vc-filters a',
				//'font-weight' => '.ivan-vc-filters a',
				'font-size' => '.owl-buttons div',
				//'line-height' => '.ivan-vc-filters a',
				//'text-transform' => '.ivan-vc-filters a',
				'color' => '.owl-buttons div',
				// Spacing
				'margin-top' => '.owl-buttons div',
				'padding-top' => '.owl-buttons div',
				'padding-right' => '.owl-buttons div',
				'padding-bottom' => '.owl-buttons div',
				'padding-left' => '.owl-buttons div',
				// Border Radius
				'border-top-left-radius' => '.owl-buttons div',
				'border-top-right-radius' => '.owl-buttons div',
				'border-bottom-left-radius' => '.owl-buttons div',
				'border-bottom-right-radius' => '.owl-buttons div',
				// Bg
				'background-color' => '.owl-buttons div',
				// Border
				'border-top-width' => '.owl-buttons div',
				'border-right-width' => '.owl-buttons div',
				'border-bottom-width' => '.owl-buttons div',
				'border-left-width' => '.owl-buttons div',
				'border-style' => '.owl-buttons div',
				'border-color' => '.owl-buttons div',
				// Hovers
				'color-hover' => '.owl-buttons div:hover',
				'border-color-hover' => '.owl-buttons div:hover',
				'background-color-hover' => '.owl-buttons div:hover',
			),
		);

		public $prefix = '';

	} // end class

	global $ivan_vc_carousel;
	$ivan_vc_carousel = new WPBakeryShortCode_ivan_carousel( array('name' => 'Content Carousel', 'base' => 'ivan_carousel') );
}