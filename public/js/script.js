$(document).ready(function () {
    let emailCounter = 2;
    const maxEmailFields = 5;

    $('#flexSwitchCheckDefault').on('change', function () {
        if ($(this).is(':checked')) {
            $('#fieldAuthors').show();
        } else {
            $('#fieldAuthors').hide();
        }
    });

    $('#addEmailField').on('click', function () {
    
        if (emailCounter <= maxEmailFields) {
            const NEXTEMAILFIELD = $(`.email-field:hidden:first`);
            NEXTEMAILFIELD.show().addClass('d-flex');
            emailCounter++;
        }
    });

    $(document).on('click', '.remove-email-field', function () {
        $(this).closest('.email-field').hide().removeClass('d-flex');
        emailCounter--;
    });
});