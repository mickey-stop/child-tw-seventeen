<!--Adding Bootstrap and style-->
<?php 
    function theme_styles() {

	wp_enqueue_style( 'bootstrap_css', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css' );
	wp_enqueue_style( 'main_css', get_template_directory_uri() . '/style.css' );

}
add_action( 'wp_enqueue_scripts', 'theme_styles');

?>

<?php 
//ACF Beginning
//Embeding ACF plugin in my theme
// 1. customize ACF path
add_filter('acf/settings/path', 'my_acf_settings_path');
 
function my_acf_settings_path( $path ) {
 
    // update path
    $path = get_stylesheet_directory() . '/acf/';
    
    // return
    return $path;
    
}
 

// 2. customize ACF dir
add_filter('acf/settings/dir', 'my_acf_settings_dir');
 
function my_acf_settings_dir( $dir ) {
 
    // update path
    $dir = get_stylesheet_directory_uri() . '/acf/';
    
    // return
    return $dir;
    
}
 

// 3. Hide ACF field group menu item
//add_filter('acf/settings/show_admin', '__return_false');


// 4. Include ACF
include_once( get_stylesheet_directory() . '/acf/acf.php' );
//ACF End
?>
<?php  
// Change number or products per row to 3
remove_filter('loop_shop_columns', 'loop_columns');
if (!function_exists('loop_columns')) {
	function loop_columns() {
		return ''; // 3 products per row
	}
}
?>

<!--My function added to show number of products in cart on shop page and single product page-->
<?php 
    function show_my_cart_number(){
        if( WC()->cart->get_cart_contents_count() > 0){ ?>
  <li>
    <a class="cart-contents" href="<?php echo wc_get_cart_url(); ?>" title="<?php _e( 'View my cart' ); ?>"><?php echo sprintf ( _n( '%d', '%d', WC()->cart->get_cart_contents_count() ), WC()->cart->get_cart_contents_count() ); ?>
    </a>
  </li>
  <?php } 
    }
?>
<?php add_action('woocommerce_before_main_content', 'show_my_cart_number'); ?>

<!--Adding tags to single product page-->
<?php add_action( 'woocommerce_single_product_summary', 'my_tags_product_show',45 ); ?>
<?php  
    function my_tags_product_show(){
        global $product;
        $product->get_tags( $product );
    }
?>

<?php  


