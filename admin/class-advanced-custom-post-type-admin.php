<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://https://profiles.wordpress.org/darshitrajyaguru97/
 * @since      1.0.0
 *
 * @package    Advanced_Custom_Post_Type
 * @subpackage Advanced_Custom_Post_Type/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Advanced_Custom_Post_Type
 * @subpackage Advanced_Custom_Post_Type/admin
 * @author     Darshit <darshitrajyaguru@gmail.com>
 */
class Advanced_Custom_Post_Type_Admin {

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
		add_shortcode('custom_post_slider', array($this, 'display_slider_shortcode'));

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
		 * defined in Advanced_Custom_Post_Type_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Advanced_Custom_Post_Type_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/advanced-custom-post-type-admin.css', array(), $this->version, 'all' );

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
		 * defined in Advanced_Custom_Post_Type_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Advanced_Custom_Post_Type_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/advanced-custom-post-type-admin.js', array( 'jquery' ), $this->version, false );

	}
	/**
	 * Register Custom Post Type
	 */
	public function register_custom_post_type(){
		$supports = array(
			'title', //Custom post type title
			'thumbnail',
		);
		$labels = array(
			'name'               		=> _x( 'Books', 'post type general name', 'advanced-custom-post-type' ),
			'singular_name'      		=> _x( 'Book', 'post type singular name', 'advanced-custom-post-type' ),
			'menu_name'          		=> _x( 'Books', 'admin menu', 'advanced-custom-post-type' ),
			'name_admin_bar'     		=> _x( 'Book', 'add new on admin bar', 'advanced-custom-post-type' ),
			'add_new'            		=> _x( 'Add New', 'book', 'advanced-custom-post-type' ),
			'add_new_item'       		=> __( 'Add New Book', 'advanced-custom-post-type' ),
			'new_item'           		=> __( 'New Book', 'advanced-custom-post-type' ),
			'edit_item'          		=> __( 'Edit Book', 'advanced-custom-post-type' ),
			'view_item'          		=> __( 'View Book', 'advanced-custom-post-type' ),
			'all_items'          		=> __( 'All Books', 'advanced-custom-post-type' ),
			'not_found'          		=> __( 'No Books found.', 'advanced-custom-post-type' ),
			'register_meta_boxes'       => 'acpt_metabox',
		);

		$args = array(
			'supports' 	=> $supports,
			'labels'	=> $labels,
			'hierarchical' => false,
			'public' => false,  // it's not public, it shouldn't have it's own permalink
			'publicly_queryable' => false,  // you should be able to query it
			'show_ui' => true,  // you should be able to edit it in wp-admin
			'exclude_from_search' => true,  // you should exclude it from search results
			'show_in_nav_menus' => false,  // you shouldn't be able to add it to menus
			'has_archive' => false,  // it shouldn't have archive page
			'rewrite' => false,  // it shouldn't have rewrite rules
			'menu_icon'           => 'dashicons-book',
		);
		register_post_type('books', $args);
	}

	/**
	 * Add Custom Meta Box
	 */
	public function add_custom_fields_meta_box() {
		add_meta_box(
			'advanced_custom_post_type_meta_field',
			__('Custom Editor', 'advanced-custom-post-type'),
			array($this, 'render_custom_fields_meta_box'),
			'books',
			'normal',
			'high'
		);
	}
	
	public function render_custom_fields_meta_box($post) {
		// Retrieve existing meta values
		$meta_value = get_post_meta($post->ID, '_custom_meta_key', true);
	
		// Output the HTML for the rich text editor
		?>
		<!-- <label for="custom_meta_box_editor"><?php _e('Custom Editor', 'advanced-custom-post-type'); ?></label> -->
		<?php wp_editor($meta_value, 'custom_meta_box_editor', array(
			'textarea_name' => '_custom_meta_key',
			'media_buttons' => true,
			'textarea_rows' => 10,
		)); ?>
	
		<!-- Add the nonce field -->
		<input type="hidden" name="custom_meta_box_nonce" value="<?php echo wp_create_nonce('custom_meta_box_nonce'); ?>" />
		<?php
	}
	
	
	public function save_meta_box_data($post_id) {
		// Check if nonce is set
		if (!isset($_POST['custom_meta_box_nonce'])) {
			return;
		}
	
		// Verify nonce
		if (!wp_verify_nonce($_POST['custom_meta_box_nonce'], 'custom_meta_box_nonce')) {
			return;
		}
	
		// Check if autosave
		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
			return;
		}
	
		// Check user permissions
		if (!current_user_can('edit_post', $post_id)) {
			return;
		}
	
		// Update or save the meta value
		if (isset($_POST['_custom_meta_key'])) {
			update_post_meta($post_id, '_custom_meta_key', wp_kses_post($_POST['_custom_meta_key']));
		}
	}

	/**
	 * Register Custom Texonomies
	 */
	public function register_custom_taxonomies() {
		$labels = array(
			'name'              => _x( 'Genres', 'taxonomy general name', 'textdomain' ),
			'singular_name'     => _x( 'Genre', 'taxonomy singular name', 'textdomain' ),
			'search_items'      => __( 'Search Genres', 'textdomain' ),
			'all_items'         => __( 'All Genres', 'textdomain' ),
			'parent_item'       => __( 'Parent Genre', 'textdomain' ),
			'parent_item_colon' => __( 'Parent Genre:', 'textdomain' ),
			'edit_item'         => __( 'Edit Genre', 'textdomain' ),
			'update_item'       => __( 'Update Genre', 'textdomain' ),
			'add_new_item'      => __( 'Add New Genre', 'textdomain' ),
			'new_item_name'     => __( 'New Genre Name', 'textdomain' ),
			'menu_name'         => __( 'Genre', 'textdomain' ),
		);

		$args = array(
			'hierarchical'      => true,
			'labels'            => $labels,
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'rewrite'           => array( 'slug' => 'genre' ),
		);

		register_taxonomy( 'genre', array( 'books' ), $args );

		unset( $args );
		unset( $labels );

		// Add new taxonomy, NOT hierarchical (like tags)
		$labels = array(
			'name'                       => _x( 'Writers', 'taxonomy general name', 'textdomain' ),
			'singular_name'              => _x( 'Writer', 'taxonomy singular name', 'textdomain' ),
			'search_items'               => __( 'Search Writers', 'textdomain' ),
			'popular_items'              => __( 'Popular Writers', 'textdomain' ),
			'all_items'                  => __( 'All Writers', 'textdomain' ),
			'parent_item'                => null,
			'parent_item_colon'          => null,
			'edit_item'                  => __( 'Edit Writer', 'textdomain' ),
			'update_item'                => __( 'Update Writer', 'textdomain' ),
			'add_new_item'               => __( 'Add New Writer', 'textdomain' ),
			'new_item_name'              => __( 'New Writer Name', 'textdomain' ),
			'separate_items_with_commas' => __( 'Separate writers with commas', 'textdomain' ),
			'add_or_remove_items'        => __( 'Add or remove writers', 'textdomain' ),
			'choose_from_most_used'      => __( 'Choose from the most used writers', 'textdomain' ),
			'not_found'                  => __( 'No writers found.', 'textdomain' ),
			'menu_name'                  => __( 'Writers', 'textdomain' ),
		);

		$args = array(
			'hierarchical'          => false,
			'labels'                => $labels,
			'show_ui'               => true,
			'show_admin_column'     => true,
			'update_count_callback' => '_update_post_term_count',
			'query_var'             => true,
			'rewrite'               => array( 'slug' => 'writer' ),
		);
		function display_slider_shortcode() {
			ob_start();
			$this->display_slider();
			return ob_get_clean();
		}
	
		function display_slider() {
			include(plugin_dir_path(__FILE__) . 'admin/partials/advanced-custom-post-type-admin-display.php');
		}

		register_taxonomy( 'writer', 'books', $args );
	}
}
