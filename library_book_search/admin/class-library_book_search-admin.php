<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       #
 * @since      1.0.0
 *
 * @package    Library_book_search
 * @subpackage Library_book_search/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Library_book_search
 * @subpackage Library_book_search/admin
 * @author     Maulik Panchal <maulikpanchal5792@gmail.com>
 */
class Library_book_search_Admin {

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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/library_book_search-admin.css', array(), $this->version, 'all' );
		wp_enqueue_style( $this->plugin_name."_font_awesome", 'https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/library_book_search-admin.js', array( 'jquery' ), $this->version, false );

	}

	public function lbs_search_book_init(){

		//Set perpage default value
		$perpagebook = get_option( "perpagebook" );
		if(empty($perpagebook))
			{ update_option( "perpagebook", "5" ); }

		// Arguments & label set for register post type of book
		$labels = array(
			'name'                  => _x( 'Books', 'Post type general name', 'textdomain' ),
			'singular_name'         => _x( 'Book', 'Post type singular name', 'textdomain' ),
			'menu_name'             => _x( 'Books', 'Admin Menu text', 'textdomain' ),
			'name_admin_bar'        => _x( 'Book', 'Add New on Toolbar', 'textdomain' ),
			'add_new'               => __( 'Add New', 'textdomain' ),
			'add_new_item'          => __( 'Add New Book', 'textdomain' ),
			'new_item'              => __( 'New Book', 'textdomain' ),
			'edit_item'             => __( 'Edit Book', 'textdomain' ),
			'view_item'             => __( 'View Book', 'textdomain' ),
			'all_items'             => __( 'All Books', 'textdomain' ),
			'search_items'          => __( 'Search Books', 'textdomain' ),
			'parent_item_colon'     => __( 'Parent Books:', 'textdomain' ),
			'not_found'             => __( 'No books found.', 'textdomain' ),
			'not_found_in_trash'    => __( 'No books found in Trash.', 'textdomain' ),
			'archives'              => _x( 'Book archives', 'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4', 'textdomain' ),
			'insert_into_item'      => _x( 'Insert into book', 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4', 'textdomain' ),
			'uploaded_to_this_item' => _x( 'Uploaded to this book', 'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4', 'textdomain' ),
			'filter_items_list'     => _x( 'Filter books list', 'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”. Added in 4.4', 'textdomain' ),
			'items_list_navigation' => _x( 'Books list navigation', 'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Pages list navigation”. Added in 4.4', 'textdomain' ),
			'items_list'            => _x( 'Books list', 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”. Added in 4.4', 'textdomain' ),
		);
		$args = array(
			'labels'             => $labels,
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => array( 'slug' => 'book' ),
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_position'      => null,
			'supports'           => array( 'title', 'editor' ),
		);
		register_post_type( 'book', $args );

		// Arguments & label set for register Book Auther Taxonomy
		$labels = array(
			'name'              => _x( 'Book Authers', 'taxonomy general name', 'textdomain' ),
			'singular_name'     => _x( 'Book Auther', 'taxonomy singular name', 'textdomain' ),
			'search_items'      => __( 'Search Book Authers', 'textdomain' ),
			'all_items'         => __( 'All Book Authers', 'textdomain' ),
			'parent_item'       => __( 'Parent Book Auther', 'textdomain' ),
			'parent_item_colon' => __( 'Parent Book Auther:', 'textdomain' ),
			'edit_item'         => __( 'Edit Book Auther', 'textdomain' ),
			'update_item'       => __( 'Update Book Auther', 'textdomain' ),
			'add_new_item'      => __( 'Add New Book Auther', 'textdomain' ),
			'new_item_name'     => __( 'New Book Auther Name', 'textdomain' ),
			'menu_name'         => __( 'Book Auther', 'textdomain' ),
		);
		$args = array(
			'hierarchical'      => true,
			'labels'            => $labels,
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'rewrite'           => array( 'slug' => 'auther' ),
		);
		register_taxonomy( 'auther', array( 'book' ), $args );

		// Arguments & label set for register Publisher Taxonomy
		$labels = array(
			'name'              => _x( 'Publishers', 'taxonomy general name', 'textdomain' ),
			'singular_name'     => _x( 'Publisher', 'taxonomy singular name', 'textdomain' ),
			'search_items'      => __( 'Search Publishers', 'textdomain' ),
			'all_items'         => __( 'All Publishers', 'textdomain' ),
			'parent_item'       => __( 'Parent Publisher', 'textdomain' ),
			'parent_item_colon' => __( 'Parent Publisher:', 'textdomain' ),
			'edit_item'         => __( 'Edit Publisher', 'textdomain' ),
			'update_item'       => __( 'Update Publisher', 'textdomain' ),
			'add_new_item'      => __( 'Add New Publisher', 'textdomain' ),
			'new_item_name'     => __( 'New Publisher Name', 'textdomain' ),
			'menu_name'         => __( 'Publisher', 'textdomain' ),
		);
		$args = array(
			'hierarchical'      => true,
			'labels'            => $labels,
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'rewrite'           => array( 'slug' => 'publisher' ),
		);
		register_taxonomy( 'publisher', array( 'book' ), $args );

	}

	// functin that add admin menu
	public function lbs_admin_menu(){
		add_menu_page('Library Book Search', 'Library Book Search', 'manage_options', 'library_book_search_preview', array( $this->bookshortcodepreviewpage,'library_book_search_preview'));
	}

	// function that creates the new metabox that will show on post
	public function star_rating_and_price_metabox() {
		add_meta_box('star_rating_and_price', 'Star Rating & Book Price', array($this,'star_rating_and_price_display'), 'book');
	}

	// star_rating dropdown display
	public function star_rating_and_price_display( $post ) {
	  // get current value
	  $star_rating_value = get_post_meta( get_the_ID(), 'star_rating', true );
	  $price_value = get_post_meta( get_the_ID(), 'price_value', true );
	  ?>
	  	<label class="post-attributes-label-wrapper" for="star_rating" >Star Rating</label>
	    <select class="post-attributes-label-wrapper" name="star_rating" id="star_rating">
	        <option value="1" <?php if($star_rating_value == '1') echo 'selected'; ?>>1</option>
	        <option value="2" <?php if($star_rating_value == '2') echo 'selected'; ?>>2</option>
	        <option value="3" <?php if($star_rating_value == '3') echo 'selected'; ?>>3</option>
	        <option value="4" <?php if($star_rating_value == '4') echo 'selected'; ?>>4</option>
	        <option value="5" <?php if($star_rating_value == '5') echo 'selected'; ?>>5</option>
	    </select>
	    <hr>
	    <label class="post-attributes-label-wrapper" for="price_value" >Price</label>
	    <input class="post-attributes-label-wrapper" type="number" step="any" name="price_value" id="price_value" value="<?php echo $price_value; ?>">
	  <?php
	}

	// dropdown saving
	public function star_rating_and_price_save( $post_id ) {
		// save the new value of the dropdown
		$star_rating_new_value = $_POST['star_rating'];
		update_post_meta( $post_id, 'star_rating', $star_rating_new_value );
		$price_new_value = $_POST['price_value'];
		update_post_meta( $post_id, 'price_value', $price_new_value );
	}


	// function executed on Book Search form submitted
	public function lbs_find_book_from_library(){
		global $wpdb;
		$lbs_find_auther = $_POST['lbs_find_auther'];
		$lbs_find_book_name = $_POST['lbs_find_book_name'];
		$lbs_find_publisher = $_POST['lbs_find_publisher'];
		$star_rating = $_POST['lbs_find_star_rating'];
		$price_min = $_POST['price_min'];
		$price_max = $_POST['price_max'];
		$lbs_offset = $_POST['lbs_offset'];

		if( $lbs_find_auther !=""){
			$query_array_auther = array(
	            'taxonomy'  => 'auther',
	            'field'     => 'slug',
	            'terms'     => $lbs_find_auther,
	        );
		}
		if( $lbs_find_publisher !=""){
			$query_array_publisher = array(
	            'taxonomy'  => 'publisher',
	            'field'     => 'term_id',
	            'terms'     => array( $lbs_find_publisher ),
	        );
		}
		if($star_rating != 0 || $star_rating !=""){
			$meta_query_array_star = array(
                'key' => 'star_rating',
                'value' => $star_rating,
            );
		}
		if( $price_min !="" &&  $price_max !="" ){
			$meta_query_array_price = array(
	            'key'     => 'price_value',
	            'value'   => array( $price_min, $price_max ),
	            'type'    => 'numeric',
	            'compare' => 'BETWEEN',
	        );
		}

		// Set the arguments for the query
		$perpage_book = get_option( "perpagebook" );
	    $args = array(
	        'posts_per_page' => $perpage_book,
			'numberposts'    => -1, // -1 is for all
			'post_type'		 => 'book', // or 'post', 'page'
			'orderby' 		 => 'title', // or 'date', 'rand'
			'order' 		 => 'ASC', // or 'DESC'
			'offset'         => $lbs_offset,
	        'tax_query' => array(
		        $query_array_auther,
		        $query_array_publisher
		    ),
	        'meta_query' => array(
	            $meta_query_array_star,
	            $meta_query_array_price
	        )
	    );
	    $args_counter = array(
			'numberposts'    => -1, // -1 is for all
			'post_type'		 => 'book', // or 'post', 'page'
			'orderby' 		 => 'title', // or 'date', 'rand'
			'order' 		 => 'ASC', // or 'DESC'
			'offset'         => $lbs_offset,
	        'tax_query' => array(
		        $query_array_auther,
		        $query_array_publisher
		    ),
	        'meta_query' => array(
	            $meta_query_array_star,
	            $meta_query_array_price
	        )
	    );

	    // Added & removed filters for where condition on wp_query
		add_filter( 'posts_where', array($this,'title_filter'), 10, 2 );
		$myposts = new WP_Query( $args );
		remove_filter( 'posts_where', array($this,'title_filter'), 10, 2 );

		add_filter( 'posts_where', array($this,'title_filter'), 10, 2 );
		$myposts_counter = new WP_Query( $args_counter );
		remove_filter( 'posts_where', array($this,'title_filter'), 10, 2 );

		$total_result = $myposts_counter->found_posts;

		Helper::book_list_structure($myposts,$perpage_book,$lbs_offset,$total_result);

		exit();
	}

	// function will execute filters for where condition on wp_query
	public function title_filter( $where, &$wp_query )
	{
	    global $wpdb;
	    $search_term =  $_POST['lbs_find_book_name'];

        $where .= ' AND ' . $wpdb->posts . '.post_title LIKE \'%' . esc_sql( $wpdb->esc_like( $search_term ) ) . '%\'';
	    
	    return $where;
	}

}
