<template>
	<div class="header mt-3 mb-3">
		<div class="header__box text-center">
			<router-link v-if="$route.name != 'home'" class="header__link text-decoration-none" :to="{name: 'home'}">
				<h1 class="header__content">APLibrary</h1>
			</router-link>
			<a v-else class="header__link text-decoration-none" :href="$router.resolve({name: 'home'}).href"><h1 class="header__content">APLibrary</h1></a>
		</div>
	</div>
</template>

<script>
export default {

}
</script>

<style scoped>

</style>