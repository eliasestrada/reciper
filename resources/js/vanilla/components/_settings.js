if ($("collapsible-li-tag") && window.innerWidth > 600) {
    setTimeout(() => {
        document
            .querySelector("#collapsible-li-tag .collapsible-body")
            .setAttribute("style", "display:block");
        $("collapsible-li-tag").classList.add("active");
    }, 1);
}
