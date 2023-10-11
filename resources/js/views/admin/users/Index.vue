<template>
  <LayoutWrapper>
    <div class="content">
      <div class="card-header">
        <a href="" :to="{name: 'adminUser'}" class="btn btn-info">Làm mới <i class="fa-solid fa-arrows-rotate"></i></a>
        <Search :placeholder="'Tìm kiếm User'" @searchInput="loadSearch"/>
        <div class="card-tools">
          <router-link :to="{name: 'createUser'}" class="btn btn-success"><i class="fa-solid fa-file-circle-plus"></i> Tạo mới</router-link>
        </div>
      </div>
      <table class="table table-bordered">
        <thead>
          <tr class="text-center">
            <th>STT</th>
            <th>Tài khoản</th>
            <th>Email</th>
            <th>Ngày sinh</th>
            <th>Số điện thoại</th>
            <th>Địa chỉ</th>
            <th>Trạng thái</th>
            <th>Hành động</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(user, index) in users" :key="user.id">      
            <td class="text-center">{{ index + 1 }}</td>
            <td class="column-text"> <img :src="getAvatarUrl(user.avatar)" alt="Avatar" class="user-avatar"><span class="user-name">{{user.full_name}}</span></td>
            <td>{{ user.email }}</td>
            <td>{{ formatDate(user.birthday) }}</td>
            <td>{{ user.phone }}</td>
            <td class="column-text">{{ user.address }}</td>
            <td>{{ user.status }}</td>
            <td class="text-center">
              <router-link :to="{name: 'editUser', params: { id: user.id }}" class="btn btn-info icon-action" >
                <i class="fa-solid fa-pen-to-square"></i>
              </router-link>
              <a class="btn btn-danger icon-action" @click="showDeleteConfirmation(user.id)">
               <i class="fa-solid fa-trash-can"></i>
              </a>
            </td>
          </tr>
        </tbody>
      </table>
      <Pagination
        v-model="currentPage"
        :totalPages="totalPages"
        @loadPage="loadPage"
      />
    </div>
  </LayoutWrapper>
</template>
  
<script>
import LayoutWrapper from '../Layout.vue';
import Request from "../../../../../resources/plugins/request.js";
import moment from 'moment';
import Toast from '../../../nofitication/toast';
import Swal from 'sweetalert2';
import Pagination from "../../../components/common/Pagination.vue";
import Search from "../../../components/common/Search.vue";

export default {
  data() {
    return {
      users: null,
      totalPages: 0,
      currentPage: 1,
      search: null,
    }
  },
  components: {
    LayoutWrapper,
    Pagination,
    Search,
  },
  mounted() {
    this.listUser();
  },
  methods: {
    async showDeleteConfirmation(id) {
      try {
        const result = await Swal.fire({
          title: 'Bạn có chắc chắn muốn xoá?',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonText: 'Xác nhận',
          cancelButtonText: 'Hủy',
          reverseButtons: true
        });
        if (result.isConfirmed) {
          this.deleteUser(id);
        }
      } catch (error) {
        console.log(error);
      }

    },
  
    async listUser() {
      let url = 'admin/users?page=' + this.currentPage;
      if (this.search) {
        url += '&search=' + this.search;
      }
      await Request.get(url, 'admin')  
        .then(response => {
          this.users = response.data.users.data;
          this.totalPages = response.data.users.last_page;
          this.currentPage = response.data.users.current_page;
        })
        .catch((err) => {
          throw err.response;
        });
    },
    async loadPage() {
      this.listUser();
    },
    async loadSearch(searchValue) {
      this.search = searchValue;
      this.listUser();
    },
    async deleteUser(id) {
      try {
        await Request.delete(`admin/users/delete/${id}`, 'admin')  
          .then(response => {
            this.listUser();
            Toast.showToast('success', response.data.message)
          })
          .catch((err) => {
            throw err.response;
          });
      }
      catch (error) {
        Toast.showToast('error', 'Có lỗi xảy ra')
      }
    },
    getAvatarUrl(avatarPath) {
            if (avatarPath) {
                return '/storage/' + avatarPath;
            }
            return '/storage/user_images/avatar-default.jpg';
        },
      formatDate(value){
        if (value) {
          return moment(String(value)).format('DD/MM/YYYY')
        }
    },
  }
};
</script>

<style lang="scss" scoped>
.card-header {
  background-color: #fff;
  height: 64px;
  width: 100%;
  .btn {
    margin-right: 12px;
  }
}
.icon-action {
  margin: 2px;
  padding:4px 6px;
}
.user-avatar {
    width: 40px;
    height: 40px;
    margin-right: 10px;
    border-radius: 50%;
}
.user-name {
    vertical-align: middle;
}

</style>