<template>
  <nav class="navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item">
        <div class="search-group">
          <i class="fas fa-search"></i>
          <input type="search" class="search-input" placeholder="Tìm kiếm" v-model="search" @input="searchUser"
            @focus="toggleOpenSearch(true)"
            >
        </div>
      </li>
    </ul>
    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Navbar Search -->
      <li class="nav-item">
      <li v-if="!authenticated.user">
        <span class="pr-3 nav-item-acction"><router-link :to="{ name: 'userLogin' }">Đăng nhập</router-link></span>
        <span class="nav-item-acction"><router-link :to="{ name: 'userRegister' }">Đăng ký</router-link></span>
      </li>
      <li v-if="!!authenticated.user">
        <span class="pr-3 friend-pending">
          <i class="fa-solid fa-user-plus text-gray" @click="toggleOpenFriendPending()"></i>
          <sup v-if="friendPendingCount > 0" class="text-red font-weight-bold pl-1">
            {{ friendPendingCount }}
          </sup>
          <div v-if="openFriendPending" class="list-friend-pending">
            <h6 class="result-search__title text-center my-2">Lời mời kết bạn</h6>
            <hr style="margin: 0;">
            <template v-if="friendPending.length > 0" v-for="user in friendPending" :index="user.id">
              <li class="list-friend-pending__item">  
                <div class="info-group">
                  <img class="rounded-circle user_img"
                    :src="getAvatarUrl(user.avatar ? user.avatar : 'user_images/avatar-user-default.png')" alt="">
                  <span class="list-friend-pending__item--name">
                    {{ user.full_name }}
                  </span>
                </div>             
                <div class="btn-group">
                  <button class="btn-accept" @click="acceptFriend(user.friendship_id, 1)">Chấp nhận</button>
                  <button class="btn-reject" @click="acceptFriend(user.friendship_id, 0)">Từ chối</button>
                </div>
              </li>
            </template>
            <template v-else>
              <p class="text-center py-5 text-gray">Không có lời mời kết bạn nào!</p>
            </template>
          </div>
      </span>
      <span class="pr-3 nav-item-acction nav-item__name">
        <img class="rounded-circle user_img"
          :src="getAvatarUrl(account.user.avatar ? account.user.avatar : 'user_images/avatar-user-default.png')" alt="">
        {{ account.user.full_name }}
      </span>
      <span class="nav-item-acction" href="javascript:void(0)" @click="logout">Đăng xuất</span>
      </li>
      </li>
    </ul>
  </nav>
  <div class="result-search" v-if="this.openSearch">
    <div class="result-search__header">
      <h6 class="result-search__title text-center my-2">Kết quả tìm kiếm</h6> 
      <button class="btn-close" @click="toggleOpenSearch(false)"></button>
      <hr style="margin: 0;">
    </div>
    <template v-if="users" v-for="user in users" :index="user.id">
      <li class="result-search__item">
        <img class="rounded-circle user_img"
          :src="getAvatarUrl(user.avatar ? user.avatar : 'user_images/avatar-user-default.png')" alt="">
        <span class="result-search__item--name">
          {{ user.full_name }}
        </span>
        <i v-if="user.friend == 0" @click="addFriend(user.id)"
          class="fa-solid fa-user-plus icon-add-user text-primary"></i>
      </li>
    </template>
    <template v-else>
      <p class="text-center py-5 text-gray">Không tìm thấy người dùng nào!</p>
    </template>
  </div>
</template>
<script>
import { mapGetters, mapMutations } from 'vuex';
import Request from "../../../../resources/plugins/request.js";
import Toast from '../../nofitication/toast';

