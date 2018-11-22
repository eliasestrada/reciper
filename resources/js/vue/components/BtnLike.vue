<template>
    <section class="ml-2 d-inline-block">
        <a v-if="userId" class="p-0 _like-button" @click="fetchLikes">
            
            <i class="fas fa-heart fa-15x heart" :class="iconClass"></i> 
            <span v-text="amount" style="transform:translate(-2px, 5px);color:#6b6b6b" class="d-inline-block"></span>
        </a>
        <a v-else class="p-0 tooltipped" :data-tooltip="tooltip" data-position="right">
            <i class="fas fa-heart fa-15x heart"></i> 
            <span v-text="amount" style="transform:translate(-4px, 5px);color:#6b6b6b" class="d-inline-block"></span>
        </a>
    </section>
</template>

<script>
import withMethod from '../../modules/_withMethod';

export default {
    data() {
        return {
            iconClass: '',
            amount: this.likes.length,
            audio: new Audio(this.audioPath),
        };
    },

    created() {
        this.toggleActive();
    },

    props: ['likes', 'recipeId', 'userId', 'tooltip', 'audioPath'],

    methods: {
        fetchLikes() {
            fetch(`/like/${this.recipeId}`, withMethod('post'))
                .then(res => res.text())
                .then(data => {
                    if (data != 'fail') {
                        this.iconClass = data;
                        this.playSoundEffect();
                        data == 'active' ? this.amount++ : this.amount--;
                    }
                })
                .catch(err => console.error(err));
        },

        playSoundEffect() {
            this.audio.volume = 0.3;
            this.audio.play();
        },

        toggleActive() {
            if (this.userId) {
                let that = this;
                let checkIfLikedBefore = this.likes.filter(like => {
                    return that.recipeId == like.recipe_id && that.userId == like.user_id;
                });
                this.iconClass = checkIfLikedBefore.length > 0 ? 'active' : '';
            }
        },
    },
};
</script>