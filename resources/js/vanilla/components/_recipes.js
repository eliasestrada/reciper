(function ReadyCheckbox() {
    let checkbox = $("ready-checkbox");
    let publishBtn = $("publish-btn");

    if (checkbox) {
        publishBtn.addEventListener("click", () => {
            if (confirm(publishBtn.getAttribute("data-alert"))) {
                if ((checkbox.checked = true)) {
                    checkbox.closest("form").submit();
                }
            }
        });
    }
})();

(function ImageUploader() {
    if (imageUploader.src && imageUploader.target) {
        imageUploader.showImage();
    }
})();

(function PopupWindowShowMore() {
    let popupTrigger = $("popup-window-trigger");
    let popupWindow = $("popup-window");

    if (popupTrigger && popupWindow) {
        activeAfterClickBtn("popup-window", "popup-window-trigger");
    }
})();

(function IncreaseFontSize() {
    let incFontSizeBtn = $('inc-font-size');
    let dicFontSizeBtn = $('dic-font-size');
    let elements = document.querySelectorAll('.font-scalable');

    incFontSizeBtn.addEventListener('click', () => {
        elements.forEach(el => {
            let currentSize = parseFloat(el.style.fontSize);

            if (el.style.fontSize == "") el.style.fontSize = "1.05em";

            if (currentSize <= 1.5 && currentSize >= 0.9) {
                el.style.fontSize = currentSize + 0.1 + "em"
            }
        });
    });

    dicFontSizeBtn.addEventListener('click', () => {
        elements.forEach(el => {
            let currentSize = parseFloat(el.style.fontSize);

            if (currentSize <= 1.6 && currentSize >= 1) {
                el.style.fontSize = currentSize - 0.1 + "em"
            }
        });
    });
})();
