<template>
    <section>
        <a v-if="userId" class="p-0 _fav-button" @click="fetchItems">
            <i class="fas fa-star fa-15x star" :class="iconClass"></i> 
            <span v-text="amount"
                style="transform:translate(-2px, 5px);color:#6b6b6b"
                class="d-inline-block"
            ></span>
        </a>
        <a v-else class="p-0 tooltipped"
            :data-tooltip="tooltip"
            data-position="bottom"
        >
            <i class="fas fa-star fa-15x star"></i> 
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
            url: `/favs/${this.recipeId}`,
        }
    },
    mixins: [BtnItem],
}
</script>