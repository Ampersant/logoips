<?php

/**
 * Hero Block template.
 *
 * @param array $block The block settings and attributes.
 */

// Load values and assign defaults.
$heading          = !empty(get_field('heading')) ? get_field('heading') : 'Sample of Heading...';
$text             = !empty(get_field('text')) ? get_field('text') : 'Your text here...';
$button_label     = !empty(get_field('button_label')) ? get_field('button_label') : 'Click!';
$background_image = get_field('background_image');
$url              = '';
$anchor           = '';

if (! empty($block['anchor'])) {
    $anchor = 'id="' . esc_attr($block['anchor']) . '" ';
}
$heading_safe = esc_html($heading);
$heading_with_br = preg_replace(
    '/\s+(\S+)$/u',
    '<br>$1',
    $heading_safe
);

// Create class attribute allowing for custom "className" and "align" values.
$class_name = 'testimonial';
if (! empty($block['className'])) {
    $class_name .= ' ' . $block['className'];
}
if (! empty($block['align'])) {
    $class_name .= ' align' . $block['align'];
}
if (!empty($background_image)) {
    $url = $background_image['url'];
}
?>

<!--=============== HERO ===============-->
<div <?php echo esc_attr($anchor); ?>class="<?php echo esc_attr($class_name); ?>">
    <section class="hero d-flex align-items-center m-3" style="background-image: url('<?php echo esc_url($url); ?>');">
        <div class="container text-center text-white">
            <h1 class="display-3 mx-auto fw-bold"><?php echo $heading_with_br; ?></h1>
            <p class="lead mx-auto hero-text">
                <?php echo esc_html($text); ?>
            </p>
            <button class="btn btn-light rounded-pill px-4 py-2 fw-medium" type="button"><?php echo esc_html($button_label); ?></button>
        </div>
    </section>
</div>