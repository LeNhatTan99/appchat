<template>
    <v-app>
        <router-view />
    </v-app>
</template>

<!-- <script>
import {showToast} from "@/common/helps.js"
import {TOAST_TYPE} from "@/common/constant.js"
import { mapActions, mapGetters } from 'vuex';

    export default {
        name: 'Layout',
        data() {
            return {
                TITLE_CHECK_IN_OUT: "",
                COUNT_CHECK_IN: "",
                currentTime: null,
                check: true
            }
        },
        computed: {
            ...mapGetters(['user', 'dataDateCurrent'])
        },
        created () {
            if (this.$router.name != 'Login') {
                this.getCheckInCurrent();
                this.getData();
            }
            setInterval(() => {
                if (this.$router.name != 'Login') {
                    this.getData();
                }
                this.check = true;
            }, 10000);
        },
        methods: {
            ...mapActions(['getCheckInCurrent']),
            getData() {
                this.COUNT_CHECK_IN = this.dataDateCurrent.length;
                if (this.COUNT_CHECK_IN % 2 == 0) {
                    this.TITLE_CHECK_IN_OUT = "Check In";
                } else {
                    this.TITLE_CHECK_IN_OUT = "Check Out";
                }
                this.currentTime = new Date();
                var currentHours = this.currentTime.getHours();
                var currentMinutes = this.currentTime.getMinutes();
                if (this.COUNT_CHECK_IN < 1 
                || (((this.COUNT_CHECK_IN == 1 && currentHours >= 12 && currentHours <= 13) 
                || ((this.COUNT_CHECK_IN == 2 && currentHours >= 12 && currentHours <= 13) 
                || (this.COUNT_CHECK_IN == 3 && currentHours >= 17 && currentMinutes >= 30))))) {
                    if (this.check) {
                        showToast(this, (this.user.name + " Bạn chưa " + this.TITLE_CHECK_IN_OUT), TOAST_TYPE.ERROR);
                        if (this.$route.name != 'Home') {
                            this.$router.push({ name: 'Home' });
                        }
                        this.check = false;
                    }
                }
            },
        }
    };
</script> -->


