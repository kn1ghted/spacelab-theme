<?php
/**
 * Frontpage template
 * Created by Spacelab - 2021
 * @package WordPress
 */
get_header();
?>
<!-- HEADER BANNER -->
<?php if ( have_rows( 'header_banner' ) ) : ?>
<?php while ( have_rows( 'header_banner' ) ) : the_row(); ?>
<div id="header-top" class="uk-section uk-background-muted uk-inline <?php the_sub_field( 'hb_class' ); ?>" style="background-image: linear-gradient( rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5) ), url(<?php the_sub_field( 'hb_image' ); ?>);">
    <div class="uk-overlay uk-padding uk-position-bottom-center">
        <?php the_sub_field( 'hb_overlay' ); ?>
    </div>
</div>
<?php endwhile; ?>
<?php endif; ?>

<!-- TEXT AND IMAGE -->
<?php if ( have_rows( 'text_image' ) ) : ?>
<?php while ( have_rows( 'text_image' ) ) : the_row(); ?>
<?php $ti_image = get_sub_field( 'ti_image' ); ?>
<div id="text-image" class="uk-section <?php the_sub_field( 'ti_style_class' ); ?>">
    <div class="uk-container">
        <div uk-grid>
            <div class="uk-width-1-2@m text uk-text-left">
                <div class="uk-margin">
                    <?php the_sub_field( 'ti_text' ); ?>
                </div>
            </div>
            <div class="uk-width-1-2@m image uk-position-relative uk-background-cover crop-image" data-src="<?php echo $ti_image; ?>" uk-img>
            </div>
        </div>
    </div>
</div>
<?php endwhile; ?>
<?php endif; ?>

<!-- SIMPLE CONTENT -->
<?php if ( have_rows( 'simple_content' ) ) : ?>
<?php while ( have_rows( 'simple_content' ) ) : the_row(); ?>
<div id="simple-content" class="uk-section uk-background-muted <?php the_sub_field( 'sc_class' ); ?>">
    <div class="uk-container uk-width-2-3@m">
        <?php the_sub_field( 'sc_content' ); ?>
    </div>
</div>
<?php endwhile; ?>
<?php endif; ?>

<!-- SLIDER -->
<div id="slider" class="uk-section-small <?php the_sub_field( 'slider_class' ); ?>">
    <div>
    <?php if ( have_rows( 'slider' ) ) : ?>
        <?php while ( have_rows( 'slider' ) ) : the_row(); ?>
            <?php $slider_images = get_sub_field( 'slider_images' ); ?>
            <?php if ( $slider_images ) :  ?>
            <div uk-slider="autoplay: true;">
                <div class="uk-position-relative uk-visible-toggle uk-light" tabindex="-1">
                    <div class="uk-slider-container uk-light">
                        <ul class="uk-slider-items uk-child-width-1-3@s uk-light uk-grid">
                        <?php foreach ( $slider_images as $slider_image ): ?>
                            <li>
                                <div class="uk-panel">
                                    <img src="<?php echo esc_url($slider_image['url']); ?>" alt="slider-img" />
                                </div>
                            </li>
                        <?php endforeach; ?>
                        </ul>
                        <a class="uk-position-center-left uk-position-small uk-button uk-button-primary uk-icon uk-slidenav-previous uk-slidenav" href="#" uk-slidenav-previous uk-slider-item="previous"></a>
                        <a class="uk-position-center-right uk-position-small uk-button uk-button-primary uk-icon uk-slidenav-next uk-slidenav" href="#" uk-slidenav-next uk-slider-item="next"></a>
                    </div>
                </div>
            </div>
            <ul class="uk-slider-nav uk-dotnav uk-flex-center uk-margin"></ul>
            <?php endif; ?>
        <?php endwhile; ?>
    <?php endif; ?>
    </div>
</div>

<!-- SIMPLE CONTENT WITH TITLE -->
<?php if ( have_rows( 'title_simple_content' ) ) : ?>
<?php while ( have_rows( 'title_simple_content' ) ) : the_row(); ?>
<div id="simple-content-title" class="uk-section uk-background-muted uk-padding-remove-bottom <?php the_sub_field( 'sct_class' ); ?>">
    <div class="uk-container">
        <h2 class="uk-text-center"><?php the_sub_field( 'sct_title' ); ?></h2>
        <?php the_sub_field( 'sct_content' ); ?>
        <div class="rows uk-container uk-width-2-3@m">
            <?php if ( have_rows( 'sct_row' ) ) : ?>
                <?php while ( have_rows( 'sct_row' ) ) : the_row(); ?>
                    <div uk-grid class="uk-child-width-1-2@m">
                        <div class="first">
                            <h3><?php the_sub_field( 'sct_row_subtitle' ); ?></h3>
                        </div>
                        <div class="second">
                            <?php the_sub_field( 'sct_row_description' ); ?>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else : ?>
                <?php // no rows found ?>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php endwhile; ?>
