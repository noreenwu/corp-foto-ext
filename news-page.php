<?php 
/* Template Name: News 
 *
 * This is the template that displays all News pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package corp-foto-ext
 */

get_header(); 

?>

	<div class="wrapper singular-section">
		<div id="primary" class="content-area">
			<main id="main" class="site-main" role="main">
				<?php

				while ( have_posts() ) : the_post();

					get_template_part( 'components/page/content', 'page' );

					get_template_part( 'components/post/content', 'comments' );

				endwhile; // End of the loop.
				?>
			</main><!-- #main -->
		</div><!-- #primary -->
		<?php get_sidebar(); ?>
	</div><!-- .wrapper -->
<?php
get_footer();
