            </div>
            <?php get_sidebar(); ?>
        </main>
        <?php if (is_front_page()): ?>
            <?php get_sidebar('footer'); ?>
        <?php endif; ?>
        <footer id="footer">
                <?php get_template_part('blocks/socials'); ?>
                <?php if(has_nav_menu('footer'))
					wp_nav_menu( array('container' => 'nav',
                        'container_class' => 'nav',
                        'theme_location' => 'footer',
                        'items_wrap' => '<ul>%3$s</ul>',
                         )); ?>
                <p><?php _e('copyright &copy; '.date("Y").'<br>'.' chicagostorage.com','chicagostorage'); ?></p>
        </footer>
        <?php if ($popap = get_field('find_box_popup','options')): ?>
            <div class="popup-holder">
                <div id="popup" class="popup">
                    <?php echo wpautop($popap,false); ?>
                </div>
            </div>
        <?php endif; ?>
        <?php wp_enqueue_script('jquery'); ?>
        <?php wp_enqueue_script( 'theme-js', get_template_directory_uri()."/js/jquery.main.js" ); ?>
		<?php wp_footer(); ?>
	</body>
</html>