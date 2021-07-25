<template>
  <thead class="users__table-head">
    <tr class="users__table-row">
      <th class="users__table-col" scope="col"><a class="text-decoration-none text-dark" @click="sortClick($event, 'id')">{{header.id}}</a></th>
      <th class="users__table-col" scope="col"><a class="text-decoration-none text-dark" @click="sortClick($event, 'login')">{{header.login}}</a></th>
      <th class="users__table-col" scope="col"><a class="text-decoration-none text-dark" @click="sortClick($event, 'email')">{{header.email}}</a></th>
      <th class="users__table-col" scope="col"><a class="text-decoration-none text-dark" @click="sortClick($event, 'name')">{{header.name}}</a></th>
      <th class="users__table-col" scope="col"><a class="text-decoration-none text-dark" @click="sortClick($event, 'surname')">{{header.surname}}</a></th>
      <th class="users__table-col" scope="col"><a class="text-decoration-none text-dark" @click="sortClick($event, 'age')">{{header.age}}</a></th>
      <th class="users__table-col" scope="col"><a class="text-decoration-none text-dark" @click="sortClick($event, 'role')">{{header.role}}</a></th>
      <th class="users__table-col text-dark" scope="col">{{header.tools}}</th>
    </tr>
  </thead>
</template>

<script>
import {mapState, mapGetters, mapActions, mapMutations} from 'vuex';
export default {
  data() {
    return {
      header: {
        'id':  '#',
        'login': 'User Name',
        'email': 'Email',
        'name': 'Name',
        'surname': 'Surname',
        'age': 'Age',
        'role': 'Role',
        'tools': 'Tools'
      }
    }
	},
	methods: {
		...mapMutations('user', [
      'setSortDirection',
      'setSortField',
      'setFilterField',
      'setSearchField'
		]),
		...mapActions('user', [
			'fetchUsers'
		]),
    sortClick(event, key){
        this.setSortField(key);
        this.setHeader(key, this.toggleDirrection(event.target.textContent));
    },
    toggleDirrection(value){
      if(!value.includes('▲') && !value.includes('▼')){
        this.clearHeader();
        this.setSortDirection('▼');
        return value + ' ▼';
      } else if(value.includes('▲')) {
        this.setSortDirection('▼');
        return this.splitString(value) + ' ▼';
      } else {
        this.setSortDirection('▲');
        return this.splitString(value) + ' ▲';
      }
    },
    clearHeader(){
      for(let key in this.header){
        this.setHeader(key, this.splitString(this.header[key]));
      }
    },
    setHeader(key, value){
      this.header[key] = value;
    },
    splitString(value){
      let val = value.split(' ');
      val[0] = val[0] !== 'User' ? val[0] : val[0] + ' ' + val[1];
      return val[0];
    },
    getSortDirection(value){
      return value[value.length - 1] === '▲';
    }
	},
	mounted() {

	},
	computed: {
		...mapState({
			users: state => state.user.users,
			loading: state => state.user.loading,
			admin: state => state.isAdmin,
      sortDirection: state => state.user.sortDirection,
      sortField: state => state.user.sortField
		}),
    ...mapGetters('user', [
			'sortArray'
		]),
	}
}
</script>

<style scoped>

</style>