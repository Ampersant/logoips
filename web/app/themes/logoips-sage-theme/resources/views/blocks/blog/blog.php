<?php
$slides   = get_field('slides');
$subtitle = get_field('subtitle');
if ($slides):
    $all_tags = [];
    foreach ($slides as $slide) {
        if (! empty($slide['slide_tags'])) {
            $all_tags = array_merge($all_tags, $slide['slide_tags']);
        }
    }
    $unique_tags = array_unique($all_tags);
    $filters     = array_merge($unique_tags);
?>
    <div class="container mt-5">
        <div class="text-center lead mx-auto blog-text">
            <h2 class="fw-light">Blog</h2>
            <?php if ($subtitle): ?>
                <p><?php echo $subtitle; ?></p>
            <?php endif; ?>
        </div>

        <div class="mt-5 mb-3 d-flex gap-2 flex-wrap justify-content-center justify-content-md-start">
            <?php foreach ($filters as $i => $tag):
                $checkbox_id = 'tag' . ($i + 1);
                $data_tag = ($i === 0) ? 'all' : $tag;
            ?>
                <input
                    type="checkbox"
                    class="btn-check"
                    id="<?php echo esc_attr($checkbox_id); ?>"
                    data-tag="<?php echo esc_attr($data_tag); ?>"
                    autocomplete="off"
                    <?php if ($i === 0) echo 'checked';
                    ?>>
                <label
                    class="btn rounded-pill bg-checks"
                    for="<?php echo esc_attr($checkbox_id); ?>"><?php echo esc_html($tag); ?></label>
            <?php endforeach; ?>
        </div>

        <div class="swiper mySwiper">
            <div class="swiper-wrapper">
                <?php foreach ($slides as $slide):
                    $image_id    = $slide['slide_image'];
                    $button_text = $slide['button_text'];
                    $tags        = !empty($slide['slide_tags']) ? $slide['slide_tags'] : [];
                    $tag_attr    = esc_attr(implode(',', $tags));
                ?>
                    <div class="swiper-slide" data-tags="<?php echo $tag_attr; ?>">
                        <div class="card text-white">
                            <?php if ($image_id):
                                $url = $image_id['url'];
                                $alt = get_post_meta($image_id, '_wp_attachment_image_alt', true);
                            ?>
                                <img src="<?php echo esc_url($url); ?>" class="card-img" alt="<?php echo esc_attr($alt); ?>">
                            <?php endif; ?>
                            <div class="card-img-overlay d-flex flex-column justify-content-end align-items-center">
                                <?php if ($button_text): ?>
                                    <button class="btn btn-light rounded-pill px-4 py-2">
                                        <?php echo esc_html($button_text); ?>
                                    </button>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="circle-container">
                <div class="swiper-button-next custom-next"></div>
            </div>
            <div class="swiper-scrollbar"></div>
        </div>
    </div>
<?php endif; ?>