<div id="team" class="uk-section uk-margin-bottom <?php the_sub_field( 'team_comp_class' ); ?>">
    <div class="uk-container uk-width-5-6">
        <h2 class="uk-text-center"><?php the_sub_field( 'team_title' ); ?></h2>
            <?php if (have_rows('team_member')) : ?>
                <?php while (have_rows('team_member')) : the_row(); ?>
                <div class="uk-grid member uk-child-width-expand" uk-grid>
                    <div class="uk-width-1-6@m uk-flex uk-flex-middle icon">
                        <?php $icon = get_sub_field( 'team_icon' ); ?>
                        <?php if ( $icon ) { ?>
                            <img src="<?php echo $icon['url']; ?>" alt="<?php echo $icon['alt']; ?>" height="100px"/>
                        <?php } ?>
                    </div>
                    <div class="uk-padding-small uk-flex uk-flex-middle name">
                        <h3><?php the_sub_field( 'team_name' ); ?></h3>
                    </div>
                    <div class="uk-width-3-5@m uk-padding-small description">
                        <?php the_sub_field( 'team_description' ); ?>
                    </div>
                </div>
                <?php endwhile; ?>
            <?php endif; ?>
    </div>
</div>