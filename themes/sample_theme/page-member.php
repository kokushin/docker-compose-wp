<?php
/*
Template Name: MEMBER
*/

get_header();
?>

<?php
  $posts = get_posts('post_type=member&posts_per_page=0');

  if( $posts ) : foreach( $posts as $post ) : setup_postdata( $post ); ?>

    <div>
      <p><?php the_title(); ?></p>
    </div>

  <?php endforeach; ?>
  <?php else : ?>

    <?php get_template_part( 'modules/parts', 'entry-item-empty' ); ?>

  <?php endif;
  wp_reset_postdata();
?>

<?php
get_footer();

