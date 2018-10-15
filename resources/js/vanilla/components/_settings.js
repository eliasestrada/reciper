if ($("visible-on-big-screen") && window.innerWidth < 600) {
    setTimeout(() => {
        $("visible-on-big-screen").removeAttribute("style", "display:block");
    }, 1);
}
