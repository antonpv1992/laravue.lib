<template>
	<router-view/>
</template>

<script>
import BaseLayout from "./layouts/BaseLayout";
import PageBooks from "./pages/PageBooks";
export default{
	components: {
    BaseLayout, PageBooks
  }
}
</script>