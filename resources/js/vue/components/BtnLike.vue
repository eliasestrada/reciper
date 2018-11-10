<template>
    <section class="ml-2 d-inline-block">
        <a v-if="userId" class="p-0 _like-button" @click="fetchLikes">
            
            <i class="fas fa-heart fa-15x heart" :class="iconClass"></i> 
            <span v-text="amount" style="transform:translate(-2px, 5px);color:#6b6b6b" class="d-inline-block"></span>
        </a>
        <a v-else class="p-0 tooltipped" :data-tooltip="tooltip" data-position="bottom">
            <i class="fas fa-star fa-15x heart"></i> 
            <span v-text="amount" style="transform:translate(-4px, 5px);color:#6b6b6b" class="d-inline-block"></span>
        </a>
    </section>
</template>

<script>
export default {
    data() {
        return {
            iconClass: '',
            amount: this.likes.length,
        };
    },

    created() {
        this.toggleActive()
    },

    props: ["likes", "recipeId", "userId", "tooltip"],

    methods: {
        fetchLikes() {
            fetch(`/like/${this.recipeId}`, {
                method: "POST",
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    _token: document.querySelector('meta[name="csrf-token"]')
                        .getAttribute('content')
                })
            })
                .then(res => res.text())
                .then(data => {
                    if (data != 'fail') {
                        this.iconClass = data
                        if (data == 'active') {
                            this.amount++
                        } else {
                            this.amount--
                        }
                    }
                })
                .catch(err => console.error(err));
        },

        toggleActive() {
            if (this.userId) {
                this.iconClass = this.likes.map(like => {
                    return this.recipeId == like.recipe_id && this.userId == like.user_id ? 'active' : '';
                });
            }
        },
    }
};
</script>