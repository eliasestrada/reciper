import $ from '../../modules/_main';
import lazyLoadImages from '../../modules/_lazyLoadImages';
import activeAfterClickBtn from '../../modules/_activeAfterClickBtn';
import axios from 'axios';

(function ReadyCheckbox() {
    let checkbox = $('ready-checkbox');
    let publishBtn = $('publish-btn');

    if (checkbox) {
        publishBtn.addEventListener('click', () => {
            if (confirm(publishBtn.getAttribute('data-alert'))) {
                if ((checkbox.checked = true)) {
                    checkbox.closest('form').submit();
                }
            }
        });
    }
})();

(function PopupWindowShowMore() {
    let popupTrigger = $('popup-window-trigger');
    let popupWindow = $('popup-window');

    if (popupTrigger && popupWindow) {
        activeAfterClickBtn('popup-window', 'popup-window-trigger');
    }
})();

(function IncreaseFontSize() {
    let incFontSizeBtn = $('inc-font-size');
    let dicFontSizeBtn = $('dic-font-size');
    let elements = document.querySelectorAll('.font-scalable');

    if (incFontSizeBtn && dicFontSizeBtn) {
        incFontSizeBtn.addEventListener('click', () => {
            elements.forEach(el => {
                let currentSize = parseFloat(el.style.fontSize);
                let newFontSize = currentSize + 0.1;

                if (currentSize <= 1.5 && currentSize >= 0.9) {
                    el.style.fontSize = newFontSize + 'em';
                    axios.get(`/invokes/font-size-switcher/${newFontSize}`)
                        .catch(err => console.error(err));
                }
            });
        });

        dicFontSizeBtn.addEventListener('click', () => {
            elements.forEach(el => {
                let currentSize = parseFloat(el.style.fontSize);
                let newFontSize = currentSize - 0.1;

                if (currentSize <= 1.6 && currentSize >= 1) {
                    el.style.fontSize = newFontSize + 'em';
                    axios.get(`/invokes/font-size-switcher/${newFontSize}`)
                        .catch(err => console.error(err));
                }
            });
        });
    }
})();

(function HideBlurImageAndShowOriginal() {
    lazyLoadImages()
})();

(function RemoveEmptyLinesFromTextareaWithLines() {
    let fields = document.querySelectorAll('.textarea-lines')
    let regex = /^\s*[\r\n]/gm

    if (fields) {
        fields.forEach(field => {
            field.addEventListener('focusout', () => {
                field.value = field.value.replace(regex, '')
                field.value = field.value.trim()
                M.textareaAutoResize(field)
            })
        })
    }
})();