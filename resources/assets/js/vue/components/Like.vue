<template>
	<span>
		<template>
			<a href="#" @click="giveLikeOrDislike()" class="like-icon" :class="iconState()" title=""></a>
			<i>{{ allLikes }}</i>
		</template>
	</span>
</template>

<script>
export default {
  data() {
    return {
      liked: false,
      allLikes: this.likes
    };
  },

  props: ["likes", "recipeId"],

  created() {
    this.fetchVisitorLikes();
  },

  methods: {
    iconState() {
      return this.liked ? "like-icon-full" : "like-icon-empty";
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
    giveLikeOrDislike() {
      var state = this.liked == false ? "like" : "dislike";

      fetch("/api/recipes/other/" + state + "/" + this.recipeId, {
        method: "post"
      })
        .then(res => res.json())
        .then(data => {
          this.changeLikeButton(data.liked);
          this.changeLikeNumber(data.liked);
        })
        .catch(err => console.log(err));
    }
  }
};
</script>