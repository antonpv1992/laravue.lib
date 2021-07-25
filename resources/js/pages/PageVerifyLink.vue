<template>

</template>

<script>
import {mapState, mapGetters, mapActions, mapMutations} from 'vuex';
export default {
    methods: {
		...mapActions('user', [
			'verifyUser'
		]),
	},
    mounted() {
      this.verifyUser({id: this.$route.params.id, hash: this.$route.params.hash, expires: this.$route.query.expires, signature: this.$route.query.signature, router: this.$router});
    }
}
</script>
