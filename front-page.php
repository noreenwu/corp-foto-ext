<?php
/**
 * The static front page template
 *
 * @package Fotografie
 */

if ( 'posts' === get_option( 'show_on_front' ) ) :

	get_template_part( 'index' );

else :

	get_header();

	?>
		<div class="wrapper singular-section">
			<div id="primary" class="content-area">
				<main id="main" class="site-main" role="main">
				

		<?php		
$args = array(
  'post_type' => 'post' ,
  'orderby' => 'date' ,
  'order' => 'DESC' ,
  'posts_per_page' => 6,
  'category_name' => 'homepage',
  'paged' => get_query_var('paged'),
  'post_parent' => $parent
); 
$q = new WP_Query($args);
if ( $q->have_posts() ) { 
  while ( $q->have_posts() ) {
    $q->the_post();
    // your loop
    the_title( '<h3>', '</h3>' );
	the_content();
  }
}
?>	
					<!-- removing original loop which displayed Did you know--
						the page that is chosen from Customize as the static page
						shown on the homepage -->

					
				</main><!-- #main -->
			</div><!-- #primary -->
			<?php get_sidebar(); ?>
		</div><!-- .singular-section -->
	<?php
	if ( get_theme_mod( 'fotografie_enable_static_page_posts' ) ) {
	?>
		<div id="primary" class="content-area">
			<main id="main" class="site-main" role="main">
				<?php get_template_part( 'components/features/recent-posts/recent-posts' ); ?>
			</main><!-- #main -->
		</div><!-- #primary -->
	<?php
	}
get_footer();

endif;
