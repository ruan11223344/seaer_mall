<template>
    <div class="container">
        <nav class="nav">
            <router-link class="nav-list" v-if="!user" tag="div" to="/login">Sign In</router-link>
            

            <div class="nav-list Customer" v-else>
                <!-- 下拉 -->
                <div>
                    <span>{{ user.user.name }}</span>
                    <Icon type="ios-arrow-down" style="marginLeft:2px;"/>
                </div>
                <ul>
                    <router-link tag="li" to="/inquiryList/personalpenter">User center</router-link>
                    <li @click="onOut">Logout</li>
                </ul>
            </div>

            <router-link class="nav-list" tag="div" to="/registered/one">Join Free</router-link>
            <div class="nav-list Customer">
                <!-- 下拉 -->
                <div>
                    <span>Customer Service</span>
                    <Icon type="ios-arrow-down" style="marginLeft:2px;"/>
                </div>
                <ul>
                    <li>Help Center</li>
                    <li>Service</li>
                </ul>
            </div>
            <router-link class="nav-list" tag="div" to="/inquiryList/inbox">Inquiry</router-link>
        </nav>
    </div>
</template>

<script>
    import getData from "@/utils/getData"
    import upData from "@/utils/upData"
    import Cookies from "@/utils/auth"

    export default {
        data() {
            return {
                user: null
            }
        },
        methods: {
            onGetUser: getData.onGetUser,
            UpOut: upData.UpOut,
            getSessionStorage: Cookies.getSessionStorage,
            setSessionStorage: Cookies.setSessionStorage,
            // 删除用户
            removeCookies: Cookies.removeCookies,
            removeRefreshKey: Cookies.removeRefreshKey,
            removeSessionStorage: Cookies.removeSessionStorage,
            getCookies: Cookies.getCookies,
            // 登出
            onOut() {
                this.UpOut()
                    .then(res => {
                        this.removeCookies()
                        this.removeRefreshKey()
                        this.removeSessionStorage()
                        this.$router.push('/login')
                    })
            }
        },
        computed: {
        },
        created() {
            this.user = this.getSessionStorage()
        },
        mounted() {
            if(!this.getSessionStorage() && this.getCookies()) {
                this.onGetUser().then(res =>{
                    this.removeSessionStorage()
                    this.setSessionStorage(res)
                    this.user = this.getSessionStorage()
                })
            }
        },
    }
</script>

<style lang="less" scoped>
    @import url("../../assets/css/index.less");
    
    .nav {
        .flex(flex-end, center);
        .lineHeight(40px);
        .color(white);
        
        &-list {
            height: 40px;
            margin-left: 25px;
            cursor: pointer;
        }

        & > .Customer {
            position: relative;

            & > ul:last-child {
                .bg-color(white);
                .width(143px, 0px);
                position: absolute;
                top: 35px;
                z-index: 10000;
                overflow: hidden;
                transition: all .2s;
                
                & > li {
                    .color(blackLight);
                    height: 30px;
                    padding-left: 15px;
                    font-size: 14px;
                    line-height: 30px;
                }

                & > li:hover {
                    .color(white);
                    .bg-color(Orange);
                }
            }

            & > div:first-child:hover + ul:last-child {
                height: 80px;
                border: solid 1px #dddddd;
                padding: 10px 0px;
            }

            ul:last-child:hover {
                height: 80px;
                border: solid 1px #dddddd;
                padding: 10px 0px;
            }
        }
    }
</style>
