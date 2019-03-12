<template>
    <section class="ml-2 d-inline-block">
        <a v-if="userId" class="p-0 _like-button" @click="fetchItems">
            <i class="fas fa-heart fa-15x heart" :class="iconClass"></i> 
            <span v-text="amount"
                style="transform:translate(-2px, 5px);color:#6b6b6b"
                class="d-inline-block"
            ></span>
        </a>

        <a v-else class="p-0 tooltipped" :data-tooltip="tooltip" data-position="right">
            <i class="fas fa-heart fa-15x heart"></i> 
            <span v-text="amount"
                style="transform:translate(-4px, 5px);color:#6b6b6b"
                class="d-inline-block"
            ></span>
        </a>
    </section>
</template>

<script>
import BtnItem from '../mixins/BtnItem'

export default {
    data() {
        return {
            url: `/likes/${this.recipeId}`,
        }
    },
    mixins: [BtnItem],
}
</script>