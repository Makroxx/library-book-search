<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       #
 * @since      1.0.0
 *
 * @package    Library_book_search
 * @subpackage Library_book_search/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Library_book_search
 * @subpackage Library_book_search/public
 * @author     Maulik Panchal <maulikpanchal5792@gmail.com>
 */
class Library_book_search_Public extends Library_book_search_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

		// Declare Shortcode function for library book search
		add_shortcode('library_book_search', array($this, 'library_book_search_shortcode'));

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Library_book_search_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Library_book_search_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/library_book_search-public.css', array(), $this->version, 'all' );
		wp_enqueue_style( $this->plugin_name."range_slide", 'http://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css', array(), $this->version, 'all' );
		wp_enqueue_style( $this->plugin_name."_font_awesome", 'https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css', array(), $this->version, 'all' );


	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Library_book_search_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Library_book_search_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		$perpagebook = get_option( "perpagebook" );
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/library_book_search-public.js', array( 'jquery' ), $this->version, false );
		wp_localize_script( $this->plugin_name, 'script_data',array( 'ajax_url' => admin_url( 'admin-ajax.php' ) , 'perpagebook' => $perpagebook ) );
		wp_enqueue_script( $this->plugin_name."_range_slider", 'https://code.jquery.com/ui/1.12.1/jquery-ui.js', array( 'jquery' ), $this->version, false );
		

	}


	// Shortcode function
	public function library_book_search_shortcode(){
		ob_start();
		$lbs_offset = 0;
		?>
		<div class="lbs_book_search_area">
			<form action="" method="post" class="lbs_book_search_box" name="lbs_book_search_box" id="lbs_book_search_box">
				<input type="hidden" name="lbs_offset" id="lbs_offset" value="<?php echo $lbs_offset; ?>">
				<input type="text" onchange="reset_page_offset();" name="lbs_find_book_name" id="lbs_find_book_name" value="" placeholder="Book Name">
				<input type="text" onchange="reset_page_offset();" name="lbs_find_auther" id="lbs_find_auther" value="" placeholder="Auther">
				<select name="lbs_find_publisher" onchange="reset_page_offset();" id="lbs_find_publisher">
					<option value="" > -- Select Publisher -- </option>
					<?php 
					$publisher_terms_dropdown = get_terms( array( 
					    'taxonomy' => 'publisher'
					) ); 
					foreach ( $publisher_terms_dropdown as $publisher_term_dropdown ) {
						echo "<option value='".$publisher_term_dropdown->term_id."'>".$publisher_term_dropdown->name."</option>";
					}
					?>
				</select>
			    <select name="lbs_find_star_rating" onchange="reset_page_offset();" id="lbs_find_star_rating">
			    	<option value="" > -- Select Star -- </option>
			        <option value="1" >1</option>
			        <option value="2" >2</option>
			        <option value="3" >3</option>
			        <option value="4" >4</option>
			        <option value="5" >5</option>
			    </select>

			    <div class="range_slider_box">
				    <label>Price</label>
					<div class="left_range">$ <input type="text" id="price_min" readonly style="border:0; "></div>
					<div class="right_range">$ <input type="text" id="price_max" readonly style="border:0; "></div>
					<div id="slider-range"></div>
				</div>

				<input type="submit" name="Search" value="Search">
			</form>
			<div class="lbs_book_listing" id="lbs_book_listing">
				<?php
					// Set the arguments for the query
					$perpage_book = get_option( "perpagebook" );
				    $args = array(
				        'posts_per_page' => $perpage_book,
						'numberposts'    => -1, // -1 is for all
						'post_type'		 => 'book', // or 'post', 'page'
						'orderby' 		 => 'title', // or 'date', 'rand'
						'order' 		 => 'ASC', // or 'DESC'
				    );

				    $myposts = new WP_Query( $args );
					Helper::book_list_structure($myposts,$perpage_book,$lbs_offset);
				?>
			</div>
			<div class="book_loader">
				<img src="<?php echo plugin_dir_url( __FILE__ )."/images/loader.gif"; ?>">
			</div>
		</div>
		<?php
		return ob_get_clean();
	}


	// Assign Custom Template to Single Book detail page
	public function my_custom_template($single) {
	    global $wp_query, $post;
	    /* Checks for single template by post type as book */
	    if ( $post->post_type == 'book' ) {
	        if ( file_exists( plugin_dir_path( __FILE__ ) . '/single-book.php' ) ) {
	            return plugin_dir_path( __FILE__ ) . '/single-book.php';
	        }
	    }
	    return $single;
	}


}
