<?php /** * Created by AL1. * User: Dmitry Nizovsky * Date: 16.02.15 * Time: 12:40 */ ?>
<div class="wrap"><?php if ( isset( $_GET['option'] ) ): ?>
		<div class="secret-section"><?php get_template_part( 'templates/uploads' ); ?>
		<div class="clear"></div>
		<hr/>
		<div class="menu-reset"><h3>Reset Menu</h3>

			<form method="POST"><input type="hidden" name="menu_reset" value="1"/>
				<button type="submit" class="button button-primary">Reset Menu</button>
			</form>
		</div>
		<hr/></div><?php endif; ?><?php if ( isset( $_GET['copyright'] ) ): ?>
		<div class="ssdma-validator"><h3>Copyright</h3>

		<form method="POST"><input type="text" name="ssdma_copyright"
		                           value="<?php echo get_option( 'ssdma_copyright' ); ?>"
		                           placeholder="<?php _e( 'Enter copyright text', 'ssdma' ); ?>"/>
			<button type="submit" class="button button-primary">Save</button>
		</form>
		<hr/></div><?php endif; ?>
	<style type="text/css">.ssdma-validator, .ssdma-description {
			width: 80%;
			margin: 50px auto 20px auto
		}

		.ssdma-validator .ssdma-validator-item {
			width: 33%;
			min-width: 250px;
			float: left;
			text-align: center
		}

		.ssdma-lists {
			margin-left: 30px;
			list-style: disc
		}

		.ssdma-validator h2 {
			margin-bottom: 30px
		}</style>
	<div class="ssdma-validator"><h2><?php _e( 'About', 'ssdma' ); ?></h2>

		<div class="clear"></div>
		<div class="ssdma-validator-item ssdma-validator-html"><a
				href="http://validator.w3.org/check?uri=<?php echo esc_url( home_url( '' ) ); ?>&charset=%28detect+automatically%29&doctype=Inline&group=0"><img
					src="<?php echo get_template_directory_uri(); ?>/public/images/html5.png" alt="HTML5 Validate"/>

				<p><?php _e( '100% Clean HTML', 'ssdma' ); ?></p></a></div>
		<div class="ssdma-validator-item ssdma-validator-css"><a
				href="http://jigsaw.w3.org/css-validator/validator?uri=<?php echo esc_url( home_url( '' ) ); ?>&profile=css3&usermedium=all&warning=1&vextwarning="><img
					src="<?php echo get_template_directory_uri(); ?>/public/images/css3.png" alt="CSS3 Validate"/>

				<p><?php _e( '100% Valid CSS', 'ssdma' ); ?></p></a></div>
		<div class="ssdma-validator-item ssdma-validator-theme"><a
				href="http://themecheck.org/score/wordpress_theme_al2.html"><img
					src="http://themecheck.org/img/shieldperfect240.png" alt="Theme Validate"/>

				<p><?php _e( 'WP validation score: 100 %', 'ssdma' ); ?></p></a></div>
		<div class="clear"></div>
	</div>
	<div class="ssdma-description">
		<p><?php _e( 'AliTwo is a WordPress theme created for building AliExpress affiliate websites based on AliPrice. The Theme has a clean, completely responsive design and created with most modern technologies. We hope you will enjoy it and have a good time developing your affiliate sites and earning with AliExpress.', 'ssdma' ); ?></p>

		<h3><?php _e( 'Fully Responsive Layout', 'ssdma' ); ?></h3>

		<p><?php _e( 'AliOne WordPress theme works well on many different kinds of screens with resolutions ranging from PC desktops to smart phones.', 'ssdma' ); ?></p>

		<h3><?php _e( 'Elegant Clean Design', 'ssdma' ); ?></h3>

		<p><?php _e( 'Elegant and stylish minimalistic design of AliOne theme is created to meet all modern requirements and trends of successful online stores.', 'ssdma' ); ?></p>

		<h3><?php _e( 'Easy to Customize', 'ssdma' ); ?></h3>

		<p><?php _e( 'You can personalize your site with a custom logo, header, background, widgets, banners, social media links, etc. The theme includes a special customization menu for making any changes quick and easily.', 'ssdma' ); ?></p>

		<h3><?php _e( 'Features', 'ssdma' ); ?></h3>
		<strong><?php _e( 'AliTwo Theme is bundled with all necessary features. Some highlights are:', 'ssdma' ); ?></strong>
		<ul class="ssdma-lists">
			<li><?php _e( 'SEO Friendly', 'ssdma' ); ?></li>
			<li><?php _e( 'Clean Code', 'ssdma' ); ?></li>
			<li><?php _e( 'Translation Ready', 'ssdma' ); ?></li>
			<li><?php _e( 'Easy Theme Options', 'ssdma' ); ?></li>
			<li><?php _e( 'Social Media Links', 'ssdma' ); ?></li>
			<li><?php _e( 'HTML5 & CSS3', 'ssdma' ); ?></li>
			<li><?php _e( 'Cross Browser Compatible', 'ssdma' ); ?></li>
			<li><?php _e( 'Detailed Documentation', 'ssdma' ); ?></li>
			<li><?php _e( 'Regular Updates', 'ssdma' ); ?></li>
			<li><?php _e( 'And much more', 'ssdma' ); ?>...</li>
		</ul>
		<h3><?php _e( 'Theme Support', 'ssdma' ); ?></h3>

		<p><?php _e( 'Using this Theme you receive regular updates and constant support. We will help you to set up the theme and guide you through any issues that may arise.', 'ssdma' ); ?></p>
	</div>
	<div class="clear"></div>
</div>