if ($("ready-checkbox")) {
    checkCheckboxThenSubmit("ready-checkbox", "publish-btn");
}

if (imageUploader.src && imageUploader.target) {
    imageUploader.showImage();
}
