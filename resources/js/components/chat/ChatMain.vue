<template>
    <div class="background-chat">
        <div class="container-fluid h-100">
            <div class="row justify-content-center h-100">
                <div class="col-md-4 col-xl-3 chat">
                    <div class="card mb-sm-3 mb-md-0 contacts_card">
                        <div class="card-body contacts_body">
                            <ui class="contacts">
                                <li @click="getConversation(conversationId)"
                                    v-for="(usersInConversation, conversationId) in listConversations" :key="conversationId"
                                    :class="{ 'active': conversationId === activeConversationId }" class="contacts__item">
                                    <template v-if="usersInConversation.length === 2">
                                        <span v-for="(user, index) in usersInConversation" :key="index">
                                            <template v-if="user.user_id !== account.user.id">
                                                <div class="d-flex bd-highlight">
                                                    <div class="img_cont">
                                                        <img :src="getAvatarUrl(user.avatar ? user.avatar : 'user_images/avatar-user-default.png')"
                                                            alt="Avatar" class="rounded-circle user_img">
                                                        <span class="online_icon"></span>
                                                    </div>
                                                    <div class="user_info">
                                                        <span>{{ user.full_name }}</span>
                                                        <p>{{ user.full_name }} is online</p>
                                                    </div>
                                                </div>
                                            </template>
                                        </span>
                                    </template>
                                    <template v-else>
                                        <template v-if="usersInConversation[0] && usersInConversation[0].conversation_name">
                                            <span class="user-item">
                                                <div class="d-flex bd-highlight">
                                                    <div class="img_cont">
                                                        <img :src="getAvatarUrl('user_images/avatar-group-default.png')"
                                                            alt="Avatar" class="rounded-circle user_img">
                                                        <span class="online_icon"></span>
                                                    </div>
                                                    <div class="user_info">
                                                        <span>{{ usersInConversation[0].conversation_name }}</span>
                                                        <p>{{ usersInConversation.length }} Thành viên</p>
                                                    </div>
                                                </div>
                                            </span>
                                        </template>
                                        <template v-else>
                                            <span class="user-item">
                                                <div class="d-flex bd-highlight">
                                                    <div class="img_cont">
                                                        <img :src="getAvatarUrl('user_images/avatar-group-default.png')"
                                                            alt="Avatar" class="rounded-circle user_img">
                                                        <span class="online_icon"></span>
                                                    </div>
                                                    <div class="user_info">
                                                        <span v-for="(user, index) in usersInConversation" :key="index"
                                                            class="user_info--group">
                                                            {{ user.full_name }},
                                                        </span>
                                                    </div>
                                                </div>
                                            </span>
                                        </template>
                                    </template>
                                </li>
                            </ui>
                        </div>
                    </div>
                </div>
                <div class="col-md-8 col-xl-6 chat">
                    <div class="card">
                        <template v-if="Object.keys(conversationInfo).length !== 0">
                            <div class="card-header msg_head">
                                <div class="d-flex bd-highlight">
                                    <div class="img_cont">
                                        <img :src="getAvatarUrl(conversationInfo.avatar ? conversationInfo.avatar
                                            : (conversationInfo.type === 'group'
                                                ? 'user_images/avatar-group-default.png'
                                                : 'user_images/avatar-user-default.png'))"
                                            class="rounded-circle user_img">
                                        <span class="online_icon"></span>
                                    </div>
                                    <div class="user_info">
                                        <span>{{ conversationInfo.name }}</span>
                                        <p>{{ listMessages.length }} Tin nhắn</p>
                                    </div>
                                    <div class="video_cam">
                                        <span><i class="fas fa-video"></i></span>
                                        <span><i class="fas fa-phone"></i></span>
                                    </div>
                                </div>
                                <span @click="toggleActionMenu" id="action_menu_btn"><i
                                        class="fas fa-ellipsis-v"></i></span>
                                <div v-if="isActionMenuOpen" class="action_menu">
                                    <ul>
                                        <li><i class="fas fa-user-circle"></i> Xem hồ sơ</li>
                                        <li><i class="fas fa-plus"></i> Thêm vào nhóm</li>
                                        <li><i class="fas fa-ban"></i> Chặn</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-body msg_card_body" ref="messageContainer">
                                <template v-if="listMessages.length > 0" v-for="(message, index) in listMessages"
                                    :key="index">
                                    <template v-if="account.user.id === message.user.id">
                                        <div class="d-flex justify-content-end mb-4">
                                            <div class="msg_cotainer_send">
                                                {{ message.message }}
                                                <span class="msg_time_send">{{ formatTimestamp(message.created_at) }}</span>
                                            </div>
                                            <div class="img_cont_msg">
                                                <img :src="getAvatarUrl(message.user.avatar)" alt="avatar"
                                                    class="rounded-circle user_img_msg">
                                            </div>
                                        </div>
                                    </template>
                                    <template v-else>
                                        <div class="d-flex justify-content-start mb-4">
                                            <div class="img_cont_msg">
                                                <img :src="getAvatarUrl(message.user.avatar)" alt="avatar"
                                                    class="rounded-circle user_img_msg">
                                            </div>
                                            <div class="msg_cotainer">
                                                {{ message.message }}
                                                <span class="msg_time">{{ formatTimestamp(message.created_at) }}</span>
                                            </div>
                                        </div>
                                    </template>
                                </template>
                            </div>
                            <div class="card-footer">
                                <div class="input-group">
                                    <div class="input-group-append">
                                        <span class="input-group-text attach_btn"><i class="fas fa-paperclip"></i></span>
                                    </div>
                                    <textarea name="" class="form-control type_msg" v-model="message"
                                        @keyup.enter="sendMessage" placeholder="Type your message..."></textarea>
                                    <div class="input-group-append">
                                        <button class="input-group-text send_btn" @click="sendMessage"><i
                                                class="fas fa-location-arrow"></i></button>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import { mapGetters, mapState  } from 'vuex';
