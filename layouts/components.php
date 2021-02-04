<div id="chudler-components">
   <?php if ( have_rows( 'page_components' ) ): ?>
	<?php while ( have_rows( 'page_components' ) ) : the_row(); ?>
            <?php if (get_row_layout() == 'editor') : ?>
                <?php get_template_part('./components/editor', ''); ?>
            <?php elseif (get_row_layout() == 'header') : ?>
                <?php get_template_part('./components/header-top', ''); ?>
            <?php elseif (get_row_layout() == 'linked_images') : ?>
                <?php get_template_part('./components/linked-images', ''); ?>
            <?php elseif (get_row_layout() == 'slider') : ?>
                <?php get_template_part('./components/slider', ''); ?>
            <?php elseif (get_row_layout() == 'team_block') : ?>
                <?php get_template_part('./components/team-block', ''); ?>
            <?php endif; ?>
        <?php endwhile; ?>
<?php else: ?>
	<?php // no layouts found ?>
<?php endif; ?>
</div>