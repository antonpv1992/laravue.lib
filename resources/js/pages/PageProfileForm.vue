<template>
	<base-layout>
		<template v-slot:content>
			<div class="col-4 ms-auto me-auto mb-3 mt-3" v-show="isErrors">
				<lib-alert-notification v-for="error in errors" :key="error" :error="error"/>
			</div>
			<div class="col-4 mb-3 mt-3 mx-auto text-center" v-if="!loading">
				...loading
			</div>
			<div class="profile mt-5 mb-5" v-else>
				<div class="profile__box col-4 me-auto ms-auto">
					<ul class="profile__list list-group list-group-flush pt-4">
						<li class="profile__item list-group-item mb-4">
							<input type="text" class="profile__title fw-bold border-0 w-100" name="login" v-model="flogin" placeholder="User name">
						</li>
						<li class="profile__item list-group-item mb-4">
							<input type="email" class="profile__title fw-bold border-0 w-100" name="email" v-model="femail" placeholder="Email">
						</li>
						<li class="profile__item list-group-item mb-4">
							<input type="text" class="profile__title fw-bold border-0 w-100" name="name" v-model="fname" placeholder="Name">
						</li>
						<li class="profile__item list-group-item mb-4">
							<input type="text" class="profile__title fw-bold border-0 w-100" name="surname" v-model="fsur" placeholder="Surname">
						</li>
						<li class="profile__item list-group-item mb-4">
							<input type="number" class="profile__title fw-bold border-0 w-100" name="age" v-model="fage" placeholder="Age">
						</li>
					</ul>
					<label class="modification__input form-input mb-3 d-flex justify-content-center">
						<button class="modification__button btn btn-primary" @click="send">Submit</button>
					</label>
				</div>
			</div>
		</template>
	</base-layout>
</template>

<script>
import BaseLayout from "../layouts/BaseLayout";
import LibAlertNotification from "../components/LibAlertNotification";
import {mapState, mapGetters, mapActions, mapMutations} from 'vuex';
export default {
	components: {
		BaseLayout, LibAlertNotification
	},
	methods: {
		...mapMutations('user', [
			'setLogin',
			'setEmail',
			'setName',
			'setSurname',
			'setAge',
		]),
		...mapActions('user', [
			'fetchUser',
			'editUser'
		]),
		send(){
			let data = this.setData();
			let id = this.$route.params.id ?? this.uid;
			this.editUser({data, id, router: this.$router});
		},
		isErrors(){
			return Object.keys(JSON.parse(JSON.stringify(this.errors))).length > 0 ? true : false;
		},
		setData(){
			let formData = new FormData();
			formData.append('login', this.login);
			formData.append('email', this.email);
			formData.append('name', this.name);
			formData.append('surname', this.surname);
			formData.append('age', this.age);
			formData.append('_method', 'PATCH');
			return formData;
		}
	},
	mounted() {
		let id = this.$route.params.id ?? this.uid
		this.fetchUser(id)
	},
	computed: {
		...mapState({
			loading: state => state.user.loading,
			admin: state => state.isAdmin,
			login: state => state.user.login,
			email: state => state.user.email,
			name: state => state.user.name,
			surname: state => state.user.surname,
			age: state => state.user.age,
			errors: state => state.user.errors,
			uid: state => state.userId
		}),
		...mapGetters('user', [

		]),
		flogin: {
			get(){
				return this.login;
			},
			set(value){
				this.setLogin(value);
			}
		},
		femail: {
			get(){
				return this.email;
			},
			set(value){
				this.setEmail(value);
			}
		},
		fname: {
			get(){
				return this.name;
			},
			set(value){
				this.setName(value);
			}
		},
		fsur: {
			get(){
				return this.surname;
			},
			set(value){
				this.setSurname(value);
			}
		},
		fage: {
			get(){
				return this.age;
			},
			set(value){
				this.setAge(value);
			}
		}
	}
}
</script>

<style scoped>

</style>