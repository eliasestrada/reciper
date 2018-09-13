if ($("ready-checkbox")) {
    checkCheckboxThenSubmit("ready-checkbox", "publish-btn", () => {
        return confirm($("publish-btn").getAttribute("data-alert"))
            ? true
            : false;
    });
}

if (imageUploader.src && imageUploader.target) {
    imageUploader.showImage();
}