<?php endif; ?>

<!-- TWO COLUMNS -->
<?php if ( have_rows( 'two_columns' ) ) : ?>
<?php while ( have_rows( 'two_columns' ) ) : the_row(); ?>
<div id="two-columns" class="uk-section uk-padding-remove-bottom <?php the_sub_field( 'tc_class' ); ?>">
    <div class="uk-container">
        <div uk-grid>
            <div class="uk-width-1-2@m first-column">
                <div>
                <?php the_sub_field( 'tc_first' ); ?>
                </div>
            </div>
            <div class="uk-width-1-2@m second-column">
                <div>
                <?php the_sub_field( 'tc_second' ); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endwhile; ?>
<?php endif; ?>

<!-- STAGES -->
<?php if ( have_rows( 'stages' ) ) : ?>
<?php while ( have_rows( 'stages' ) ) : the_row(); ?>
<div id="stages" class="uk-section uk-padding-remove-bottom <?php the_sub_field( 'stage_class' ); ?>">
    <div class="uk-container">
        <h2 class="uk-text-center"><?php the_sub_field( 'stages_title' ); ?></h2>
        <div uk-grid class="uk-grid-collapse uk-child-width-1-4@m">
            <?php if ( have_rows( 'stage' ) ) : ?>
                <?php while ( have_rows( 'stage' ) ) : the_row(); ?>
                <div class="stage">
                    <?php $stage_icon = get_sub_field( 'stage-icon' ); ?>
                    <?php if ( $stage_icon ) { ?>
                        <p class="uk-text-center">
                            <img src="<?php echo $stage_icon['url']; ?>" alt="<?php echo $stage_icon['alt']; ?>" style="max-height: 100px;"/>
                        </p>
                    <?php } ?>
                    <h3 class="uk-text-center stage-title"><?php the_sub_field( 'stage-title' ); ?></h3>
                    <div class="uk-flex uk-flex-middle stage-description uk-background-muted uk-padding">
                        <?php the_sub_field( 'stage-description' ); ?>
                    </div>
                </div>
                <?php endwhile; ?>
            <?php else : ?>
                <?php // no rows found ?>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php endwhile; ?>
<?php endif; ?>

<!-- SLIDER BOTTOM -->
<div id="slider-bottom" class="uk-section-small <?php the_sub_field( 'slider_bottom_class' ); ?>">
    <div>
    <?php if ( have_rows( 'slider_bottom' ) ) : ?>
        <?php while ( have_rows( 'slider_bottom' ) ) : the_row(); ?>
            <?php $slider_images = get_sub_field( 'slider_bottom_images' ); ?>
            <?php if ( $slider_images ) :  ?>
            <div uk-slider="autoplay: true;">
                <div class="uk-position-relative uk-visible-toggle uk-light" tabindex="-1">
                    <div class="uk-slider-container uk-light">
                        <ul class="uk-slider-items uk-child-width-1-3@s uk-light uk-grid">
                        <?php foreach ( $slider_images as $slider_image ): ?>
                            <li>
                                <div class="uk-panel">
                                    <img src="<?php echo esc_url($slider_image['url']); ?>" alt="slider-img" />
                                </div>
                            </li>
                        <?php endforeach; ?>
                        </ul>
                        <a class="uk-position-center-left uk-position-small uk-button uk-button-primary uk-icon uk-slidenav-previous uk-slidenav" href="#" uk-slidenav-previous uk-slider-item="previous"></a>
                        <a class="uk-position-center-right uk-position-small uk-button uk-button-primary uk-icon uk-slidenav-next uk-slidenav" href="#" uk-slidenav-next uk-slider-item="next"></a>
                    </div>
                </div>
            </div>
            <ul class="uk-slider-nav uk-dotnav uk-flex-center uk-margin"></ul>
            <?php endif; ?>
        <?php endwhile; ?>
    <?php endif; ?>
    </div>
</div>

<?php get_footer(); ?>