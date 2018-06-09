<template>
	<div class="row">
		<div v-for="(field, i) in fields" :key="field" class="col-12 col-sm-6 col-md-3">
			<div class="form-group simple-group">
				<label :for="'category_id' + field">{{ label }} {{ field }}</label>
				<select name="categories[]">
					<option v-if="recipeCategories" :value="recipeCategories[i]['id']" selected>
						{{ recipeCategories[i]['name_' + locale] }}
					</option>
					<option v-for="categ in categories" :key="categ['id']" :value="categ['id']">
						{{ categ['name_' + locale] }}
					</option>
				</select>
			</div>
		</div>
		<div class="col-12 col-sm-6 col-md-3 row">
			<div v-if="visibleAddBtn" class="col-6 pr-0">
				<div class="form-group simple-group" :title="add">
					<input @click="addField" type="button" :value="add + ' +'" class="add-remove-field" style="color:darkgreen;">
				</div>
			</div>
			<div v-if="visibleDelBtn" class="col-6 pl-0" :title="deleting">
				<div class="form-group simple-group">
					<input @click="deleteField" type="button" :value="deleting + ' -'" class="add-remove-field" style="color:brown;">
				</div>
			</div>
		</div>
	</div>
</template>

<script>
export default {
	data() {
		return {
			categories: [],
			fields: 1,
			visibleAddBtn: true,
			visibleDelBtn: false
		}
	},

	props: ['label', 'locale', 'select', 'deleting', 'add', 'recipeCategories'],

	created() {
		this.fetchCategories(),
		this.getFieldsFromProps()
	},
	 
	methods: {
		fetchCategories() {
			fetch('/api/recipes/categories')
			.then(res => res.json())
			.then(data => this.categories = data)
			.catch(err => console.log(err))
		},

		getFieldsFromProps() {
			if (this.recipeCategories) {
				this.fields = this.recipeCategories.length
				this.stableButtons()
			}
		},

		addField() {
			if (this.fields <= 2 && this.fields > 0) {
				this.fields++
			}
			this.stableButtons()
		},

		deleteField() {
			if (this.fields > 1) {
				this.fields--
			}
			this.stableButtons()
		},

		stableButtons() {
			if (this.fields > 1) {
				this.visibleDelBtn = true
			}

			if (this.fields === 3) {
				this.visibleAddBtn = false
				this.visibleDelBtn = true
			}

			if (this.fields < 3) {
				this.visibleAddBtn = true
			}

			if (this.fields === 1) {
				this.visibleDelBtn = false
			}
		}
	}
}
</script>