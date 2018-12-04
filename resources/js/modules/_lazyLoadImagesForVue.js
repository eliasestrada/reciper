export default function () {
    let images = document.querySelectorAll('img.lazy-load-img-vue')

    if (images.length > 0) {
        images.forEach(img => {
            setTimeout(() => {
                img.style.display = 'block'
                img.parentElement.querySelector('.placeholder-image').style.display = 'none'
            }, 0)
        })
    }
}