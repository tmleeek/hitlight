$j = jQuery.noConflict();

$j(document).ready(function () {

    $j('.slider_tab_container').each(function () {
        var slider = $j(this).find('ul').attr('class');

        $j('.' + slider).bxSlider({
            slideWidth: 170,
            minSlides: 1,
            maxSlides: 4,
            slideMargin: 10,
            pager: false
        });
    });


    hm_tab('.project_tab_menu');
    hm_tab('.list_project_tab');

    $j('.slider_tab_container ul li').click(function () {
        var showImage = $j(this).attr('data-show');
        $j('.' + showImage + ' img').attr('src', $j(this).attr('data-image'));
    });

});


function hm_tab(parent) {
    $j(parent).each(function () {
        // For each set of tabs, we want to keep track of
        // which tab is active and its associated content
        var $active, $content, $links = $j(this).find('a');

        // If the location.hash matches one of the links, use that as the active tab.
        // If no match is found, use the first link as the initial active tab.
        $active = $j($links.filter('[href="' + location.hash + '"]')[0] || $links[0]);
        $active.addClass('active');

        $content = $j($active[0].hash);

        // Hide the remaining content
        $links.not($active).each(function () {
            $j(this.hash).hide();
        });

        // Bind the click event handler
        $j(this).on('click', 'a', function (e) {
            // Make the old tab inactive.
            $active.removeClass('active');
            $content.hide();

            // Update the variables with the new link and content
            $active = $j(this);
            $content = $j(this.hash);

            // Make the tab active.
            $active.addClass('active');
            $content.fadeIn(500);

            HeightTitle('.name_product_project', 0);

            // Prevent the anchor's default click action
            e.preventDefault();
        });
    });
}

function HeightTitle(child, pah) {
    var maxHeight = 0;

    jQuery(child).each(function () {
        jQuery(this).removeAttr('style');
        var height = jQuery(this).height();
        maxHeight = (height > maxHeight) ? height : maxHeight;
    });

    jQuery(child).removeAttr('style').css('height', (maxHeight + pah) + 'px');
}

function setHeightAuto(selector, child) {
    $j(selector).each(function () {

        var highestBox = 0;
        $j(child, this).each(function () {

            if ($j(this).height() > highestBox)
                highestBox = $j(this).height();
        });

        $j(child, this).height(highestBox);

    });
}