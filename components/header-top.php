<?php $image = get_sub_field('image'); ?>
<div id="header-top" class="uk-section uk-background-muted uk-background-cover uk-height-large" style="background-image: linear-gradient( rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5) ), url(<?php echo $image['url']; ?>);"
    <div class="uk-flex uk-flex-left">
        <div class="uk-padding">
            <?php the_sub_field('content'); ?>
        </div>
    </div>
</div>