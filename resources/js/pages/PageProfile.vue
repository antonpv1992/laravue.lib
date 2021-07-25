<template>
	<base-layout>
		<template v-slot:content>
			<div class="col-sm-3 mb-3 mx-auto text-center" v-if="!loading">
				...loading
			</div>
			<section class="profile mt-5 mb-5" v-else>
				<lib-control
					:edit="$route.params.id ? '/user/edit/' : '/profile/edit/'"
					:value="$route.params.id ? user.id : uid"
					@deleteItem="onDeleteItem"
				/>
				<div class="profile__box col-4 me-auto ms-auto">
					<ul class="profile__list list-group list-group-flush pt-4">
						<li class="profile__item list-group-item mb-4">
							<span class="profile__title fw-bold">User name:</span> {{user.login}}
						</li>
						<li class="profile__item list-group-item mb-4">
							<span class="profile__title fw-bold">Email:</span> {{user.email}}
						</li>
						<li class="profile__item list-group-item mb-4">
							<span class="profile__title fw-bold">Name:</span> {{user.name}}
						</li>
						<li class="profile__item list-group-item mb-4">
							<span class="profile__title fw-bold">Surname:</span> {{user.surname}}
						</li>
						<li class="profile__item list-group-item mb-4">
							<span class="profile__title fw-bold">Age:</span> {{user.age}}
						</li>
					</ul>
				</div>
			</section>
		</template>
	</base-layout>
</template>

<script>
import BaseLayout from "../layouts/BaseLayout";
import LibControl from "../components/LibControl";
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
		onDeleteItem(data){
			this.deleteUser({id: data.id, router: this.$router})
		},
		...mapMutations('user', [

		]),
		...mapActions('user', [
			'fetchUser',
			'deleteUser'
		]),
	},
	mounted() {
		let id = this.$route.params.id ?? this.uid;
		this.fetchUser(id);
	},
	computed: {
		...mapState({
			user: state => state.user.fullUser,
			loading: state => state.user.loading,
			admin: state => state.isAdmin,
			uid: state => state.userId
		}),
		...mapGetters('user', [

		]),
	}
}
</script>

<style scoped>

</style>