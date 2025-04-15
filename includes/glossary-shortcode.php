<?php
// Shortcode for rendering glossary items and live search form
function glossary_shortcode($atts) {
    // Default shortcode attributes
    $atts = shortcode_atts(apply_filters('glossary_shortcode_defaults', array(
        'show_excerpt'       => 'false',
        'show_letters'       => 'false',
        'only_active_letters'=> 'false',
        'post_type'          => 'glossary_item', // Default post type
    )), $atts, 'glossary_search_shortcode');

    $show_excerpt        = filter_var($atts['show_excerpt'], FILTER_VALIDATE_BOOLEAN);
    $show_letters        = filter_var($atts['show_letters'], FILTER_VALIDATE_BOOLEAN);
    $only_active_letters = filter_var($atts['only_active_letters'], FILTER_VALIDATE_BOOLEAN);
    $post_type           = sanitize_text_field($atts['post_type']); // Sanitize the custom post type

    ob_start();    
    ?>
    <div class="container glossary-container">
        <div class="row mb-3">
            <div class="col-md-12">
                <form id="glossary-search-form" action="">
                    <input type="text" id="search-input" class="form-control" placeholder="Search...">
                </form>
            </div>
        </div>

        <?php
        // Fetch all glossary items for letter grouping and content rendering
        $args = array(
            'post_type'      => $post_type, // Use dynamic post type
            'posts_per_page' => -1,
            'orderby'        => 'title',
            'order'          => 'ASC',
        );

        $query = new WP_Query($args);
        $posts_by_letter = array();

        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();
                $title = get_the_title();
                $first_letter = strtoupper(substr($title, 0, 1));
                $posts_by_letter[$first_letter][] = get_the_ID();
            }
            wp_reset_postdata();
        }

        if ($show_letters) : ?>
        <div class="alphabet-nav mb-4 text-center">
            <?php foreach (range('A', 'Z') as $char) :
                if ($only_active_letters && empty($posts_by_letter[$char])) {
                    continue;
                }
                ?>
                <a href="#group-<?php echo esc_attr($char); ?>" class="mx-1 alphabet-link"><?php echo esc_html($char); ?></a>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

        <div class="row">
            <div class="col-md-12" id="glossary-list">
                <?php
                $current_letter = '';

                if (!empty($posts_by_letter)) :
                    echo '<div class="glossary-groups">';

                    foreach (range('A', 'Z') as $char) {
                        if (empty($posts_by_letter[$char])) {
                            continue;
                        }

                        echo '<div class="glossary-group-wrapper row">';
                        echo '<h3 id="group-' . esc_attr($char) . '" class="col-md-2 group-title">' . esc_html($char) . '</h3>';
                        echo '<div class="col-md-10 glossary-group">';

                        foreach ($posts_by_letter[$char] as $post_id) {
                            $title = get_the_title($post_id);
                            $permalink = get_permalink($post_id);

                            $custom_link = esc_url(get_post_meta($post_id, '_glossary_link', true));
                            $link = !empty($custom_link) ? $custom_link : $permalink;

                            echo '<p><a href="' . esc_url($link) . '">' . esc_html($title) . '</a>';

                            if ($show_excerpt) {
                                $excerpt = get_the_excerpt($post_id);
                                if (!empty($excerpt)) {
                                    echo '<br><small>' . esc_html($excerpt) . '</small>';
                                }
                            }

                            echo '</p>';
                        }

                        echo '</div></div>'; // Close group
                    }

                    echo '</div>'; // Close glossary-groups
                endif;
                ?>
            </div>
        </div>
    </div>    
    <?php
    return ob_get_clean();
}
add_shortcode('glossary_search_shortcode', 'glossary_shortcode');