export default {
  data() {
    return {
      openSearch: false,
      openFriendPending: false,
      search: null,
      users: null,
      friendPendingCount: null,
      friendPending: null,
    }
  },
  computed: {
    ...mapGetters(['token', 'account', 'authenticated']),
  },
  mounted() {
    this.$store.dispatch('currentUser', 'user')
    this.searchUser()
    this.getFriendPending()
  },

  methods: {
    ...mapMutations(['setFriendRequestAccepted']),
    async logout() {
      this.$store.dispatch('logout', 'user');
      this.$router.push({ name: 'userLogin' });
    },
    getAvatarUrl(avatarPath) {
      if (avatarPath) {
        return '/storage/' + avatarPath;
      }
      return '/storage/user_images/avatar-default.jpg';
    },
    toggleOpenSearch(value) {
      this.openSearch = value;
    },
    toggleOpenFriendPending() {
      this.openFriendPending = !this.openFriendPending;
    },
    async searchUser() {
      try {
        let url = 'user/search-user';

        const params = new URLSearchParams();
        if (this.search) {
          params.append('search', this.search);
          url += `?${params.toString()}`;
        }

        const response = await Request.get(url, 'user')

        if (!response) {
          throw new Error('Có lỗi xảy ra');
        }

        this.users = response.data.users;
      } catch (err) {
        console.error(err);
      }
    },
    async addFriend(friendId) {
      try {
        const response = await Request.postNormal(`user/friend/add/${friendId}`, null, 'user')
        if (!response) {
          throw new Error('Có lỗi xảy ra');
        }
        if (response.data.message) {
          Toast.showToast('success', response.data.message)
        }
        else Toast.showToast('error', "Gửi yêu cầu kết bạn thành công!")
      } catch (err) {
        console.error(err);
        if (err.response.data.error) {
          Toast.showToast('error', err.response.data.error)
        }
        else Toast.showToast('error', "Gửi yêu cầu kết bạn thất bại!")
      }
    },
    async acceptFriend(friendshipId, status) {
      try {
        const data = {
                    status: status,
                };
        const response = await Request.postNormal(`user/friend/accept-friendship/${friendshipId}`, data, 'user')
        if (!response) {
          throw new Error('Có lỗi xảy ra');
        }
        if (response.data.message) {
          this.getFriendPending()
          Toast.showToast('success', response.data.message)
          if(status == 1) {
            this.setFriendRequestAccepted(true);
          }
        }
        else Toast.showToast('error', "Xác nhận thành công!")
      } catch (err) {
        console.error(err);
        if (err.response.error) {
          Toast.showToast('error', err.response.error)
        }
        else Toast.showToast('error', "Xử lý yêu cầu thất bại!")
      }
    },
    async getFriendPending() {
      try {
        const response = await Request.get(`user/friend/friend-pending`, 'user')
        if (!response) {
          throw new Error('Có lỗi xảy ra');
        }
        this.friendPendingCount = response.data.count
        this.friendPending = response.data.data
      } catch (err) {
        console.error(err);
      }
    }

  }
}
</script>
<style lang="scss" scoped>
.friend-pending {
  position: relative;
  &:hover {
    cursor: pointer;
  }
}
.btn-group {
  margin-left: 48px;
}
.btn-accept, .btn-reject {
  font-size: 14px;
  font-weight: 500;
  padding: 2px 4px;
  margin: 2px 8px 2px 0;
  border: none;
  border-radius: 4px;
  color: #fff;
}
.btn-accept {
  background-color: #3899da;
}
.btn-reject {
  background-color: #df4935;
}
.btn-close {
  border: none;
  border-radius: 4px;
  padding: 0 8px;
  position: absolute;
  top: 0;
  right: 0;
}
.result-search__header {
  position: relative;
}
.list-friend-pending,
.result-search {
  overflow-y: auto;
  position: absolute;
  border: 1px solid #ccc;
  border-radius: 0 0 4px 4px;
  width: 320px;
  height: 400px;
  z-index: 10;
  background-color: #fff;
  box-shadow: 1px 1px 4px 1px #ccc;

  &__item {
    padding: 4px 8px;
    position: relative;

    &:hover {
      background-color: #b4bdce;
    }

    &--name {
      font-weight: 600;
      margin-left: 8px;
    }
  }
}

.icon-add-user {
  position: absolute;
  right: 12px;
  top: 12px;

  &:hover {
    font-size: 120%;
    color: #3c0381;
    cursor: pointer;
  }
}

.nav-item-acction:hover {
  cursor: pointer;
  font-size: 110%;
}

.nav-item__name {
  font-weight: 600;
}

.search-input {
  border: 1px solid #ccc;
  border-radius: 10px;
  padding: 4px 12px;
  margin: 0 4px;
}

.user_img {
  height: 40px;
  width: 40px;
  border: 1.5px solid #f5f6fa;

}

.navbar {
  position: relative;
  margin-left: 160px;
  margin-right: 160px;
}


@media(max-width: 768px) {
  .navbar {
    margin-left: 0;
    margin-right: 0;
  }
}
</style>