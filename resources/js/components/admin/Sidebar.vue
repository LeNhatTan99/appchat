<template>
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="index3.html" class="brand-link">
            <span class="font-weight-bold">Admin</span>
        </a>
        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar user panel (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <li v-if="!authenticated.admin || !roles.admin">
                    <a class="pr-5"><router-link :to="{ name: 'userLogin' }">Đăng nhập</router-link></a>
                </li>
                <li v-if="!!authenticated.admin && !!roles.admin">
                    <div class="image pr-2">
                        <i class="fas fa-user text-white"></i>
                    </div>
                    <a class="pr-5">{{ account.admin?.full_name || account.admin?.user_name }} </a>
                    <a href="javascript:void(0)" @click="logout">Đăng xuất</a>
                </li>
            </div>
            <!-- SidebarSearch Form -->
            <div class="form-inline">
                <div class="input-group" data-widget="sidebar-search">
                    <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                    <div class="input-group-append">
                        <button class="btn btn-sidebar">
                            <i class="fas fa-search fa-fw"></i>
                        </button>
                    </div>
                </div>
            </div>
            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <li class="nav-item">
                        <router-link class="nav-link" :to="{ name: 'adminUser' }">
                            <i class="nav-icon fas fa-users-cog"></i>
                            <p> Admins </p>
                        </router-link>
                    </li>
                    <li class="nav-item">
                        <router-link class="nav-link" :to="{ name: 'adminUser' }">
                            <i class="nav-icon fas fa-users"></i>
                            <p> Tài khoản người dùng </p>
                        </router-link>
                    </li>
                    <li class="nav-item">
                        <router-link class="nav-link" :to="{name: 'adminCategory'}">
                            <i class="nav-icon fas fa-th"></i>
                            <p> Danh mục sản phẩm </p>
                        </router-link>
                    </li>

                    <li class="nav-item">
                        <router-link class="nav-link" :to="{name: 'adminProduct'}">
                            <i class="nav-icon fa-brands fa-product-hunt"></i>
                            <p> Sản phẩm </p>
                        </router-link>
                    </li>

                    <li class="nav-item">
                        <router-link class="nav-link" :to="{name: 'adminOrder'}">
                            <i class="nav-icon fa-regular fa-clipboard"></i>
                            <p> Đơn hàng </p>
                        </router-link>
                    </li>
                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>
</template>
<script>
import { mapGetters, mapActions } from 'vuex';
import Swal from 'sweetalert2';

export default {
    computed: {
        ...mapGetters(['token', 'account', 'authenticated', 'roles']),
    },
    mounted() {
        this.$store.dispatch('currentUser', 'admin')
    },

    methods: {
        async logout() {
            this.$store.dispatch('logout', 'admin');
            this.$router.push({ name: 'userLogin' });
        },
        showAlert() {
            Swal.fire({
                title: 'Thông báo',
                text: 'Đây là nội dung thông báo',
                icon: 'info',
            });
        },
    }
}
</script>