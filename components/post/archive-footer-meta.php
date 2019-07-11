<?php
/**
 * Footer meta for archive pages
 * Display author and comment
 * @packageCorporate_Fotografie
 */

?>

<?php if ( ! is_single() && ! post_password_required() ) : ?>
	<footer class="entry-footer entry-meta">
		<?php corporatefotografie_entry_author(); ?>
		<?php if ( comments_open() || get_comments_number() ) :
			corporatefotografie_entry_comment(); ?>
		<?php endif; ?>
	</footer><!-- .entry-meta -->
<?php endif;

