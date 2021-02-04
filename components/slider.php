<div id="slider" class="uk-background-muted uk-section uk-section-small">
    <div>
        <?php $title =  get_sub_field('title'); ?>
        <?php if ($title) { ?>
            <h2 class="uk-text-center"><?php echo $title; ?></h2>
        <?php } ?>
        <div uk-slider="autoplay: true;">
            <div class="uk-position-relative uk-visible-toggle uk-light" tabindex="-1">
				<div class="uk-slider-container uk-light">
                <ul class="uk-slider-items uk-child-width-1-3@s uk-light uk-grid">
                    <?php if (have_rows('comp-slider')) : ?>
                        <?php while (have_rows('comp-slider')) : the_row(); ?>
                            <li>
                                <div class="uk-panel">
                                    <?php $image = get_sub_field('image'); ?>
                                    <?php if ($image) { ?>
                                        <img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" />
                                    <?php } ?>
                                    <div class="container-slider">
                                        <a href="<?php the_sub_field('link'); ?>" target="_blank">
											<h4><?php the_sub_field('date'); ?></h4>
                                            <?php the_sub_field('title'); ?>
                                        </a>
                                    </div>
                                </div>
                            </li>
                        <?php endwhile; ?>
                    <?php endif; ?>
                </ul>
                <a class="uk-position-center-left uk-position-small uk-button uk-button-primary uk-icon uk-slidenav-previous uk-slidenav" href="#" uk-slidenav-previous uk-slider-item="previous"></a>
                <a class="uk-position-center-right uk-position-small uk-button uk-button-primary uk-icon uk-slidenav-previous uk-slidenav" href="#" uk-slidenav-next uk-slider-item="next"></a>
				</div>
            </div>
            <ul class="uk-slider-nav uk-dotnav uk-flex-center uk-margin"></ul>
        </div>
    </div>
</div>