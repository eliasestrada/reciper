<template>
    <span>
        <a href="#" @click="toggleButton()" class="like-icon" :class="iconState()">
            <div class="btn-wrapper">
                <a class="btn-like"><slot></slot></a>
            </div>
        </a>
        <audio ref="audio" src="/storage/audio/like-effect.mp3" type="audio/mpeg"></audio>
        <i id="_all-likes">{{ allLikes }}</i>
    </span>
</template>

<script>
export default {
    data() {
        return {
        liked: false,
        allLikes: this.likes,
        processed: true
        };
    },

    props: ["likes", "recipeId"],

    created() {
        this.fetchVisitorLikes();
    },

    methods: {
        iconState() {
            return this.liked ? "btn--liked-small" : "";
        },
        
        fetchVisitorLikes() {
            fetch("/api/recipes/other/check-if-liked/" + this.recipeId, {
                method: "post"
            })
                .then(res => res.json())
                .then(data => this.changeLikeButton(data))
                .catch(err => console.log(err));
            },
        
        changeLikeButton(value) {
            this.liked = value == 0 ? false : true;
        },
        
        changeLikeNumber(value) {
            value == 0 ? this.allLikes-- : this.allLikes++;
        },

        playSound() {
            this.$refs.audio.volume = 0.2
            this.$refs.audio.play()
        },
        
        toggleButton() {
            if (this.processed) {
                this.processed = false
                var state = this.liked == false ? "like" : "dislike"

                fetch("/api/recipes/other/" + state + "/" + this.recipeId, {method: "post"})
                    .then(res => res.json())
                    .then(data => {
                        this.playSound()
                        this.changeLikeButton(data.liked)
                        this.changeLikeNumber(data.liked)
                        this.processed = true
                    })
                    .catch(err => console.log(err));
            }
        },
    }
};
</script>