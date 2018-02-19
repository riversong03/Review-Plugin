<?php 
/*  
	Plugin Name: SiteLock Review Loader
	Plugin URI: https://wpdistrict.com/meet-the-neighbors/
 	Description: A plugin to create a reviews page by adding a shortcode to the page content
	Version: 1.0
	Author: Jill Wen
	Author URI: 
	License: GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
*/



	// Activate the plugin
	register_activation_hook( __FILE__, 'sl_review_loader_wp_activate');

	function sl_review_slider_wp_activate() {
		require_once('sl-review-loader-install.php');
	} // End 'register_activation_hook'



	// Action hook to initialize the plugin
	add_action( 'init', 'sl_review_loader_wp_init' );
	add_action( 'wp_head', 'sl_rloader_add_styles' );
	add_action( 'admin_print_scripts-post.php', 'sl_rloader_image_admin_scripts' );
	add_action( 'admin_print_scripts-post-new.php', 'sl_rloader_image_admin_scripts' );
	
	require_once('sl-review-loader-admin.php');



	// Initialize the slider
	function sl_review_loader_wp_init() 
	{
		// register the products custom post type
		$labels = array(
				'name'=> __( 'SL Review Loader', 'SL_Review_Loader' ),
				'singular_name' => __( 'Review', 'SL_Review_Loader' ),
				'add_new' => 'Add New',
				'add_new_item' => 'Add New Review',
				'edit_item' => 'Edit Review',
				'new_item' =>  'New Review',
				'view_item' => null,
				'search_items' => 'Search Reviews',
				'not_found' => 'No Reviews Found',
				'menu_name' => __( 'Reviews', 'SL_Review_Loader' )
		);

		$args = array(
				'labels' => $labels,
				'public' => true,
				'publicly_queryable' => false,
				'show_ui' => true,
				'show_in_menu' => true,
				'query_var' => true,
				'rewrite' => true,
				'capability_type' => 'post',
				'has_archive' => true,
				'hierarchical' => false,
				'menu_position' => null,
				'supports' => array( 'title', 'editor' )
		);
	

		
		add_filter( 'enter_title_here', 'wp_change_title_text' );

		register_post_type( 'sl-review-loader', $args );


	} // End 'sl_review_loader_wp_init'


	function wp_change_title_text( $title ) {

		$screen = get_current_screen();
		
		if( $screen->post_type == 'sl-review-loader' ) {
			$title = 'Enter name of reviewer\'s company';
		}

		return $title;
	
	} // End function


	// Add stylesheet to page if review shortcode is found in the page content
	function sl_rloader_add_styles() {
		
		echo '<link rel="stylesheet" href="/wp-content/plugins/sl-review-loader/css/sl-rloader-styles.css?v=1.01" type="text/css" />';
	
	} // End function

         add_action( 'add_meta_boxes', 'sl_rloader_metabox_create' );



	function sl_rloader_metabox_create() {
		add_meta_box( 'sl-rloader-meta', 'Review Info', 'sl_rloader_metabox_function', 'sl-review-loader', 'normal', 'high' );

	}


	function sl_rloader_metabox_function( $post ) {
		

		// Show metabox for user to input review info
		$sl_rloader_reviewer_name = get_post_meta( $post->ID, '_sl_rloader_reviewer_name', true ); 
		$sl_rloader_reviewer_img = get_post_meta( $post->ID, '_sl_rloader_reviewer_img', true );
		$sl_rloader_company_logo = get_post_meta( $post->ID, '_sl_rloader_company_logo', true );
		$sl_rloader_orderonpage = get_post_meta( $post->ID, '_sl_rloader_orderonpage', true );
	?>
			<table class="widefat">
			<thead>
				<tr>
					<th colspan="2"><p>Please enter review information below:</p></th>
				</tr>
			</thead>

			<tbody>
			<tr>
					<td>	
						<h3>Reviewer Name</h3>
					</td>
					<td>
						 <input type="text" size="50" style="margin-top:10px"  name="sl_rloader_reviewer_name" id="sl_rloader_reviewer_name" value="<?php echo esc_attr( $sl_rloader_reviewer_name ); ?>" />
					</td>
				</tr>
				<tr style="background-color:#efefef">
					<td>
						<h3>Reviewer Image</h3>
					</td>
					<td>&nbsp;</td>
				</tr>
				<tr style="background-color:#efefef">
					<td id="rProfile" rowspan="2">
						<?php if($sl_rloader_reviewer_img != '') { ?> 
                                               		<div class="reviewerPhoto">
                                                        	<img id="meta_reviewer_img"  src="<?php echo $sl_rloader_reviewer_img; ?>" alt="Reviewer image"  height="140"  />
                                                	</div><!--End 'reviewerPhoto'-->
						<?php } ?>
                                        </td>
					<td>

						<input type="text" size="50"  name="sl_rloader_reviewer_img" id="sl_rloader_reviewer_img" value="<?php echo esc_url( $sl_rloader_reviewer_img ); ?>" />
					</td>
				</tr>
				<tr style="background-color:#efefef">
					<td>
						<input id="upload_reviewer_img_button" type="button" value="Media Library Image" class="button-secondary" />
						<br />
						Enter an image URL or use an image from the Media Library
					</td>
                                </tr>
				<tr>
					<td>
						<h3>Company Logo</h3>
					</td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td id="rLogo" rowspan="2">
						<?php if($sl_rloader_company_logo != '') { ?>
                                                	<div class="reviewerLogo">
                                                		<img id="meta_company_logo" src="<?php echo $sl_rloader_company_logo; ?>" alt="Company logo"  height="140" />
                                                	</div><!--End 'reviewerLogo'-->
                        			<?php } ?>

					</td>
					<td>
						<input type="text" size="50"  name="sl_rloader_company_logo" id="sl_rloader_company_logo" value="
			<?php echo esc_url( $sl_rloader_company_logo ); ?>" />
					</td>
				</tr>
				<tr>
					<td>
						<input id="upload_company_logo_button" type="button" value="Media Library Image" class="button-secondary" />
						<br />Enter an image URL or use an image from the Media Library<br />
					</td>
				</tr>
				<tr>
				   <td>
				          <h3>Review's rank in page layout***</h3>
					  <p> (Numbers only)</p>
				   </td>
				   <td>
			 	         <input type="text" size="10" name="sl_rloader_orderonpage" id="sl_rloader_orderonpage" value="<?php echo esc_attr( $sl_rloader_orderonpage ); ?>" />
			    	   </td>
				</tr>
				<tr>
					<td colspan="2"><p>***This will determine where the review will appear in the layout.  Assigning it a number 1 will place it at the top of the page, and assigning it a lower number will move it further down in the layout.</p>
					</td>
				</tr>
				<tr><td colspan="2">&nbsp;</td></tr>
			</tbody>
		</table>

	<?php 

	}

	
	// Hook to save the meta box data
	add_action( 'save_post', 'sl_rloader_save_meta' );



	function sl_rloader_save_meta( $post_id ) {

		// Verify the meta is set
		if ( isset( $_POST['sl_rloader_reviewer_name'] ) ) {
		
			// Save the metadata
			update_post_meta( $post_id, '_sl_rloader_reviewer_name', strip_tags( $_POST['sl_rloader_reviewer_name'] ) );
			update_post_meta( $post_id, '_sl_rloader_reviewer_img', esc_url_raw( $_POST['sl_rloader_reviewer_img'] ) );
			update_post_meta( $post_id, '_sl_rloader_company_logo', esc_url_raw( $_POST['sl_rloader_company_logo'] ) );
			update_post_meta( $post_id, '_sl_rloader_orderonpage', strip_tags( $_POST['sl_rloader_orderonpage'] ) );

		} // End if
	} // End function


	function sl_rloader_image_admin_scripts() {

		wp_enqueue_script( 'sl-image-upload', plugins_url( '/sl-review-loader/js/sl-loader-meta-image.js' ), array( 'jquery', 'media-upload', 'thickbox' )
		);


	}


	// Register shortcode
	add_shortcode( 'sl_review_load', 'sl_rloader_scl_load' );



	function enqueue_loader_script() {
		$ver = "2.".rand(0,999);
		wp_register_script( 'sl_rloader_jqueryui_library', plugin_dir_url(__FILE__).'js/jquery-ui.min.js',array('jquery'), $ver, true );
		wp_register_script( 'sl_rloader_review_transitions', plugin_dir_url(__FILE__).'js/sl-loader-review-transition.js',array('jquery'), $ver, true  );
		wp_enqueue_script( 'sl_rloader_jqueryui_library' );
		wp_enqueue_script( 'sl_rloader_review_transitions' );

	} // End function


	// The callback function that will load the review content
	function sl_rloader_scl_load() {

		add_action('wp_footer', 'enqueue_loader_script' );
		
		// Get admin options
		$review_bg_color = get_option('sl_rloader_review_bgcolor');
		$review_qty = get_option( 'sl_rloader_review_qty' );
		$review_transition = get_option( 'sl_rloader_review_transition' );

/*
		$reviews = new WP_Query(
					array(
						'post_type' => 'sl-review-loader',
						'meta_query' => 'sl_rloader_orderonpage',
						'orderby' => 'meta_value_num',
						'order' => 'DESC',
						'posts_per_page' => -1,
					)
			   );
*/

		function sl_rloader_get_reviews() {

			$args = array(
				'post_type' => 'sl-review-loader',
				'posts_per_page' => -1,
				'order' => 'ASC',
				'orderby' => 'meta_value',
				'meta_key' => '_sl_rloader_orderonpage' 							
			);

			$first_review_query = new WP_Query( $args );

			return $first_review_query;		
	
		}


		$reviews = sl_rloader_get_reviews();

		$cnt = 0;
		
		$reviewOutput = '<div class="customerReviews';
		if(preg_match("#continualloop#", strtolower($review_transition) )) { 
			$reviewOutput .= ' loop';
		} // End if
		
		$reviewOutput .= '">';
		
		 
		while ( $reviews->have_posts() ) : $reviews->the_post();
			$reviewID = get_the_ID();

		$sl_rloader_reviewer_name = '';
		$sl_rloader_reviewer_img = ''; 
		$sl_rloader_reviewer_company = ''; 
		$sl_rloader_company_logo = '';



		$sl_rloader_reviewer_name = get_post_meta( $reviewID, '_sl_rloader_reviewer_name', true );
                $sl_rloader_reviewer_img = get_post_meta( $reviewID, '_sl_rloader_reviewer_img', true );
                $sl_rloader_company_logo = get_post_meta( $reviewID, '_sl_rloader_company_logo', true );
		$sl_rloader_orderonpage = get_post_meta( $reviewID, '_sl_rloader_orderonpage', true );
		if( strlen( $sl_rloader_reviewer_img ) < 1 ) {
			$sl_rloader_reviewer_img = $sl_rloader_company_logo;
			$sl_rloader_company_logo = '';
		}

		$cnt++;
		
		if( $cnt % 2 == 0) {
			$orient="right";
			$cImgOrient = "left";
		} else {
			$orient="left";
			$cImgOrient = "right";
		}
		
		// Save content to var for display on the page
		ob_start();
		the_content();
		$reviewContent = ob_get_clean();
		
		ob_start();
		the_title();
		$sl_rloader_reviewer_company  = ob_get_clean();

		// Set html template for image wrapper
		$sl_rloader_r_img = '<div class="imgWrapper '.$orient.'">
					<div class="reviewerImg">';
		if( strlen($sl_rloader_reviewer_img) > 1 ) { 
			$sl_rloader_r_img .=	'<img src="'.$sl_rloader_reviewer_img.'" alt="" />';
		}
		
		$sl_rloader_r_img .=	'</div><!--End "reviewerImg"-->
					<h5>'.$sl_rloader_reviewer_name.'</h5>
					<p class="company">'.$sl_rloader_reviewer_company.'</p>
				</div><!--End "imgWrapper"-->';

		// Set html markup for point div
		$sl_rloader_point = '<div class="pointWrapper"><div class="point '.$orient.' '.$review_bg_color.'"></div></div>'; 

		// Begin review html	
		if($cnt < 2) {
			$pageCnt = 1; 
			$reviewOutput .= '<div class="page page'.$pageCnt;
			if( preg_match("#onclick#", strtolower($review_transition) ) ) {
				$reviewOutput .= ' active';
			} // End if

			$reviewOutput .= '">'; 
			
		} // End if statement

		

		if( ($cnt > $review_qty) && ($cnt % $review_qty == 1) ) { 
			$pageCnt++;
			if( preg_match("#onclick#",strtolower($review_transition) ) ) {
				$reviewOutput .= '<a class="pageLoader"></a>';
			} // End if statement
	
			$reviewOutput .= '</div><div class="page page'.$pageCnt.'">';
 
		} // End if statement

		$reviewOutput .= '<div class="quoteWrapper">';

		if( $orient == 'left' ) {  $reviewOutput .=  $sl_rloader_r_img; }
		
		$reviewOutput .= '<div class="content">';
		
		if( $orient == 'left' ) { $reviewOutput .= $sl_rloader_point; }  
	
			$reviewOutput .= '<p class="'.$review_bg_color.'">'.$reviewContent.'</p>';
		
			if( $orient == 'right' ) {  $reviewOutput .= $sl_rloader_point; }
	
			if( $sl_rloader_company_logo != '' ) { 
	
				$reviewOutput .= '<img class="companyLogo '.$cImgOrient.'" src="'.$sl_rloader_company_logo.'" />';	
			} // End if

			$reviewOutput .= '</div><!--End "content"-->';
		
			if( $orient == 'right' ) {  $reviewOutput .= $sl_rloader_r_img; }
		
			$reviewOutput .= '<div class="clearFloat"></div><!--End "clearFloat"-->
						</div><!--End "quoteWrapper"-->';
			

		 endwhile;
  
		if( preg_match( "#onclick#",strtolower($review_transition) ) && ($review_qty < $cnt) ) {
			$reviewOutput .= '<a class="pageLoader-restart">Go back to beginning</a>';
		} // End if

		$reviewOutput .= '</div></div>';
		// After while loop has run through all of the reviews, close the final page div

		wp_reset_postdata();

		return $reviewOutput;

	} // End sl_rloader_scl_load function		


?>