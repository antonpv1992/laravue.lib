import {createRouter, createWebHistory} from "vue-router";
import PageBook from "../pages/PageBook";
import PageBooks from "../pages/PageBooks";
import PageUsers from "../pages/PageUsers";
import PageBookForm from "../pages/PageBookForm";
import PageBookFormAdd from "../pages/PageBookFormAdd";
import PageProfileForm from "../pages/PageProfileForm";
import PageProfileFormAdd from "../pages/PageProfileFormAdd";
import PageProfile from "../pages/PageProfile";
import PageReset from "../pages/PageReset";
import PageVerification from "../pages/PageVerification";
import PageVerifyLink from "../pages/PageVerifyLink";
import store from '../store/index';


const routes = [
    {
        path: '/',
        name: 'home',
        component: PageBooks,
        meta: {
            guest: true
        }
    },
    {
        path: '/book/:id',
        name: 'book',
        component: PageBook,
        meta: {
            verify: true
        }
    },
    {
        path: '/users',
        name: 'users',
        component: PageUsers,
        meta: {
            admin: true
        }
    },
    {
        path: '/profile',
        name: 'profile',
        component: PageProfile,
        meta: {
            auth: true
        }
    },
    {
        path: '/profile/edit',
        name: 'pedit',
        component: PageProfileForm,
        meta: {
            auth: true
        }
    },
    {
        path: '/user/:id',
        name: 'user',
        component: PageProfile,
        meta: {
            verify: true
        }
    },
    {
        path: '/reset/:token',
        name: 'reset',
        component: PageReset,
        meta: {
            onlyguest: true
        }
    },
    {
        path: '/verify',
        name: 'verify',
        component: PageVerification,
        meta: {
            verified: true
        }
    },
    {
        path: '/book/add',
        name: 'badd',
        component: PageBookFormAdd,
        meta: {
            admin: true
        }
    },
    {
        path: '/book/edit/:id',
        name: 'bedit',
        component: PageBookForm,
        meta: {
            admin: true
        }
    },
    {
        path: '/user/add',
        name: 'uadd',
        component: PageProfileFormAdd,
        meta: {
            admin: true
        }
    },
    {
        path: '/user/edit/:id',
        name: 'uedit',
        component: PageProfileForm,
        meta: {
            admin: true
        }
    },
    {
        path: '/verify/:id/:hash',
        name: 'cverify',
        component: PageVerifyLink,
        meta: {
            verified: true
        }
    },
]

const router = createRouter({
    routes,
    history: createWebHistory()
})

router.beforeEach((to, from, next) => {
    const auth = to.matched.some(r => r.meta.auth);
    const verify = to.matched.some(r => r.meta.verify);
    const admin = to.matched.some(r => r.meta.admin);
    const guest = to.matched.some(r => r.meta.guest);
    const verified = to.matched.some(r => r.meta.verified);
    const onlyguest = to.matched.some(r => r.meta.onlyguest);
    if(guest) next()
    else if(admin && store.state.isAdmin) next()
    else if(verify && store.state.verify) next()
    else if(auth && store.state.isAuth) next()
    else if(verified && store.state.isAuth && !store.state.verify) next()
    else if(auth && !store.state.isAuth) next({name: 'home', query:{message: 'You are not authorized to view this page'}})
    else if(verify && !store.state.verify) next({name: 'verify'})
    else if(admin && !store.state.isAdmin) next({name: 'home', query:{message: 'You do not have access rights'}})
    else if(verified && store.state.isAuth && store.state.verify) next({name: 'home', query:{message: 'You are already verified'}})
    else if(onlyguest && store.state.isAuth) next({name: 'home', query:{message: 'You do not have access rights'}})
    else if(verified && !store.state.isAuth) next({name: 'home', query:{message: 'You do not have access rights'}})
    else next()
})

export default router;