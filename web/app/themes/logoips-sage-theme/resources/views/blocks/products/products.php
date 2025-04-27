<?php
// Проверяем, есть ли карточки
if (have_rows('product_cards')):
?>
    <div class="container mt-5">
        <h2 class="fw-light">Our Products</h2>
        <div class="row row-cols-1 row-cols-md-3 g-4">
            <?php while (have_rows('product_cards')): the_row();
                $image = get_sub_field('product_image');
                $title = get_sub_field('product_name');
                $desc  = get_sub_field('product_description');
                $link  = get_sub_field('product_link');
                $card_color = get_sub_field('card_color');
            ?>
                <div class="col">
                    <div class="card border-light" <?php if ($card_color) echo 'style="background-color:' . esc_attr($card_color) . ';"'; ?>>
                        <?php if ($image): ?>
                            <img src="<?php echo esc_url($image['url']); ?>" class="card-img-top mb-4" alt="<?php echo esc_attr($image['alt']); ?>">
                        <?php endif; ?>
                        <div class="card-body text-white product-descr">
                            <?php if ($title): ?>
                                <h5 class="card-title"><?php echo esc_html($title); ?></h5>
                            <?php endif; ?>
                            <?php if ($desc): ?>
                                <p class="card-text"><?php echo esc_html($desc); ?></p>
                            <?php endif; ?>
                            <?php if ($link): ?>
                                <div class="circle-container">
                                    <a href="<?php echo esc_url($link['url']); ?>" target="<?php echo esc_attr($link['target']); ?>">
                                        <img src="<?php echo e(asset('assets/icons/nav/arrow-right.png')); ?>" width="20px" height="20px" alt="Arrow">
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
        <?php
        $show_all = get_field('show_all_link');
        if ($show_all): ?>
            <a class="link-secondary text-end m-4 link-offset-2 fw-medium" href="<?php echo esc_url($show_all['url']); ?>" target="<?php echo esc_attr($show_all['target']); ?>">
                <p><?php echo esc_html($show_all['title']); ?></p>
            </a>
        <?php endif; ?>
    </div>
<?php endif; ?>