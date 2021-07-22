import {createWebHistory, createRouter} from "vue-router";

import Login from '../pages/Login.vue';
import Dashboard from '../pages/Dashboard.vue';
import Register from '../pages/Register.vue'

import Products from '../components/Product.vue';
import AddProduct from '../components/AddProduct.vue';
import EditProduct from '../components/EditProduct.vue';



export const routes = [
    {
        name: 'home',
        path: '/',
        component: Login
    },
    {
        name: 'login',
        path: '/login',
        component: Login
    },
    {
        name: 'register',
        path: '/register',
        component: Register
    },
    {
        name: 'dashboard',
        path: '/dashboard',
        component: Dashboard
    },
    {
        name: 'products',
        path: '/products',
        component: Products
    },
    {
        name: 'addproduct',
        path: '/products/add',
        component: AddProduct
    },
    {
        name: 'editproduct',
        path: '/products/edit/:id',
        component: EditProduct
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes: routes,
});

export default router;

