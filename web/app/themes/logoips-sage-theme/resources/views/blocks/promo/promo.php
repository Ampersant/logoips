<?php

/**
 * Promo block template.
 *
 * @param array $block The block settings and attributes.
 */

// Load values and assign defaults.
$heading          = !empty(get_field('heading')) ? get_field('heading') : 'Sample of Heading...';
$text             = !empty(get_field('text')) ? get_field('text') : 'Your text here...';
$button_label     = !empty(get_field('button_label')) ? get_field('button_label') : 'Click!';
$image            = get_field('promo_image');
$background_color = get_field('promo_background_color');
?>
            
<div class="container my-5" id="promo">
    <div class="card border-0 shadow text-white" <?php if ($background_color) echo 'style="background-color:' . esc_attr($background_color) . ';"'; ?>>
        <div class="row g-0 h-100">
            <div class="col-md-4 order-2 order-md-1 d-flex flex-column p-4">
                <div class="mb-2">
                    <h2 class="card-title fw-light"><?php echo esc_html($heading) ?></h2>
                    <p class="card-text fw-light">
                        <?php echo esc_html($text); ?>
                    </p>
                </div>
                <div class="mt-auto p-3">
                    <a href="#" class="btn btn-light rounded-pill"><?php echo esc_html($button_label); ?></a>
                </div>
            </div>
            <div class="col-md-8  d-flex order-1 order-md-2">
                <?php if (is_array($image) && ! empty($image['url'])) : ?>
                    <img
                        src="<?php echo esc_url($image['url']); ?>"
                        alt="<?php echo esc_attr($image['alt'] ?? 'cardimage'); ?>"
                        class="card-img-right">
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>