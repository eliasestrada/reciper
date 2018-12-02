export default function () {
    let images = document.querySelectorAll('img.lazy-load-img')

    if (images) {
        images.forEach(img => {
            let bigImg = document.createElement('img')

            bigImg.onload = () => {
                img.src = bigImg.src
                img.classList.remove('blur')
                img.classList.add('noblur')
            }

            setTimeout(() => {
                bigImg.src = img.src.replace('/blur/', '/small/')
            }, 10);
        })
    }
}