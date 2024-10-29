<?php
        $post_id = get_the_ID();
        $info    = new AEProducts();
        $info->set($post_id);

$image       = ssdma_image_get_alt( array($info->getThumb()), true );

 ?>
<ul>
	<li>
		<a rel="nofollow" href="#" target="_blank" onclick="window.open('https://www.facebook.com/sharer/sharer.php?u='+encodeURIComponent(location.href), 'facebook-share-dialog', 'width=626,height=436');  return false;">
			<span class="b-social-icon-facebook-squared"></span>
		</a>
	</li>
	<li>
	<script> var descr='123';</script>
		<a rel="nofollow" href="#" target="_blank" onclick="window.open('http://pinterest.com/pin/create/button/?media=<?php echo $image['url'];?>&url='+this.href,'_blank', 'width=700, height=300'); return false;">
			<span class="b-social-icon-pinterest-squared"></span></a></li><li><a rel="nofollow" href="<?php echo esc_url('https://twitter.com/share'); ?>" data-count="none" target="_blank"><span class="b-social-icon-twitter-squared"></span>
		</a>
	</li>
	<li>
		<a rel="nofollow" href="https://plus.google.com/share?url=<?php echo esc_url(home_url(add_query_arg(array()))); ?>" onclick="javascript:window.open(this.href,'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600'); return false;" target="_blank">
		<span class="b-social-icon-gplus-squared"></span>
		</a>
	</li>
</ul>