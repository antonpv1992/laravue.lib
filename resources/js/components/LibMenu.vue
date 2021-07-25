<template>
	<nav class="menu navbar navbar-expand container mt-2 px-2">
		<ul class="menu__buttons navbar-nav me-auto mb-2 mb-lg-0">
			<li class="menu__item nav-item me-3">
				<router-link class="menu__button btn btn-primary" role="button" :to="{name: 'profile'}" v-if="auth && $route.name != 'user'">
					{{ucFirst(userName)}}
				</router-link>
				<a class="menu__button btn btn-primary" role="button" :href="$router.resolve({name: 'profile'}).href" v-else-if="auth && $route.name == 'user'">{{ucFirst(userName)}}</a>
				<button type="button" class="menu__button btn btn-primary" data-bs-toggle="modal" data-bs-target="#log" v-else>
					Login
				</button>
			</li>
			<li class="menu__item nav-item me-3" v-if="auth">
				<button type="button" class="menu__button btn btn-primary" @click="exit">
					Logout
				</button>
			</li>
			<li class="menu__item nav-item me-3" v-if="admin">
				<router-link class="menu__button btn btn-outline-primary" role="button" :to="{name: 'badd'}">
					Add book
				</router-link>
			</li>
			<li class="menu__item nav-item"  v-if="admin">
				<router-link class="menu__button btn btn-outline-primary" role="button" :to="{name: 'users'}">
					Show Users
				</router-link>
			</li>
		</ul>
		<div class="menu__form d-flex" v-if="auth">
			<lib-menu-sort/>
			<lib-menu-filter/>
			<input class="menu__search form-control me-3" name="bsearch" type="search" placeholder="Search" aria-label="Search" v-model="$route.query.search" @keyup.enter="search"> <!-- @input="writeQuery(squery)">-->
			<button class="menu__button btn btn-outline-primary" type="button" @click.prevent="search">Search</button>
		</div>
	</nav>
</template>

<script>
import LibMenuFilter from "./LibMenuFilter";
import LibMenuSort from "./LibMenuSort";
import {mapState, mapMutations, mapActions} from 'vuex';
export default {
	components: {
		LibMenuFilter, LibMenuSort
	},
	data() {
		return {

		}
	},
	computed: {
		...mapState({
			searchQuery: state => state.book.searchQuery,
			token: state => state.token,
			auth: state => state.isAuth,
			admin: state => state.isAdmin,
			userId: state => state.userId,
			userName: state => state.userName
		})
	},
	methods: {
		...mapMutations('book', [
			'setSearchQuery'
		]),
		...mapActions('book', [
			'fetchBooks'
		]),
		...mapActions('user', [
			'logout'
		]),
		search() {
			if(this.$route.name != 'home'){
				this.$router.push({ name: 'home', query: {search: this.$route.query.search}});
				return
			}
			this.setSearchQuery(this.$route.query.search);
			this.fetchBooks();
		},
		exit(){
			this.logout({router: this.$router});
		},
		ucFirst(str) {
			if (!str) return str;
			return str[0].toUpperCase() + str.slice(1);
		}
	},
	mounted() {
		this.$route.query.search ? this.setSearchQuery(this.$route.query.search) : this.setSearchQuery('');
	}
}
</script>

<style scoped>

</style>