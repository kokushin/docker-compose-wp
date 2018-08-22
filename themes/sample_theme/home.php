<?php
/*
Template Name: WORKS
*/

get_header();
?>

<div class="works-list">
<?php
  if ( have_posts() ) :
    while ( have_posts() ) : the_post();
    ?>

    <?php get_template_part( 'modules/parts', 'entry-item' ); ?>

    <?php
    endwhile;
  else:
  ?>

    <?php get_template_part( 'modules/parts', 'entry-item-empty' ); ?>

  <?php
  endif;
?>
</div>

<?php
get_footer();
