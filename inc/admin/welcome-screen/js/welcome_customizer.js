jQuery(document).ready(function () {
    var newspaperx_aboutpage = newspaperxWelcomeScreenCustomizerObject.aboutpage;
    var newspaperx_nr_actions_required = newspaperxWelcomeScreenCustomizerObject.nr_actions_required;

    /* Number of required actions */
    if ((typeof newspaperx_aboutpage !== 'undefined') && (typeof newspaperx_nr_actions_required !== 'undefined') && (newspaperx_nr_actions_required != '0')) {
        jQuery('#accordion-section-themes .accordion-section-title').append('<a href="' + newspaperx_aboutpage + '"><span class="newspaperx-actions-count">' + newspaperx_nr_actions_required + '</span></a>');
    }


});
