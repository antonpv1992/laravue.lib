<template>
	<base-layout>
		<template v-slot:content>
			<div class="reset">
				<div class="reset__dialog col-6 me-auto ms-auto">
					<div class="mt-2 mb-2 px-5" v-show="isErrors">
						<lib-alert-notification v-for="error in errors" :key="error" :error="error"/>
					</div>
					<div class="reset__form form px-5 py-5">
						<!-- Password Reset Token -->
						<input type="hidden" name="token" value="">
						<label class="form__input form-input">
							<i class="form__icon fa fa-envelope"></i>
							<input type="email" class="form__control form-control" name="email" v-model="$route.query.email" placeholder="Email address" require disabled>
						</label>
						<label class="form__input form-input">
							<i class="form__icon fa fa-lock"></i>
							<input type="password" class="form__control form-control" name="password" v-model="password" placeholder="Password" require>
						</label>
						<label class="form__input form-input">
							<i class="form__icon fa fa-lock"></i>
							<input type="password" class="form__control form-control" name="password_confirmation" v-model="password_confirmation" placeholder="Repeat Password" require>
						</label>
						<button class="form__submit btn btn-primary mt-4" @click="send">Update</button>
					</div>
				</div>
			</div>
		</template>
	</base-layout>
</template>

<script>
import LibAlertNotification from "../components/LibAlertNotification";
import BaseLayout from "../layouts/BaseLayout";
import {mapState, mapGetters, mapActions, mapMutations} from 'vuex';
export default {
	components: {
		BaseLayout, LibAlertNotification
	},
	data() {
		return {
			password: '',
			password_confirmation: '',
		}
	},
	methods: {
		...mapMutations('user', [

		]),
		...mapActions('user', [
			'resetPassword'
		]),
		send(){
			let data = this.setData();
			this.resetPassword({data, router: this.$router});
		},
		setData(){
			let formData = new FormData();
			formData.append('email', this.$route.query.email);
			formData.append('password', this.password);
			formData.append('password_confirmation', this.password_confirmation);
			formData.append('token', this.$route.params.token);
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
				this.password= value;
			} catch(e){

			}
		},
		password_confirmation: (value) => {
			try{
				this.password_confirmation = value;
			} catch(e){

			}
		}
	}
}
</script>

<style scoped>

</style>