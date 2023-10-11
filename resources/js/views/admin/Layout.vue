<template>
    <div id="layout-wrapper">
        <Header />
        <Sidebar />
        <div class="main-content">
            <div class="page-content">
                <slot></slot>
            </div>
        </div>
        <Footer />
    </div>
</template>
  
<script>
import Header from '../../components/admin/Header.vue'
import Sidebar from '../../components/admin/Sidebar.vue'
import Footer from '../../components/admin/Footer.vue'

export default {
    components: {
        Header,
        Sidebar,
        Footer,
    },
};
</script>
<style lang="scss">
@import '../../../../public/template_adminlte/dist/css/adminlte.min.css';
.main-content {
    min-height: 500px;
}
.main-content {
    margin-left: 250px;
}
</style>