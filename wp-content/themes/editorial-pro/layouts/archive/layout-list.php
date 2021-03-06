<?php
/**
 * Template part for displaying archive loop post in classic layout.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Mystery Themes
 * @subpackage Editorial Pro
 * @since 1.0.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?>>
	
	<div class="post-image">
		<a href="<?php the_permalink();?>" title="<?php the_title();?>">
			<figure>
				<?php
					if( has_post_thumbnail() ) {
						the_post_thumbnail( 'editorial-block-medium' );
					} else {
						$image_src = editorial_pro_image_fallback( 'editorial-block-medium' );
                        echo '<img src="'. $image_src[0] .'"/>';
					}
				?>
			</figure>
		</a>
		<?php do_action( 'editorial_pro_post_categories' ); ?>
	</div>

	<div class="archive-desc-wrapper clearfix">
		<header class="entry-header">
			<?php
				the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
			?>
		</header><!-- .entry-header -->	
		<div class="entry-content">
			<div class="entry-meta">
				<?php 
					editorial_pro_posted_on();
					editorial_pro_post_comment();
				?>
			</div><!-- .entry-meta -->
			<?php
				$excerpt_length = get_theme_mod( 'archive_excerpt_length', '70' );
				$post_content = get_the_content();
				echo wp_trim_words( $post_content, $excerpt_length, '' );
			?>
		</div><!-- .entry-content -->

		<?php editorial_pro_archive_readmore(); ?>

		<footer class="entry-footer">
			<?php editorial_pro_entry_footer(); ?>
		</footer><!-- .entry-footer -->
	</div><!-- .archive-desc-wrapper -->
</article><!-- #post-## -->