<template>
    <aside class="main-sidebar sidebar-light-primary elevation-4">
        <!-- Brand Logo -->
        <a href="index3.html" class="brand-link">
            <span class="font-weight-bold">Users</span>
        </a>
        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar user panel (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <i class="fas fa-user text-white"></i>
                </div>
                <li v-if="!authenticated.user ">
                    <a class="pr-5"><router-link :to="{ name: 'userLogin' }">Đăng nhập</router-link></a>
                    <a><router-link :to="{ name: 'userRegister' }">Đăng ký</router-link></a>
                </li>
                <li v-if="!!authenticated.user">
                    <a class="pr-5">{{ account.user?.full_name || account.user?.user_name }} </a>
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
                    <li v-for="(usersInConversation, conversationId) in listConversations" :key="conversationId" class="nav-link">
                    <router-link :to="{name: 'editUser', params: { id: conversationId }}">
                        <template v-if="usersInConversation.length === 2">
                            <span v-for="(user, index) in usersInConversation" :key="index">
                                <template v-if="user.user_id !== account.user.id">
                                    <img :src="getAvatarUrl(user.avatar)" alt="Avatar" class="user-avatar">
                                    <span class="user-full-name">{{ user.full_name }}</span>
                                </template>
                            </span>
                        </template>
                        <template v-else>
                            <template v-if="usersInConversation[0] && usersInConversation[0].conversation_name">
                                <span class="user-item">
                                    <i class="fa-solid fa-users pr-2 icon-avatar" ></i>
                                    <span class="conversation-name">{{ usersInConversation[0].conversation_name }}</span>
                                </span>
                            </template>
                            <template v-else>                               
                                <span v-for="(user, index) in usersInConversation" :key="index" class="user-item">
                                    <img :src="getAvatarUrl(user.avatar)" alt="Avatar" class="user-avatar-group">
                                    <span class="user-full-name">{{ user.full_name }},</span>
                                </span>
                            </template>
                        </template>
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
import { mapGetters } from 'vuex';
import Request from "../../../../resources/plugins/request.js";

export default {
    data() {
        return {
            listConversations: {},
        }
    },
    computed: {
        ...mapGetters(['token', 'account', 'authenticated']),
    },
    mounted() {
        this.$store.dispatch('currentUser', 'user'),
        this.loadConversation()
    },

    methods: {
        async logout() {
            this.$store.dispatch('logout', 'user');
            this.$router.push({ name: 'userLogin' });
        },
        async loadConversation() {
            try {
                const response = await Request.get(`user/chat/list-conversations`, 'user')
                this.listConversations = response.data.conversations
            } catch (error) {
                console.log(error)
            }
        },
        getAvatarUrl(avatarPath) {
            if (avatarPath) {
                return '/storage/' + avatarPath;
            }
            return '/storage/user_images/avatar-default.jpg';
        },
    }
}
</script>
<style lang="scss" scoped>
.user-avatar {
    width: 40px;
    height: 40px;
    margin-right: 4px;
    border-radius: 50%;
}
.user-avatar-group {
    width: 24px;
    height: 24px;
    margin-right: 4px;
    border-radius: 50%;
}
.user-item {
  display: inline-flex;
  margin-right: 4px;
}
.nav-link {
    color: #000 !important;
}
.nav-link:hover {
    cursor: pointer;
    background-color: #ddd;
    border: 1px solid #ccc;
}
.icon-avatar {
    font-size: 24px;
    width: 40px;
    margin-right: 4px;
    border-radius: 50%;
}
</style>