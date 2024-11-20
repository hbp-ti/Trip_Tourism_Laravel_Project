document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('.contact-form');
    
    form.addEventListener('submit', function(event) {
        event.preventDefault();
        
        Swal.fire({
            icon: 'success',
            title: 'Message Sent',
            text: 'Your support message has been sent successfully. We will get back to you soon!',
            confirmButtonText: 'Ok',
            confirmButtonColor: '#2081A5'
        }).then((result) => {
            if (result.isConfirmed) {
            }
        });
    });
});