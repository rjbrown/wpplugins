<?php
/**
 * @package RB_Sabot_Plugin
 * @version 1.0.0
 */
/*
Plugin Name: Sabot Plugin
Plugin URI: http://www.getuwired.com
Description: Sabot Custom Post tpyes and more
Author: RB
Version: 1.0.1
*/

function say_context() {
	/** These are the lyrics to Hello Dolly */
	$output = "Whats on the screen";


	// And then randomly choose a line.
	return wptexturize( $output );
}

// This just echoes the chosen line, we'll position it later.
function say() {
	$chosen = say_context();

	echo $chosen;
}

// Now we set that function up to execute when the admin_notices action is called.
add_action( 'admin_notices', 'Thank you for using Sabot' );



/* Now we must set up the cstom post type */

function rb_sabot_products_post_type() {
    register_post_type('sabot_product',
        array(
            'labels'      => array(
                'name'          => __('Products', 'textdomain'),
                'singular_name' => __('Product', 'textdomain'),
            ),
                'public'      => true,
                'has_archive' => true,
        )
    );
}
add_action('init', 'rb_sabot_products_post_type');




function rb_sabot_products_taxonomy() {
     $labels = array(
         'name'              => _x( 'Products', 'taxonomy general name' ),
         'singular_name'     => _x( 'Product', 'taxonomy singular name' ),
         'search_items'      => __( 'Search Products' ),
         'all_items'         => __( 'All Products' ),
         'parent_item'       => __( 'Parent Product' ),
         'parent_item_colon' => __( 'Parent Product:' ),
         'edit_item'         => __( 'Edit Product' ),
         'update_item'       => __( 'Update Product' ),
         'add_new_item'      => __( 'Add New Product' ),
         'new_item_name'     => __( 'New Product Name' ),
         'menu_name'         => __( 'Product' ),
     );
     $args   = array(
         'hierarchical'      => true,
         'labels'            => $labels,
         'show_ui'           => true,
         'show_admin_column' => true,
         'query_var'         => true,
         'rewrite'           => [ 'slug' => 'product' ],
     );
     register_taxonomy( 'sabot_product', [ 'post' ], $args );
}
add_action( 'init', 'rb_sabot_products_taxonomy' );






