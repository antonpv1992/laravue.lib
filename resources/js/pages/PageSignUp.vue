<template>
	<div class="registration modal fade" id="reg" tabindex="-1" aria-hidden="true">
		<div class="registration__dialog modal-dialog">
			<div class="registration__form form modal-content px-5 py-5">
				<button type="button" class="form__close btn-close ms-auto" data-bs-dismiss="modal" aria-label="Close"></button>
				<div class="mt-2 mb-2" v-show="isErrors">
					<lib-alert-notification v-for="error in errors" :key="error" :error="error"/>
				</div>
				<label class="form__input form-input">
					<i class="form__icon fa fa-envelope"></i>
					<input type="email" class="form__control form-control" name="email" v-model="email" placeholder="Email" require>
				</label>
				<label class="form__input form-input">
					<i class="fa fa-user"></i>
					<input type="text" class="form-control" name="login" v-model="login" placeholder="User name" require>
				</label>
				<label class="form__input form-input">
					<i class="fa fa-lock"></i>
					<input type="password" class="form-control" name="password" v-model="password" placeholder="Password" require>
				</label>
				<label class="form__input form-input">
					<i class="fa fa-lock"></i>
					<input type="password" class="form-control" name="password_confirmation" v-model="password_confirmation" placeholder="Repeat password" require>
				</label>
				<label class="form__input form-input">
					<i class="fas fa-user-tie"></i>
					<input type="text" class="form-control" name="name" v-model="name" placeholder="Name">
				</label>
				<label class="form__input form-input">
					<i class="fas fa-user-tie"></i>
					<input type="text" class="form-control" name="surname" v-model="surname" placeholder="Surname">
				</label>
				<label class="form__input form-input">
					<i class="fas fa-clock"></i>
					<input type="text" class="form-control" name="age" v-model="age" placeholder="Age">
				</label>
				<button class="form__submit btn btn-primary mt-4" @click="send">Sign Up</button>
				<div class="form__alt-entry text-center mt-3">
					<span class="form__alt-span">Or continue with these social profile</span>
				</div>
				<div class="form__social d-flex justify-content-center mt-4">
					<a class="form__social-icon text-decoration-none" @click="gsend"><i class="fab fa-google"></i></a>
					<a class="form__social-icon text-decoration-none" @click="fsend"><i class="fab fa-facebook-f"></i></a>
				</div>
				<div class="form__action text-center mt-4">
					<span class="form__action-span">Already a member?</span>
					<a class="form__action-button text-decoration-none" data-bs-toggle="modal" data-bs-target="#log"
						data-bs-dismiss="modal" aria-label="Close"> Login</a>
				</div>
				<div class="form__action text-center mt-4">
					<span class="form__action-span">Forgot password?</span>
					<a class="form__action-button text-decoration-none" data-bs-toggle="modal" data-bs-target="#forg"
						data-bs-dismiss="modal" aria-label="Close"> Forgot</a>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
import LibAlertNotification from "../components/LibAlertNotification";
import {mapState, mapGetters, mapActions, mapMutations} from 'vuex';
export default {
	components: {
		LibAlertNotification
	},
	data() {
		return {
			password: '',
			password_confirmation: '',
			login: '',
			email: '',
			name: '',
			surname: '',
			age: ''
		}
	},
	methods: {
		...mapMutations('user', [

		]),
		...mapActions('user', [
			'registration',
			'googleAuth',
			'facebookAuth'
		]),
		send(){
			let data = this.setData();
			this.registration({data, router: this.$router});
		},
		fsend(){
			this.facebookAuth();
		},
		gsend(){
			this.googleAuth();
		},
		setData(){
			let formData = new FormData();
			formData.append('email', this.email);
			formData.append('login', this.login);
			formData.append('password', this.password);
			formData.append('password_confirmation', this.password_confirmation);
			formData.append('name', this.name);
			formData.append('surname', this.surname);
			formData.append('age', this.age);
			return formData;
		},
		isErrors(){
			return Object.keys(JSON.parse(JSON.stringify(this.errors))).length > 0 ? true : false;
		},
	},
	mounted() {

	},
	computed: {
		...mapState({
			loading: state => state.user.loading,
			admin: state => state.isAdmin,
			errors: state => state.user.errors
		}),
		...mapGetters('user', [

		]),
	},
	watch: {
		password: (value) => {
			try{
				this.password = value;
			} catch(e){

			}
		},
		password_confirmation: (value) => {
			try{
				this.password_confirmation = value;
			} catch(e){

			}
		},
		login: (value) => {
			try{
				this.login = value;
			} catch(e){

			}
		},
		email: (value) => {
			try{
				this.email = value;
			} catch(e){

			}
		},
		age: (value) => {
			try{
				this.age = value;
			} catch(e){

			}
		},
		name: (value) => {
			try{
				this.name = value;
			} catch(e){

			}
		},
		surname: (value) => {
			try{
				this.surname = value;
			} catch(e){

			}
		}
	}
}
</script>

<style scoped>

</style>