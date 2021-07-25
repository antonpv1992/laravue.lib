<template>
	<base-layout>
		<template v-slot:content>
			<div class="library row pt-2 mt-4">
				<div class="mb-4" v-show="$route.query.message">
					<lib-alert-success :message="$route.query.message"/>
				</div>

				<div class="col-sm-3 mb-3 mx-auto text-center" v-if="!loading">
					Loading...
				</div>

				<div class="library__book col-sm-3 mb-3 mx-auto text-center" v-else-if="books.length === 0">
					<p class="">No Books</p>
				</div>

				<lib-book-card v-else v-for="book in books" :key="book.id"
					:book="book"
					@onDeleteItem="onDeleteItem"
				/>
			</div>
			<lib-pagination
				v-if="pagination.last_page > 1 && auth"
				:total="pagination.last_page"
				:current="pagination.current_page"
				@paginate="onPaginate"
			/>
		</template>
	</base-layout>
</template>

<script>
import LibBookCard from "../components/LibBookCard";
import LibPagination from "../components/LibPagination";
import BaseLayout from "../layouts/BaseLayout";
import LibAlertSuccess from "../components/LibAlertSuccess"
import {mapState, mapGetters, mapActions, mapMutations} from 'vuex';
export default {
	components: {
		LibBookCard, BaseLayout, LibPagination, LibAlertSuccess
	},
	data() {
		return {
			toggle: {
				icon: 'fa-arrow-circle-down',
				collapse: 'collapse',
			}
		}
	},
	methods: {
		onPaginate(data){
			this.fetchBooks(data.page);
		},
		...mapMutations('book', [
			'setBooks',
			'setPagination'
		]),
		...mapActions('book', [
			'fetchBooks',
			'removeBook'
		]),
		onDeleteItem(data) {
			this.removeBook({id: data.id, router: this.$router});
			setTimeout(() => this.fetchBooks(), 1000);
		}
	},
	mounted() {
		this.fetchBooks();
	},
	computed: {
		...mapState({
			books: state => state.book.books,
			pagination: state => state.book.pagination,
			loading: state => state.book.loading,
			admin: state => state.isAdmin,
			auth: state => state.isAuth,
			ver: state => state.verify
		}),
		...mapGetters('book', [
			'getBooks',
		])
	}

}
</script>

<style scoped>

</style>