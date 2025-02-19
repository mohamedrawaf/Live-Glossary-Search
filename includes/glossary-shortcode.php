<?php
// Shortcode for rendering glossary items and live search form
function glossary_shortcode($atts) {
    ob_start();    
    ?>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <form id="glossary-search-form" action="">
                    <input type="text" id="search-input" class="form-control" placeholder="Search...">
                </form>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-12" id="glossary-list">
                <?php
                // Fetch and display all posts by first letter
                // Modify this loop as needed to retrieve glossary posts
                $args = array(
                    'post_type'      => 'glossary_item', // Adjust the post type
                    'posts_per_page' => -1,
                    'orderby'        => 'title',
                    'order'          => 'ASC',
                );

                $query = new WP_Query($args);

                $current_letter = '';

                if ($query->have_posts()) :
                    echo '<div class="glossary-groups">';
                    
                    while ($query->have_posts()) :
                        $query->the_post();
                        $title = get_the_title();
                        $permalink = get_permalink();
                
                        // Check if "_glossary_link" custom field is set
                        $custom_link = get_post_meta(get_the_ID(), '_glossary_link', true);
                
                        // Use the custom link if available, otherwise use the permalink
                        $link = !empty($custom_link) ? $custom_link : $permalink;
                
                        $first_letter = strtoupper(substr($title, 0, 1));
                
                        if ($first_letter !== $current_letter) {
                            if ($current_letter !== '') {
                                echo '</div>'; // Close the previous group
                                echo '</div>'; // Close the previous glossary-group-wrapper
                            }
                            echo '<div class="glossary-group-wrapper row">';
                            echo '<h3 class="col-md-2 group-title">' . $first_letter . '</h3>';
                            echo '<div class="col-md-10 glossary-group">';
                            $current_letter = $first_letter;
                        }
                
                        // Output the post title as a link
                        echo '<p><a href="' . esc_url($link) . '">' . $title . '</a></p>';
                    endwhile;
                    echo '</div>'; // Close the last group

                    echo '</div>'; // Close glossary-groups

                    echo '</div>'; // Close glossary-group-wrapper
                endif;
                wp_reset_postdata();
                ?>
            </div>
        </div>
    </div>    
   
    <?php
    return ob_get_clean();
}
add_shortcode('glossary_search_shortcode', 'glossary_shortcode');