<?php /** * Created by SSDMAThemes. * User: Dmitry Nizovsky * Date: 13.01.15 * Time: 15:54 */ ?><!DOCTYPE html><!--[if lt IE 7]><html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8 lt-ie7" itemscope itemtype="http://schema.org/WebPage"><![endif]--><!--[if IE 7]><html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8" itemscope itemtype="http://schema.org/WebPage"><![endif]--><!--[if IE 8]><html <?php language_attributes(); ?> class="no-js lt-ie9" itemscope itemtype="http://schema.org/WebPage"><![endif]--><!--[if gt IE 8]><html <?php language_attributes(); ?> class="no-js" itemscope itemtype="http://schema.org/WebPage"><!--<![endif]--><head><title><?php wp_title('|', true, 'right'); ?></title><meta charset="<?php bloginfo( 'charset' ); ?>" /><meta http-equiv="X-UA-Compatible" content="IE=edge"><meta name="viewport" content="width=device-width, initial-scale=1"><link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/favicon.ico" /><link href="http://fonts.googleapis.com/css?family=Monoton" rel="stylesheet" type="text/css"/><link href="http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800" rel="stylesheet" type="text/css"/><link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/public/css/bootstrap.min.css" type="text/css" media="all"><style type="text/css">body{background-color:#111}div.p404{padding:40px;font-size:75px;font-family:'Monoton',cursive;text-align:center;text-transform:uppercase;text-shadow:0 0 80px red,0 0 30px FireBrick,0 0 6px DarkRed;color:red}div.p404 p{margin:0}#error:hover{text-shadow:0 0 200px #fff,0 0 80px #008000,0 0 6px #00f}#code:hover{text-shadow:0 0 100px red,0 0 40px FireBrick,0 0 8px DarkRed}#error{color:#fff;text-shadow:0 0 80px #fff,0 0 30px #008000,0 0 6px #00f}#error span{animation:upper 11s linear infinite}#code span:nth-of-type(2){animation:lower 10s linear infinite}#code span:nth-of-type(1){text-shadow:none;opacity:.4}@keyframes upper{0%,19.999%,22%,62.999%,64%,64.999%,70%,100%{opacity:.99;text-shadow:0 0 80px #fff,0 0 30px #008000,0 0 6px #00f}20%,21.999%,63%,63.999%,65%,69.999%{opacity:.4;text-shadow:none}}@keyframes lower{0%,12%,18.999%,23%,31.999%,37%,44.999%,46%,49.999%,51%,58.999%,61%,68.999%,71%,85.999%,96%,100%{opacity:.99;text-shadow:0 0 80px red,0 0 30px FireBrick,0 0 6px DarkRed}19%,22.99%,32%,36.999%,45%,45.999%,50%,50.99%,59%,60.999%,69%,70.999%,86%,95.999%{opacity:.4;text-shadow:none}}.b-search{max-width:600px;margin:20px auto}.b-search__caption{color:#fff;font:24px 'Open Sans',sans-serif;text-align:center;margin-bottom:50px}.b-search__field{width:100%}</style></head><body <?php body_class(); ?>><div class="p404"><p id="error">E<span>r</span>ror</p><p id="code">4<span>0</span><span>4</span></p></div><div class="b-search"><div class="b-search__caption"><p><?php _e( 'It looks like nothing was found at this location. Maybe try a search?', 'ssdma' ); ?></p></div><div class="b-search__field"><form method="GET" action="<?php echo esc_url( home_url('/') ); ?>"><div class="input-group"><input type="text" name="s" class="form-control input-lg"><span class="input-group-btn input-group-lg"><button class="btn btn-default btn-lg" type="submit"><?php _e( 'Search', 'ssdma' ); ?></button></span></div></form></div></div></body></html>