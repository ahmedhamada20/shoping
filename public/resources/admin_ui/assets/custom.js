$(document).ready(function(){
    $('#chk_contact').change(function(){
        if(this.checked)
            $('#contact-section').fadeIn('slow');
        else
            $('#contact-section').fadeOut('slow');

    });
});