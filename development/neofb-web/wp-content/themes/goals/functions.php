<?php
// Runs php script in text widget
add_filter('widget_text','execute_php',100);
function execute_php($html){
     if(strpos($html,"<"."?php")!==false){
          ob_start();
          eval("?".">".$html);
          $html=ob_get_contents();
          ob_end_clean();
     }
     return $html;
}	
/**
 * Register our sidebars and widgetized areas.
 *
 */
function socmed_widgets_init() {

	register_sidebar( array(
		'name'          => 'Top Bar Right',
		'id'            => 'top_bar_1',
		'before_widget' => '<div class="col-xs-12 col-sm-3 fb-socmed">',
		'after_widget'  => '</div>',
		'before_title'  => ' ',
		'after_title'   => ' ',
	) );

}
add_action( 'widgets_init', 'socmed_widgets_init' );

add_filter('widget_title','top_bar_1');
function top_bar_1($t) {
	return null;
}

function chat_widgets_init() {

	register_sidebar( array(
		'name'          => 'Header Right',
		'id'            => 'header_right',
		'before_widget' => '<div class="col-xs-12 col-sm-8">',
		'after_widget'  => '</div>',
		'before_title'  => ' ',
		'after_title'   => ' ',
	) );

}
add_action( 'widgets_init', 'chat_widgets_init' );

add_filter('widget_title','header_right');
function header_right($t) {
	return null;
}

function logo_widgets_init() {

	register_sidebar( array(
		'name'          => 'Logo',
		'id'            => 'logo',
		'before_widget' => '<div class="col-xs-12 col-sm-4">',
		'after_widget'  => '</div>',
		'before_title'  => ' ',
		'after_title'   => ' ',
	) );

}
add_action( 'widgets_init', 'logo_widgets_init' );

add_filter('widget_title','logo');
function logo($t) {
	return null;
}

function apply_widgets_init() {

	register_sidebar( array(
		'name'          => 'Apply',
		'id'            => 'apply',
		'before_widget' => '<div class="col-xs-12 fb-col-content fb-col-regis">',
		'after_widget'  => '</div>',
		'before_title'  => ' ',
		'after_title'   => ' ',
	) );

}
add_action( 'widgets_init', 'apply_widgets_init' );

add_filter('widget_title','apply');
function apply($t) {
	return null;
}

// Navigations
function register_menus() {
  register_nav_menus(
    array(
      'header-menu' => __( 'Header Menu' ),
      'footer-produk-menu' => __( 'Footer Produk Menu' ),
      'footer-support-menu' => __( 'Footer Support Menu' )
    )
  );
}
add_action( 'init', 'register_menus' );


// custom menu example @ https://digwp.com/2011/11/html-formatting-custom-menus/
function custom_menus_header() {
	$menu_name = 'header-menu'; // specify custom menu slug
	if (($locations = get_nav_menu_locations()) && isset($locations[$menu_name])) {
		$menu = wp_get_nav_menu_object($locations[$menu_name]);
		$menu_items = wp_get_nav_menu_items($menu->term_id);

		$menu_list = '<div class="col-xs-12 fb-col-menu">' ."\n";
		$menu_list .= "\t\t\t\t". '<ul class="list-inline fb-ul-menu">' ."\n";
		foreach ((array) $menu_items as $key => $menu_item) {
			$title = $menu_item->title;
			$url = $menu_item->url;
			$menu_list .= "\t\t\t\t\t". '<li><a href="'. $url .'">'. $title .'</a></li>' ."\n";
		}
		$menu_list .= "\t\t\t\t". '</ul>' ."\n";
		$menu_list .= "\t\t\t". '</div>' ."\n";
	} else {
		// $menu_list = '<!-- no list defined -->';
	}
	echo $menu_list;
}

// SHORTCODES

// [highlight]Highlighted paragraph here[/highlight]

function func_high( $atts, $content = NULL ) {
		return '<div class="highlight">'.do_shortcode($content).'</div>';
}
add_shortcode( 'highlight', 'func_high' );


function func_mark( $atts, $content = NULL ) {
		return '<mark>'.do_shortcode($content).'</mark>';
}
add_shortcode( 'mark', 'func_mark' );

// END SHORTCODES
?>