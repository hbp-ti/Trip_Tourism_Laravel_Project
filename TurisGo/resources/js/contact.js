document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('.contact-form');
    
    form.addEventListener('submit', function(event) {
        event.preventDefault();
        
        Swal.fire({
            icon: 'success',
            title: translate('Message Sent'),
            text: translate('Your support message has been sent successfully. We will get back to you soon!'),
            confirmButtonText: translate('OK'),
            confirmButtonColor: '#2081A5'
        }).then((result) => {
            if (result.isConfirmed) {
            }
        });
    });
});