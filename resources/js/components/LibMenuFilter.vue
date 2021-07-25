<template>
	<div class="menu__filter filter dropdown me-3">
		<button class="menu__button btn btn-outline-primary dropdown-toggle" type="button" id="dropdownFilter" data-bs-toggle="dropdown" aria-expanded="false" @click="toggleClick">
			Filters
		</button>
		<ul class="filter__list dropdown-menu" :class="toggle" aria-labelledby="dropdownFilter">
			<li class="filter__item dropdown-item">
				<label class="filter__label form-check form-switch">
					<input class="filter__input form-check-input" name="filter[]" type="checkbox" value="title" v-model="ffil">
					by title
				</label>
			</li>
			<li class="filter__item dropdown-item">
				<label class="filter__label form-check form-switch">
					<input class="filter__input form-check-input" name="filter[]" type="checkbox" value="author" v-model="ffil">
					by author
				</label>
			</li>
			<li class="filter__item dropdown-item">
				<label class="filter__label form-check form-switch">
					<input class="filter__input form-check-input" name="filter[]" type="checkbox" value="genre" v-model="ffil">
					by genre
				</label>
			</li>
			<li class="filter__item dropdown-item">
				<label class="filter__label form-check form-switch">
					<input class="filter__input form-check-input" name="filter[]" type="checkbox" value="year" v-model="ffil">
					by year
				</label>
			</li>
			<li class="filter__item dropdown-item">
				<label class="filter__label form-check form-switch">
					<input class="filter__input form-check-input" name="filter[]" type="checkbox" value="country" v-model="ffil">
					by country
				</label>
			</li>
		</ul>
	</div>
</template>

<script>
import {mapState, mapMutations} from 'vuex';
export default {
	data() {
		return {
			toggle: '',
		}
	},
	computed: {
		...mapState({
			filterSelected: state => state.book.filterSelected,
		}),
		ffil: {
			get(){
				return this.filterSelected;
			},
			set(value){
				this.setFilterSelected(value);
			}
		},
	},
	methods: {
		...mapMutations('book', [
			'setFilterSelected'
		]),
		toggleClick(){
			this.toggle = this.toggle === '' ? 'show' : '';
		},
	},
	mounted() {

	}
}
</script>

<style scoped>

</style>