<?php get_header();
pageBanner();
?>

<?php 
//This loops through all psots and is a WP func
while(have_posts()) : 
  //Call the post
  the_post(); ?>


  <div class="container container--narrow page-section">
  <div class="metabox metabox--position-up metabox--with-home-link">
      <p><a class="metabox__blog-home-link" href="<?php echo site_url('/blog') ?>"><i class="fa fa-home" aria-hidden="true"></i> Blog Home</a> 
      <span class="metabox__main">Posted by <?php echo the_author_posts_link(); ?> on the <?php echo the_time('l jS F Y'); ?> in <?php echo get_the_category_list(', '); ?></span></p>
    </div>
    <div class="generic-content">
    <?php the_content(); ?>
    </div>

  </div>
<?php endwhile; ?>

<?php get_footer(); ?>


