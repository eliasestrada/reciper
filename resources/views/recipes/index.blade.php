@extends('layouts.app')

@section('title', trans('recipes.recipes'))

@section('content')

<h1 class="headline">@lang('recipes.recipes')</h1>

<div class="recipes">
	<div class="row" id="target-for-recipes"></div>
	<ul class="pagination" id="target-for-pagination"></ul>
</div>

@endsection

@section('script')
<script defer>
	let pagin = {}
	let paginationButtons = ''

	// This function fetches recipes
	function fetchData(page_url) {
		page_url = page_url || '/api/recipes'

		fetch(page_url)
		.then(res => res.json())
		.then(res => {
			let recipes  = ''
			
			// Looping our object
			res.data.forEach(recipe => {
				recipes += `
					<div class="recipe-container col-md-3 col-12 col-sm-6">
						<div class="recipe">
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
				<li class="page-item ${ pagin.prev_page_url ? '' : 'disabled' }">
					<a href="#" class="page-link" id="prev-btn">&laquo;</a>
				</li>
				<li class="page-item disabled">
					<a class="page-link">${ pagin.current_page } / ${ pagin.last_page }</a>
				</li>
				<li class="page-item ${ pagin.next_page_url ? '' : 'disabled' }">
					<a href="#" class="page-link" id="next-btn">&raquo;</a>
				</li>
			`

			// Inserting pagination into a target div
			if (pagin.next_page_url || pagin.prev_page_url) {
				document.getElementById('target-for-pagination').innerHTML = paginationButtons
			}
			
			// Add onclick event if previous page exists
			if (pagin.prev_page_url) {
				document.getElementById('prev-btn').addEventListener('click', () => {
					fetchData(pagin.prev_page_url)
				})
			}

			// Add onclick event if next page exists
			if (pagin.next_page_url) {
				document.getElementById('next-btn').addEventListener('click', () => { 
					fetchData(pagin.next_page_url)
				})
			}
		})
		.catch(err => console.log(err))
	}

	// We need this function for handling pagination
	function makePagination(meta, links) {
		pagin = {
			current_page: meta.current_page,
			last_page: meta.last_page,
			next_page_url: links.next,
			prev_page_url: links.prev
		}
	}

	fetchData()
</script>
@endsection
