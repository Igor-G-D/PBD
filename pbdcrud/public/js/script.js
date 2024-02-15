$(document).ready(function() {
    $(".dropdown-trigger").dropdown({
        'coverTrigger': false
    });

    $(".dropFilters").dropdown({
        'coverTrigger': false,
        'closeOnClick': false,
        'constrainWidth': false
    });

    $(".dropOrder").dropdown({
        'coverTrigger': false,
        'closeOnClick': false,
        'constrainWidth': false
    });

    $(document).ready(function(){
        $('select').formSelect();
    });

    $('.tabs').tabs();
});

