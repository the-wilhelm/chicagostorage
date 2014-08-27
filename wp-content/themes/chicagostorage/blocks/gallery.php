<?php if ($gall = get_field('gallery') ): ?>
    <div class="carousel2">
        <div class="mask">
            <ul class="slideset">
                <?php for($i=0;$i<count($gall);$i++): ?>
                    <li><?php echo get_theme_image($gall[$i],'gallery-thumbnail'); ?></li>
                <?php endfor; ?>
            </ul>
        </div>
        <a href="#" class="btn-prev icon-arrow-left"></a>
        <a href="#" class="btn-next icon-arrow-right"></a>
    </div>
<?php endif; ?>