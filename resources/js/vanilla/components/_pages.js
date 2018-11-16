import $ from '../modules/_main';
import activeAfterClickBtn from '../modules/_activeAfterClickBtn';

/**
 * When visitor clicks search button, it will show the search form
 * instead of submitting, js prevents default behavior. After first click
 * it will set varible preventing to false, now after second click, it
 * will submit the search form
 */
(function HomeHeaderSearchForm() {
    let preventing = true;
    let button = $('home-search-btn');
    let form = $('home-search-form');

    if (form && button) {
        activeAfterClickBtn('home-search-form', 'home-search-btn');

        button.addEventListener('click', e => {
            if (preventing) {
                e.preventDefault();
                preventing = false;
            }
        });
    }
})();

/**
 * This object auto updates pictures after
 * selecting them via file input
 */
(function runImageUploader() {
    let target = $('target-image');
    let src = $('src-image');
    let fr = new FileReader();

    if (target && src) {
        src.addEventListener('change', () => {
            if (src.files.length !== 0) {
                fr.readAsDataURL(src.files[0]);
                fr.onload = function() {
                    target.src = this.result;
                };
            } else {
                target.src = '/storage/recipes/default.jpg';
            }
        });
    }
})();

(function PreventSubmittingIfNotConfirmed() {
    let buttons = document.querySelectorAll('.confirm');

    if (buttons) {
        buttons.forEach(btn => {
            btn.addEventListener('click', e => {
                if (!confirm(btn.getAttribute('data-confirm'))) {
                    e.preventDefault();
                }
            });
        });
    }
})();

(function PreventMultipleFormSubmitting() {
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
})();
