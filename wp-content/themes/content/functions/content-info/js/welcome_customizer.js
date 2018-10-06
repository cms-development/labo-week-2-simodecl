jQuery(document).ready(function() {
    var content_aboutpage = contentLiteWelcomeScreenCustomizerObject.aboutpage;
    var content_nr_actions_required = contentLiteWelcomeScreenCustomizerObject.nr_actions_required;

    /* Number of required actions */
    if ((typeof content_aboutpage !== 'undefined') && (typeof content_nr_actions_required !== 'undefined') && (content_nr_actions_required != '0')) {
        jQuery('#accordion-section-themes .accordion-section-title').append('<a href="' + content_aboutpage + '"><span class="content-actions-count">' + content_nr_actions_required + '</span></a>');
    }

    /* Upsell in Customizer (Link to Welcome page) */
    if ( !jQuery( ".content-upsells" ).length ) {
        jQuery('#customize-theme-controls > ul').prepend('<li class="accordion-section content-upsells">');
    }
    if (typeof content_aboutpage !== 'undefined') {
        jQuery('.content-upsells').append('<a style="width: 80%; margin: 5px auto 15px auto; display: block; text-align: center;" href="' + content_aboutpage + '" class="button" target="_blank">{themeinfo}</a>'.replace('{themeinfo}', contentLiteWelcomeScreenCustomizerObject.themeinfo));
    }
    if ( !jQuery( ".content-upsells" ).length ) {
        jQuery('#customize-theme-controls > ul').prepend('</li>');
    }
});