import Request from "../../../../resources/plugins/request.js";

export default {
    data() {
        return {
            isActionMenuOpen: false,
            listConversations: {},
            message: '',
            listMessages: [],
            conversationId: 0,
            conversationInfo: {},
            usersOnline: [],
            activeConversationId: null,
        };
    },
    watch: {
        friendRequestAccepted(newVal) {
            if (newVal) {
                this.loadConversation();
                this.$store.commit('setFriendRequestAccepted', false);
            }
        },
    },
    computed: {
        ...mapGetters(['token', 'account', 'authenticated']),
        ...mapState(['friendRequestAccepted']),
    },
    mounted() {
        this.$store.dispatch('currentUser', 'user'),
        this.loadConversation(),
        this.loadMessage(),
        this.switchConversation()
    },
    methods: {
        switchConversation() {
            this.activeConversationId = this.conversationId;
            if (this.conversationId > -1) {
                // Echo.private(`conversation.${this.conversationId}`)
                //     .listen('MessagePosted', (data) => {
                //         if (data.message.conversation_id == this.conversationId) {
                //             let message = data.message
                //             message.user = data.user
                //             this.listMessages.push(message)
                //         }
                //     })
        Echo.join(`conversation.${this.conversationId}`)
        .here((users) => { // gọi ngay thời điểm ta join vào phòng, trả về tổng số user hiện tại có trong phòng (cả ta)
          this.usersOnline = users
        })
        .joining((user) => { // gọi khi có user mới join vào phòng
          this.usersOnline.push(user)
        })
        .leaving((user) => { // gọi khi có user rời phòng
          const index = this.usersOnline.findIndex(item => item.id === user.id)
          if (index > -1) {
            this.usersOnline.splice(index, 1)
          }
        })
        .listen('MessagePosted', (data) => {
                     if (data.message.conversation_id == this.conversationId) {
                            let message = data.message
                            message.user = data.user
                            this.listMessages.push(message)
                        }
        })
            }
        },
        beforeDestroy() {
            Echo.leave(`conversation.${this.conversationId}`)
        },
        scrollToBottom() {
            const messageContainer = this.$refs.messageContainer;
            messageContainer.scrollTop = messageContainer.scrollHeight;
        },

        toggleActionMenu() {
            this.isActionMenuOpen = !this.isActionMenuOpen;
        },
        async loadConversation() {
            let url = 'user/chat/list-conversations';

            const params = new URLSearchParams();
            try {
                const response = await Request.get(url, 'user')
                this.listConversations = response.data.conversations
            } catch (error) {
                console.log(error)
            }
        },
        getConversation(conversationId) {
            this.beforeDestroy()
            this.conversationId = conversationId
            this.loadMessage()
            this.switchConversation()
        },
        async loadMessage() {
            try {
                const conversationId = this.conversationId
                const response = await Request.get(`user/chat/${conversationId}/messages`, 'user')
                this.listMessages = response.data.messages
                this.conversationInfo = response.data.conversationInfo
                this.$nextTick(() => {
                    this.scrollToBottom();
                });
            } catch (error) {
                console.log(error)
            }
        },
        async sendMessage() {
            try {
                const data = {
                    message: this.message,
                    conversation_id: this.conversationId
                };
                const response = await Request.post('user/chat/send-message', data, 'user')
                this.listMessages.push(response.data.message)
                this.message = ''
                this.$nextTick(() => {
                    this.scrollToBottom();
                });
            } catch (error) {
                console.log(error)
            }
        },
        formatTimestamp(timestamp) {
            const createdAt = new Date(timestamp);
            const currentDate = new Date();
            if (
                createdAt.getDate() === currentDate.getDate() &&
                createdAt.getMonth() === currentDate.getMonth() &&
                createdAt.getFullYear() === currentDate.getFullYear()
            ) {
                return `${createdAt.getHours()}:${String(createdAt.getMinutes()).padStart(2, '0')}`;
            } else {
                return `${createdAt.getHours()}:${String(createdAt.getMinutes()).padStart(2, '0')} ${createdAt.toLocaleDateString()}`;
            }
        },
        getAvatarUrl(avatarPath) {
            if (avatarPath) {
                return '/storage/' + avatarPath;
            }
            return '/storage/user_images/avatar-default.jpg';
        },
    }
};
</script>
<style lang="scss">
.background-chat {
    height: 100%;
    margin: 0;
    background: #7F7FD5;
    background: -webkit-linear-gradient(to right, #91EAE4, #86A8E7, #7F7FD5);
    background: linear-gradient(to right, #91EAE4, #86A8E7, #7F7FD5);

    .chat {
        margin-top: auto;
        margin-bottom: auto;
    }

    .card {
        height: 500px;
        border-radius: 15px !important;
        background-color: rgba(0, 0, 0, 0.4) !important;
    }

    .contacts_body {
        padding: 0.75rem 0 !important;
        overflow-y: auto;
        white-space: nowrap;
    }

    .msg_card_body {
        overflow-y: auto;
    }

    .card-header {
        border-radius: 15px 15px 0 0 !important;
        border-bottom: 0 !important;
    }

    .card-footer {
        border-radius: 0 0 15px 15px !important;
        border-top: 0 !important;
    }

    .container {
        align-content: center;
    }

    .search {
        border-radius: 15px 0 0 15px !important;
        background-color: rgba(0, 0, 0, 0.3) !important;
        border: 0 !important;
        color: white !important;

        &:focus {
            box-shadow: none !important;
            outline: 0px !important;
        }
    }

    .type_msg {
        background-color: rgba(0, 0, 0, 0.3) !important;
        border: 0 !important;
        color: white !important;
        height: 60px !important;
        overflow-y: auto;

        &:focus {
            box-shadow: none !important;
            outline: 0px !important;
        }
    }

    .attach_btn {
        border-radius: 15px 0 0 15px !important;
        background-color: rgba(0, 0, 0, 0.3) !important;
        border: 0 !important;
        color: white !important;
        cursor: pointer;
    }

    .send_btn {
        border-radius: 0 15px 15px 0 !important;
        background-color: rgba(0, 0, 0, 0.3) !important;
        border: 0 !important;
        color: white !important;
        cursor: pointer;
    }

    .search_btn {
        border-radius: 0 15px 15px 0 !important;
        background-color: rgba(0, 0, 0, 0.3) !important;
        border: 0 !important;
        color: white !important;
        cursor: pointer;
    }

    .contacts {
        list-style: none;
        padding: 0;

        &__item:hover {
            cursor: pointer;
        }
    }

    .contacts li {
        width: 100% !important;
        padding: 5px 10px;
        margin-bottom: 15px !important;
    }

    .active {
        background-color: rgba(0, 0, 0, 0.3);
    }

    .user_img {
        height: 70px;
        width: 70px;
        border: 1.5px solid #f5f6fa;

    }

    .user_img_msg {
        height: 40px;
        width: 40px;
        border: 1.5px solid #f5f6fa;

    }

    .img_cont {
        position: relative;
        height: 70px;
        width: 70px;
    }

    .img_cont_msg {
        height: 40px;
        width: 40px;
    }

    .online_icon {
        position: absolute;
        height: 15px;
        width: 15px;
        background-color: #4cd137;
        border-radius: 50%;
        bottom: 0.2em;
        right: 0.4em;
        border: 1.5px solid white;
    }

    .offline {
        background-color: #c23616 !important;
    }

    .user_info {
        margin-top: auto;
        margin-bottom: auto;
        margin-left: 15px;
        overflow: hidden;
        text-overflow: ellipsis;
        color: white;

        &--group {
            font-size: 16px !important;
        }
    }

    .user_info span {
        font-size: 18px;
        color: white;
    }

    .user_info p {
        font-size: 10px;
        color: rgba(255, 255, 255, 0.6);
    }

    .video_cam {
        margin-left: 50px;
        margin-top: 5px;
    }

    .video_cam span {
        color: white;
        font-size: 20px;
        cursor: pointer;
        margin-right: 20px;
    }

    .msg_cotainer {
        margin-top: auto;
        margin-bottom: auto;
        margin-left: 10px;
        border-radius: 25px;
        background-color: #82ccdd;
        padding: 10px;
        position: relative;
    }

    .msg_cotainer_send {
        margin-top: auto;
        margin-bottom: auto;
        margin-right: 10px;
        border-radius: 25px;
        background-color: #78e08f;
        padding: 10px;
        position: relative;
    }

    .msg_time {
        position: absolute;
        left: 0;
        bottom: -15px;
        color: rgba(255, 255, 255, 0.5);
        font-size: 10px;
    }

    .msg_time_send {
        position: absolute;
        right: 0;
        bottom: -15px;
        color: rgba(255, 255, 255, 0.5);
        font-size: 10px;
    }

    .msg_head {
        position: relative;
    }

    #action_menu_btn {
        position: absolute;
        right: 10px;
        top: 10px;
        color: white;
        cursor: pointer;
        font-size: 20px;
    }

    .action_menu {
        z-index: 1;
        position: absolute;
        padding: 15px 0;
        background-color: rgba(0, 0, 0, 0.5);
        color: white;
        border-radius: 15px;
        top: 30px;
        right: 15px;
    }

    .action_menu ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .action_menu ul li {
        width: 100%;
        padding: 10px 15px;
        margin-bottom: 5px;
    }

    .action_menu ul li i {
        padding-right: 10px;

    }

    .action_menu ul li:hover {
        cursor: pointer;
        background-color: rgba(0, 0, 0, 0.2);
    }
}


@media(max-width: 576px) {
    .contacts_card {
        margin-bottom: 15px !important;
    }
}
</style>