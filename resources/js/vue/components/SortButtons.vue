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
    props: ['newBtn', 'watchedBtn', 'popularBtn'],
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
                    title: this.watchedBtn,
                    icon: 'remove_red_eye',
                    link: 'viewed',
                    isActive: false
                },
                {
                    title: this.popularBtn,
                    icon: 'favorite',
                    link: 'popular',
                    isActive: false
                },
            ]
        }
    },

    created() {
        Event.$on('hash-changed', (hash) => {
            this.btns.forEach((btn) => {
                if (btn.link == hash) {
                    btn.isActive = true
                } else {
                    btn.isActive = false
                }
            })
        })
    },
    
    methods: {
        makeFirstRequest() {
            alert('nice')
        }
    }
}
</script>