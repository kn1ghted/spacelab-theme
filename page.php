<?php get_header(); ?>
<?php
if (have_posts()) :
    while (have_posts()) :
        the_post(); ?>
    <div class="uk-section uk-padding-remove-bottom uk-padding-remove-top" uk-height-viewport="offset-bottom: true; expand: true">
        <div class="uk-width-expand">
            <?php
            // wp content
            get_template_part('/layouts/components', '');
            ?>
        </div>
    </div>
    <?php
    endwhile;
endif;?>
<?php get_footer(); ?>