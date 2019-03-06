<template>
    <el-aside width="305px">
        <el-menu
            :default-active="$route.path"
            id="aside"
            :router="true"
            :collapse="false"
            @open="handleOpen"
            @close="handleClose"
            background-color="#4c4c4c"
            text-color="#9b9b9b"
            active-text-color="#f0883a"
            >
            <el-menu-item index="/home">
                <img :src="require('@/assets/sy.png')" alt="" class="icon">
                <span slot="title" class="title">首页</span>
            </el-menu-item>
            <el-submenu index="2">
                <template slot="title">
                    <img :src="require('@/assets/yhgl.png')" alt="" class="icon">
                    <span slot="title" class="title">用户管理</span>
                </template>
                <el-menu-item-group>
                    <el-menu-item index="/user" class="item">用户</el-menu-item>
                    <el-menu-item index="/business" class="item">商家</el-menu-item>
                    <el-menu-item index="/admin/home" class="item">管理员</el-menu-item>
                </el-menu-item-group>
            </el-submenu>
            <el-submenu index="3">
                <template slot="title">
                    <img :src="require('@/assets/spgl.png')" alt="" class="icon">
                    <span slot="title" class="title">商品管理</span>
                </template>
                <el-menu-item-group>
                    <el-menu-item index="/allproducts" class="item">全部商品</el-menu-item>
                    <el-menu-item index="/wait" class="item">待审核商品</el-menu-item>
                </el-menu-item-group>
            </el-submenu>
            <el-submenu index="4">
                <template slot="title">
                    <img :src="require('@/assets/wzgl.png')" alt="" class="icon">
                    <span slot="title" class="title">文章管理</span>
                </template>
                <el-menu-item-group>
                    <el-menu-item index="/article" class="item">系统文章</el-menu-item>
                    <el-menu-item index="/agreement" class="item">会员协议</el-menu-item>
                </el-menu-item-group>
            </el-submenu>
            <el-submenu index="5">
                <template slot="title">
                    <img :src="require('@/assets/gggl.png')" alt="" class="icon">
                    <span slot="title" class="title">广告管理</span>
                </template>
                <el-menu-item-group>
                    <el-menu-item index="5-1" class="item">首页广告</el-menu-item>
                </el-menu-item-group>
            </el-submenu>
            <el-submenu index="6">
                <template slot="title">
                    <img :src="require('@/assets/xtgg.png')" alt="" class="icon">
                    <span slot="title" class="title">系统公告</span>
                </template>
                <el-menu-item-group>
                    <el-menu-item index="/bulletin" class="item">系统公告</el-menu-item>
                </el-menu-item-group>
            </el-submenu>
            <el-submenu index="7">
                <template slot="title">
                    <img :src="require('@/assets/yjfk.png')" alt="" class="icon">
                    <span slot="title" class="title">意见反馈</span>
                </template>
                <el-menu-item-group>
                    <el-menu-item index="/feedback" class="item">反馈信息</el-menu-item>
                </el-menu-item-group>
            </el-submenu>
        </el-menu>
    </el-aside>
</template>

<script>
    export default {
        methods: {
            handleOpen(key, keyPath) {
            },
            handleClose(key, keyPath) {
            }
        }
    }
</script>

<style lang="scss" scoped>
    #aside {
        width: 305px;
        height: 100vh;
        position: fixed;
        top: 0px;
        left: 0px;
        .icon {
            width: 21px;
            height: 21px;
            display: inline-block;
        }

        .title {
            font-size: 20px;
            margin-left: 30px;
        }

        .item {
            font-size: 20px;
            color: #f0883a;
            padding-left: 70px !important;
        }
    }
</style>
