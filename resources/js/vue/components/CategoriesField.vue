<template>
    <div class="row py-2">
        <h5 class="col s12 center mb-1">{{ categoriesTitle }} {{ fields }} / 4</h5>
        <h6 class="col s12 center mb-2">
            <a class="add-remove-field ml-2" style="color:darkgreen;"
                :class="classAddBtn"
                @click="addField">{{ add + ' +' }}</a>
            <a style="color:brown;" class="add-remove-field ml-2"
                :class="classDelBtn"
                @click="deleteField">{{ deleting + ' -' }}</a>
        </h6>

        <div v-for="(field, i) in fields" :key="field" class="col s12 m6">
            <div class="form-group simple-group">
                <label :for="'category_id' + field">{{ label }} {{ field }}</label>
                <select name="categories[]" class="browser-default">
                    <option :value="recipeCategories[i]['id']"
                        v-if="recipeCategories && recipeCategories[i]"
                        selected>
                        {{ recipeCategories[i]['name_' + locale] }}
                    </option>
                    <option v-for="categ in categories" :key="categ.id" :value="categ.id">
                        {{ categ['name_' + locale] }}
                    </option>
                </select>
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
        };
    },

    props: [
        "label",
        "locale",
        "select",
        "deleting",
        "add",
        "recipeCategories",
        "categoriesTitle"
    ],

    created() {
        this.fetchCategories(),
        this.getFieldsFromProps();
    },

    methods: {
        fetchCategories() {
            fetch("/api/recipes-category")
                .then(res => res.json())
                .then(data => (this.categories = data))
                .catch(err => console.error(err));
        },

        getFieldsFromProps() {
            if (this.recipeCategories) {
                if (this.recipeCategories.length == 0) {
                    this.fields = 1;
                } else {
                    this.fields = this.recipeCategories.length;
                }
                this.stableButtons();
            }
        },

        addField() {
            if (this.fields <= 3 && this.fields > 0) {
                this.fields++;
            }
            this.stableButtons();
        },

        deleteField() {
            if (this.fields > 1) {
                this.fields--;
            }
            this.stableButtons();
        },

        stableButtons() {
            if (this.fields > 1) {
                this.visibleDelBtn = true;
            }

            if (this.fields === 4) {
                this.visibleAddBtn = false;
                this.visibleDelBtn = true;
            }

            if (this.fields < 4) {
                this.visibleAddBtn = true;
            }

            if (this.fields === 1) {
                this.visibleDelBtn = false;
            }
        }
    },
    computed: {
        classDelBtn() {
            return {
                disable: !this.visibleDelBtn
            };
        },
        classAddBtn() {
            return {
                disable: !this.visibleAddBtn
            };
        }
    }
};
</script>