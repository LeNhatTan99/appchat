import { createRouter, createWebHistory } from 'vue-router'
import store from "./store";

// component user
import UserLogin from "./components/user/Login.vue";
import UserRegister from "./components/user/Register.vue";
import UserDashboard from "./views/user/Index.vue";
import ChatLayout from './components/chat/ChatLayout.vue'
// component admin
import AdminDashboard from "./views/admin/Index.vue";
import AdminUser from "./views/admin/users/Index.vue";
import CreateUser from "./views/admin/users/Create.vue";
import App from "./App.vue";

function requireLogin(to, from, next) {
    const role = to.meta.role;
    if (store.getters.authenticated[role]) {
        return next();
    }
    return next({
        name: 'userLogin',
    });
}

const routes = [
    {
        path: '/',
        redirect: '/user/login',
        component: App,
        children: [
            {
                path: '/user',
                component: App,
                children: [
                    {
                        path: 'login',
                        component: UserLogin,
                        name: 'userLogin',
                        meta: {
                            title: 'Đăng nhập',
                        },
                    },
                    {
                        path: 'register',
                        component: UserRegister,
                        name: 'userRegister',
                        meta: {
                            title: 'Đăng ký',
                        },
                    },
                    {
                        path: 'dashboard',
                        component: UserDashboard,
                        name: 'userDashboard',
                        meta: {
                            title: 'Trang chủ',
                            role: 'user'
                        },
                        beforeEnter: requireLogin,
                    },
                    {
                        path: 'chat',
                        component: ChatLayout,
                        name: 'chatLayout',
                        meta: {
                            title: 'Trang chủ',
                            role: 'user'
                        },
                        beforeEnter: requireLogin,
                    },
                ]
            },
            {
                path: '/admin',
                component: App,
                children: [
                    {
                        path: 'dashboard',
                        component: AdminDashboard,
                        name: 'adminDashboard',
                        meta: {
                            title: 'Admin|Trang chủ',
                            role: 'admin'
                        },
                        beforeEnter: requireLogin,
                    },
                    {
                        path: 'users',
                        component: AdminUser,
                        name: 'adminUser',
                        meta: {
                            title: 'Admin|Quản lý người dùng',
                            role: 'admin'
                        },
                        beforeEnter: requireLogin,
                    },      
                    {
                        path: 'users/create',
                        component: CreateUser,
                        name: 'createUser',
                        meta: {
                            title: 'Admin|Tạo tài khoản',
                            role: 'admin'
                        },
                        beforeEnter: requireLogin,
                    },
                    {
                        path: 'users/edit/:id',
                        component: CreateUser,
                        name: 'editUser',
                        props: true,
                        meta: {
                            title: 'Admin|Chỉnh sửa tài khoản',
                            role: 'admin'
                        },
                        beforeEnter: requireLogin,
                    },
                    
                    {
                        path: 'categories',
                        component: AdminUser,
                        name: 'adminCategory',
                        meta: {
                            title: 'Admin|Quản lý danh mục sản phẩm',
                            role: 'admin'
                        },
                        beforeEnter: requireLogin,
                    },
                    {
                        path: 'products',
                        component: AdminUser,
                        name: 'adminProduct',
                        meta: {
                            title: 'Admin|Quản lý sản phẩm',
                            role: 'admin'
                        },
                        beforeEnter: requireLogin,
                    },
                    {
                        path: 'orders',
                        component: AdminUser,
                        name: 'adminOrder',
                        meta: {
                            title: 'Admin|Quản lý đơn hàng',
                            role: 'admin'
                        },
                        beforeEnter: requireLogin,
                    },
                ]
            }
        ],
    },
    {
        path: '/:pathMatch(.*)*',
        component: App,
        name: 'NotFound',
      },
]

const router = createRouter({
    history: createWebHistory(),
    routes: routes
})

export default router
