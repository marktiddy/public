<div class="post-item">
	  <h2 class="headline headline--medium headline--post-title"><a href="<?php the_permalink();?>"><?php the_title();?></a></h2>
	  <div class="metabox">
	  <p>Posted by <?php echo the_author_posts_link(); ?> on the <?php echo the_time('l jS F Y'); ?> in <?php echo get_the_category_list(', '); ?></p>
	  </div>
	  <div class="generic-content">
	  <?php the_excerpt();?>
	  <p><a href="<?php the_permalink();?>" class="btn btn--blue">Continue Reading &raquo;</a></p>
	  </div>
	  <?php
    echo paginate_links();
    ?>
	  </div>