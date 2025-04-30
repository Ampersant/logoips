<?php

namespace App\Walkers;

use Walker_Nav_Menu;
// Кастомный класс Walker для вывода меню в заданной структуре
class CustomNavWalker extends Walker_Nav_Menu {

    // Определяем, есть ли у элемента вложенные пункты
    function display_element( $element, &$children_elements, $max_depth, $depth = 0, $args, &$output ) {
        $id_field = $this->db_fields['id'];
        if ( isset( $children_elements[$element->$id_field] ) ) {
            $element->classes[] = 'menu-item-has-children';
        }
        return parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
    }

    // Начало уровня (обёртка для вложенных пунктов меню)
    function start_lvl( &$output, $depth = 0, $args = array() ) {
        // Не обрабатывать футерное меню
        if ( isset($args->theme_location) && $args->theme_location === 'footer_menu' ) {
            parent::start_lvl($output, $depth, $args);
            return;
        }
        if ( $depth === 0 ) {
            $output .= "\n<div class=\"dropdown__container\"><div class=\"dropdown__content\">\n";
        }
    }

    // Конец уровня (обёртка для вложенных пунктов меню)
    function end_lvl( &$output, $depth = 0, $args = array() ) {
        if ( isset($args->theme_location) && $args->theme_location === 'footer_menu' ) {
            parent::end_lvl($output, $depth, $args);
            return;
        }
        if ( $depth === 0 ) {
            $output .= "</div></div>\n";
        }
    }

    // Начало элемента меню
    function start_el(  &$output, $item, $depth = 0, $args = array(), $id = 0  ) {
        // Не обрабатывать футерное меню
        if ( isset($args->theme_location) && $args->theme_location === 'footer_menu' ) {
            parent::start_el($output, $item, $depth, $args, $id);
            return;
        }
        $title = apply_filters( 'the_title', $item->title, $item->ID );
        $url   = $item->url;
        $classes = (array) $item->classes;

        if ( $depth === 0 ) {
            // Пункт верхнего уровня
            if ( in_array( 'menu-item-has-children', $classes ) ) {
                // Пункт с выпадающим списком
                $slug = sanitize_title( $title );
                $arrow_id = $slug . '_arrow';
                $output .= '<li class="dropdown__item">';
                $output .= '<div class="nav__link dropdown__button fw-bold">' . $title;
                $output .= '<img id="' . $arrow_id . '" class="dropdown__arrow hidden" src="' . get_template_directory_uri() . '/public/build/assets/icons/nav/arrow-sm-right.png" alt="">';
                $output .= '</div>';
            } else {
                // Обычный пункт меню
                $output .= '<li>';
                $output .= '<a href="' . esc_url( $url ) . '" class="nav__link fw-bold">' . $title . '</a>';
                $output .= '</li>';
            }
        } else {
            // Пункт вложенного меню (группа в dropdown)
            $output .= '<div class="dropdown__group">';
            $output .= '<a href="' . esc_url( $url ) . '"><span class="dropdown__title">' . $title . '</span></a>';
            $output .= '</div>';
        }
    }

    // Конец элемента меню
    function end_el( &$output, $item, $depth = 0, $args = array() ) {
        if ( isset($args->theme_location) && $args->theme_location === 'footer_menu' ) {
            parent::end_el($output, $item, $depth, $args);
            return;
        }
        if ( $depth === 0 && in_array( 'menu-item-has-children', (array) $item->classes ) ) {
            $output .= '</li>';
        }
    }
}

?>