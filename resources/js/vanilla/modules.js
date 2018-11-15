'use strict';

/**
 * A simple way to cut 'document.getElementById'
 * @param {string} e
 */
function $(e) {
    return document.getElementById(e);
}

// Script that prevents mulltiple forms submitting
document.querySelectorAll('form').forEach(function(form) {
    form.addEventListener(
        'submit',
        function() {
            var buttons = this.querySelectorAll('button');
            buttons.forEach(function(button) {
                button.setAttribute('disabled', 'disabled');
                button.classList.add('disabled');
                button.innerHTML =
                    '<i class="fas fa-circle-notch fa-1x fa-spin"></i>';
            });
        },
        false
    );
});

let i;
