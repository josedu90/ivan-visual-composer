<?php
/***
 * Module > Posts
 *
 * This module extends default VC class, turning easy extend it with custom functions!
 *
 **/

if(class_exists('WPBakeryShortCode')) {
	class WPBakeryShortCode_ivan_posts extends WPBakeryShortCode {

		// Shortcode
		protected function content( $atts, $content = null ) {
			global $ivan_custom_css;
			// Extract shortcode attributes
			extract( shortcode_atts( array(
				'loop' => '',
				'ivan_columns' => '4',
				'ivan_type' => 'mansory',
				'ivan_margin' => '',
				'ivan_opacity' => '',
				'ivan_zoom' => '',
				'ivan_grayscale' => '',
				'ivan_cover' => '',
				'ivan_cover_hover' => '',
				'ivan_img_size' => 'large',
				'ivan_custom_height' => '',
				'ivan_enable_thumb' => 'yes',
				'ivan_enable_cover' => 'yes',
					'ivan_enable_title' => 'yes',
					'ivan_enable_categories' => 'yes',
					'ivan_enable_excerpt' => '',
					'ivan_enable_read_more' => '',
					'ivan_enable_read_more_txt' => 'READ MORE',
				'ivan_carousel_nav' => 'yes',
				'ivan_carousel_bullets' => 'yes',
				'ivan_enable_sizes' => 'no',
				'el_class' => '',
			), $atts) );

			if(empty($loop)) return;
			
			$output = '';

			$loop_args = array();
			$query = false;
			list($loop_args, $query)  = vc_build_loop_query($loop, get_the_ID());

			//$output .= '<div>'.var_export($loop_args, true).'</div>';

			if(!$query)
				return;

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

			$ivan_query = $query;

			$colNumber = $ivan_columns;
			$columns = 12 / $colNumber; // 12 Bootstrap Columns / number of columns

			// Container
			$type = $ivan_type;

			$containerClass = 'ivan-projects ivan-posts ivan-projects-' . $type;
			$containerClass .= ' row';
			$containerClass .= $ivan_margin;

			// If prefix is not defined
			if('' == $this->prefix) {
				$this->prefix = 'vc_custom_' . rand(25, 15000);
			}
			$output .= '<div class="ivan-projects-main-wrapper ivan-posts-main-wrapper ' . str_replace('.', '', $this->prefix) . '">';


			$additionalClass = '';
			$additionalClass .= $ivan_opacity;
			$additionalClass .= $ivan_zoom;
			$additionalClass .= $ivan_cover;
				$additionalClass .= $ivan_cover_hover;

			if('yes' == $ivan_grayscale)
				$additionalClass .= ' gray-enabled';

			if( $ivan_query->have_posts() ) :

			if( 'carousel' == $type ) {
				wp_enqueue_script( 'ivan_owl_carousel' );
				wp_enqueue_style( 'ivan_owl_carousel' );

				$columns = 12;
			}

			wp_enqueue_style('ivan_vc_projects');
			wp_enqueue_script('ivan_vc_projects');

			$output .= '<div class="'.$containerClass.'">';

			$output .= '<div class="gutter-sizer"></div>';

			// Carousel Markup
			if( 'carousel' == $type ) {
				$output .= '<div class="owl-carousel">';
			}

				ob_start();
				while( $ivan_query->have_posts() ) : $ivan_query->the_post();

					$singleColumn = $columns;
					$singleTags = '';

					// If mansory, apply custom tags to change size
					if('mansory' == $type && 'yes' == $ivan_enable_sizes) {
						$_tags = get_the_tags( get_the_ID() );
						if($_tags) {
							foreach ($_tags as $_tag) {
								if($_tag->name == 'double') {
									if($singleColumn == 4) // 3 Cols
										$singleColumn = 8;
									else if($singleColumn == 3) // 4 Cols
										$singleColumn = 6;
									else if($singleColumn == 6) // 2 Cols
										$singleColumn = 12;

									$singleTags .= ' double-size';
								}
								else if($_tag->name == 'full') {
									$singleColumn = 12;
									$singleTags .= 'full-size';
								}
								else if($_tag->name == 'half-height') {
									$singleTags .= ' half-height';
								}
							}
						}
					}
				
				?>

				<div class="col-xs-12 col-sm-<?php echo $singleColumn; ?> col-md-<?php echo $singleColumn; ?> taphover ivan-project <?php echo $singleTags; ?> <?php echo $additionalClass; ?>">

					<div class="ivan-project-inner">

						<?php
						// Custom Thumbnail Height
						$_customHeight = '';
						$_thumbClass = '';
						if( $ivan_custom_height != '') {
							$_customHeight = 'height:' . str_replace('px', '', $ivan_custom_height) . 'px;';
						}

						if(has_post_thumbnail() == false) {
							$_thumbClass = ' no-thumb';
						}

						?>

						<?php if('yes' == $ivan_enable_thumb) : ?>
							<a href="<?php the_permalink(); ?>" class="thumbnail<?php echo $_thumbClass; ?>" style="<?php echo $_customHeight; ?>">
								<span class="ivan-hover-fx"></span>
								<?php echo get_the_post_thumbnail( get_the_ID(), $ivan_img_size ); ?>
							</a>
						<?php endif; ?>

						<?php if('yes' == $ivan_enable_cover) : ?>
						<div class="entry">
							<div class="entry-inner">
								<div class="centered">

									<?php if('yes' == $ivan_enable_title) : ?>
									<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
									<?php endif; ?>

									<?php if('yes' == $ivan_enable_categories) : ?>
										<div class="categories">
											<span class="date"><?php echo get_the_date(); ?></span>
										</div>
									<?php endif; ?>

									<?php if('yes' == $ivan_enable_excerpt) : ?>
									<div class="excerpt"><?php the_excerpt(); ?></div>
									<?php endif; ?>

									<?php if('yes' == $ivan_enable_read_more) : ?>
									<div class="read-more">
										<a href="<?php the_permalink(); ?>" class="button"><?php echo $ivan_enable_read_more_txt; ?></a>
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
				endwhile;
				$output .= ob_get_clean();

				if( 'carousel' == $type ) {
					$output .= '</div>';
				}
			$output .= '</div>';// #row
			$output .= '</div>';// #main-wrapper

			$output .= '<script type="text/javascript">
				jQuery(document).ready( function() {
					';

			if( is_admin() ) {
				$output .= '
				ivan_vc_hide_entry();
				ivan_vc_init_mansory();

				if(typeof jQuery.fn.owlCarousel == "function") {';
			}

			if( 'carousel' == $type ) {

				$_prefix = str_replace('.', '', $this->prefix);

				$carouselCode = '
				_carousel.owlCarousel({
					items: '. $colNumber .',
					itemsDesktop:[1199,'. $colNumber .'],
					autoHeight: true';

				if($ivan_columns == '1')
					$carouselCode .= ',singleItem: true';

				if('yes' == $ivan_carousel_nav) {
				$carouselCode .= ',navigation: true,
					navigationText: [\'<i class="fa fa-angle-left"></i>\', \'<i class="fa fa-angle-right"></i>\']';
				}

				if('yes' == $ivan_carousel_bullets) {
				$carouselCode .= ',pagination: true';
				}
				else {
					$carouselCode .= ',pagination: false';
				}

				$carouselCode .= '});';			

				$output .= '
					var _carousel = jQuery(".'.$_prefix.' .owl-carousel");
					var _navH = 0;
				';

				$output .= $carouselCode;

				if('yes' == $ivan_carousel_nav) {

					if('yes' == $ivan_carousel_bullets)
						$output .= '
						_carousel.find(".owl-controls").each(function() {
							_navH = jQuery(this).outerHeight(true) / 2;
						});
						';

					$output .= '
						_carousel.find(".owl-buttons div").each(function(){
							var _h = (jQuery(this).outerHeight() / 2) + _navH;
							jQuery(this).css("margin-top", "-" + _h + "px" );
						});
					';
				}

			}

			if(is_admin()) {
				$output .= '} /* Ends owlCarousel function check... */';
			}

			$output .= '});</script>';		

			wp_reset_query();

			endif;// #end main query

			
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
				'color' => '.entry h3 a',
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
			'cats_css' => array(
				// Font
				'font-family' => '.entry .categories',
				'font-weight' => '.entry .categories',
				'font-size' => '.entry .categories',
				'line-height' => '.entry .categories',
				'text-transform' => '.entry .categories',
				'color' => '.entry .categories',
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

	} // #end class

	// Init global var to store this module data
	global $ivan_vc_posts;
	$ivan_vc_posts = new WPBakeryShortCode_ivan_posts( array('name' => 'Posts', 'base' => 'ivan_posts') );

 } // #end class check