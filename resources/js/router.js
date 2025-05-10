import { createRouter, createWebHistory } from 'vue-router';
import ExchangeRates from './components/ExchangeRates.vue';
import ExchangeRateForm from './components/ExchangeRateForm.vue';
import Login from './components/Login.vue';
import Register from './components/Register.vue';

const routes = [
    { path: '/', name: 'exchange-rates', component: ExchangeRates },
    { path: '/login', name: 'login', component: Login },
    { path: '/register', name: 'register', component: Register },
    {
        path: '/exchange-rate-form',
        name: 'exchange-rate-form',
        component: ExchangeRateForm,
        meta: { requiresAuth: true }
    }
];

const router = createRouter({
    history: createWebHistory(),
    routes
});

router.beforeEach((to, from, next) => {
    const isAuthenticated = !!localStorage.getItem('auth_token');
    if (to.meta.requiresAuth && !isAuthenticated) {
        next({ name: 'login' });
    } else {
        next();
    }
});

export default router;