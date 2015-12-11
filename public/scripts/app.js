$(function()
{
    /*
    |--------------------------------------------------------------------------
    | Text selection on fields with Autofocus
    |--------------------------------------------------------------------------
    */
    $('[autofocus]').eq(0).focus().select();

    /*
    |--------------------------------------------------------------------------
    | Confirm Dialog
    |--------------------------------------------------------------------------
    */
    $(document).on('click', '[data-confirm]', function(event) {
        event.preventDefault();

        if (confirm($(this).attr('data-confirm'))) {
            if ($(this).is('a')) {
                window.location = $(this).attr('href');
            } else if ($(this).attr('type') == 'submit' || $(this).attr('type') == 'button') {
                $(this).removeAttr('data-confirm');
                $(this).click();
            }
        }
    });
})
