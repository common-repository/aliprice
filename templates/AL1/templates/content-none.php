<?php /** * Created by SSDMAThemes. * User: Dmitry Nizovsky * Date: 13.01.15 * Time: 18:56 */ ?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="page-header"><h1 class="page-title"><?php _e( 'Nothing Found', 'ssdma' ); ?></h1></header>
	<div class="page-content"><?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>
			<p><?php printf( __( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'ssdma' ), admin_url( 'post-new.php' ) ); ?></p><?php elseif ( is_search() ) : ?>
			<p><?php _e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'ssdma' ); ?></p><?php get_search_form(); ?><?php else : ?>
			<p><?php _e( "It seems we can't find what you're looking for. Perhaps searching can help.", 'ssdma' ); ?></p><?php get_search_form(); ?><?php endif; ?>
	</div>
</article>