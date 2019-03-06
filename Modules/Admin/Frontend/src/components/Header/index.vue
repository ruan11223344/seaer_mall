<template>
    <el-header height="80px" id="header">
        <section>
            <el-breadcrumb separator-class="el-icon-arrow-right">
                <template v-for="(item, index) in meta">
                    <el-breadcrumb-item :key="index">{{ item }}</el-breadcrumb-item>
                </template>
            </el-breadcrumb>
        </section>

        <section class="right">
            <el-badge :value="100" :max="1">
                <!-- <img :src="require('@/assets/xiaox.png')" alt=""> -->
                <div class="right-email"></div>
            </el-badge>
            <div class="right-avatar">

                <template>
                    <el-popover
                        placement="top-start"
                        width="200"
                        trigger="hover"
                        >
                            <img slot="reference" :src="require('@/assets/mrtx.png')" alt="">

                            <section>
                                <div class="admin">
                                    <span>admin</span>
                                    <span>（超级管理员）</span>
                                </div>
                                <div class="out">
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
                meta: []
            }
        },
        mounted() {
            this.meta = this.$route.meta
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
            @include mixin-flex(space-between, center);

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
