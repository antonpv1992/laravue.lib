<template>
	<div class="remember modal fade" id="forg" tabindex="-1" aria-hidden="true" >
		<div class="remember__dialog modal-dialog">
			<div class="remember__form form modal-content px-5 py-5">
				<button type="button" class="form__close btn-close ms-auto" data-bs-dismiss="modal" aria-label="Close"></button>
				<div class="mt-2 mb-2" v-show="isErrors">
					<lib-alert-notification v-for="error in errors" :key="error" :error="error"/>
				</div>
				<label class="form__input form-input">
					<i class="form__icon fa fa-envelope"></i>
					<input type="email" class="form__control form-control" name="email" v-model="email" placeholder="Email address" require>
				</label>
				<button class="form__submit btn btn-primary mt-4" @click="send">Remember me</button>
				<div class="form__action text-center mt-4">
					<span class="form__action-span">Not a member?</span>
					<a class="form__action-button text-decoration-none" data-bs-toggle="modal" data-bs-target="#reg" data-bs-dismiss="modal" aria-label="Close"> Sign Up</a>
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
			email: ''
		}
	},
	methods: {
		...mapMutations('user', [

		]),
		...mapActions('user', [
			'forgotPassword'
		]),
		send(){
			let data = this.setData();
			this.forgotPassword({data, router: this.$router});
		},
		setData(){
			let formData = new FormData();
			formData.append('email', this.email);
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
		email: (value) => {
			try{
				this.email = value;
			} catch(e){

			}
		}
	}
}
</script>

<style scoped>

</style>