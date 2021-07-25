<template>
	<base-layout>
		<template v-slot:content>
			<div class="mb-2 mt-3" v-show="$route.query.message">
				<lib-alert-success :message="$route.query.message"/>
			</div>
			<div class="users container mt-3 pt-3 pb-2">
				<div class="users__form d-flex justify-content-around">
					<label class="users__input form-input col-5">
						<input type="text" class="users__search form-control" v-model="search" placeholder="Title">
					</label>
					<router-link class="menu__button btn btn-outline-primary" role="button" :to="{name: 'uadd'}" v-if="admin">
						Add user
					</router-link>
					<lib-user-filter/>
				</div>
				<table class="users__table table table-striped">
					<lib-user-thead/>
					<lib-user-tbody
						:users="getSortUsers"
						@onDeleteItem="onDeleteItem"
					/>
				</table>
			</div>
		</template>
	</base-layout>

</template>

<script>
import LibUserFilter from "../components/LibUserFilter";
import LibUserThead from "../components/LibUserThead";
import LibUserTbody from "../components/LibUserTbody";
import LibAlertSuccess from "../components/LibAlertSuccess";
import BaseLayout from "../layouts/BaseLayout";
import {mapState, mapGetters, mapActions, mapMutations} from 'vuex';
export default {
	components: {
		BaseLayout, LibUserFilter, LibUserThead, LibUserTbody, LibAlertSuccess
	},
	data() {
		return {

		}
	},
	methods: {
		...mapMutations('user', [
			'setSortDirection',
			'setSortField',
			'setSearchField',
			'setFilterField'
		]),
		...mapActions('user', [
			'fetchUsers',
			'deleteUser'
		]),
		onDeleteItem(data){
			console.log(data.id);
			this.deleteUser({id: data.id, router: this.$router})
		}
	},
	mounted() {
		this.setSortDirection('▲');
		this.setSortField('id');
		this.setSearchField('');
		this.setFilterField('login')
		this.fetchUsers();
	},
	computed: {
		...mapState({
			users: state => state.user.users,
			loading: state => state.user.loading,
			admin: state => state.isAdmin,
			searchField: state => state.user.searchField
		}),
		...mapGetters('user', [
			'sortUsers',
			'getSortUsers',
		]),
		search: {
			get(){
				return this.searchField;
			},
			set(value){
				this.setSearchField(value);
			}
		},
	}
}
</script>

<style scoped>

</style>