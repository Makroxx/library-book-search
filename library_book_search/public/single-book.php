<?php
/**
 * The Template for displaying all book posts.
 *
 * @package Styled Lite
 */

get_header(); ?>

<div id="wrapper" class="wrap">
<h1 class="entry-title">
          <?php the_title(); ?>
        </h1>
        <div>
          <label>Auther: </label>
            <span>
              <?php
              $auther_terms = get_the_terms($post->ID,"auther");
              $auther_counter = 0;
              foreach ( $auther_terms as $auther_term ) {
                echo "<a href='".get_term_link($auther_terms[$auther_counter]->term_id)."'>".$auther_term->name."</a><br>";
                $auther_counter++;
              }
              ?>
            </span>
          <hr>
          <label>Publisher: </label>
            <span>
              <?php
              $publisher_terms = get_the_terms($post->ID,"publisher");
              $publisher_counter = 0;
              foreach ( $publisher_terms as $publisher_term ) {
                echo "<a href='".get_term_link($publisher_terms[$publisher_counter]->term_id)."'>".$publisher_term->name."</a><br>";
                $publisher_counter++;
              }
              ?>
            </span>
            <hr>
          <label>Book Price: </label>
            <span>$ <?php echo number_format(get_post_meta($post->ID,"price_value")[0]); ?></span>
            <hr>
          <label>Ratings: </label>
            <span><?php 
                    // Used Star rating helper file function
                    $star_rating_layout = get_post_meta($post->ID,"star_rating")[0];
                    echo Helper::star_rating_html($star_rating_layout); 
                    ?>
            </span>
            <hr>
        </div>
  <div id="contentwrapper" class="animated fadeIn">
    <div id="content">
      <?php while ( have_posts() ) : the_post(); ?>
      <div <?php post_class(); ?>>
        <div class="entry">
          <label>Book Details</label>
          <?php the_content(); ?>
          <?php wp_link_pages(array('before' => '<p><strong>'. esc_html__( 'Pages:', 'styled-lite' ) .'</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
          <?php edit_post_link(); ?>
          <?php echo get_the_tag_list('<p class="singletags">',' ','</p>'); ?>
         
          <?php comments_template(); ?>
        </div>
      </div>
      <?php endwhile; // end of the loop. ?>
    </div>
  </div>
</div>
<?php get_footer(); ?>
