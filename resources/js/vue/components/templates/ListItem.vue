<template>
    <section @click="iconState = !iconState">
        <span class="btn-floating center mr-3 left transparent" :class="classNames">
            <span v-if="iconState">
                <slot name="icon-on"></slot>
            </span>
            <i class="main-text bold-text" v-else>
                <slot name="icon-off"></slot>
            </i>
        </span>
        <slot name="item"></slot>
    </section>
</template>

<script>
export default {
    data() {
        return {
            iconState: false,
        }
    },
    props: {
        classNames: {
            default: null,
        },
    },
}
</script>