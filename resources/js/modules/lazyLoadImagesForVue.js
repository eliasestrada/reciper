export default function(element = null) {
    const images = document.querySelectorAll('img.lazy-load-img-vue')

    if (element) {
        setTimeout(() => {
            element.style.display = 'block'
            element.parentElement.querySelector('.placeholder-image').style.display = 'none'
        }, 0)
    } else if (images.length > 0) {
        images.forEach(img => {
            setTimeout(() => {
                img.style.display = 'block'
                img.parentElement.querySelector('.placeholder-image').style.display = 'none'
            }, 0)
        })
    }
}