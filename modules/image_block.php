<?php
/***
 * Module > Image Block
 *
 * This module extends default VC class, turning easy extend it with custom functions!
 *
 **/

if(class_exists('WPBakeryShortCode')) {

	class WPBakeryShortCode_ivan_image_block extends WPBakeryShortCode {

		// Shortcode
		protected function content( $atts, $content = null ) {
			global $ivan_custom_css;
			// Extract shortcode attributes
			extract( shortcode_atts( array(
				'ivan_cover' => '',
				'ivan_cover_hover' => '',
				'ivan_img_size' => 'large',
				'ivan_custom_height' => '',
				'ivan_enable_cover' => 'yes',
					'ivan_cover_link' => '',
					'ivan_cover_title' => '',
					'ivan_cover_excerpt' => '',
					'ivan_cover_read_more' => 'Read More',
				'ivan_bg_img' => '',
				'ivan_img_size' => 'large',
				'el_class' => '',
			), $atts) );
			
			$output = '';

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

			$colNumber = 1;
			$columns = 12 / $colNumber; // 12 Bootstrap Columns / number of columns

			$containerClass = 'ivan-projects ivan-image-block';
			$containerClass .= ' row';

			// If prefix is not defined
			if('' == $this->prefix) {
				$this->prefix = 'vc_custom_' . rand(25, 15000);
			}

			$output .= '<div class="ivan-projects-main-wrapper ivan-block-image-main-wrapper '. $el_class .' ' . str_replace('.', '', $this->prefix) . '">';

			$additionalClass = '';
			$additionalClass .= ' cover-entry';
				$additionalClass .= $ivan_cover_hover;

			wp_enqueue_style('ivan_vc_projects');
			wp_enqueue_script('ivan_vc_projects');

			$output .= '<div class="'.$containerClass.'">';

			ob_start();
				
			?>
				<div class="col-xs-12 col-sm-12 col-md-12 ivan-project ivan-image-block taphover <?php echo $additionalClass; ?>">

					<div class="ivan-project-inner">

						<?php
						// Custom Thumbnail Height
						$_customCSS = '';
						$_thumbClass = '';
						if( $ivan_custom_height != '') {
							$_customCSS = 'height:' . str_replace('px', '', $ivan_custom_height) . 'px;';
						}

						if($ivan_bg_img == false) {
							$_thumbClass = ' no-thumb';
						}

						?>

						<?php 
						if($ivan_bg_img != '') {
							$url = wp_get_attachment_image_src($ivan_bg_img, $ivan_img_size);

							$_customCSS .= 'background-image: url('.$url['0'].');';
						} 
						?>
						<div class="thumbnail<?php echo $_thumbClass; ?>" style="<?php echo $_customCSS; ?>"></div>

						<?php if('yes' == $ivan_enable_cover) : ?>
						<div class="entry">
							<div class="entry-inner">
								<div class="centered">

									<?php if('' != $ivan_cover_title) : ?>
									<h3>
										<?php if('' != $ivan_cover_link) : ?>
											<a href="<?php echo $ivan_cover_link; ?>">
										<?php endif; ?>
										
										<?php echo $ivan_cover_title; ?>
										
										<?php if('' != $ivan_cover_link) : ?>
											</a>
										<?php endif; ?>
									</h3>
									<?php endif; ?>

									<?php if('' != $ivan_cover_excerpt) : ?>
									<div class="excerpt"><?php echo $ivan_cover_excerpt; ?></div>
									<?php endif; ?>

									<?php if('' != $ivan_cover_link && '' != $ivan_cover_read_more) : ?>
									<div class="read-more">
										<a href="<?php echo $ivan_cover_link; ?>" class="button"><?php echo $ivan_cover_read_more; ?></a>
									</div>
									<?php endif; ?>

								</div>
							</div>
						</div>
						<?php endif; ?>
					</div>

					<div></div>
				</div>

				<?php
				$output .= ob_get_clean();

			$output .= '</div>';// #row
			$output .= '</div>';// #main-wrapper

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
			'block_css' => array(
				// Font
				//'font-family' => 'h1',
				//'font-weight' => 'h1',
				//'font-size' => 'h1',
				//'line-height' => 'h1',
				//'color' => 'h1',
				// Spacing
				'margin-top' => '.ivan-image-block',
				'margin-right' => '.ivan-image-block',
				'margin-bottom' => '.ivan-image-block',
				'margin-left' => '.ivan-image-block',
				'padding-top' => '.ivan-image-block',
				//'padding-right' => '.ivan-project .entry-inner',
				//'padding-bottom' => '.ivan-project .entry-inner',
				//'padding-left' => '.ivan-project .entry-inner',
				// Bg
				//'background-color' => '.ivan-project .entry',
				// Border
				//'border-top-width' => '.thumbnail',
				//'border-right-width' => '.thumbnail',
				//'border-bottom-width' => '.thumbnail',
				//'border-left-width' => '.thumbnail',
				//'border-style' => '.thumbnail',
				//'border-color' => '.thumbnail',
				// Border Radius
				//'border-top-left-radius' => '.thumbnail, img',
				//'border-top-right-radius' => '.thumbnail, img',
				//'border-bottom-left-radius' => '.thumbnail, img',
				//'border-bottom-right-radius' => '.thumbnail, img',
				// Hovers
				//'color-hover' => 'a:hover',
				//'border-color-hover' => 'a:hover',
				//'background-color-hover' => 'a:hover',
			),
			'thumb_css' => array(
				// Font
				//'font-family' => 'h1',
				//'font-weight' => 'h1',
				//'font-size' => 'h1',
				//'line-height' => 'h1',
				//'color' => 'h1',
				// Spacing
				//'margin-top' => '.ivan-project .entry',
				//'margin-right' => '.ivan-project .entry',
				//'margin-bottom' => '.ivan-project .entry',
				//'margin-left' => '.ivan-project .entry',
				//'padding-top' => '.ivan-project .entry-inner',
				//'padding-right' => '.ivan-project .entry-inner',
				//'padding-bottom' => '.ivan-project .entry-inner',
				//'padding-left' => '.ivan-project .entry-inner',
				// Bg
				//'background-color' => '.ivan-project .entry',
				// Border
				'border-top-width' => '.thumbnail',
				'border-right-width' => '.thumbnail',
				'border-bottom-width' => '.thumbnail',
				'border-left-width' => '.thumbnail',
				'border-style' => '.thumbnail',
				'border-color' => '.thumbnail',
				// Border Radius
				'border-top-left-radius' => '.thumbnail, img',
				'border-top-right-radius' => '.thumbnail, img',
				'border-bottom-left-radius' => '.thumbnail, img',
				'border-bottom-right-radius' => '.thumbnail, img',
				// Hovers
				//'color-hover' => 'a:hover',
				//'border-color-hover' => 'a:hover',
				//'background-color-hover' => 'a:hover',
			),
			'entry_css' => array(
				// Font
				//'font-family' => 'h1',
				//'font-weight' => 'h1',
				//'font-size' => 'h1',
				//'line-height' => 'h1',
				//'color' => 'h1',
				// Spacing
				'margin-top' => '.ivan-project .entry',
				'margin-right' => '.ivan-project .entry',
				'margin-bottom' => '.ivan-project .entry',
				'margin-left' => '.ivan-project .entry',
				'padding-top' => '.ivan-project .entry-inner',
				'padding-right' => '.ivan-project .entry-inner',
				'padding-bottom' => '.ivan-project .entry-inner',
				'padding-left' => '.ivan-project .entry-inner',
				// Bg
				'background-color' => '.ivan-project .entry',
				// Border
				'border-top-width' => '.ivan-project .entry',
				'border-right-width' => '.ivan-project .entry',
				'border-bottom-width' => '.ivan-project .entry',
				'border-left-width' => '.ivan-project .entry',
				'border-style' => '.ivan-project .entry',
				'border-color' => '.ivan-project .entry',
				// Border Radius
				'border-top-left-radius' => '.ivan-project .entry',
				'border-top-right-radius' => '.ivan-project .entry',
				'border-bottom-left-radius' => '.ivan-project .entry',
				'border-bottom-right-radius' => '.ivan-project .entry',
				// Hovers
				//'color-hover' => 'a:hover',
				//'border-color-hover' => 'a:hover',
				//'background-color-hover' => 'a:hover',
			),
			'title_css' => array(
				// Font
				'font-family' => '.entry h3',
				'font-weight' => '.entry h3',
				'font-size' => '.entry h3',
				'line-height' => '.entry h3',
				'text-transform' => '.entry h3',
				'color' => '.entry h3, .entry h3 a',
				// Spacing
				//'margin-top' => '.ivan-project .entry',
				//'margin-right' => '.ivan-project .entry',
				//'margin-bottom' => '.ivan-project .entry',
				//'margin-left' => '.ivan-project .entry',
				//'padding-top' => '.ivan-project .entry',
				//'padding-right' => '.ivan-project .entry',
				//'padding-bottom' => '.ivan-project .entry',
				//'padding-left' => '.ivan-project .entry',
				// Bg
				//'background-color' => '.ivan-project .entry',
				// Border
				//'border-top-width' => 'h1',
				//'border-right-width' => 'h1',
				//'border-bottom-width' => 'h1',
				//'border-left-width' => 'h1',
				//'border-style' => 'h1',
				//'border-color' => 'h1',
				// Hovers
				'color-hover' => '.entry h3 a:hover',
				//'border-color-hover' => 'a:hover',
				//'background-color-hover' => 'a:hover',
			),
			'excerpt_css' => array(
				// Font
				'font-family' => '.entry .excerpt',
				'font-weight' => '.entry .excerpt',
				'font-size' => '.entry .excerpt',
				'line-height' => '.entry .excerpt',
				'text-transform' => '.entry .excerpt',
				'color' => '.entry .excerpt',
				// Spacing
				//'margin-top' => '.ivan-project .entry',
				//'margin-right' => '.ivan-project .entry',
				//'margin-bottom' => '.ivan-project .entry',
				//'margin-left' => '.ivan-project .entry',
				//'padding-top' => '.ivan-project .entry',
				//'padding-right' => '.ivan-project .entry',
				//'padding-bottom' => '.ivan-project .entry',
				//'padding-left' => '.ivan-project .entry',
				// Bg
				//'background-color' => '.ivan-project .entry',
				// Border
				//'border-top-width' => 'h1',
				//'border-right-width' => 'h1',
				//'border-bottom-width' => 'h1',
				//'border-left-width' => 'h1',
				//'border-style' => 'h1',
				//'border-color' => 'h1',
				// Hovers
				//'color-hover' => '.entry h3 a:hover',
				//'border-color-hover' => 'a:hover',
				//'background-color-hover' => 'a:hover',
			),
			'read_more_css' => array(
				// Font
				'font-family' => '.read-more a',
				'font-weight' => '.read-more a',
				'font-size' => '.read-more a',
				'line-height' => '.read-more a',
				'text-transform' => '.read-more a',
				'color' => '.read-more a',
				// Spacing
				//'margin-top' => '.ivan-project .entry',
				//'margin-right' => '.ivan-project .entry',
				//'margin-bottom' => '.ivan-project .entry',
				//'margin-left' => '.ivan-project .entry',
				'padding-top' => '.read-more a',
				'padding-right' => '.read-more a',
				'padding-bottom' => '.read-more a',
				'padding-left' => '.read-more a',
				// Bg
				'background-color' => '.read-more a',
				// Border Radius
				'border-top-left-radius' => '.read-more a',
				'border-top-right-radius' => '.read-more a',
				'border-bottom-left-radius' => '.read-more a',
				'border-bottom-right-radius' => '.read-more a',
				// Border
				'border-top-width' => '.read-more a',
				'border-right-width' => '.read-more a',
				'border-bottom-width' => '.read-more a',
				'border-left-width' => '.read-more a',
				'border-style' => '.read-more a',
				'border-color' => '.read-more a',
				// Hovers
				'color-hover' => '.read-more a:hover',
				'border-color-hover' => '.read-more a:hover',
				'background-color-hover' => '.read-more a:hover',
			),
		);

		public $prefix = '';

	} // #end class

	// Init global var to store this module data
	global $ivan_vc_image_block;
	$ivan_vc_image_block = new WPBakeryShortCode_ivan_image_block( array('name' => 'Image Block', 'base' => 'ivan_image_block') );


 } // #end class check