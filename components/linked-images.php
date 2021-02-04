<div id="linked-images" class="uk-section <?php the_sub_field( 'li_image_comp_class' ); ?>">
    <div class="uk-container uk-container-center uk-text-center">
        <h2><?php the_sub_field( 'li_title' ); ?></h2>
        <?php if ( have_rows( 'li_images' ) ) : ?>
        <div class="uk-grid uk-flex-center uk-child-width-expand uk-grid-small" uk-grid>
            <?php while ( have_rows( 'li_images' ) ) : the_row(); ?>
            <div>
                <?php $li_image = get_sub_field( 'li_image' ); ?>
                <?php if ( $li_image ) { ?>
                <a href="<?php the_sub_field( 'li_link' ); ?>" target="_blank">
                        <img src="<?php echo $li_image['url']; ?>" alt="<?php echo $li_image['alt']; ?>" />
                </a>
                <?php } ?>
                <?php $li_text = get_sub_field( 'li_text' ); ?>
                <?php if ( $li_text ) { ?>
                <p><?php the_sub_field( 'li_text' ); ?></p>
                <a href="<?php the_sub_field( 'li_link' ); ?>" target="_blank"><?php the_sub_field( 'li_link' ); ?></a>
                <?php } ?>
            </div>
            <?php endwhile; ?>
            <?php else : ?>
                <?php // no rows found ?>
        </div>
        <?php endif; ?>
	</div>
</div>