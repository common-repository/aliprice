<?php echo $args['before_widget']; ?><?php if($instance['atitle']): ?><div class="text-header text-header__bg-red"><h3 class="widget-title">
	
<a href="<?php the_term_link( $instance['cat']); ?>"><?php the_term_title( $instance['cat']); ?></a></h3></div>
<div class="aliframe-window">
    <iframe src=''  width='100%' height=''  frameborder='0' marginwidth='0' marginheight='0' vspace='0' hspace='0' scrolling='no'  ></iframe>
</div>
<?php else: ?><div class="text-header text-header__bg-red"><h3 class="widget-title"><?php echo $instance['title']; ?></h3>
</div>

<?php endif; ?>
<?php $params = array( 'orderby' => $instance['order'], 'posts_per_page' => $instance['count'], 'paged' => 0, 'pre_process' => false ); ssdma_posts_process('products', $params, $instance['cat']); ?><div class="b-products base-mar-b-20 b-products-big text-md-left text-sm-center text-xs-center"><?php while ( have_posts() ) : the_post(); ?><?php get_template_part( 'templates/product' ); ?><?php endwhile; ?></div><?php wp_reset_query(); ?><?php echo $args['after_widget']; ?>
