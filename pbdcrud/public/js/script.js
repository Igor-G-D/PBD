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

    $('select').formSelect();

    $('.add-playlist-button').on('click', function () {
        var button = $(this);
        var icon = button.find('.material-icons');
        var musica = button.data('musica');
        var playlist = button.data('playlist')
        var type = "musicas";
        var action = '';

        // Toggle between "favorite_border" and "favorite" icons
        if (icon.text().includes('add')) {
            action = 'add';
            icon.text('remove');
        } else {
            action = 'remove'
            icon.text('add');
        }

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // AJAX request to submit data
        $.ajax({
            type: 'POST',
            url: '/playlists/details/'+playlist+'/edit/'+action, // Replace with your actual route
            data: {
                musica: musica,
                playlist: playlist
            },
            success: function (response) {
                console.log(response); // Handle the response from the server
            },
            error: function (error) {
                console.error('Error:', error);
            }
        });
    });

    $('.favorite-button').on('click', function () {
        var button = $(this);
        var icon = button.find('.material-icons');
        var number = button.data('number');
        var type = button.data('type');
        var action = '';

        // Toggle between "favorite_border" and "favorite" icons
        if (icon.text().includes('favorite_border')) {
            action = 'like';
            icon.text('favorite');
        } else {
            action = 'unlike'
            icon.text('favorite_border');
        }

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // AJAX request to submit data
        $.ajax({
            type: 'POST',
            url: '/'+type+'/'+action, // Replace with your actual route
            data: {
                id: number
            },
            success: function (response) {
                console.log(response); // Handle the response from the server
            },
            error: function (error) {
                console.error('Error:', error);
            }
        });
    });

    $('.tabs').tabs();
});

