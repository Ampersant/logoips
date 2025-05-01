<?php

/**
 * Theme setup.
 */

namespace App;

use Illuminate\Support\Facades\Vite;

/**
 * Inject styles into the block editor.
 *
 * @return array
 */
add_filter('block_editor_settings_all', function ($settings) {
    $style = Vite::asset('resources/css/editor.css');

    $settings['styles'][] = [
        'css' => "@import url('{$style}')",
    ];

    return $settings;
});

/**
 * Inject scripts into the block editor.
 *
 * @return void
 */
add_filter('admin_head', function () {
    if (! get_current_screen()?->is_block_editor()) {
        return;
    }

    $dependencies = json_decode(Vite::content('editor.deps.json'));

    foreach ($dependencies as $dependency) {
        if (! wp_script_is($dependency)) {
            wp_enqueue_script($dependency);
        }
    }

    echo Vite::withEntryPoints([
        'resources/js/editor.js',
    ])->toHtml();
});

/**
 * Use the generated theme.json file.
 *
 * @return string
 */
add_filter('theme_file_path', function ($path, $file) {
    return $file === 'theme.json'
        ? public_path('build/assets/theme.json')
        : $path;
}, 10, 2);

/**
 * Register the initial theme setup.
 *
 * @return void
 */
add_action('after_setup_theme', function () {
    /**
     * Disable full-site editing support.
     *
     * @link https://wptavern.com/gutenberg-10-5-embeds-pdfs-adds-verse-block-color-options-and-introduces-new-patterns
     */
    remove_theme_support('block-templates');

    /**
     * Register the navigation menus.
     *
     * @link https://developer.wordpress.org/reference/functions/register_nav_menus/
     */
    register_nav_menus([
        'primary_navigation' => __('Primary Navigation', 'sage'),
    ]);

    /**
     * Disable the default block patterns.
     *
     * @link https://developer.wordpress.org/block-editor/developers/themes/theme-support/#disabling-the-default-block-patterns
     */
    remove_theme_support('core-block-patterns');

    /**
     * Enable plugins to manage the document title.
     *
     * @link https://developer.wordpress.org/reference/functions/add_theme_support/#title-tag
     */
    add_theme_support('title-tag');

    /**
     * Enable post thumbnail support.
     *
     * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
     */
    add_theme_support('post-thumbnails');

    /**
     * Enable responsive embed support.
     *
     * @link https://developer.wordpress.org/block-editor/how-to-guides/themes/theme-support/#responsive-embedded-content
     */
    add_theme_support('responsive-embeds');

    /**
     * Enable HTML5 markup support.
     *
     * @link https://developer.wordpress.org/reference/functions/add_theme_support/#html5
     */
    add_theme_support('html5', [
        'caption',
        'comment-form',
        'comment-list',
        'gallery',
        'search-form',
        'script',
        'style',
    ]);

    /**
     * Enable selective refresh for widgets in customizer.
     *
     * @link https://developer.wordpress.org/reference/functions/add_theme_support/#customize-selective-refresh-widgets
     */
    add_theme_support('customize-selective-refresh-widgets');
}, 20);

/**
 * Register the theme sidebars.
 *
 * @return void
 */
add_action('widgets_init', function () {
    $config = [
        'before_widget' => '<section class="widget %1$s %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h3>',
        'after_title' => '</h3>',
    ];

    register_sidebar([
        'name' => __('Primary', 'sage'),
        'id' => 'sidebar-primary',
    ] + $config);

    register_sidebar([
        'name' => __('Footer', 'sage'),
        'id' => 'sidebar-footer',
    ] + $config);
});

// registration of blocks
add_action('acf/init', function () {
    register_block_type(get_theme_file_path('resources/views/blocks/hero'));
    register_block_type(get_theme_file_path('resources/views/blocks/products'));
    register_block_type(get_theme_file_path('resources/views/blocks/promo'));
    register_block_type(get_theme_file_path('resources/views/blocks/highlights'));
    register_block_type(get_theme_file_path('resources/views/blocks/footer'));
    register_block_type(get_theme_file_path('resources/views/blocks/scroll-back'));
    // register_block_type(get_theme_file_path('resources/views/blocks/blog'));

    // ==== registring Blog Block with Scripts ====
    wp_register_script(
        'jquery-cdn',
        'https://code.jquery.com/jquery-3.7.1.min.js',
        [],
        '3.7.1',
        true
    );
    wp_register_script(
        'swiper-cdn',
        'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js',
        ['jquery-cdn'],
        '11.0.0',
        true
    );

    $block_dir = 'resources/views/blocks/blog';
    wp_register_script(
        'block-blog-script',
        get_theme_file_uri("$block_dir/blog.js"),
        ['swiper-cdn'],
        filemtime(get_theme_file_path("$block_dir/blog.js")),
        true
    );
    wp_register_style(
        'swiper-css',
        'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css',
        [],
        '11.0.0'
    );
    wp_register_style(
        'block-blog-style',
        get_theme_file_uri('resources/views/blocks/blog/blog.css'),
        [],
        filemtime(get_theme_file_path('resources/views/blocks/blog/blog.css'))
    );
    register_block_type(
        get_theme_file_path("$block_dir/block.json"),
        [
            'viewScript' => 'block-blog-script',
            'style'  =>  ['swiper-css', 'block-blog-style'],
        ]
    );
});

// adding bootstrap css to Gutenberg-editor
add_action('after_setup_theme', function () {
    add_theme_support('editor-styles');
    add_editor_style('https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css');
});
