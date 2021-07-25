import axios from "axios";

export const bookModule = {
    state: () => ({
        loading: false,
        books: '',
        fullBook: '',
        pagination: [],
        sortSelected: 'id',
        sortDirection: 'down',
        filterSelected: ['title'],
        searchQuery: '',
        limitPages: 8,
        id: '',
        title: '',
        desc: '',
        author: '',
        image: '',
        genre: '',
        year: '',
        country: '',
        pages: '',
        book: '',
        errors: [],
    }),
    getters: {
        getBooks(state){
            return state.books;
        },
        getFullBook(state){
            return state.fullBook;
        },
    },
    mutations: {
        setBooks(state, books) {
            state.books = books;
        },
        setFullBook(state, book) {
            state.fullBook = book;
        },
        setPagination(state, pagination) {
            state.pagination = pagination;
        },
        setSortSelected(state, sortSelected) {
            state.sortSelected = sortSelected;
        },
        setSortDirection(state, sortDirection) {
            state.sortDirection = sortDirection;
        },
        setFilterSelected(state, filterSelected) {
            state.filterSelected = filterSelected;
        },
        setSearchQuery(state, searchQuery) {
            state.searchQuery = searchQuery;
        },
        setId(state, id) {
            state.id = id;
        },
        setTitle(state, title) {
            state.title = title;
        },
        setDesc(state, desc) {
            state.desc = desc;
        },
        setAuthor(state, author) {
            state.author = author;
        },
        setImage(state, image) {
            state.image = image;
        },
        setGenre(state, genre) {
            state.genre = genre;
        },
        setYear(state, year) {
            state.year = year;
        },
        setCountry(state, country) {
            state.country = country;
        },
        setPages(state, pages) {
            state.pages = pages;
        },
        setBook(state, book){
            state.book = book;
        },
        setLoading(state, loading) {
            state.loading = loading;
        },
        setLoadBook(state, obj){
            state.fullBook = obj;
            state.id = obj.id;
            state.title = obj.title;
            state.desc = obj.desc;
            state.author = obj.author;
            state.image = undefined;
            state.genre = obj.genre;
            state.year = obj.year;
            state.country = obj.country;
            state.pages = obj.pages;
            state.book = obj.book;
        },
        clearFields(state){
            state.fullBook = {};
            state.id = '';
            state.title = '';
            state.desc = '';
            state.author = '';
            state.image = undefined;
            state.genre = '';
            state.year = '';
            state.country = '';
            state.pages = '';
            state.book = '';
            state.errors = [];
        },
        setErrors(state, errors){
            state.errors = errors;
        }
    },
    actions: {
        async fetchBooks({state, commit}, page = 1){
            try  {
                commit('setLoading', false);
                const response = await axios.get('/api/book', {
                    params: {
                        limit: state.limitPages,
                        page,
                        search: state.searchQuery,
                        sort: state.sortSelected,
                        order: state.sortDirection,
                        filter: state.filterSelected,
                    }
                })
                commit('setBooks', response.data.data);
                commit('setPagination', response.data.pagination);
                commit('setLoading', true);
            } catch(e){
                console.log(e);
            }
        },
        async fetchBook({commit, rootState}, id){
            try  {
                commit('setLoading', false);
                const response = await axios.get('/api/book/' + id, {
                    headers: {
                        Authorization: `Bearer ${rootState.token}`
                    }
                });
                if(response.data.success){
                    commit('setLoadBook', response.data.data);
                } else {
                    console.log('no post by this id: ' + id);
                }
                commit('setLoading', true);

            } catch(e){
                console.log(e);
            }
        },
        async createBook({commit, rootState}, {data, router}){
            try {
                const response = await axios.post('/api/book/', data, {
                    headers: {
                        Authorization: `Bearer ${rootState.token}`
                    }
                });
                if(response.data.success){
                    commit('setErrors', []);
                    router.push({name: 'home', query: { message: 'Book added successfully' } });
                } else {
                    commit('setErrors', response.data.message);
                }
            } catch(e){
                console.log(e);
            }
        },
        async editBook({commit, rootState}, {data, id, router}){
            try {
                const response = await axios.post('/api/book/' + id, data, {
                    headers: {
                        Authorization: `Bearer ${rootState.token}`
                    }
                });
                if(response.data.success){
                    commit('setErrors', []);
                    router.push({name: 'home', query: { message: 'Book by id ' + id + ' edited successfully' } });
                } else {
                    commit('setErrors', response.data.message);
                }
            } catch(e){
                console.log(e);
            }
        },
        async removeBook({rootState}, {id, router}){
            try {
                const response = await axios.delete('/api/book/' + id, {
                    headers: {
                        Authorization: `Bearer ${rootState.token}`
                    }
                });
                if(response.data.success){
                    router.push({name: 'home', query: { message: 'Book by id ' + id + ' deleted successfully' } });
                }
            } catch(e){
                console.log(e);
            }
        }
    },
    namespaced: true
}