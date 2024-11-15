$(document).ready(function() {
    const editButton = $('.edit-button');
    const inputs = $('.profile-info input');

    editButton.click(function() {
        if (editButton.text() === 'Edit') {
            inputs.removeAttr('readonly');
            editButton.text('Save');
        } else {
            inputs.attr('readonly', true);
            editButton.text('Edit');
        }
    });
});
