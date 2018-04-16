@extends('layouts.app')

@section('title', 'Рецепты')

@section('content')

<h2 class="headline">Рецепты</h2>

<div class="container recipes">
	<div class="row" id="target-for-recipes"></div>
	<ul class="pagination" id="target-for-pagination"></ul>
</div>

@endsection

@section('script')
<script>
	let pagination = {}
	let paginationButtons = ''

	// This function fetches recipes
	function fetchData(page_url) {
		page_url = page_url || '/api/recipes'

		fetch(page_url)
		.then(res => res.json())
		.then(res => {
			let recipes = ''
			let i = 0

			// Looping our object
			res.data.forEach(recipe => {
				recipes += `
					<div class="recipe-container col-xs-12 col-sm-6 col-md-4 col-lg-3">
						<div class="recipe" style="animation: appear 1.${ i++ }s;">
							<a href="/recipes/${ recipe.id }" title="${ recipe.title }">
								<img src="storage/images/${ recipe.image }" alt="${ recipe.title }">
							</a>
							<div class="recipes-content">
								<h3>${ recipe.title }</h3>
							</div>
						</div>
					</div>`
			})

			// Inserting our recipes into a target div
			document.getElementById('target-for-recipes').innerHTML = recipes

			// Perfect place for calling the method makePagination
			makePagination(res.meta, res.links)

			paginationButtons = `
				<li class="page-item ${ pagination.prev_page_url ? '' : 'disabled' }">
					<a href="#" class="page-link" id="prev-btn">&laquo;</a>
				</li>
				<li class="page-item ${ pagination.next_page_url ? '' : 'disabled' }">
					<a href="#" class="page-link" id="next-btn">&raquo;</a>
				</li>
			`

			// Inserting pagination into a target div
			document.getElementById('target-for-pagination').innerHTML = paginationButtons

			/**
			 * Add onclick event if previous page exists
			 * @event click
			 */
			if (pagination.prev_page_url) {
				document.getElementById('prev-btn').addEventListener('click', () => {
					fetchData(pagination.prev_page_url)
				})
			}

			/**
			 * Add onclick event if next page exists
			 * @event click
			 */
			if (pagination.next_page_url) {
				document.getElementById('next-btn').addEventListener('click', () => { 
					fetchData(pagination.next_page_url)
				})
			}
		})
		.catch(err => console.log(err))
	}

	// We need this function for handling pagination
	function makePagination(meta, links) {
		pagination = {
			current_page: meta.current_page,
			last_page: meta.last_page,
			next_page_url: links.next,
			prev_page_url: links.prev
		}
	}

	fetchData()
</script>
@endsection
