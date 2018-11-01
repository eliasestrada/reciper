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
