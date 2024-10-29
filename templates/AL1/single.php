<?php /** * Created by SSDMAThemes. * User: Dmitry Nizovsky * Date: 13.01.15 * Time: 15:52 */ ?><?php get_header(); ?><div class="container">
<?php get_template_part( 'templates/breadcrumbs' ); ?>
<h1 class="b-margin-base"><?php the_title(); ?></h1><?php get_template_part( 'templates/single', get_post_format() ); ?><?php comments_template(); ?></div><?php get_footer(); ?>