export default function () {
    let images = document.querySelectorAll('img.lazy-load-img')

    if (images) {
        images.forEach(img => {
            img.onload = () => {
                let holder = img.parentElement.querySelector('.placeholder-image')

                setTimeout(() => {
                    img.style.display = 'block'
                    holder.style.display = 'none'
                }, 0);
            };
        })
    }
}