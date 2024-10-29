<?php /** * Created by AL1. * User: Dmitry Nizovsky * Date: 12.02.15 * Time: 17:43 */ ?>
<div class="b-grid-p-left b-margin-base"><section id="primary" class="content-area"><div id="content" class="site-content b-posts" role="main"><?php if ( have_posts() ): ?>
<?php while ( have_posts() ) : the_post(); ?>
	<?php get_template_part( 'templates/content', get_post_format() ); ?>
<?php endwhile; ?><div class="text-center">
<?php ssdma_paging_nav(); ?></div>
<?php else: ?>
	<?php get_template_part( 'templates/content', 'none' ); ?>
<?php endif; ?></div></section></div>
<div class="b-grid-p-right b-margin-base"><?php $info = new AEProducts(); $post_ids = $info->bestSellers(16); ssdma_posts_process('products', array( 'posts_per_page' => 16, 'paged' => 0, 'post__in' => $post_ids )); ?><?php if ( have_posts() ): ?>
<div class="b-products b-products__min">
	<div class="aliframe-window">
	    <iframe src='' width='' height="" frameborder='0' marginwidth='0' marginheight='0' vspace='0' hspace='0' scrolling='no'  ></iframe>
	</div>
	<?php while ( have_posts() ) : the_post(); ?><?php get_template_part( 'templates/product' ); ?><?php endwhile; ?></div><div class="text-center"><?php ssdma_paging_nav(); ?>
</div>
<?php else: ?><?php get_template_part( 'templates/content', 'none' ); ?><?php endif; ?></div>