jQuery(document).ready(function() {
    // Live search/filter functionality
    jQuery('#search-input').keyup(function() {
        var searchValue = jQuery(this).val().toLowerCase();
        jQuery('#glossary-list p').filter(function() {
            jQuery(this).toggle(jQuery(this).text().toLowerCase().indexOf(searchValue) > -1);
        });

        jQuery('#glossary-list h3').each(function() {
            var hasVisibleItems = jQuery(this).nextUntil('h3:visible').length > 0;
            jQuery(this).toggle(hasVisibleItems);
        });

        glossary_hide_empty_groups();
    });
});

// Loop through each letter group and hide if no posts are visible
function glossary_hide_empty_groups(){        
    jQuery('.glossary-group-wrapper').each(function() {
        var group_wrapper = jQuery(this);
        group_wrapper.show(); //show it by default
        var $visiblePosts = group_wrapper.find('p:visible');                
        if ($visiblePosts.length === 0) {
            group_wrapper.hide();
        } else {
            group_wrapper.show();
        }
    });
}