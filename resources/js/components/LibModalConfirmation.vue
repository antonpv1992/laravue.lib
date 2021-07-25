<template>
	<div class="modal fade" id="deleteBook" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="deleteBookLabel" aria-hidden="true">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">
				<div class="modal-body text-center">
					Do you really want to delete it?
				</div>
				<div class="d-flex justify-content-around mb-3">
					<button type="button" class="btn btn-danger" @click.prevent="deleteItem">Yes {{value}}</button>
					<button type="button" class="btn btn-success" data-bs-dismiss="modal">No</button>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
export default {
	props: {
		deleteItem: {
			type: Function,
			required: true
		},
		value: {
			type: Number,
			required: true
		}
	}
}
</script>

<style scoped>

</style>