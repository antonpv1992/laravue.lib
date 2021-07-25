import axios from "axios";

export const userModule = {
    state: () => ({
        loading: false,
        users: [],
        fullUser: {},
        id: '',
        login: '',
        email: '',
        name: '',
        surname: '',
        age: '',
        role: '',
        g_id: '',
        f_id: '',
        photo: '',
        created: '',
        verify: '',
        errors: [],
        sortDirection: '▲',
        sortField: 'id',
        filterField: '',
        searchField: 'login'
    }),
    getters: {
        getUsers(state){
            return state.users;
        },
        getSortUsers(state, getters){
            return getters.sortUsers.filter(user => user[state.filterField].toString().toLowerCase().includes(state.searchField.toLowerCase()));
        },
        sortUsers(state, getters){
            return state.sortDirection === '▼'
            ? [...state.users].sort((user1, user2) => getters.sortByType(user2[state.sortField], user1[state.sortField]))
            : [...state.users].sort((user1, user2) => getters.sortByType(user1[state.sortField], user2[state.sortField]));
        },
        sortByType: state => (a, b) => {
            return Number.isInteger(a) ? (a - b) : a.localeCompare(b);
        },
        removeUser: state => id => {
            state.users = state.users.filter(user => user.id !== id)
        }
    },
    mutations: {
        setUsers(state, users){
            state.users = users;
        },
        setLoading(state, loading) {
            state.loading = loading;
        },
        setSortDirection(state, sort){
            state.sortDirection = sort;
        },
        setSortField(state, sort){
            state.sortField = sort;
        },
        setFilterField(state, filter){
            state.filterField = filter;
        },
        setSearchField(state, search){
            state.searchField = search;
        },
        setLogin(state, login){
            state.login = login;
        },
        setEmail(state, email){
            state.email = email;
        },
        setName(state, name){
            state.name = name;
        },
        setSurname(state, surname){
            state.surname = surname;
        },
        setAge(state, age){
            state.age = age;
        },
        setErrors(state, errors){
            state.errors = errors;
        },
        setLoadUser(state, obj){
            state.fullUser = obj;
            state.id = obj.id;
            state.login = obj.login;
            state.email = obj.email;
            state.name = obj.name;
            state.surname = obj.surname;
            state.age = obj.age;
            state.role = obj.role ?? '';
            state.g_id = obj.google_id ?? '';
            state.f_id = obj.facebook_id ?? '';
            state.photo = obj.profile_photo_url ?? '';
            state.created = obj.created ?? '';
            state.verify = obj.verify ?? '';
        },
        clearUser(state){
            state.fullUser = {};
            state.id = '';
            state.login = '';
            state.email = '';
            state.name = '';
            state.surname = '';
            state.age = '';
            state.role = '';
            state.g_id = '';
            state.f_id = '';
            state.photo = '';
            state.created = '';
            state.errors = [];
        }
    },
    actions: {
        async fetchUsers({rootState, commit}){
            try  {
                commit('setLoading', false);
                const response = await axios.get('/api/user', {
                    headers: {
                        Authorization: `Bearer ${rootState.token}`
                    }
                })
                commit('setUsers', response.data.data);
                commit('setLoading', true);
            } catch(e){
                console.log(e);
            }
        },
        async fetchUser({commit, rootState}, id){
            try  {
                commit('setLoading', false);
                const response = await axios.get('/api/user/' + id, {
                    headers: {
                        Authorization: `Bearer ${rootState.token}`
                    }
                });
                if(response.data.success){
                    commit('setLoadUser', response.data.data);
                } else {
                    console.log('no user by this id: ' + id);
                }
                commit('setLoading', true);

            } catch(e){
                console.log(e);
            }
        },
        async createUser({commit, rootState}, {data, router}){
            try {
                const response = await axios.post('/api/user/', data, {
                    headers: {
                        Authorization: `Bearer ${rootState.token}`
                    }
                });
                if(response.data.success){
                    commit('setErrors', []);
                    router.push({name: 'users', query: { message: 'User added successfully' } });
                } else {
                    commit('setErrors', response.data.message);
                }
            } catch(e){
                console.log(e);
            }
        },
        async editUser({commit, rootState}, {data, id, router}){
            try {
                const response = await axios.post('/api/user/' + id, data, {
                    headers: {
                        Authorization: `Bearer ${rootState.token}`
                    }
                });
                if(response.data.success){
                    commit('setErrors', []);
                    router.push({name: 'users', query: { message: 'User by id ' + id + ' edited successfully' } });
                } else {
                    commit('setErrors', response.data.message);
                }
            } catch(e){
                console.log(e);
            }
        },
        async deleteUser({rootState}, {id, router}){
            try {
                const response = await axios.delete('/api/user/' + id, {
                    headers: {
                        Authorization: `Bearer ${rootState.token}`
                    }
                });
                if(response.data.success){
                    router.push({name: 'users', query: { message: 'User by id ' + id + ' deleted successfully' } });
                }
            } catch(e){
                console.log(e);
            }
        },
        async login({commit}, {data, router}){
            try{
                const response = await axios.post('/api/login', data);
                if(response.data.success){
                    commit('setErrors', []);
                    localStorage.setItem('uid', response.data.data.id);
                    localStorage.setItem('uname', response.data.data.login);
                    localStorage.setItem('verify', response.data.data.verify);
                    localStorage.setItem('token', response.data.data.token);
                    localStorage.setItem('role', response.data.data.role == 'admin');
                    router.push({name: 'home', query: { message: 'You are successfully logged in' } });
                    setTimeout(() => router.go(), 10);
                } else {
                    commit('setErrors', response.data.message);
                }
            } catch(e){
                commit('setErrors', [[e.response.data.message]]);
                console.log(e.response.data.message);
            }
        },
        async logout({rootState}, {router}){
            try {
                const response = await axios.post('/api/logout', null, {
                    headers: {
                        Authorization: `Bearer ${rootState.token}`
                    }
                });
                if(response.data.success){
                    localStorage.clear();
                    router.push({name: 'home'});
                    setTimeout(() => router.go(), 10);
                }
            }catch(e){
                console.log(e)
            }
        },
        async registration({commit}, {data, router}) {
            try {
                const response = await axios.post('/api/register', data);
                if(response.data.success){
                    commit('setErrors', []);
                    localStorage.setItem('uid', response.data.data.id);
                    localStorage.setItem('uname', response.data.data.login);
                    localStorage.setItem('verify', response.data.data.verify);
                    localStorage.setItem('token', response.data.data.token);
                    localStorage.setItem('role', response.data.data.role == 'admin');
                    router.go();
                    setTimeout(() => router.push({name: 'verify'}), 10);
                } else {
                    commit('setErrors', response.data.message);
                }
            } catch(e){
                commit('setErrors', [[e.response.data.message]]);
                console.log(e.response.data.message);
            }
        },
        async verifyUser({rootState}, {id, hash, expires, signature, router}){
            try {
                const response = await axios.get(`/api/verify/${id}/${hash}`, {
                    params: {
                        expires, signature
                    },
                    headers: {
                        Authorization: `Bearer ${rootState.token}`
                    }
                });
                if(response.data.success){
                    localStorage.setItem('verify', true);
                    router.push({name: 'home', query: {message: 'You verified successfully!'}});
                } else {
                    router.push({name: 'verify'});
                }
            } catch(e){
                console.log(e);
                router.push({name: 'verify'});
            }
        },
        async sendVerify({rootState}, {router}){
            try {
                const response = await axios.post('/api/verify', null, {
                    headers: {
                        Authorization: `Bearer ${rootState.token}`
                    }
                });
                if(!response.data.success){
                    router.push({name: 'home'});
                }
            } catch(e){
                console.log(e);
            }
        },
        async forgotPassword({commit}, {data, router}) {
            try {
                const response = await axios.post('/api/forgot', data)
                console.log(JSON.parse(JSON.stringify(response.data.message)));
                if(response.data.success){
                    commit('setErrors', []);
                    router.push({name: 'home', query:{ message: 'Password reset request sent by email'}});
                    setTimeout(() => router.go(), 10);
                } else {
                    let message = JSON.parse(JSON.stringify(response.data.message)) instanceof Object
                    ? JSON.parse(JSON.stringify(response.data.message))
                    : [[JSON.parse(JSON.stringify(response.data.message))]];
                    commit('setErrors', message);
                }
            } catch(e) {
                let message = JSON.parse(JSON.stringify(e.response.data.message)) instanceof Object
                ? JSON.parse(JSON.stringify(e.response.data.message))
                : [[JSON.parse(JSON.stringify(e.response.data.message))]];
                commit('setErrors', message);
                console.log(e.response.data.message);
            }
        },
        async resetPassword({commit}, {data, router}) {
            try {
                const response = await axios.post('/api/reset', data);
                if(response.data.success){
                    commit('setErrors', []);
                    router.push({name: 'home', query:{ message: 'Password changed successfully!'}});
                    setTimeout(() => router.go(), 10);
                } else {
                    let message = JSON.parse(JSON.stringify(response.data.message)) instanceof Object
                    ? JSON.parse(JSON.stringify(response.data.message))
                    : [[JSON.parse(JSON.stringify(response.data.message))]];
                    commit('setErrors', message);
                }

            } catch(e) {
                let message = JSON.parse(JSON.stringify(e.response.data.message)) instanceof Object
                ? JSON.parse(JSON.stringify(e.response.data.message))
                : [[JSON.parse(JSON.stringify(e.response.data.message))]];
                commit('setErrors', message);
            }
        },
        async facebookAuth({commit}){
            try{
                const response = await axios.get('/api/auth/facebook');
                if(response.data.success){
                    commit('setErrors', []);
                    localStorage.setItem('uid', response.data.data.id);
                    localStorage.setItem('uname', response.data.data.login);
                    localStorage.setItem('verify', response.data.data.verify);
                    localStorage.setItem('token', response.data.data.token);
                    localStorage.setItem('role', response.data.data.role == 'admin');
                } else {
                    let message = JSON.parse(JSON.stringify(response.data.message)) instanceof Object
                    ? JSON.parse(JSON.stringify(response.data.message))
                    : [[JSON.parse(JSON.stringify(response.data.message))]];
                    commit('setErrors', message);
                }
            } catch(e){
                let message = JSON.parse(JSON.stringify(e.response.data.message)) instanceof Object
                ? JSON.parse(JSON.stringify(e.response.data.message))
                : [[JSON.parse(JSON.stringify(e.response.data.message))]];
                commit('setErrors', message);
            }
        },
        async googleAuth({commit}){
            try{
                const response = await axios.get('/api/auth/google');
                if(response.data.success){
                    commit('setErrors', []);
                    localStorage.setItem('uid', response.data.data.id);
                    localStorage.setItem('uname', response.data.data.login);
                    localStorage.setItem('verify', response.data.data.verify);
                    localStorage.setItem('token', response.data.data.token);
                    localStorage.setItem('role', response.data.data.role == 'admin');
                } else {
                    let message = JSON.parse(JSON.stringify(response.data.message)) instanceof Object
                    ? JSON.parse(JSON.stringify(response.data.message))
                    : [[JSON.parse(JSON.stringify(response.data.message))]];
                    commit('setErrors', message);
                }
            } catch(e){
                let message = JSON.parse(JSON.stringify(e.response.data.message)) instanceof Object
                ? JSON.parse(JSON.stringify(e.response.data.message))
                : [[JSON.parse(JSON.stringify(e.response.data.message))]];
                commit('setErrors', message);
            }
        }
    },
    namespaced: true
}