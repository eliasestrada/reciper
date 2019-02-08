import axios from 'axios'
import addClassAfterClick from '../../modules/addClassAfterClick'

;(function SearchFromWillAppearAfterBtnWillBeClicked() {
    const btn = document.getElementById('nav-btn-for-search')
    const el = document.getElementById('nav-search-form')
    const input = el.querySelector('#search-input')

    ;(btn && el && input)
        ? addClassAfterClick(el, btn, 'active', () => input.focus(), () => input.blur())
        : ''
})()

;(function DarkThemeSwitcher() {
    const button = document.getElementById('dark-theme-toggle')
    const className = document.body.classList
    const urlWithState = state => `/invokes/dark-theme-switcher/${state}`

    button.addEventListener('click', () => {
        if (className.value === 'dark-theme') {
            className.remove('dark-theme')
            axios.get(urlWithState(0)).catch(e => console.error(e))
        } else {
            className.add('dark-theme')
            axios.get(urlWithState(1)).catch(e => console.error(e))
        }
    })
})()

;(function MarkNotificationsAsRead() {
    const button = document.getElementById('mark-notifs-as-read')
    const alertIcon = document.querySelector('#mark-notifs-as-read span')

    if (button && alertIcon) {
        button.addEventListener('click', () => {
            alertIcon.classList.remove('small-notif')
            axios.put('/invokes/notifications').catch(e => console.error(e))
        })
    }
})()
