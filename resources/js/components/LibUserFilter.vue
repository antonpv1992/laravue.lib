<template>
  <div class="users__filter col-5">
    <select class="users__select form-select" v-model="filtered" aria-label=".form-select-sm example">
      <option class="users__option" value="id" selected>Id</option>
      <option class="users__option" value="login">User name</option>
      <option class="users__option" value="email">Email</option>
      <option class="users__option" value="name">Name</option>
      <option class="users__option" value="surname">Surname</option>
      <option class="users__option" value="age">Age</option>
    </select>
  </div>
</template>

<script>
import {mapState, mapGetters, mapActions, mapMutations} from 'vuex';
export default {
  data() {
    return {

    }
	},
	methods: {
		...mapMutations('user', [
			'setFilterField'
		]),
		...mapActions('user', [
			'fetchUsers'
		])
	},
    computed: {
		...mapState({
			filterField: state => state.user.filterField
		}),
		filtered: {
			get(){
				return this.filterField;
			},
			set(value){
				this.setFilterField(value);
			}
		},
	}
}
</script>

<style scoped>

</style>