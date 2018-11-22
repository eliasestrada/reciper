<template>
    <section>
        <a v-if="userId" class="p-0 _fav-button" @click="fetchFavs">
            <i class="fas fa-star fa-15x star" :class="iconClass"></i> 
            <span v-text="amount" style="transform:translate(-2px, 5px);color:#6b6b6b" class="d-inline-block"></span>
        </a>
        <a v-else class="p-0 tooltipped" :data-tooltip="tooltip" data-position="bottom">
            <i class="fas fa-star fa-15x star"></i> 
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
            amount: this.favs.length,
            audio: new Audio(this.audioPath),
        };
    },

    created() {
        this.toggleActive();
    },

    props: ['recipeId', 'favs', 'userId', 'tooltip', 'audioPath'],

    methods: {
        fetchFavs() {
            fetch(`/favs/${this.recipeId}`, withMethod('post'))
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
                let checkIfAddedBefore = this.favs.filter(fav => {
                    return that.recipeId == fav.recipe_id && that.userId == fav.user_id;
                });
                this.iconClass = checkIfAddedBefore.length > 0 ? 'active' : '';
            }
        },
    },
};
</script>