<template>
	<base-layout>
		<template v-slot:content>
			<div class="col-sm-3 mb-3 mx-auto text-center" v-if="!loading">
				...loading
			</div>
			<section style="position:relative" v-else>
				<lib-control
					:edit="'/book/edit/'"
					:value="book.id"
					@deleteItem="onDeleteItem"
				/>
				<h5 class="book__title card-title text-center my-3">{{book.title}}</h5>
				<div class="book__picture col-sm-4 ms-auto me-auto">
					<img :src="book.image" class="book__image card-img-top " alt="...">
				</div>
				<div class="book__full container col-10 ms-auto me-auto my-3">
					<p class="book__inner mt-3">
						{{book.book}}
					</p>
				</div>
			</section>
		</template>
	</base-layout>
</template>

<script>
import BaseLayout from "../layouts/BaseLayout";
import LibControl from "../components/LibControl.vue";
import {mapState, mapGetters, mapActions, mapMutations} from 'vuex';
export default {
	components: {
		BaseLayout, LibControl
	},
	data() {
		return {

		}
	},
	methods: {
		onDeleteItem(){
			this.removeBook({id: this.book.id, router: this.$router});
		},
		...mapMutations('book', [

		]),
		...mapActions('book', [
			'fetchBook',
			'removeBook'
		]),
	},
	mounted() {
		this.fetchBook(this.$route.params.id)
	},
	computed: {
		...mapState({
			book: state => state.book.fullBook,
			loading: state => state.book.loading,
			admin: state => state.isAdmin
		}),
		...mapGetters('book', [
		]),
	}
}
</script>

<style scoped>

</style>