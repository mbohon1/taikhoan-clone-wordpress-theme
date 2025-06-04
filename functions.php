<?php
/**
 * Taikhoan Clone Theme functions and definitions
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Theme Setup
function taikhoan_setup() {
    // Add default posts and comments RSS feed links to head
    add_theme_support('automatic-feed-links');

    // Let WordPress manage the document title
    add_theme_support('title-tag');

    // Enable support for Post Thumbnails on posts and pages
    add_theme_support('post-thumbnails');

    // Register Navigation Menus
    register_nav_menus(array(
        'primary' => esc_html__('Primary Menu', 'taikhoan-clone'),
        'footer'  => esc_html__('Footer Menu', 'taikhoan-clone'),
    ));

    // Switch default core markup to output valid HTML5
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ));
}
add_action('after_setup_theme', 'taikhoan_setup');

// Enqueue scripts and styles
function taikhoan_scripts() {
    // Enqueue Google Fonts
    wp_enqueue_style('google-fonts', 'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap', array(), null);
    
    // Enqueue Font Awesome
    wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css', array(), '6.0.0');
    
    // Enqueue main stylesheet
    wp_enqueue_style('taikhoan-style', get_stylesheet_uri(), array(), '1.0.0');
    
    // Enqueue custom JavaScript
    wp_enqueue_script('taikhoan-script', get_template_directory_uri() . '/assets/js/main.js', array('jquery'), '1.0.0', true);
}
add_action('wp_enqueue_scripts', 'taikhoan_scripts');

// Register Custom Post Type for Products
function taikhoan_register_post_types() {
    $labels = array(
        'name'               => _x('Products', 'post type general name', 'taikhoan-clone'),
        'singular_name'      => _x('Product', 'post type singular name', 'taikhoan-clone'),
        'menu_name'          => _x('Products', 'admin menu', 'taikhoan-clone'),
        'add_new'            => _x('Add New', 'product', 'taikhoan-clone'),
        'add_new_item'       => __('Add New Product', 'taikhoan-clone'),
        'edit_item'          => __('Edit Product', 'taikhoan-clone'),
        'new_item'           => __('New Product', 'taikhoan-clone'),
        'view_item'          => __('View Product', 'taikhoan-clone'),
        'search_items'       => __('Search Products', 'taikhoan-clone'),
        'not_found'          => __('No products found', 'taikhoan-clone'),
        'not_found_in_trash' => __('No products found in Trash', 'taikhoan-clone'),
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'      => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'product'),
        'capability_type'   => 'post',
        'has_archive'       => true,
        'hierarchical'      => false,
        'menu_position'     => 5,
        'supports'          => array('title', 'editor', 'thumbnail', 'excerpt'),
        'menu_icon'         => 'dashicons-cart',
    );

    register_post_type('product', $args);
}
add_action('init', 'taikhoan_register_post_types');

// Register Custom Taxonomy for Product Categories
function taikhoan_register_taxonomies() {
    $labels = array(
        'name'              => _x('Product Categories', 'taxonomy general name', 'taikhoan-clone'),
        'singular_name'     => _x('Product Category', 'taxonomy singular name', 'taikhoan-clone'),
        'search_items'      => __('Search Product Categories', 'taikhoan-clone'),
        'all_items'         => __('All Product Categories', 'taikhoan-clone'),
        'parent_item'       => __('Parent Product Category', 'taikhoan-clone'),
        'parent_item_colon' => __('Parent Product Category:', 'taikhoan-clone'),
        'edit_item'         => __('Edit Product Category', 'taikhoan-clone'),
        'update_item'       => __('Update Product Category', 'taikhoan-clone'),
        'add_new_item'      => __('Add New Product Category', 'taikhoan-clone'),
        'new_item_name'     => __('New Product Category Name', 'taikhoan-clone'),
        'menu_name'         => __('Categories', 'taikhoan-clone'),
    );

    $args = array(
        'hierarchical'      => true,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'product-category'),
    );

    register_taxonomy('product_category', array('product'), $args);
}
add_action('init', 'taikhoan_register_taxonomies');

// Add custom meta boxes for product details
function taikhoan_add_product_meta_boxes() {
    add_meta_box(
        'product_details',
        __('Product Details', 'taikhoan-clone'),
        'taikhoan_product_details_callback',
        'product',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'taikhoan_add_product_meta_boxes');

// Meta box callback function
function taikhoan_product_details_callback($post) {
    // Add nonce for security
    wp_nonce_field('taikhoan_product_details', 'taikhoan_product_details_nonce');

    // Get existing values
    $price = get_post_meta($post->ID, '_product_price', true);
    $stock = get_post_meta($post->ID, '_product_stock', true);
    $sold = get_post_meta($post->ID, '_product_sold', true);

    ?>
    <p>
        <label for="product_price"><?php _e('Price:', 'taikhoan-clone'); ?></label>
        <input type="text" id="product_price" name="product_price" value="<?php echo esc_attr($price); ?>">
    </p>
    <p>
        <label for="product_stock"><?php _e('Stock Available:', 'taikhoan-clone'); ?></label>
        <input type="number" id="product_stock" name="product_stock" value="<?php echo esc_attr($stock); ?>">
    </p>
    <p>
        <label for="product_sold"><?php _e('Units Sold:', 'taikhoan-clone'); ?></label>
        <input type="number" id="product_sold" name="product_sold" value="<?php echo esc_attr($sold); ?>">
    </p>
    <?php
}

// Save product meta box data
function taikhoan_save_product_meta($post_id) {
    // Check if nonce is set
    if (!isset($_POST['taikhoan_product_details_nonce'])) {
        return;
    }

    // Verify nonce
    if (!wp_verify_nonce($_POST['taikhoan_product_details_nonce'], 'taikhoan_product_details')) {
        return;
    }

    // If this is an autosave, don't do anything
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    // Check user permissions
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    // Save meta box data
    if (isset($_POST['product_price'])) {
        update_post_meta($post_id, '_product_price', sanitize_text_field($_POST['product_price']));
    }
    if (isset($_POST['product_stock'])) {
        update_post_meta($post_id, '_product_stock', sanitize_text_field($_POST['product_stock']));
    }
    if (isset($_POST['product_sold'])) {
        update_post_meta($post_id, '_product_sold', sanitize_text_field($_POST['product_sold']));
    }
}
add_action('save_post', 'taikhoan_save_product_meta');
