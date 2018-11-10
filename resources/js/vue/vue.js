import "./bootstrap";

window.Event = new Vue();

const components = [
    "RandomRecipesSidebar",
    "StatisticsChart",
    "DeleteRecipeBtn",
    "CategoriesField",
    "SortButtons",
    "Visibility",
    "Recipes",
    "BtnFavs",
    "BtnLike",
    "Tabs",
    "Tab"
];

components.forEach(comp => {
    Vue.component(comp, require("./components/" + comp + ".vue"));
});

const app = new Vue({
    el: "#app"
});
