<template>
    <div>
        <a :href="`/recipes#${btn.link}`" v-for="btn in btns"
            :key="btn.link"
            :class="{ 'active': btn.isActive }"
            class="btn btn-sort"
        >
            <i class="fas red-text left" :class="btn.icon"></i>
            <span v-text="btn.title"></span>
        </a>
    </div>
</template>

<script>
import SortButtons from '../mixins/SortButtons'

export default {
    mixins: [SortButtons],

    props: [
        'newBtn',
        'simpleBtn',
        'myViewesBtn',
        'mostLikedBtn',
        'breakfastBtn',
        'lunchBtn',
        'dinnerBtn',
    ],

    created() {
        this.buttonWasClicked()
    },

    methods: {
        buttonWasClicked() {
            Event.$on('hash-changed', hash => {
                this.btns[0].isActive = true

                if (hash != '') {
                    this.btns.forEach(btn => {
                        btn.isActive = btn.link == hash ? true : false
                    })
                }
            })
        },
    },
}
</script>
