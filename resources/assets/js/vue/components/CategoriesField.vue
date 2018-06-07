<template>
	<div class="row">
		<div v-for="field in fields" :key="field" class="col-12 col-sm-6 col-md-3">
			<div class="form-group simple-group">
				<label :for="'category_id' + field">{{ label }} {{ field }}</label>
				<select @click="hideChooseWord" name="category_id">
					<option v-show="fieldNotClicked">--- {{ select }} ---</option>
					<option v-for="categ in categories" :key="categ['id']" :value="categ['id']">
						{{ categ['name_' + locale] }}
					</option>
				</select>
			</div>
		</div>
		<div class="col-12 col-sm-6 col-md-3 row">
			<div v-if="visibleAddBtn" class="col-6 pr-0">
				<div class="form-group simple-group">
					<input @click="addField" type="button" :value="add+' +'" class="add-remove-field" style="color:darkgreen;">
				</div>
			</div>
			<div v-if="visibleDelBtn" class="col-6 pl-0">
				<div class="form-group simple-group">
					<input @click="deleteField" type="button" :value="deleting+' -'" class="add-remove-field" style="color:brown;">
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
			visibleDelBtn: false,
			fieldNotClicked: true
		}
	},

	props: ['label', 'locale', 'select', 'deleting', 'add'],

	created() {
		this.fetchCategories()
	},
	 
	methods: {
		fetchCategories() {
			fetch('/api/recipes/categories')
			.then(res => res.json())
			.then(data => this.categories = data)
			.catch(err => console.log(err))
		},

		addField() {
			if (this.fields <= 2 && this.fields > 0) {
				this.fields++
			}

			if (this.fields > 1) {
				this.visibleDelBtn = true
			}

			if (this.fields === 3) {
				this.visibleAddBtn = false
				this.visibleDelBtn = true
			}
		},

		deleteField() {
			if (this.fields > 1) {
				this.fields--
			}

			if (this.fields < 3) {
				this.visibleAddBtn = true
			}

			if (this.fields === 1) {
				this.visibleDelBtn = false
			}
		},

		hideChooseWord() {
			this.fieldNotClicked = false
		}
	}
}
</script>