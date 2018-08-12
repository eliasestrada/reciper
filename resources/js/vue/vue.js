import './bootstrap'

const components = [
	'Recipes',
	'RandomRecipesSidebar',
	'DeleteRecipeBtn',
	'CategoriesField',
	'Like',
	'Visibility',
]

components.forEach(comp => {
	Vue.component(comp, require('./components/' + comp + '.vue'))
})

const app = new Vue({
	el: '#app'
});