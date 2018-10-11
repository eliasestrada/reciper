import "./bootstrap";

window.Event = new Vue();

const components = [
    "RandomRecipesSidebar",
    "DeleteRecipeBtn",
    "CategoriesField",
    "SortButtons",
    "Visibility",
    "Recipes",
    "BtnFavs",
    "Like",
    "Card",
    "Tabs",
    "Tab"
];

components.forEach(comp => {
    Vue.component(comp, require("./components/" + comp + ".vue"));
});

const app = new Vue({
    el: "#app"
});
