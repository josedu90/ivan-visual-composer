<?php
/***
 * Module > Table
 *
 * This module extends default VC class, turning easy extend it with custom functions!
 *
 **/

if(class_exists('WPBakeryShortCode')) {

	// Class
	class WPBakeryShortCode_ivan_table extends WPBakeryShortCode {

		protected function content( $atts, $content = null ) {
			// Extract  atts and setup initial vars
			extract( shortcode_atts( array(
				'el_class' => '',
			), $atts) );

			$output = '';
			$classes = '';

			// Add custom classes provided by users
			if('' != $el_class)
				$classes .= ' ' . $el_class;

			// Output Form
			ob_start();
			?>
			<div class="ivan-table <?php echo $classes; ?>">
				<?php echo do_shortcode($content); ?>
			</div>
			<?php
			$output .= ob_get_clean();

			return $output;
		}
	}// #class end

	// Init global var to store this module data
	global $ivan_vc_table;
	$ivan_vc_table = new WPBakeryShortCode_ivan_table( array('name' => 'Table', 'base' => 'ivan_table') );

} // #end class check