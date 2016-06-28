jQuery(document).ready(function () {
    var bugle_aboutpage = ensignWelcomeScreenCustomizerObject.aboutpage;
    var bugle_nr_actions_required = ensignWelcomeScreenCustomizerObject.nr_actions_required;

    /* Number of required actions */
    if ((typeof bugle_aboutpage !== 'undefined') && (typeof bugle_nr_actions_required !== 'undefined') && (bugle_nr_actions_required != '0')) {
        jQuery('#accordion-section-themes .accordion-section-title').append('<a href="' + bugle_aboutpage + '"><span class="bugle-actions-count">' + bugle_nr_actions_required + '</span></a>');
    }


});
