<?php /** * Created by SSDMAThemes. * User: Dmitry Nizovsky * Date: 13.01.15 * Time: 15:51 */ ?><?php get_header(); ?>
	<div class="container">
	<h1><?php the_title(); ?></h1><?php while ( have_posts() ) : the_post(); ?><?php the_content(); ?><?php endwhile; ?><?php if ( has_post_thumbnail() ) {
	the_post_thumbnail();
} ?></div><?php get_footer(); ?>