<?php get_header(); ?>


<?php 
//This loops through all psots and is a WP func
while(have_posts()) : 
  //Call the post
  the_post(); ?>
<h1><?php the_title(); ?></h1>
<p><?php the_content(); ?></p>



<?php endwhile; ?>

<?php get_footer(); ?>

