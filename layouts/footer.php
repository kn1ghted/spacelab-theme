<div id="tm-footer" class="uk-background-muted">
    <div class="uk-container uk-container-expand uk-padding-remove-right">
        <div class="uk-child-width-1-3@m" uk-grid>
            <div class="footer-block-a uk-padding">
                <?php if ( have_rows( 'block_a', 'option' ) ) : ?>
                    <?php while ( have_rows( 'block_a', 'option' ) ) : the_row(); ?>
                        <div class="footer-text">
                            <?php the_sub_field( 'fba_text' ); ?>
                        </div>
                        <div class="footer-social">
                            <?php if ( have_rows( 'fba_social' ) ) : ?>
                                <?php while ( have_rows( 'fba_social' ) ) : the_row(); ?>
                                    <a href="<?php the_sub_field( 'social_external-url' ); ?>" uk-icon="icon:<?php the_sub_field( 'social_icon' ); ?>; ratio: 1.5" class="uk-icon"></a>
                                    <br>
                                <?php endwhile; ?>
                            <?php else : ?>
                                <?php // no rows found ?>
                            <?php endif; ?>
                        </div>
                    <?php endwhile; ?>
                <?php endif; ?>
            </div>
            <div class="footer-block-b uk-padding">
                <?php if ( have_rows( 'block_b', 'option' ) ) : ?>
                    <?php while ( have_rows( 'block_b', 'option' ) ) : the_row(); ?>
                        <?php if ( have_rows( 'fbb_links' ) ) : ?>
                            <ul>
                            <?php while ( have_rows( 'fbb_links' ) ) : the_row(); ?>
                                <li>
                                    <a href="<?php the_sub_field( 'link' ); ?>"><?php the_sub_field( 'text' ); ?></a>
                                </li>
                            <?php endwhile; ?>
                            </ul>
                        <?php else : ?>
                            <?php // no rows found ?>
                        <?php endif; ?>
                    <?php endwhile; ?>
                <?php endif; ?>
            </div>
            <div class="footer-block-c uk-flex">
                <?php if ( get_field( 'footer_logo', 'option' ) ) { ?>
                    <div class="uk-flex uk-flex-center uk-flex-middle">
                        <img src="<?php the_field( 'footer_logo', 'option' ); ?>" style="max-width: 400px;"/>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
    <!-- copyright container -->
    <div class="copyright uk-text-center">
        <?php the_field('footer_copyright', 'option'); ?>
    </div>
</div>