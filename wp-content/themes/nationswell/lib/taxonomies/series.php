<?php
/**
 * Add custom series taxonomy
 *
 * http://codex.wordpress.org/Function_Reference/register_taxonomy
 */
function add_custom_series_taxonomy() {
    // Add new "Series" taxonomy to Posts
    register_taxonomy('series', 'post', array(
            'hierarchical' => false,
            'labels' => array(
                'name' => _x( 'Series', 'taxonomy general name' ),
                'singular_name' => _x( 'Series', 'taxonomy singular name' ),
                'search_items' =>  __( 'Search Series' ),
                'all_items' => __( 'All Series' ),
                'parent_item' => __( 'Parent Series' ),
                'parent_item_colon' => __( 'Parent Series:' ),
                'edit_item' => __( 'Edit Series' ),
                'update_item' => __( 'Update Series' ),
                'add_new_item' => __( 'Add New Series' ),
                'new_item_name' => __( 'New Series Name' ),
                'menu_name' => __( 'Series' ),
            ),

            'rewrite' => array('slug' => 'series'),
        ));
}
add_action('init', 'add_custom_series_taxonomy', 0);