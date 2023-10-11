<template>
    <LayoutWrapper>
        <div class="content">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Tạo tài khoản</h3>
                </div>
                <!-- form start -->
                <form @submit.prevent="saveUser" enctype="multipart/form-data">
                    <div class="card-body px-5">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label>Email </label>
                                <input type="email" class="form-control" v-model="user.email">
                                <span class="error-message">{{ errors.email }}</span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label>Họ và tên</label>
                                <input type="text" class="form-control" v-model="user.full_name">
                                <span class="error-message">{{ errors.full_name }}</span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label>Số điện thoại</label>
                                <input type="text" class="form-control" v-model="user.phone">
                                <span class="error-message">{{ errors.phone }}</span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label>Ngày sinh </label>
                                <input type="date" class="form-control" id="dateInput" v-model="user.birthday">
                                <span class="error-message">{{ errors.birthday }}</span>
                            </div>
                        </div>
                        <div class="row">
                            <label>Địa chỉ </label>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="text" class="form-control " v-model="user.address">
                                    <span class="error-message">{{ errors.address }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <select id="province" class="form-control" v-model="user.province_id"
                                        @change="loadDistricts">
                                        <option value="">Chọn Tỉnh/Thành phố </option>
                                        <option :value="province.id" v-for="province in provinces" :key="province.id">{{
                                            province.name }} </option>
                                    </select>
                                    <span class="error-message">{{ errors.province_id }}</span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <select id="district" class="form-control" v-model="user.district_id" @change="loadCommunes">
                                        <option value="">Chọn Quận/Huyện</option>
                                        <option :value="district.id" v-for="district in districts" :key="district.id">{{
                                            district.name }} </option>
                                    </select>
                                    <span class="error-message">{{ errors.district_id }}</span>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <select id="commune" class="form-control" v-model="user.commune_id">
                                        <option value="">Chọn Phường/Xã</option>
                                        <option :value="commune.id" v-for="commune in communes" :key="commune.id">{{
                                            commune.name }} </option>
                                    </select>
                                    <span class="error-message">{{ errors.commune_id }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="">Avatar</label>
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="inputImg">
                                        <span class="btn btn-success">
                                            <i class="fa-solid fa-image nav-icon"></i> Chọn hình ảnh
                                        </span>
                                    </label>
                                    <input type="file" id="inputImg" class="inputImg form-control"
                                        @change="handleFileChange" accept="image/*">
                                </div>
                            </div>
                            <div class="image-preview" id="imgPreview">
                                <img v-if="previewURL" :src="previewURL" alt="Preview">
                                <span class="image-preview__text">Avatar</span>
                            </div>
                            <span class="error-message">{{ errors.avatar }}</span>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label>Mật khẩu </label>
                                <div class="input-group">
                                    <input :type="showPassword ? 'text' : 'password'" class="form-control"
                                        v-model="user.password" />
                                    <div class="input-group__append">
                                        <span class="input-group__icon" @click="togglePasswordVisibility">
                                            <i class="fa-solid nav-icon"
                                                :class="{ 'fa-eye-slash': showPassword, 'fa-eye': !showPassword }"></i>
                                        </span>
                                    </div>
                                </div>
                                <span class="error-message">{{ errors.password }}</span>
                            </div>
                        </div>

                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">{{ editing ? 'Cập nhật' : 'Tạo mới'}}</button>
                    </div>
                </form>
            </div>
        </div>
        <div>
        </div>
    </LayoutWrapper>
</template>
    
<script>
import LayoutWrapper from '../Layout.vue';
import Request from "../../../../../resources/plugins/request.js";
import axios from 'axios';
import Toast from '../../../nofitication/toast';

export default {
    props: ['id'],
    data() {
        return {
            previewURL: null,
            showPassword: false,
            provinces: [],
            districts: [],
            communes: [],
            user: {
                province_id: '',
                district_id: '',
                commune_id: '',
                email: null,
                full_name: null,
                phone: null,
                password: null,
                avatar: null,
                address: null,
                birthday: null,
            },
            errors: {
                province_id: null,
                district_id: null,
                commune_id: null,
                email: null,
                full_name: null,
                phone: null,
                password: null,
                avatar: null,
                address: null,
                birthday: null,
            },
            editing: false,
        }
    },
    components: {
        LayoutWrapper,
    },
    async mounted() {
        try {
            await this.getProvince();
            if (this.id) {
                this.editing = true;
                await this.fetchUser();
                const district = this.user.district_id;
                const commune = this.user.commune_id;
                await this.loadDistricts();
                this.user.district_id = district;
                await this.loadCommunes();
                this.user.commune_id = commune;
            }
        } catch (error) {
            console.error(error);
        }
    },
    methods: {
        async getProvince() {
            await axios.get('/api/get-provinces')
                .then(response => {
                    this.provinces = response.data.data;
                    this.user.province_id = '';
                    this.user.district_id = '';
                    this.user.commune_id = '';
                })
                .catch((err) => {
                    throw err.response;
                });
        },

        async loadDistricts() {
            if (!this.user.province_id) {
                this.districts = [];
                return;
            }
            try {
                const response = await axios.get('/api/get-districts', {
                    params: {
                        province_id: this.user.province_id
                    }
                });
                this.districts = response.data.data;
                this.user.district_id = '';
                this.user.commune_id = '';
            } catch (error) {
                console.error(error);
            }
        },
        async loadCommunes() {
            if (!this.user.district_id) {
                this.communes = [];
                return;
            }
            try {
                const response = await axios.get('/api/get-communes', {
                    params: {
                        district_id: this.user.district_id
                    }
                });
                this.communes = response.data.data;
                this.user.commune_id = '';
            } catch (error) {
                console.error(error);
            }
        },
        async handleFileChange(event) {
            const file = event.target.files[0];
            if (file) {
                this.user.avatar = file;
                await this.previewImage(file);
            }
        },
        async previewImage(file) {
            try {
                const reader = new FileReader();
                const result = await new Promise((resolve, reject) => {
                    reader.onload = event => resolve(event.target.result);
                    reader.onerror = error => reject(error);
                    reader.readAsDataURL(file);
                });
                this.previewURL = result;
            } catch (error) {
                console.error('Error reading file:', error);
            }
        },
        togglePasswordVisibility() {
            this.showPassword = !this.showPassword;
        },
        async saveUser() {
            try {
                const data = {
                    province_id: this.user.province_id,
                    district_id: this.user.district_id,
                    commune_id: this.user.commune_id,
                    email: this.user.email,
                    full_name: this.user.full_name,
                    phone: this.user.phone,
                    password: this.user.password,
                    avatar: this.user.avatar,
                    address: this.user.address,
                    birthday: this.user.birthday,
                };
                if(this.editing) {
                    const id = this.$route.params.id; 
                    await Request.post(`admin/users/update/${id}`,data,'admin')
                    .then(response => {
                        if (response.data.message) {
                            Toast.showToast('success', response.data.message)
                            this.$router.push({ name: 'adminUser' });
                        }
                    })
                    .catch((err) => {
                        throw err.response;
                    }); 
                } else {
                    await Request.post('admin/users/create',data ,'admin')
                    .then(response => {
                        if (response.data.message) {
                            Toast.showToast('success', response.data.message)
                            this.$router.push({ name: 'adminUser' });
                        }
                    })
                    .catch((err) => {
                        throw err.response;
                    }); 
                }
            } catch(error){
                console.log(error);
                if (error.data.errors || error.response.data.errors) {
                    const errorMessages = error.data.errors || error.response.data.errors;
                    for (const field in this.errors) {
                            this.errors[field] = null;
                            if (errorMessages.hasOwnProperty(field)) {
                            this.errors[field] = errorMessages[field].join('\n');
                        }
                    }
                }
            }
        },
        async fetchUser() {
            try {
                const id = this.$route.params.id; 
                await Request.get(`admin/users/edit/${id}`, 'admin')
                    .then (response => {
                        const userData = response.data.data
                        for (const key in this.user) {
                            if (key !== 'avatar' && userData[key] !== undefined) {
                                this.user[key] = userData[key];
                            }
                        }
                        this.previewURL = '/storage/'+ userData['avatar']
                    })
                    .catch((err) => {
                        throw err.response;
                    });
            } catch (error) {
                Toast.showToast('error', error.data.message)
            }
        },

    }
};
</script>
  
<style lang="scss">
.inputImg {
    display: none;
}

.image-preview {
    width: 200px;
    height: 200px;
    border: 2px solid #ccc;
    display: flex;
    justify-content: center;
    align-items: center;
    margin-top: 10px;
    position: relative;

    &__text {
        position: absolute;
        color: #ccc;
        font-weight: bold;
    }

    img {
        z-index: 9;
        max-width: 100%;
        max-height: 100%;
        object-fit: cover;
    }
}

.input-group {
    position: relative;
    &__append {
        z-index: 9;
        position: absolute;
        right: 4px;
        top: 50%;
        transform: translateY(-50%);
    }

    &__icon {
        cursor: pointer;
    }
}</style>