<?php /** * Created by SSDMAThemes. * User: Dmitry Nizovsky * Date: 13.01.15 * Time: 15:53 */ ?>
<?php get_header(); ?>
<div class="container base-mar-t-20 base-mar-b-20">
	<?php get_template_part( 'templates/breadcrumbs' ); ?>
	<div class="grid-277 clearfix"><?php get_sidebar(); ?></div>
	<div class="grid-900 grid-m-23 base-bg-white clearfix"><h1 class="page-title b-margin-base"><?php single_cat_title(); ?></h1><?php get_template_part( 'templates/catalog' ); ?></div>
	<div class="clearfix"></div>
</div>
<?php get_template_part( 'templates/footer-before' ); ?>

<?php get_footer(); ?>