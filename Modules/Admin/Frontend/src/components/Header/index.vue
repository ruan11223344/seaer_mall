<template>
    <el-header height="80px" id="header">
        <section>
            <el-breadcrumb separator-class="el-icon-arrow-right">
                <template v-for="(item, index) in meta">
                    <el-breadcrumb-item :key="index">
                        <span @click="onClick(item)" :class="arr.includes(item) ? 'hover' : ''">{{ item }}</span>
                    </el-breadcrumb-item>
                </template>
            </el-breadcrumb>
        </section>

        <section class="right">
            <!-- <el-badge :value="100" :max="1">
                <div class="right-email" @click="$router.push('/news')"></div>
            </el-badge> -->
            <div class="right-avatar">
                <template>
                    <el-popover
                        placement="top-start"
                        width="200"
                        trigger="hover"
                        >
                            <img slot="reference" style="cursor: pointer;" :src="require('@/assets/mrtx.png')" alt="">

                            <section v-if="user">
                                <div class="admin">
                                    <span>{{ user.name }}</span>
                                    <span>{{ '（' + user.role_name + '）' }}</span>
                                </div>
                                <div class="out" @click="onOut">
                                    <div>退出登录</div>
                                    <i class="el-icon-arrow-right"></i>
                                </div>
                            </section>
                    </el-popover>
                </template>
            </div>
        </section>
    </el-header>
</template>

<script>
    export default {
        data() {
            return {
                meta: [],
                arr: [ '管理员', '全部商品', '待审核商品', '系统文章', '首页广告', '反馈信息' ],
                user: null
            }
        },
        methods: {
            onOut() {
                this.$PutRequest.putLogout()
                    .then(res => {
                        this.$Auth.removeCookies()
                        this.$Auth.removeRefreshKey()
                        this.$Auth.rmUserCookies()
                        this.$router.push('/login')
                    })
                    .catch(err => {
                        this.$message.error(err.message)
                    })
            },
            onClick(key) {
                switch (key) {
                    case '管理员':
                        this.$router.push('/admin/home')
                        break
                    case '全部商品':
                        this.$router.push('/products/allproducts')
                        break
                    case '待审核商品':
                        this.$router.push('/products/wait')
                        break
                    case '系统文章':
                        console.log()
                        if(this.$route.path != '/article/systemarticle') {
                            this.$router.go(-1)
                        }
                        break
                    case '首页广告':
                        this.$router.push('/advertisement/home')
                        break
                    case '反馈信息':
                        this.$router.push('/opinion/feedback')
                        break
                    default:
                        break
                }
            },
            onUserInfo() {
                this.$GetRequest.getAccountInfo()
                    .then(res => {
                        this.$Auth.setUserCookies(res)
                        this.user = this.$Auth.getUserCookies()
                    })
            }
        },
        mounted() {
            this.meta = this.$route.meta
            const v = this.$Auth.getUserCookies()
            if(!v) {
                this.onUserInfo()
            }else {
                this.user = this.$Auth.getUserCookies()
            }

        },
        watch: {
            '$route': function ({ meta }) {
                this.meta = meta
            }
        },
    }
</script>

<style lang="scss" scoped>
    #header {
        @include mixin-bg-color(lead);
        @include mixin-flex(space-between, center);

        .right {
            width: 170px;
            height: 80px;
            @include mixin-flex(flex-end, center);

            &-email {
                width: 29px;
                height: 21px;
                background-image: url('../../assets/xiaox.png');
                cursor: pointer;
            }

            &-email:hover {
                background-image: url('../../assets/xzxx.png');
            }

            &-avatar {
                width: 53px;
                height: 53px;
                border-radius: 50%;
                @include mixin-bg-color(white);

                
            }
        }

        .hover {
            cursor: pointer;
        }

        .hover:hover {
            @include mixin-color(yellow);
        }
    }

    .admin {
        padding: 17px 0px;
        cursor: pointer;
        border-bottom: 1px solid #eeeeee;

        & > span:first-of-type {
            font-size: 16px;
            @include mixin-color(yellow);
        }

        & > span:last-of-type {
            font-size: 12px;
            @include mixin-color(dark);
        }
    }

    .out {
        padding: 17px 0px;
        font-size: 14px;
        cursor: pointer;
        @include mixin-color(grey);
        @include mixin-flex(space-between, center);
    }
</style>
