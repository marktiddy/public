<?php get_header();?>

<?php
//This loops through all psots and is a WP func
while (have_posts()):
    //Call the post
    the_post();
    pageBanner();
    ?>


	  <div class="container container--narrow page-section">
	    <?php
    $theParent = wp_get_post_parent_id(get_the_ID());
    if ($theParent): ?>
	       <div class="metabox metabox--position-up metabox--with-home-link">
	      <p><a class="metabox__blog-home-link" href="<?php echo get_permalink($theParent) ?>"><i class="fa fa-home" aria-hidden="true"></i> Back to <?php echo get_the_title($theParent) ?></a> <span class="metabox__main"><?php the_title();?></span></p>
	    </div>
	    <?php endif;?>

    <?php
//If func has children this will be an array of children
$testArray = get_pages(array('child_of' => get_the_ID()));
if ($theParent or $testArray): ?>
<!--Only display if we're on a child page or if it has children -->

<div class="page-links">
      <h2 class="page-links__title"><a href="<?php echo get_permalink($theParent) ?>"><?php echo get_the_title($theParent) ?></a></h2>
      <ul class="min-list">
       <?php
if ($theParent) {
    $findChildrenOf = $theParent;
} else {
    $findChildrenOf = get_the_ID();
}

wp_list_pages(array(
    'title_li' => null,
    'child_of' => $findChildrenOf,
));?>
      </ul>
    </div>
    <?php endif;?>

    <div class="generic-content">
<?php get_search_form() ?>
  </div>

  </div>



<?php endwhile;?>

<?php get_footer();?>

