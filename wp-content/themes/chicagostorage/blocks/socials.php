<?php $link = get_field('link_button','options'); ?>
<?php $caption = get_field('caption_button','options'); ?>
<?php if ( ($link && $caption) || have_rows('socials','options') ) : ?>
        <?php if( have_rows('socials','options') ): ?>
            <ul class="social-networks">
                <?php  while ( have_rows('socials','options') ) : the_row(); ?>
                    <?php if( get_row_layout() == 'twitter' ): ?>
                        <li><a href="<?php the_sub_field('link'); ?>"><i class="icon-twitter"></i></a></li>
                    <?php elseif( get_row_layout() == 'facebook' ): ?>
                        <li><a href="<?php the_sub_field('link'); ?>"><i class="icon-facebook"></i></a></li>
                    <?php elseif( get_row_layout() == 'googleplus' ): ?>
                        <li><a href="<?php the_sub_field('link'); ?>"><i class="icon-googleplus"></i></a></li>
                    <?php elseif( get_row_layout() == 'linkedin' ): ?>
                        <li><a href="<?php the_sub_field('link'); ?>"><i class="icon-linkedin"></i></a></li>
                    <?php endif; ?>
                <?php endwhile; ?>
            </ul>
        <?php endif; ?>
        <?php if ( $link && $caption ) : ?>
            <a href="<?php echo $link; ?>" class="btn"><?php echo $caption; ?></a>
        <?php endif; ?>
<?php endif; ?>