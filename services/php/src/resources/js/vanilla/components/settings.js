;(function CollapsibleNavigationMenu() {
    const li = document.getElementById('collapsible-li-tag')
    const body = document.querySelector('#collapsible-li-tag .collapsible-body')

    if (li && window.innerWidth > 600) {
        setTimeout(() => {
            body.setAttribute('style', 'display:block')
            li.classList.add('activated')
        }, 1)
    }
})()
