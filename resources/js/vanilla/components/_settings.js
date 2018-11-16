import $ from '../modules/_main';

(function CollapsibleNavigationMenu() {
    let li = $('collapsible-li-tag');
    let body = document.querySelector('#collapsible-li-tag .collapsible-body');

    if (li && window.innerWidth > 600) {
        setTimeout(() => {
            body.setAttribute('style', 'display:block');
            li.classList.add('active');
        }, 1);
    }
})();
