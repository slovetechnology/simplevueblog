
import VueRouter from 'vue-router'
import HomeComponent from './components/HomeComponent';
import Login from './forms/Login';
import Register from './forms/Register';
import ProfileComponent from './components/ProfileComponent';
import Singlepost from './pages/Singlepost';
import Singleuser from './pages/Singleuser';

const routes = [
    {
        path: '/',
        component: HomeComponent,
        name: "home",
        beforeEnter: (to, from, next) => {
            axios.get('/api/authenticated')
            .then(() => {
                next();
            })
            .catch(() => {
                next({ name: 'login' });
            })
        }
    },
    {
        path: '/profile',
        component: ProfileComponent,
        name: 'profile',
        beforeEnter: (to, from, next) => {
            axios('/api/authenticated')
            .then(() => {
                next();
            })
            .catch(() => {
                next({ name: 'login' });
            })
        }
    },
    {
        path: '/login',
        component: Login,
        name: 'login',
        beforeEnter: (to, from, next) => {
            axios('/api/authenticated')
            .then( () => {
                next({ name: 'home' });
            })
            .catch(() => {
                next();
            })
        }
    },
    {
        path: '/register',
        component: Register,
        name: 'register',
        beforeEnter: (to, from, next) => {
            axios('/api/authenticated')
            .then( () => {
                next({ name: 'home' });
            })
            .catch(() => {
                next();
            })
        }
    },
    {
        path: '/post/:id',
        component: Singlepost,
        name: 'post',
        beforeEnter: (to, from, next) => {
            axios('/api/authenticated')
            .then(() => {
                next();
            })
            .catch(() => {
                next({ name: 'login' });
            })
        }
    },
    {
        path: '/singleuser/:id',
        component: Singleuser,
        name: 'singleuser',
        beforeEnter: (to, from, next) => {
            axios('/api/authenticated')
            .then(() => {
                next();
            })
            .catch(() => {
                next({name: 'login'});
            })
        }
    }
];

const router = new VueRouter({
    routes,
    mode: "history",
});

export default router;

