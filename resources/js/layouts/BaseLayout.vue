<template>
	<page-sign-up/>
	<page-sign-in/>
	<page-remember/>
	<div class="container">
		<lib-header/>
		<lib-menu/>
		<slot name="content"></slot>
		<lib-footer/>
	</div>
</template>

<script>
import PageSignUp from "../pages/PageSignUp";
import PageSignIn from "../pages/PageSignIn";
import PageRemember from "../pages/PageRemember";
import LibHeader from "../components/LibHeader";
import LibMenu from "../components/LibMenu";
import LibFooter from "../components/LibFooter";
export default {
	components: {
    PageSignUp, PageSignIn, PageRemember, LibHeader, LibMenu, LibFooter
  }
}
</script>

<style scoped>

</style>