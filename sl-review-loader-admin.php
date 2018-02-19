<?php
/* *****

Review loader admin menu for WordPress dashboard

*/


/* Set up plugin admin */
add_action( 'admin_menu', 'sl_rloader_create_menu' );


// Create plugin submenu tab under WP Settings menu on dashboard
function sl_rloader_create_menu() {

                // Create custom  menu
                $page = add_menu_page( 'SL Review Loader Settings', 'Review Loader Settings',
                        'manage_options', 'sl_rloader',
                        'sl_rloader_options_page' );

		add_action( 'admin_init', 'sl_rloader_admin_init' );

} // End 'sl_rloader_create_menu'


// Creates the settings page
function sl_rloader_options_page() {

	?>
	<div class="wrap">
		<h2>SL Review Loader</h2>
		<p>The Review Loader allows you to create customer reviews, and then display these reviews on whatever pages you want on your website.  All published reviews will be placed vertically on the page. For each customer review, you have the option to display a logo and a photo.</p>
		<p>To Use:</p>
		<ol>
			<li>Create as many customer reviews as you like.</li>
			<li>In the SL Review Loader Settings, choose the background-color for the review text, how many reviews you wish to be displayed at a time, and what type of transition you prefer between the pages.</li>
			<li>Place the following shortcode on any pages where you want the reviews to display: [sl_review_load]</li>
		</ol>
		<br />

		<form action="options.php" method="post">

	<?php
		settings_fields( 'sl_rloader_options' );
		do_settings_sections( 'sl_rloader_options' );
	?>
		<table class="form-table">
			<tr valign="top">
			<th scope="row">Review Background-color</th>
			<td><select name="sl_rloader_review_bgcolor">
				<option value="blue" <?php if(esc_attr( get_option( 'sl_rloader_review_bgcolor') ) == 'blue'){ ?>selected<?php } ?> >blue</option>
				<option value="red" <?php if(esc_attr( get_option( 'sl_rloader_review_bgcolor') ) == 'red'){ ?>selected<?php } ?> >red</option>
				<option value="white" <?php if(esc_attr( get_option( 'sl_rloader_review_bgcolor') ) == 'white'){ ?>selected<?php } ?> >white</option>
				<option value="gray" <?php if(esc_attr( get_option( 'sl_rloader_review_bgcolor' ) ) == 'gray'){ ?>selected<?php } ?>>gray</option>
			</select>
			</td>
		</tr>

		<tr valign="top">
			<th scope="row">Reviews per page</th>
			<td><input type="text" name="sl_rloader_review_qty" value="<?php echo esc_attr( get_option( 'sl_rloader_review_qty' )); ?>" /></td>
		</tr>

		<tr valign="top">
			<th scope="row">Review transition</th>
			<td>
				<select name="sl_rloader_review_transition">
					<option value="loadonclick" <?php if(esc_attr( get_option( 'sl_rloader_review_transition' ) ) == 'loadonclick') { ?>selected<?php } ?> >Load new page on click</option>
					<option value="continualloop" <?php if(esc_attr( get_option( 'sl_rloader_review_transition' ) ) == 'continualloop') { ?>selected<?php } ?> >Loop reviews continuously</option>
				</select>	

	<?php	submit_button();	?>

		</form>
	</div><!--End 'wrap'-->

	<?php
} // End 'sl_rloader_options_page'



// Register and define the options
function sl_rloader_admin_init() {

	register_setting( 'sl_rloader_options', 'sl_rloader_review_bgcolor', 'sl_rloader_validate_options' );
	register_setting( 'sl_rloader_options', 'sl_rloader_review_qty', 'sl_rloader_validate_options' );
	register_setting( 'sl_rloader_options', 'sl_rloader_review_transition', 'sl_rloader_validate_options' );

} // End 'sl_rloader_admin_init'



// Validate the option values
function sl_rloader_validate_options( $input ) {

	$valid = array();
	$valid = preg_replace( '/[^a-zA-Z0-9]/', '', $input );
	return $valid;

} // End 'sl_rloader_validate_options' 


?>
  
