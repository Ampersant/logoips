<?php
if (have_rows('highlights')):
?>
    <!--=============== HIGHLIGHTS SECTION ===============-->
    <div class="container">
        <div class="row g-4">
            <?php while (have_rows('highlights')): the_row();
                $heading    = get_sub_field('heading');
                $short_desc = get_sub_field('short_description');
                $icon       = get_sub_field('icon');
            ?>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm text-center h-100" style="background-color: #f2f2f2;">
                        <div class="card-body">
                            <div class="my-3">
                                <?php if ($icon): ?>
                                    <img src="<?php echo esc_url($icon['url']); ?>" alt="icon-a" class="highlight-image">
                                <?php endif; ?>
                            </div>
                            <div>
                                <h5 class="card-title fw-bold"><?php echo esc_html($heading); ?></h5>
                                <p class="card-text">
                                    <?php echo $short_desc; ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
<?php endif; ?>