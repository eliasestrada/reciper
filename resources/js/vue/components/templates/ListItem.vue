<template>
    <div @click="iconState = !iconState">
        <span class="btn-floating center mr-3 left transparent" :class="classNames">
            <slot name="icon-on" v-if="iconState"></slot>
            <i class="main-text bold-text">
                <slot name="icon-off" v-if="!iconState"></slot>
            </i>
        </span>
        <slot name="item"></slot>
    </div>
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