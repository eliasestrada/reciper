import './bootstrap';

window.Event = new Vue();

Vue.component('random-recipes-sidebar', require('./components/RandomRecipesSidebar'));
Vue.component('delete-recipe-btn', require('./components/DeleteRecipeBtn'));
Vue.component('categories-field', require('./components/CategoriesField'));
Vue.component('list-item', require('./components/templates/ListItem'));
Vue.component('sort-buttons', require('./components/SortButtons'));
Vue.component('visibility', require('./components/Visibility'));
Vue.component('btn-favs', require('./components/BtnFavs'));
Vue.component('btn-like', require('./components/BtnLike'));
Vue.component('recipes', require('./components/Recipes'));
Vue.component('tabs', require('./components/Tabs'));
Vue.component('tab', require('./components/Tab'));

new Vue({
    el: '#app',
});
