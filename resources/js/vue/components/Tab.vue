<template>
    <div v-show="active"><slot></slot></div>
</template>

<script>
export default {
    data() {
        return {
            active: false
        }
    },

    props: {
        name: { required: true },
        selected: { default: false }
    },
     
    mounted() {
        this.active = this.selected
    },
    computed: {
        href() {
            return '#' + this.name.toLowerCase().replace(/ /g, '-')
        }
    }
}
</script>