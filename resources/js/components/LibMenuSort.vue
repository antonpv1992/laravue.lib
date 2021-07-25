<template>
	<div class="menu__sort sort dropdown me-3">
		<button class="menu__button btn btn-outline-primary dropdown-toggle" type="button" id="dropdownSort" data-bs-toggle="dropdown" aria-expanded="false" @click="toggleClick">
			Sorts
		</button>
		<ul class="sort__list dropdown-menu" :class="collapse" aria-labelledby="dropdownSort">
			<li class="sort__item dropdown-item d-flex justify-content-between">
				<label class="sort__label form-check form-switch">
					<input class="sort__input form-check-input" type="radio" name="sort" value="title" v-model="fsort">
					by title
				</label>
			</li>
			<li class="sort__item dropdown-item d-flex justify-content-between">
				<label class="sort__label form-check form-switch">
					<input class="sort__input form-check-input" type="radio" name="sort" value="author" v-model="fsort">
					by author
				</label>
			</li>
			<li class="sort__item dropdown-item d-flex justify-content-between">
				<label class="sort__label form-check form-switch">
					<input class="sort__input form-check-input" type="radio" name="sort" value="genre" v-model="fsort">
					by genre
				</label>
			</li>
			<li class="sort__item dropdown-item d-flex justify-content-between">
				<label class="sort__label form-check form-switch">
					<input class="sort__input form-check-input" type="radio" name="sort" value="year" v-model="fsort">
					by year
				</label>
			</li>
			<li class="sort__item dropdown-item d-flex justify-content-between">
				<label class="sort__label form-check form-switch">
					<input class="sort__input form-check-input" type="radio" name="sort" value="country" v-model="fsort">
					by country
				</label>

			</li>
			<li class="sort__item dropdown-item">
				<label class="sort__label form-check form-switch">
					<input class="sort__input form-check-input" type="radio" name="sort" value="id" v-model="fsort">
					by id
				</label>
			</li>
			<li class="sort__item">
				<label class="sort__label ms-4 me-4">
					Sort direction:
					</label>
				<div class="d-flex justify-content-around">
					<label class="sort__label">
						<input class="sort__input form-check-input" type="radio" name="order" value="down" v-model="fdir">
						▼
					</label>
					<label class="sort__label">
						<input class="sort__input form-check-input" type="radio" name="order" value="up" v-model="fdir">
						▲
					</label>
				</div>
			</li>
		</ul>
	</div>
</template>

<script>
import {mapState, mapMutations} from 'vuex';
export default {
	data() {
		return {
			collapse: '',
		}
	},
	computed: {
		...mapState({
			sortSelected: state => state.book.sortSelected,
			sortDirection: state => state.book.sortDirection,
		}),
		fsort: {
			get(){
				return this.sortSelected;
			},
			set(value){
				this.setSortSelected(value);
			}
		},
		fdir: {
			get(){
				return this.sortDirection;
			},
			set(value){
				this.setSortDirection(value);
			}
		}
	},
	methods: {
		...mapMutations('book', [
			'setSortSelected',
			'setSortDirection'
		]),
		toggleClick(){
			this.collapse = this.collapse === '' ? 'show' : '';
		}
	},
	mounted() {

	}
}
</script>

<style scoped>

</style>