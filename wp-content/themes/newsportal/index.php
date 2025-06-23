<?php
/**
 * The main template file
 *
 * @package NewsPortal
 */

get_header();
?>

<main class="main-content">
    <div class="container">
        <?php
        if ( have_posts() ) :
            // Featured Article
            get_template_part( 'template-parts/featured', 'post' );
            
            // News Grid
            echo '<section class="news-grid">';
            echo '<div class="section-header">';
            echo '<h3>' . esc_html__( 'Latest News', 'newsportal' ) . '</h3>';
            echo '<div class="view-all"><a href="' . esc_url( get_permalink( get_option( 'page_for_posts' ) ) ) . '">' . esc_html__( 'View All', 'newsportal' ) . '</a></div>';
            echo '</div>';
            
            echo '<div class="grid-container">';
            while ( have_posts() ) :
                the_post();
                get_template_part( 'template-parts/content', 'grid' );
            endwhile;
            echo '</div>';
            echo '</section>';
            
            // Pagination
            the_posts_pagination( array(
                'prev_text' => '<i class="fas fa-chevron-left"></i>',
                'next_text' => '<i class="fas fa-chevron-right"></i>',
                'before_page_number' => '<span class="meta-nav screen-reader-text">' . esc_html__( 'Page', 'newsportal' ) . ' </span>',
            ) );
            
        else :
            get_template_part( 'template-parts/content', 'none' );
        endif;
        ?>
    </div>
</main>

<?php
get_sidebar();
get_footer();
