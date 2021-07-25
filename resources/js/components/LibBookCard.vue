<template>
<div class="library__book col-3 mb-4">
	<div class="library__card card">
		<lib-control
			:edit="'/book/edit/'"
			:value="book.id"
			@deleteItem="onDeleteItem"
		/>
		<h5 class="library__card-title card-title card-header d-flex">
			<router-link class="text-decoration-none text-dark" :to="'/book/' + book.id">
				<span>{{book.title}}</span>
			</router-link>
		</h5>
		<router-link :to="'/book/' + book.id">
			<img :src="book.image" class="library__card-image card-img-top" alt="...">
		</router-link>
	</div>
	<ul class="library__card-desc list-group list-group-flush">
		<li class="card__item list-group-item">{{book.desc}}</li>
		<lib-collapse-list
			:collapse="toggle.collapse"
			:book="book"
		/>
	</ul>
	<div class="library__card-button card">
		<a class="library__button btn border border-primary" role="button" data-bs-toggle="collapse" aria-expanded="false" aria-controls="card1" @click.prevent="toggleCollapse">
			<i class="library__button-icon fa text-primary" :class="toggle.icon" aria-hidden="true"></i>
		</a>
		<router-link class="library__button btn btn-primary" :to="'/book/' + book.id">Read</router-link>
	</div>
</div>
</template>

<script>
import LibControl from "../components/LibControl.vue";
import LibCollapseList from "../components/LibCollapseList";
import {mapState, mapActions} from 'vuex';
export default {
	components: {
		LibControl, LibCollapseList
	},
	data() {
		return {
			toggle: {
				icon: 'fa-arrow-circle-down',
				collapse: 'collapse',
			}
		}
	},
	props: {
		book: {
			type: Object,
			required: true
		}
	},
	methods: {
		toggleCollapse(){
			if(this.toggle.collapse === 'collapse show'){
				this.toggle.icon = 'fa-arrow-circle-down';
				this.toggle.collapse = 'collapse'
				return;
			}
			this.toggle.icon =  'fa-arrow-circle-up';
			this.toggle.collapse = 'collapse show'
		},
		onDeleteItem(data){
			this.$emit('onDeleteItem', {
        id: data.id
      });
		}
	},
	computed: {
		...mapState({
			admin: state => state.isAdmin
		}),
		...mapActions('book', [
			'removeBook'
		]),
	}
}
</script>

<style scoped>

</style>