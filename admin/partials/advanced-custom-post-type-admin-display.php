<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://https://profiles.wordpress.org/darshitrajyaguru97/
 * @since      1.0.0
 *
 * @package    Advanced_Custom_Post_Type
 * @subpackage Advanced_Custom_Post_Type/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" ></script>

<div id="custom-post-slider" class="carousel slide" data-ride="carousel">
    <div class="carousel-inner">

        <?php
        $args = array(
            'post_type'      => 'books', // Change to your custom post type
            'posts_per_page' => 3, // Adjust the number of posts to display
        );

        $query = new WP_Query($args);

        $count = 0;

        while ($query->have_posts()) {
            $query->the_post();
            $author = get_the_author();
            $publish_date = get_the_date();
            $excerpt = get_the_excerpt();
            $read_more_link = get_permalink();
            ?>

            <div class="carousel-item<?php echo ($count === 0 ? ' active' : ''); ?>">
                <img class="d-block w-100" src="<?php echo get_the_post_thumbnail_url(); ?>" alt="<?php echo get_the_title(); ?>">
                <div class="carousel-caption d-none d-md-block">
                    <h5><?php echo get_the_title(); ?></h5>
                    <p><?php echo $excerpt; ?></p>
                    <p>Author: <?php echo $author; ?></p>
                    <p>Publish Date: <?php echo $publish_date; ?></p>
                    <a class="btn btn-primary" href="<?php echo $read_more_link; ?>">Read More</a>
                </div>
            </div>

            <?php
            $count++;
        }

        wp_reset_postdata();
        ?>

    </div>

    <a class="carousel-control-prev" href="#custom-post-slider" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#custom-post-slider" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
</div>