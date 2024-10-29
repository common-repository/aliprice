<?php
/**
 * Created by AL1.
 * User: Dmitry Nizovsky
 * Date: 29.01.15
 * Time: 18:40
 */

$tw = get_option('thumbnail_size_w');
$th = get_option('thumbnail_size_h');

$mw = get_option('medium_size_w');
$mh = get_option('medium_size_h');

$lw = get_option('large_size_w');
$lh = get_option('large_size_h');

$font_g_url  = get_option('ssdma_font_family_global_url');
$font_g_name = get_option('ssdma_font_family_global_name');

$font_h_url  = get_option('ssdma_font_family_header_url');
$font_h_name = get_option('ssdma_font_family_header_name');

?>

<?php if($font_h_url && $font_h_name): ?>
    @import url(<?php echo $font_h_url; ?>);

    h1,h2,h3,h4,h5,h6 {
    <?php echo $font_h_name; ?>
    }
<?php endif; ?>

<?php if($font_g_url && $font_g_name): ?>
    @import url(<?php echo $font_g_url; ?>);

    body {
        <?php echo $font_g_name; ?>
    }
<?php endif; ?>

.gallery-size-thumbnail .gallery-item {
    width: <?php echo $tw; ?>px;
    height: <?php echo $th; ?>px;
}
.gallery-size-medium .gallery-item {
    width: <?php echo $mw; ?>px;
    height: <?php echo $mh; ?>px;
}
.gallery-size-large .gallery-item {
    width: <?php echo $lw; ?>px;
    height: <?php echo $lh; ?>px;
}