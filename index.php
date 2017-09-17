<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 */

get_header(); ?>

<div class="wrap">
	<?php if ( is_home() && ! is_front_page() ) : ?>
		<header class="page-header">
			<h1 class="page-title"><?php single_post_title(); ?></h1>
		</header>
	<?php else : ?>
	<header class="page-header">
		<h2 class="page-title"><?php _e( 'Posts', 'twentyseventeen' ); ?></h2>
	</header>
	<?php endif; ?>
	<h1>Ovo je child tema twenty seventeen</h1>
	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<?php
			if ( have_posts() ) :

				/* Start the Loop */
				while ( have_posts() ) : the_post();

					/*
					 * Include the Post-Format-specific template for the content.
					 * If you want to override this in a child theme, then include a file
					 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
					 */
					get_template_part( 'template-parts/post/content', get_post_format() );

				endwhile;

				the_posts_pagination( array(
					'prev_text' => twentyseventeen_get_svg( array( 'icon' => 'arrow-left' ) ) . '<span class="screen-reader-text">' . __( 'Previous page', 'twentyseventeen' ) . '</span>',
					'next_text' => '<span class="screen-reader-text">' . __( 'Next page', 'twentyseventeen' ) . '</span>' . twentyseventeen_get_svg( array( 'icon' => 'arrow-right' ) ),
					'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'twentyseventeen' ) . ' </span>',
				) );

			else :

				get_template_part( 'template-parts/post/content', 'none' );

			endif;
			?>

		</main><!-- #main -->
	</div><!-- #primary -->
	<!--MOJ DODATAK ZA IZVLAČENJE PROIZVODA-->
	<?php
$params = array('posts_per_page' => 4, 'post_type' => 'product','tax_query' => array(
        'relation' => 'AND',
        array(
        'taxonomy' => 'product_cat',
        'field' => 'id',
        'terms' => 21,
        'include_children' => true,
        'operator' => 'IN'
        ),
        array(
        'taxonomy' => 'product_tag',
        'field' => 'slug',
        'terms' => 'crven',
        'include_children' => true,
        'operator' => 'IN'
        )
    ));
$wc_query = new WP_Query($params);
?>
<div class="row">
     <?php if ($wc_query->have_posts()) : ?>
     <?php while ($wc_query->have_posts()) :
                $wc_query->the_post(); ?>
		<!--U sledećem redu od posta tipa product kreiramo objekat wc_product -->
		<?php $product=wc_get_product(get_the_ID());?>
				
     <div class="col-sm-6">
          <h3>
               <a href="<?php the_permalink(); ?>">
               <?php the_title(); ?>
               </a>
          </h3>
          <?php the_post_thumbnail(); ?>
          <div class="text-center"><?php the_excerpt(); ?></div>
		  <div class="price"><?php echo "Price is ".$product->get_price()." din"; ?></div>
		  <div class="stock"><?php echo "Na zalihama je ".$product->get_stock_quantity()." kom"; ?></div>

     </div>
     <?php endwhile; ?>
     <?php wp_reset_postdata(); ?>
     <?php else:  ?>
     <li>
          <?php _e( 'No Products' ); ?>
     </li>
     <?php endif; ?>
</div>
	<?php get_sidebar(); ?>
</div><!-- .wrap -->

<?php get_footer();
