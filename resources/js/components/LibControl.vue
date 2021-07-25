<template>

	<button type="button" class="library__book-close" @click="deleteItem(value)" v-if="admin">
		<i class="library__card-icon fas fa-times"></i>
	</button>
	<router-link type="button" class="library__book-edit" :to="edit.includes('profile') ? edit : (edit + value)" v-if="(admin || (edit.includes('profile') && user == value))">
		<i class="library__card-icon fas fa-pencil-alt"></i>
	</router-link>

</template>

<script>
import LibModalConfirmation from "./LibModalConfirmation";
import {mapState} from 'vuex';
export default {
	components: {
		LibModalConfirmation
	},
	emits: ['deleteItem'],
	props: {
		value: {
			type: [Number, String],
			required: true,
			default: 0
		},
		edit: {
			type: String,
			required: true
		}
	},
	methods: {
		deleteItem(id){
      this.$emit('deleteItem', {
        id
      });
    }
	},
	computed: {
		...mapState({
			admin: state => state.isAdmin,
			user: state => state.userId
		})
	},
}
</script>

<style scoped>

</style>