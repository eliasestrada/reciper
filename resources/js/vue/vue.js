import './bootstrap';

window.Event = new Vue();

import StatisticsChart from './components/StatisticsChart';
import RandomRecipesSidebar from './components/RandomRecipesSidebar';
import DeleteRecipeBtn from './components/DeleteRecipeBtn';
import CategoriesField from './components/CategoriesField';
import SortButtons from './components/SortButtons';
import Visibility from './components/Visibility';
import Recipes from './components/Recipes';
import BtnFavs from './components/BtnFavs';
import BtnLike from './components/BtnLike';
import Tabs from './components/Tabs';
import Tab from './components/Tab';

new Vue({
    el: '#app',
    components: {
        StatisticsChart,
        RandomRecipesSidebar,
        DeleteRecipeBtn,
        CategoriesField,
        SortButtons,
        Visibility,
        Recipes,
        BtnFavs,
        BtnLike,
        Tabs,
        Tab,
    },
});
