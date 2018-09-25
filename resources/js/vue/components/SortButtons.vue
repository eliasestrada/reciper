<template>
    <div>
        <a :href="'/recipes#' + btn.link" v-for="btn in btns" :key="btn.link" :class="{ 'active': btn.isActive }" class="btn btn-sort main-text">
            <i class="fas red-text left" :class="btn.icon"></i>
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
                    icon: 'fa-clock',
                    link: 'new',
                    isActive: false
                },
                {
                    title: this.mostLikedBtn,
                    icon: 'fa-star',
                    link: 'most_liked',
                    isActive: false
                },
                {
                    title: this.simpleBtn,
                    icon: 'fa-concierge-bell',
                    link: 'simple',
                    isActive: false
                },
                {
                    title: this.breakfastBtn,
                    icon: 'fa-utensils',
                    link: 'breakfast',
                    isActive: false
                },
                {
                    title: this.lunchBtn,
                    icon: 'fa-utensils',
                    link: 'lunch',
                    isActive: false
                },
                {
                    title: this.dinnerBtn,
                    icon: 'fa-utensils',
                    link: 'dinner',
                    isActive: false
                },
                {
                    title: this.myViewesBtn,
                    icon: 'fa-eye',
                    link: 'my_viewes',
                    isActive: false
                },
                {
                    title: this.myLikesBtn,
                    icon: 'fa-heart',
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