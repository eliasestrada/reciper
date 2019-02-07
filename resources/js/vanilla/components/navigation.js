import axios from 'axios'
import addClassAfterClick from '../../modules/addClassAfterClick'

;(function SearchFormActivator() {
    let opened = false
    const navBtnForSearch = document.getElementById('nav-btn-for-search')
    const searchInput = document.getElementById('search-input')

    if (navBtnForSearch && searchInput) {
        addClassAfterClick(navBtnForSearch, searchInput)

        navBtnForSearch.addEventListener('click', () => {
            if (opened == false) {
                searchInput.focus()
                opened = true
            } else {
                searchInput.blur()
                opened = false
            }
        })
    }
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
