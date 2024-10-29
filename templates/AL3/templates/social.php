<?php 
global $ali3;
$facebook = $ali3->ssdma_social_facebook;
$gplus = $ali3->ssdma_social_gplus;
$twitter = $ali3->ssdma_social_twitter;
$youtube = $ali3->ssdma_social_youtube;
$pinterest = $ali3->ssdma_social_pinterest;
$vk = $ali3->ssdma_social_vk;
$attr_facebook = ' href="#" target="_blank" onclick="window.open(\'https://www.facebook.com/sharer/sharer.php?u=\'+encodeURIComponent(location.href), \'facebook-share-dialog\', \'width=626,height=436\');  return false;" ';
$attr_twitter = ' href="https://twitter.com/share" data-count="none" target="_blank" ';
$attr_gplus = ' href="https://plus.google.com/share?url=' . esc_url(home_url(add_query_arg(array()))) . '" onclick="javascript:window.open(this.href,\'\', \'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600\'); return false;" target="_blank" ';
$attr_youtube = '';
$attr_pinterest = '';
$attr_vk = ' href="http://vk.com/share.php?url=' . esc_url(home_url(add_query_arg(array()))) . '" onclick="javascript:window.open(this.href,\'\', \'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600\'); return false;" target="_blank"';
if ($facebook != '') {
    $attr_facebook = ' href="' . $facebook . '" ';
}
if ($gplus != '') {
    $attr_gplus = ' href="' . $gplus . '" ';
}
if ($twitter != '') {
    $attr_twitter = ' href="' . $twitter . '" ';
} 
if ($youtube != '') {
    $attr_youtube = ' href="' . $youtube . '" ';
}
if ($pinterest != '') {
    $attr_pinterest = ' href="' . $pinterest . '" ';
}
if ($vk != '') {
    $attr_vk = ' href="' . $vk . '" ';
}
?>
<li><a class="b-social-item" rel="nofollow" <?php echo $attr_facebook; ?>><span
            class="b-social-icon-facebook"></span></a></li>
<li><a class="b-social-item" rel="nofollow" <?php echo $attr_twitter; ?>><span class="b-social-icon-twitter"></span></a>
</li>
<li><a class="b-social-item" rel="nofollow" <?php echo $attr_gplus; ?>><span class="b-social-icon-gplus"></span></a>
</li>
<li><a class="b-social-item" rel="nofollow" <?php echo $attr_youtube; ?>><span class="b-social-icon-youtube"></span></a>
</li>
<li><a class="b-social-item" rel="nofollow" <?php echo $attr_pinterest; ?>><span class="b-social-icon-pinterest"></span></a>
</li>
<li><a class="b-social-item" rel="nofollow" <?php echo $attr_vk; ?>><span class="b-social-icon-vk"></span></a>
</li>