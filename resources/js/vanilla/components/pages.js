import activeAfterClickBtn from '../../modules/addClassAfterClick'

/**
 * When visitor clicks search button, it will show the search form
 * instead of submitting, js prevents default behavior. After first click
 * it will set varible preventing to false, now after second click, it
 * will submit the search form
 */
;(function HomeHeaderSearchForm() {
    const button = document.getElementById('home-search-btn')
    const form = document.getElementById('home-search-form')
    let preventing = true

    if (form && button) {
        activeAfterClickBtn(form, button)

        button.addEventListener('click', e => {
            if (preventing) {
                e.preventDefault()
                preventing = false
            }
        })
    }
})()

/**
 * This object auto updates pictures after
 * selecting them via file input
 */
;(function runImageUploader() {
    let target = document.getElementById('target-image')
    let src = document.getElementById('src-image')
    let fr = new FileReader()

    if (target && src) {
        src.addEventListener('change', () => {
            if (src.files.length !== 0) {
                fr.readAsDataURL(src.files[0])
                fr.onload = function () {
                    target.src = this.result
                }
            } else {
                target.src = '/storage/big/recipes/default.jpg'
            }
        })
    }
})()

;(function PreventSubmittingIfNotConfirmed() {
    let buttons = document.querySelectorAll('.confirm')

    if (buttons) {
        buttons.forEach(btn => {
            btn.addEventListener('click', e => {
                if (!confirm(btn.getAttribute('data-confirm'))) {
                    e.preventDefault()
                }
            })
        })
    }
})()

;(function PreventMultipleFormSubmitting() {
    document.querySelectorAll('form').forEach(form => {
        form.addEventListener('submit', e => {
            e.target.querySelectorAll('button').forEach(btn => {
                btn.setAttribute('disabled', 'disabled')
                btn.classList.add('disabled')
                btn.innerHTML = '<i class="fas fa-circle-notch fa-1x fa-spin"></i>'
            })
        }, false)
    })
})()
