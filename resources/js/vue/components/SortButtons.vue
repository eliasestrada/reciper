<template>
    <div>
        <a :href="'/recipes#' + btn.link" v-for="btn in btns" :key="btn.link" :class="{ 'active': btn.isActive }" class="btn btn-sort main-text">
            <i class="material-icons red-text left">{{ btn.icon }}</i>
            {{ btn.title }}
        </a>
    </div>
</template>

<script>
export default {
    props: ['newBtn', 'simpleBtn', 'myViewesBtn', 'mostLikedBtn', 'myLikesBtn', 'breakfastBtn', 'lunchBtn', 'dinnerBtn'],
    data() {
        return {
            btns: [
                {
                    title: this.newBtn,
                    icon: 'watch_later',
                    link: 'new',
                    isActive: false
                },
                {
                    title: this.mostLikedBtn,
                    icon: 'star',
                    link: 'most_liked',
                    isActive: false
                },
                {
                    title: this.simpleBtn,
                    icon: 'library_books',
                    link: 'simple',
                    isActive: false
                },
                {
                    title: this.breakfastBtn,
                    icon: 'restaurant',
                    link: 'breakfast',
                    isActive: false
                },
                {
                    title: this.lunchBtn,
                    icon: 'restaurant',
                    link: 'lunch',
                    isActive: false
                },
                {
                    title: this.dinnerBtn,
                    icon: 'restaurant',
                    link: 'dinner',
                    isActive: false
                },
                {
                    title: this.myViewesBtn,
                    icon: 'remove_red_eye',
                    link: 'my_viewes',
                    isActive: false
                },
                {
                    title: this.myLikesBtn,
                    icon: 'favorite',
                    link: 'my_likes',
                    isActive: false
                },
            ]
        }
    },

    created() {
        Event.$on('hash-changed', (hash) => {
            this.btns[0].isActive = true
            if (hash != '') {
                this.btns.forEach((btn) => {
                    if (btn.link == hash) {
                        btn.isActive = true
                    } else {
                        btn.isActive = false
                    }
                })
            }
        })
    }
}
</script>