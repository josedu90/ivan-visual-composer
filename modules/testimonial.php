<?php
/***
 * Module > Testimonial
 *
 * This module extends default VC class, turning easy extend it with custom functions!
 *
 **/

if(class_exists('WPBakeryShortCode')) {

	// Class
	class WPBakeryShortCode_ivan_testimonial extends WPBakeryShortCode {

		protected function content( $atts, $content = null ) {
			global $ivan_custom_css;
			// Extract  atts and setup initial vars
			extract( shortcode_atts( array(
				'align' => '',
				'meta_align' => '',
				'author' => '',
				'image_id' => '',
				'image_position' => '',
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

			// Main Classes
			if('left' == $image_position)
				$classes .= ' img-at-left';
			else if('right' == $image_position)
				$classes .= ' img-at-right';

			// Testimonial
			$testimonial_classes = $align;

			// Meta
			$meta_classes = $meta_align;

			// Add custom classes provided by users
			if('' != $el_class)
				$classes .= ' ' . $el_class;

			// Output Form
			ob_start();
			?>
			<div class="ivan-testimonial-main <?php echo str_replace('.', '', $this->prefix); ?>">
				<div class="ivan-testimonial <?php echo $classes; ?>">

					<?php if('' != $image_id && 'left' == $image_position) : ?>
						<div class="img-wrap">
							<?php
							$url = wp_get_attachment_image_src($image_id, 'full');
							echo '<img src="'. $url['0'].'" alt="">';
							?>
						</div>
					<?php endif; ?>

					<div class="main-wrap">
						<div class="testimonial-content <?php echo $testimonial_classes; ?>">
							<?php echo do_shortcode($content); ?>
						</div>

						<?php if('' != $author) : ?>
							<div class="testimonial-meta <?php echo $meta_classes; ?>">
								<div class="meta-inner">
									<?php if('' != $image_id && ('default' == $image_position OR '' == $image_position) ) :
										$url = wp_get_attachment_image_src($image_id, 'full');
										echo '<img src="'. $url['0'].'" alt="">';
									endif; ?>
									<?php echo $author; ?>
								</div>
							</div>
						<?php endif; ?>
					</div>

					<?php if('' != $image_id && 'right' == $image_position) : ?>
						<div class="img-wrap">
							<?php
							$url = wp_get_attachment_image_src($image_id, 'full');
							echo '<img src="'. $url['0'].'" alt="">';
							?>
						</div>
					<?php endif; ?>

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
			'main_css' => array(
				// Font
				//'font-family' => 'h2',
				//'font-weight' => 'h2',
				//'font-size' => 'h2',
				//'line-height' => 'h2',
				//'text-transform' => 'h2',
				//'color' => 'h2',
				// Spacing
				'margin-top' => '.ivan-testimonial',
				'margin-right' => '.ivan-testimonial',
				'margin-bottom' => '.ivan-testimonial',
				'margin-left' => '.ivan-testimonial',
				'padding-top' => '.ivan-testimonial',
				'padding-right' => '.ivan-testimonial',
				'padding-bottom' => '.ivan-testimonial',
				'padding-left' => '.ivan-testimonial',
				// Bg
				'background-color' => '.ivan-testimonial',
				// Border Radius
				'border-top-left-radius' => '.ivan-testimonial',
				'border-top-right-radius' => '.ivan-testimonial',
				'border-bottom-left-radius' => '.ivan-testimonial',
				'border-bottom-right-radius' => '.ivan-testimonial',
				// Border
				'border-top-width' => '.ivan-testimonial',
				'border-right-width' => '.ivan-testimonial',
				'border-bottom-width' => '.ivan-testimonial',
				'border-left-width' => '.ivan-testimonial',
				'border-style' => '.ivan-testimonial',
				'border-color' => '.ivan-testimonial',
				// Hovers
				//'color-hover' => 'label:hover',
				//'border-color-hover' => 'label:hover',
				//'background-color-hover' => 'label:hover',
			),
			'quote_css' => array(
				// Font
				'font-family' => '.testimonial-content',
				'font-weight' => '.testimonial-content',
				'font-size' => '.testimonial-content',
				'line-height' => '.testimonial-content',
				'text-transform' => '.testimonial-content',
				'color' => '.testimonial-content',
				// Spacing
				'margin-top' => '.testimonial-content',
				'margin-right' => '.testimonial-content',
				'margin-bottom' => '.testimonial-content',
				'margin-left' => '.testimonial-content',
				//'padding-top' => '.ivan-testimonial',
				//'padding-right' => '.ivan-testimonial',
				//'padding-bottom' => '.ivan-testimonial',
				//'padding-left' => '.ivan-testimonial',
				// Bg
				//'background-color' => '.ivan-testimonial',
				// Border Radius
				//'border-top-left-radius' => '.ivan-testimonial',
				//'border-top-right-radius' => '.ivan-testimonial',
				//'border-bottom-left-radius' => '.ivan-testimonial',
				//'border-bottom-right-radius' => '.ivan-testimonial',
				// Border
				//'border-top-width' => '.ivan-testimonial',
				//'border-right-width' => '.ivan-testimonial',
				//'border-bottom-width' => '.ivan-testimonial',
				//'border-left-width' => '.ivan-testimonial',
				//'border-style' => '.ivan-testimonial',
				//'border-color' => '.ivan-testimonial',
				// Hovers
				//'color-hover' => 'label:hover',
				//'border-color-hover' => 'label:hover',
				//'background-color-hover' => 'label:hover',
			),
			'meta_css' => array(
				// Font
				'font-family' => '.testimonial-meta',
				'font-weight' => '.testimonial-meta',
				'font-size' => '.testimonial-meta',
				'line-height' => '.testimonial-meta',
				'text-transform' => '.testimonial-meta',
				'color' => '.testimonial-meta',
				// Spacing
				'margin-top' => '.testimonial-meta',
				'margin-right' => '.testimonial-meta',
				'margin-bottom' => '.testimonial-meta',
				'margin-left' => '.testimonial-meta',
				//'padding-top' => '.ivan-testimonial',
				//'padding-right' => '.ivan-testimonial',
				//'padding-bottom' => '.ivan-testimonial',
				//'padding-left' => '.ivan-testimonial',
				// Bg
				//'background-color' => '.ivan-testimonial',
				// Border Radius
				//'border-top-left-radius' => '.ivan-testimonial',
				//'border-top-right-radius' => '.ivan-testimonial',
				//'border-bottom-left-radius' => '.ivan-testimonial',
				//'border-bottom-right-radius' => '.ivan-testimonial',
				// Border
				//'border-top-width' => '.ivan-testimonial',
				//'border-right-width' => '.ivan-testimonial',
				//'border-bottom-width' => '.ivan-testimonial',
				//'border-left-width' => '.ivan-testimonial',
				//'border-style' => '.ivan-testimonial',
				//'border-color' => '.ivan-testimonial',
				// Hovers
				//'color-hover' => 'label:hover',
				//'border-color-hover' => 'label:hover',
				//'background-color-hover' => 'label:hover',
			),
			'img_css' => array(
				// Font
				//'font-family' => '.testimonial-meta',
				//'font-weight' => '.testimonial-meta',
				//'font-size' => '.testimonial-meta',
				//'line-height' => '.testimonial-meta',
				//'text-transform' => '.testimonial-meta',
				//'color' => '.testimonial-meta',
				// Spacing
				//'margin-top' => '.testimonial-meta',
				//'margin-right' => '.testimonial-meta',
				//'margin-bottom' => '.testimonial-meta',
				//'margin-left' => '.testimonial-meta',
				//'padding-top' => '.ivan-testimonial',
				//'padding-right' => '.ivan-testimonial',
				//'padding-bottom' => '.ivan-testimonial',
				//'padding-left' => '.ivan-testimonial',
				// Bg
				//'background-color' => '.ivan-testimonial',
				// Border Radius
				'border-top-left-radius' => 'img',
				'border-top-right-radius' => 'img',
				'border-bottom-left-radius' => 'img',
				'border-bottom-right-radius' => 'img',
				// Border
				'border-top-width' => 'img',
				'border-right-width' => 'img',
				'border-bottom-width' => 'img',
				'border-left-width' => 'img',
				'border-style' => 'img',
				'border-color' => 'img',
				// Hovers
				//'color-hover' => 'label:hover',
				//'border-color-hover' => 'label:hover',
				//'background-color-hover' => 'label:hover',
			),
						
		);

		public $prefix = '';
	}// #class end

	// Init global var to store this module data
	global $ivan_vc_testimonial;
	$ivan_vc_testimonial = new WPBakeryShortCode_ivan_testimonial( array('name' => 'Testimonial', 'base' => 'ivan_testimonial') );

} // #end class check