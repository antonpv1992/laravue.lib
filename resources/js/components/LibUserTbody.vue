<template>
  <tbody class="col-sm-3 mb-3 mx-auto text-center" v-if="!loading">
    <tr class="users__table-row">
      <td class="users__table-col" colspan="8">
        ...loading
      </td>
    </tr>
  </tbody>
  <tbody class="users__table-body" v-else-if="users.length > 0">
    <tr class="users__table-row" v-for="user in users" :key="user.id">
      <th class="users__table-col" scope="row">{{user.id}}</th>
      <td class="users__table-col"><router-link class="text-decoration-none text-dark" :to="{name: 'user', params: {id: user.id}}">{{user.login}}</router-link></td>
      <td class="users__table-col">{{user.email}}</td>
      <td class="users__table-col">{{user.name}}</td>
      <td class="users__table-col">{{user.surname}}</td>
      <td class="users__table-col">{{user.age}}</td>
      <td class="users__table-col">{{user.role}}</td>
      <td class="users__table-col">
        <div class="position-relative">
          <lib-control
              :edit="'/user/edit/'"
              :value="user.id"
              @deleteItem="onDeleteItem"
          />
        </div>
      </td>
    </tr>
  </tbody>
  <tbody class="col-sm-3 mb-3 mx-auto text-center" v-else>
    <tr class="users__table-row">
      <td class="users__table-col" colspan="8">
          No Users
      </td>
    </tr>
  </tbody>
</template>

<script>
import LibControl from './LibControl.vue'
import {mapState, mapGetters} from 'vuex';
export default {
  components: {
      LibControl
  },
  data() {
    return {

    }
	},
  props: {
    users: {
      type: Object,
      required: true
    }
  },
  methods: {
    onDeleteItem(data){
      this.$emit('onDeleteItem', {
        id: data.id
      });
      this.removeUser(data.id);
    }
  },
  computed: {
    ...mapState({
      loading: state => state.user.loading,
      admin: state => state.isAdmin
    }),
    ...mapGetters('user', [
      'removeUser'
    ]),
	},
}
</script>

<style scoped>

</style>