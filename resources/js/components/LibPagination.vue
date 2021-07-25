<template>
    <div class="library__pagination col-3 mx-auto" >
		<nav>
      <ul class="pagination">
        <li class="page-item" v-for="n in total" :key="n" :class="n === current ? 'active' : ''">
          <span class="page-link" v-if="n === current">{{n}}</span>
          <span class="page-link page__link" @click="paginate(n)" v-else>{{n}}</span>
        </li>
      </ul>
    </nav>
    </div>
</template>

<script>

export default {
	components: {

	},
	data() {
		return {

		}
	},
	props: {
		total: {
      type: Number,
      required: true
    },
    current: {
      type: Number,
      required: true
    }
	},
	methods: {
		paginate(n){
      this.$emit('paginate', {
        page: n
      });
    }
	}
}
</script>

<style scoped>

</style>