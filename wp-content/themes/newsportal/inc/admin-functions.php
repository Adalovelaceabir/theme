<?php
/**
 * Custom Admin Panel for NewsPortal
 */

// Add custom admin menu
function newsportal_admin_menu() {
    add_menu_page(
        'NewsPortal Dashboard',
        'NewsPortal',
        'manage_options',
        'newsportal-dashboard',
        'newsportal_admin_dashboard',
        'dashicons-admin-site',
        2
    );
    
    add_submenu_page(
        'newsportal-dashboard',
        'NewsPortal Dashboard',
        'Dashboard',
        'manage_options',
        'newsportal-dashboard'
    );
    
    add_submenu_page(
        'newsportal-dashboard',
        'NewsPortal Settings',
        'Settings',
        'manage_options',
        'newsportal-settings',
        'newsportal_admin_settings'
    );
    
    add_submenu_page(
        'newsportal-dashboard',
        'Ad Management',
        'Ad Management',
        'manage_options',
        'newsportal-ads',
        'newsportal_admin_ads'
    );
}
add_action( 'admin_menu', 'newsportal_admin_menu' );

// Admin dashboard page
function newsportal_admin_dashboard() {
    if ( !current_user_can( 'manage_options' ) ) {
        wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
    }
    
    include get_template_directory() . '/admin/dashboard.php';
}

// Admin settings page
function newsportal_admin_settings() {
    if ( !current_user_can( 'manage_options' ) {
        wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
    }
    
    include get_template_directory() . '/admin/settings.php';
}

// Admin ads page
function newsportal_admin_ads() {
    if ( !current_user_can( 'manage_options' ) {
        wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
    }
    
    include get_template_directory() . '/admin/ads.php';
}

// Enqueue admin styles and scripts
function newsportal_admin_scripts( $hook ) {
    if ( strpos( $hook, 'newsportal' ) !== false ) {
        wp_enqueue_style( 'newsportal-admin', get_template_directory_uri() . '/admin/css/admin.css' );
        wp_enqueue_script( 'newsportal-admin', get_template_directory_uri() . '/admin/js/admin.js', array( 'jquery' ), false, true );
    }
}
add_action( 'admin_enqueue_scripts', 'newsportal_admin_scripts' );

// Custom admin dashboard widgets
function newsportal_admin_dashboard_widgets() {
    wp_add_dashboard_widget(
        'newsportal_stats_widget',
        'NewsPortal Stats',
        'newsportal_stats_widget_content'
    );
}
add_action( 'wp_dashboard_setup', 'newsportal_admin_dashboard_widgets' );

function newsportal_stats_widget_content() {
    $posts_count = wp_count_posts()->publish;
    $pages_count = wp_count_posts( 'page' )->publish;
    $comments_count = wp_count_comments()->total_comments;
    
    echo '<div class="newsportal-stats">';
    echo '<div class="stat-item"><span class="stat-number">' . $posts_count . '</span><span class="stat-label">Posts</span></div>';
    echo '<div class="stat-item"><span class="stat-number">' . $pages_count . '</span><span class="stat-label">Pages</span></div>';
    echo '<div class="stat-item"><span class="stat-number">' . $comments_count . '</span><span class="stat-label">Comments</span></div>';
    echo '</div>';
}

// Custom admin columns for posts
function newsportal_custom_post_columns( $columns ) {
    $columns['featured_image'] = 'Featured Image';
    $columns['post_views'] = 'Views';
    return $columns;
}
add_filter( 'manage_posts_columns', 'newsportal_custom_post_columns' );

function newsportal_custom_post_columns_data( $column, $post_id ) {
    switch ( $column ) {
        case 'featured_image':
            if ( has_post_thumbnail( $post_id ) ) {
                echo get_the_post_thumbnail( $post_id, 'thumbnail' );
            } else {
                echo '—';
            }
            break;
        case 'post_views':
            $views = get_post_meta( $post_id, 'post_views', true );
            echo $views ? $views : '0';
            break;
    }
}
add_action( 'manage_posts_custom_column', 'newsportal_custom_post_columns_data', 10, 2 );
