<?php 
    $icon = get_field('icon');
?>
<div class="container d-flex justify-content-center align-items-center" id="scroll-back">
    <div class="circle-container-scroll">
        <a href="#">
            <img src="<?php echo esc_url($icon['url']); ?>" width="20px" height="20px" alt="">
        </a>
    </div>
</div>