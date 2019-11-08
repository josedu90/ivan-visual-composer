<?php
/***
 * Module > Projects
 *
 * This module extends default VC class, turning easy extend it with custom functions!
 *
 **/

if(class_exists('WPBakeryShortCode')) {
	class WPBakeryShortCode_ivan_projects extends WPBakeryShortCode {

		// Shortcode
		protected function content( $atts, $content = null ) {
			global $ivan_custom_css;
			// Extract shortcode attributes
			extract( shortcode_atts( array(
				'ivan_columns' => '4',
				'ivan_type' => 'mansory',
				'ivan_margin' => '',
				'ivan_opacity' => '',
				'ivan_zoom' => '',
				'ivan_cover' => '',
				'ivan_grayscale' => '',
				'ivan_cover_hover' => '',
				'ivan_posts_per_page' => 10,
				'ivan_img_size' => 'large',
				'ivan_custom_height' => '',
				'ivan_sortable_filters' => '',
				'ivan_enable_cover' => 'yes',
					'ivan_enable_title' => 'yes',
					'ivan_enable_categories' => 'yes',
					'ivan_enable_excerpt' => '',
					'ivan_enable_read_more' => '',
					'ivan_enable_read_more_txt' => 'READ MORE',
				'ivan_category' => '',
				'ivan_portfolio' => '',
				'ivan_carousel_nav' => 'yes',
				'ivan_carousel_bullets' => 'yes',
				'ivan_enable_sizes' => 'no',
				'ivan_open' => '',
				'ico_family' => 'fa fa-',
				'ico' => '',
				'ico_custom' => '',
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

			// Args
			$args = array(
				'post_type' => 'ivan_vc_projects',
				'posts_per_page' => $ivan_posts_per_page,
				'post_status' => 'publish',
			);

			if('' != $ivan_category) {
				$args['ivan_vc_projects_cats'] = $ivan_category;
			}

			if('' != $ivan_portfolio) {
				$args['ivan_vc_projects_portfolios'] = $ivan_portfolio;
			}

			$ivan_query = new WP_Query( $args );

			$colNumber = $ivan_columns;
			$columns = 12 / $colNumber; // 12 Bootstrap Columns / number of columns

			// Container
			$type = $ivan_type;

			$containerClass = 'ivan-projects ivan-projects-' . $type;
			$containerClass .= ' row';
			$containerClass .= $ivan_margin;

			// If prefix is not defined
			if('' == $this->prefix) {
				$this->prefix = 'vc_custom_' . rand(25, 15000);
			}
			$output .= '<div class="ivan-projects-main-wrapper '. $el_class .' ' . str_replace('.', '', $this->prefix) . '">';


			$additionalClass = '';
			$additionalClass .= $ivan_opacity;
			$additionalClass .= $ivan_zoom;
			$additionalClass .= $ivan_cover;
				$additionalClass .= $ivan_cover_hover;

			if('yes' == $ivan_grayscale)
				$additionalClass .= ' gray-enabled';

			// Icon Logic
			if(' cover-entry' == $ivan_cover && ('' != $ico || '' != $ico_custom) ) {
				$icon_markup = '<i class="'.$ico_family.$ico.'"></i>';
					
				if('' != $ico_custom)
					$icon_markup = '<i class="'.$ico_custom.'"></i>';
			}

			if( $ivan_query->have_posts() ) :

			if( 'carousel' == $type ) {
				wp_enqueue_script( 'ivan_owl_carousel' );
				wp_enqueue_style( 'ivan_owl_carousel' );

				$columns = 12;
			}

			wp_enqueue_script('ivan_vc_projects');

			// Sortable
			$enableSortable = $ivan_sortable_filters;

			if('yes' == $enableSortable && 'carousel' != $type) {
				$filters = get_terms("ivan_vc_projects_cats");

				if( 0 < count($filters) ) {
					$output .= '<div class="ivan-vc-filters-wrapper"><div class="ivan-vc-filters">';

					foreach ($filters as $filter) {
						$filterName = strtolower($filter->name);
						$filterName = str_replace(' ', '-', $filterName);

						$output .= '<a href="#" data-filter="'.$filterName.'">'. $filter->name . '</a>';
					}

					$output .= '</div></div>';
				}
			}

			$output .= '<div class="'.$containerClass.'">';

			$output .= '<div class="gutter-sizer"></div>';

			// Carousel Markup
			if( 'carousel' == $type ) {
				$output .= '<div class="owl-carousel">';
			}

				ob_start();
				while( $ivan_query->have_posts() ) : $ivan_query->the_post();

					// Sortable Magin
					$sortableData = '';

					// Categories
					$categories = '';

					$filters = get_the_terms(get_the_ID(), "ivan_vc_projects_cats");
					if ( $filters && ! is_wp_error( $filters ) ) {
						$ids = array();
						$cats = array();
						foreach ( $filters as $filter ) {
							$cats[] = $filter->name;
							$ids[] = strtolower($filter->name);
						}
						
						$ids = str_replace(' ', '-', $ids);	

						// join ids in a single string
						$sortableData = join( " ", $ids );

						// join IDs splitted by comma
						$categories = join( ", ", $cats);
					}

					$singleColumn = $columns;
					$singleTags = '';

					// If mansory, apply custom tags to change size
					if('mansory' == $type && 'yes' == $ivan_enable_sizes) {
						$_tags = get_the_terms(get_the_ID(), "ivan_vc_projects_sizes");
						if($_tags) {
							foreach ($_tags as $_tag) {
								if($_tag->name == 'double-width') {
									if($singleColumn == 4) // 3 Cols
										$singleColumn = 8;
									else if($singleColumn == 3) // 4 Cols
										$singleColumn = 6;
									else if($singleColumn == 6) // 2 Cols
										$singleColumn = 12;

									$singleTags .= ' double-width';
								}
								else if($_tag->name == 'double-height') {
									$singleTags .= ' double-height';
								}
								else if($_tag->name == 'half-height') {
									$singleTags .= ' half-height';
								}
								else if($_tag->name == 'full') {
									$singleColumn = 12;
									$singleTags .= 'full-size';
								}
							}
						}
					}
				
				?>

				<?php
				// Permalink or lightbox logic
				$_permalink = get_permalink();

				if('lightbox' == $ivan_open && true == has_post_thumbnail() ) {
					$lightboxImg = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'full' );
					$_permalink = $lightboxImg[0];

					$additionalClass .= ' with-lightbox';
				}

				?>

				<div class="col-xs-12 col-sm-<?php echo $singleColumn; ?> col-md-<?php echo $singleColumn; ?> taphover ivan-project <?php echo $singleTags; ?> <?php echo $additionalClass; ?> <?php echo $sortableData; ?>">

					<div class="ivan-project-inner">

						<?php
						// Custom Thumbnail Height
						$_customHeight = '';
						$_thumbClass = '';
						if( $ivan_custom_height != '') {
							$_customHeight = 'height:' . $ivan_custom_height . 'px;';
						}

						if(has_post_thumbnail() == false) {
							$_thumbClass = ' no-thumb';
						}
						?>

						<a href="<?php echo $_permalink; ?>" class="thumbnail<?php echo $_thumbClass; ?>" style="<?php echo $_customHeight; ?>">
							<span class="ivan-hover-fx"></span>
							<?php echo get_the_post_thumbnail( get_the_ID(), $ivan_img_size ); ?>
						</a>

						<?php if('yes' == $ivan_enable_cover) : ?>
						<div class="entry">
							<div class="entry-inner">
								<div class="centered">

									<?php if(' cover-entry' == $ivan_cover && ('' != $ico || '' != $ico_custom) ) : ?>
										<div class="icon-wrapper"><a href="<?php echo $_permalink; ?>" class="icon-inner"><?php echo $icon_markup; ?></a></div>
									<?php endif; ?>

									<?php if('yes' == $ivan_enable_title) : ?>
									<h3><a href="<?php echo $_permalink; ?>"><?php the_title(); ?></a></h3>
									<?php endif; ?>

									<?php if('' != $categories && 'yes' == $ivan_enable_categories) : ?>
										<div class="categories">
											<?php echo $categories; ?>
										</div>
									<?php endif; ?>

									<?php if('yes' == $ivan_enable_excerpt) : ?>
									<div class="excerpt"><?php the_excerpt(); ?></div>
									<?php endif; ?>

									<?php if('yes' == $ivan_enable_read_more) : ?>
									<div class="read-more">
										<a href="<?php echo $_permalink; ?>" class="button"><?php echo $ivan_enable_read_more_txt; ?></a>
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
				ivan_vc_init_filters();

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
			'icon_css' => array(
				// Font
				//'font-family' => 'h2',
				//'font-weight' => 'h2',
				'font-size' => '.icon-inner',
				//'line-height' => 'h2',
				//'text-transform' => 'h2',
				'color' => '.icon-inner',
				// Spacing
				'margin-top' => '.icon-inner',
				'margin-right' => '.icon-inner',
				'margin-bottom' => '.icon-inner',
				'margin-left' => '.icon-inner',
				'padding-top' => '.icon-inner',
				'padding-right' => '.icon-inner',
				'padding-bottom' => '.icon-inner',
				'padding-left' => '.icon-inner',
				// Bg
				'background-color' => '.icon-inner',
				// Border Radius
				'border-top-left-radius' => '.icon-inner',
				'border-top-right-radius' => '.icon-inner',
				'border-bottom-left-radius' => '.icon-inner',
				'border-bottom-right-radius' => '.icon-inner',
				// Border
				'border-top-width' => '.icon-inner',
				'border-right-width' => '.icon-inner',
				'border-bottom-width' => '.icon-inner',
				'border-left-width' => '.icon-inner',
				'border-style' => '.icon-inner',
				'border-color' => '.icon-inner',
				// Hovers
				'color-hover' => '.icon-inner:hover',
				'border-color-hover' => '.icon-inner:hover',
				'background-color-hover' => '.icon-inner:hover',
			),
			'filter_css' => array(
				// Font
				'font-family' => '.ivan-vc-filters a',
				'font-weight' => '.ivan-vc-filters a',
				'font-size' => '.ivan-vc-filters a',
				'line-height' => '.ivan-vc-filters a',
				'text-transform' => '.ivan-vc-filters a',
				'color' => '.ivan-vc-filters a',
				'text-align' => '.ivan-vc-filters',
				// Spacing
				'margin-top' => '.ivan-vc-filters-wrapper',
				'margin-right' => '.ivan-vc-filters a',
				'margin-bottom' => '.ivan-vc-filters-wrapper',
				'margin-left' => '.ivan-vc-filters a',
				'padding-top' => '.ivan-vc-filters a',
				'padding-right' => '.ivan-vc-filters a',
				'padding-bottom' => '.ivan-vc-filters a',
				'padding-left' => '.ivan-vc-filters a',
				// Bg
				'background-color' => '.ivan-vc-filters a',
				// Border Radius
				'border-top-left-radius' => '.ivan-vc-filters a',
				'border-top-right-radius' => '.ivan-vc-filters a',
				'border-bottom-left-radius' => '.ivan-vc-filters a',
				'border-bottom-right-radius' => '.ivan-vc-filters a',
				// Border
				'border-top-width' => '.ivan-vc-filters a',
				'border-right-width' => '.ivan-vc-filters a',
				'border-bottom-width' => '.ivan-vc-filters a',
				'border-left-width' => '.ivan-vc-filters a',
				'border-style' => '.ivan-vc-filters a',
				'border-color' => '.ivan-vc-filters a',
				// Hovers
				'color-hover' => '.ivan-vc-filters a:hover, .ivan-vc-filters a.current',
				'border-color-hover' => '.ivan-vc-filters a:hover, .ivan-vc-filters a.current',
				'background-color-hover' => '.ivan-vc-filters a:hover, .ivan-vc-filters a.current',
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
	global $ivan_vc_projects;
	$ivan_vc_projects = new WPBakeryShortCode_ivan_projects( array('name' => 'Projects', 'base' => 'ivan_projects') );

 } // #end class check

