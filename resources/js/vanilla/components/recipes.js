import lazyLoadImages from '../../modules/lazyLoadImages'
import addClassAfterClick from '../../modules/addClassAfterClick'
import axios from 'axios'

;(function ReadyCheckbox() {
    const checkbox = document.getElementById('ready-checkbox')
    const publishBtn = document.getElementById('publish-btn')

    if (checkbox) {
        publishBtn.addEventListener('click', () => {
            if (confirm(publishBtn.getAttribute('data-alert'))) {
                if (checkbox.checked = true) {
                    checkbox.closest('form').submit()
                }
            }
        })
    }
})()

;(function PopupWindowShowMore() {
    const btn = document.getElementById('popup-window-trigger')
    const target = document.getElementById('popup-window')

    ;(target && btn) ? addClassAfterClick(target, btn) : ''
})()

;(function IncreaseFontSize() {
    let incFontSizeBtn = document.getElementById('inc-font-size')
    let dicFontSizeBtn = document.getElementById('dic-font-size')
    let elements = document.querySelectorAll('.font-scalable')

    if (incFontSizeBtn && dicFontSizeBtn) {
        incFontSizeBtn.addEventListener('click', () => {
            elements.forEach(el => {
                const currentSize = parseFloat(el.style.fontSize)
                const newFontSize = currentSize + 0.1

                if (currentSize <= 1.5 && currentSize >= 0.9) {
                    el.style.fontSize = newFontSize + 'em'
                    axios.get(`/invokes/font-size-switcher/${newFontSize}`)
                        .catch(err => console.error(err))
                }
            })
        })

        dicFontSizeBtn.addEventListener('click', () => {
            elements.forEach(el => {
                const currentSize = parseFloat(el.style.fontSize)
                const newFontSize = currentSize - 0.1

                if (currentSize <= 1.6 && currentSize >= 1) {
                    el.style.fontSize = newFontSize + 'em'
                    axios.get(`/invokes/font-size-switcher/${newFontSize}`)
                        .catch(err => console.error(err))
                }
            })
        })
    }
})()

;(function HideBlurImageAndShowOriginal() {
    lazyLoadImages()
})()

;(function RemoveEmptyLinesFromTextareaWithLines() {
    const fields = document.querySelectorAll('.textarea-lines')
    const regex = /^\s*[\r\n]/gm

    if (fields) {
        fields.forEach(field => {
            field.addEventListener('focusout', () => {
                field.value = field.value.replace(regex, '')
                field.value = field.value.trim()
                M.textareaAutoResize(field)
            })
        })
    }
})()