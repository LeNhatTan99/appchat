<template>
    <div id="layout-wrapper">
        <Header></Header>
        <Sidebar />
        <div class="main-content">
            <div class="page-content">
                    <router-view />
            </div>
        </div>
        <Footer></Footer>
    </div>
</template>
<script>
    import Header from '../../components/user/Header.vue'
    import Sidebar from '../../components/user/Sidebar.vue'
    import Footer from '../../components/user/Footer.vue'

    export default {
        components: {Header, Sidebar, Footer},
    }
</script>
<style lang="scss">
    @import '../../../../public/template_adminlte/dist/css/adminlte.min.css';
    .main-content {
        min-height: 500px;
    }
</style>