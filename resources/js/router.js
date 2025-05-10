import { createRouter, createWebHistory } from 'vue-router';
import ExchangeRates from './components/ExchangeRates.vue';
import ExchangeRateForm from './components/ExchangeRateForm.vue';

const routes = [
    {
        path: '/',
        name: 'exchange-rates',
        component: ExchangeRates
    },
    {
        path: '/admin/rates',
        name: 'exchange-rate-form',
        component: ExchangeRateForm
    }
];

const router = createRouter({
    history: createWebHistory(),
    routes
});

export default router;