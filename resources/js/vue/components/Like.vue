<script>
export default {
    data() {
        return {
            liked: false,
            allLikes: this.likes,
            processed: true,
            visitorLikesNumber: $('visitor-likes-number'),
            visitorLikesIcon: $('visitor-likes-icon')
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
            fetch(`/api/like/check/${this.recipeId}`, {
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

        changeVisitorLikesNumber() {
            if (this.liked) {
                setTimeout(() => {
                    this.visitorLikesIcon.classList.remove('d-inline-block')
                    var number = (this.visitorLikesNumber.innerHTML);
                    number--;
                    if (number < 1) {
                        this.visitorLikesIcon.classList.add('hide')
                    }
                    this.visitorLikesNumber.innerHTML = number;
                }, 300);
            } else {
                setTimeout(() => {
                    this.visitorLikesIcon.classList.add('d-inline-block')
                    var number = this.visitorLikesNumber.innerHTML;
                    number++;
                    this.visitorLikesNumber.innerHTML = number;
                }, 300);
            }
        },
        
        toggleButton() {
            if (this.processed) {
                this.processed = false
                var state = this.liked == false ? "like" : "dislike"
                this.changeVisitorLikesNumber()

                fetch(`/api/like/${state}/${this.recipeId}`, {method: "post"})
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