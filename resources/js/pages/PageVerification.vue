<template>
	<base-layout>
		<template v-slot:content>
			<div class="mx-3 my-3">
				<div class="container">
					<div>
						Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.
					</div>
					<div v-show="mess">
						A new verification link has been sent to the email address you provided during registration.
					</div>
					<div class="mt-4 d-flex justify-content-around">
						<button class="btn btn-outline-primary" @click="resend">
								Resend Verification Email
						</button>
						<button class="btn btn-outline-primary" @click="exit">
								Logout
						</button>
					</div>
				</div>
			</div>
		</template>
	</base-layout>
</template>

<script>
import BaseLayout from "../layouts/BaseLayout";
import {mapState, mapGetters, mapActions, mapMutations} from 'vuex';
export default {
	data(){
		return {
			mess: false
		}
	},
	components: {
		BaseLayout
	},
	methods: {
		...mapActions('user', [
			'logout',
			'sendVerify'
		]),
		exit(){
			this.logout({router: this.$router});
		},
		resend(){
			this.mess = true;
			this.sendVerify({router: this.$router});
		}
	},
}
</script>

<style scoped>

</style>