export default function () {
    let images = document.querySelectorAll('img.lazy-load-img')

    if (images) {
        images.forEach(img => {
            let bigImg = document.createElement('img')
            let newSrc = img.getAttribute('data-lazy-load')

            bigImg.onload = () => img.src = bigImg.src;

            setTimeout(() => {
                bigImg.src = img.src = newSrc
            }, 10);
        })
    }
}