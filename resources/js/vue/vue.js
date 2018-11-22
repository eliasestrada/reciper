import './bootstrap';

window.Event = new Vue();

import RandomRecipesSidebar from './components/RandomRecipesSidebar';
import StatisticsChart from './components/StatisticsChart';
import DeleteRecipeBtn from './components/DeleteRecipeBtn';
import CategoriesField from './components/CategoriesField';
import SortButtons from './components/SortButtons';
import Visibility from './components/Visibility';
import Recipes from './components/Recipes';
import BtnFavs from './components/BtnFavs';
import BtnLike from './components/BtnLike';
import Tabs from './components/Tabs';
import Tab from './components/Tab';

Vue.component('random-recipes-sidebar', RandomRecipesSidebar);
Vue.component('delete-recipe-btn', DeleteRecipeBtn);
Vue.component('categories-field', CategoriesField);
Vue.component('statistics-chart', StatisticsChart);
Vue.component('sort-buttons', SortButtons);
Vue.component('visibility', Visibility);
Vue.component('btn-favs', BtnFavs);
Vue.component('btn-like', BtnLike);
Vue.component('recipes', Recipes);
Vue.component('tabs', Tabs);
Vue.component('tab', Tab);

new Vue({
    el: '#app',
});
