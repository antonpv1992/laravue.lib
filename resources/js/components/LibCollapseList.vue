<template>
	<li class="card__collapse" :class="collapse" id="card1">
		<ul class="card__list list-group list-group-flush">
			<li class="card__desc-item list-group-item">
				<span class="card__desc-title fw-bold">Author:</span> {{book.author}}
			</li>
			<li class="card__desc-item list-group-item">
				<span class="card__desc-title fw-bold">Genre:</span> {{book.genre}}
			</li>
			<li class="card__desc-item list-group-item">
				<span class="card__desc-title fw-bold">Year:</span> {{book.year}}
			</li>
			<li class="card__desc-item list-group-item">
				<span class="card__desc-title fw-bold">Country:</span> {{book.country}}
			</li>
			<li class="card__desc-item list-group-item">
				<span class="card__desc-title fw-bold">Pages:</span> {{book.pages}}
			</li>
		</ul>
	</li>
</template>

<script>
export default {
	props: {
		collapse: {
			type: String,
			required: true
		},
		book: {
			type: Object,
			required: true
		}
	}
}
</script>

<style scoped>

</style>