<template>
	<base-layout>
		<template v-slot:content>
			<div class="col-sm-8 ms-auto me-auto" v-show="isErrors">
				<lib-alert-notification v-for="error in errors" :key="error" :error="error"/>
			</div>
			<div class="modification mt-5 mb-4">
				<div class="modification__form col-sm-8 ms-auto me-auto pt-3 pb-2">
					<label class="modification__input form-input mb-3">
						<input type="text" class="modification__control form-control" name="title" placeholder="Title" v-model="ftitle" required>
					</label>
					<label class="modification__input form-input mb-3">
						<input type="text" class="modification__control form-control" name="description" placeholder="Description" v-model="fdesc" required>
					</label>
					<label class="modification__input form-input mb-3">
						<input type="file" class="modification__control form-control" name="image" placeholder="Image" @change="changeImage">
					</label>
					<label class="modification__input form-input mb-3">
						<input type="text" class="modification__control form-control" name="author" placeholder="Author" v-model="fauth" required>
					</label>
					<label class="modification__input form-input mb-3">
						<input type="text" class="modification__control form-control" name="genre" placeholder="Genre" v-model="fgenre" required>
					</label>
					<label class="modification__input form-input mb-3">
						<input type="number" class="modification__control form-control" name="year" placeholder="Year" v-model="fyear" required>
					</label>
					<label class="modification__input form-input mb-3">
						<input type="text" class="modification__control form-control" name="country" placeholder="Country" v-model="fcount" required>
					</label>
					<label class="modification__input form-input mb-3">
						<input type="number" class="modification__control form-control" name="pages" placeholder="Pages" v-model="fpages" required>
					</label>
					<label class="modification__input form-input mb-3 ">
						<textarea class="modification__control form-control" rows="10" name="book" placeholder="Book" v-model="fbook" required></textarea>
					</label>
					<label class="modification__input form-input mb-3 text-center">
						<button class="modification__button btn btn-primary" @click="send">Submit</button>
					</label>
				</div>
			</div>
		</template>
	</base-layout>

</template>

<script>
import BaseLayout from "../layouts/BaseLayout";
import LibAlertNotification from "../components/LibAlertNotification";
import {mapState, mapGetters, mapActions, mapMutations} from 'vuex';
export default {
	components: {
		BaseLayout, LibAlertNotification
	},
	data() {
		return {
		}
	},
	methods: {
		...mapMutations('book', [
			'setTitle',
			'setDesc',
			'setImage',
			'setAuthor',
			'setGenre',
			'setYear',
			'setPages',
			'setCountry',
			'setBook',
			'clearFields'
		]),
		...mapActions('book', [
			'createBook'
		]),
		changeImage(event){
			this.setImage(event.target.files[0]);
		},
		send(){
			let data = this.setData();
			this.createBook({data, router: this.$router})
		},
		isErrors(){
			return Object.keys(JSON.parse(JSON.stringify(this.errors))).length > 0 ? true : false;
		},
		setData(){
			let formData = new FormData();
			formData.append('title', this.title);
			formData.append('description', this.desc);
			if(this.image !== undefined){
				formData.append('image', this.image);
			}
			formData.append('author', this.author);
			formData.append('genre', this.genre);
			formData.append('country', this.country);
			formData.append('year', this.year);
			formData.append('pages', this.pages);
			formData.append('book', this.book);
			return formData;
		}
	},
	mounted() {
		this.clearFields();
	},
	computed: {
		...mapState({
			loading: state => state.book.loading,
			admin: state => state.isAdmin,
			title: state => state.book.title,
			desc: state => state.book.desc,
			author: state => state.book.author,
			image: state => state.book.image,
			genre: state => state.book.genre,
			year: state => state.book.year,
			country: state => state.book.country,
			pages: state => state.book.pages,
			book: state => state.book.book,
			errors: state => state.book.errors
		}),
		ftitle: {
			get(){
				return this.title;
			},
			set(value){
				this.setTitle(value);
			}
		},
		fdesc: {
			get(){
				return this.desc;
			},
			set(value){
				this.setDesc(value);
			}
		},
		fauth: {
			get(){
				return this.author;
			},
			set(value){
				this.setAuthor(value);
			}
		},
		fgenre: {
			get(){
				return this.genre;
			},
			set(value){
				this.setGenre(value);
			}
		},
		fyear: {
			get(){
				return this.year;
			},
			set(value){
				this.setYear(value);
			}
		},
		fcount: {
			get(){
				return this.country;
			},
			set(value){
				this.setCountry(value);
			}
		},
		fpages: {
			get(){
				return this.pages;
			},
			set(value){
				this.setPages(value);
			}
		},
		fbook: {
			get(){
				return this.book;
			},
			set(value){
				this.setBook(value);
			}
		},
	}
}
</script>

<style scoped>

</style>