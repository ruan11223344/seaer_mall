<template>
    <el-aside width="305px">
        <el-menu
            default-active="1"
            id="aside"
            :collapse="false"
            @open="handleOpen"
            @close="handleClose"
            background-color="#4c4c4c"
            text-color="#9b9b9b"
            active-text-color="#f0883a"
            >
            <el-menu-item index="1">
                <i class="el-icon-menu"></i>
                <span slot="title">首页</span>
            </el-menu-item>
            <el-submenu index="2">
                <template slot="title">
                    <i class="el-icon-location"></i>
                    <span>用户管理</span>
                </template>
                <el-menu-item-group>
                    <el-menu-item index="2-1">用户</el-menu-item>
                    <el-menu-item index="2-2">管理员</el-menu-item>
                    <el-menu-item index="2-3">商家</el-menu-item>
                </el-menu-item-group>
            </el-submenu>
            <el-submenu index="3">
                <template slot="title">
                    <i class="el-icon-location"></i>
                    <span>商品管理</span>
                </template>
                <el-menu-item-group>
                    <el-menu-item index="3-1">全部商品</el-menu-item>
                    <el-menu-item index="3-2">待审核商品</el-menu-item>
                </el-menu-item-group>
            </el-submenu>
            <el-submenu index="4">
                <template slot="title">
                    <i class="el-icon-location"></i>
                    <span>文章管理</span>
                </template>
                <el-menu-item-group>
                    <el-menu-item index="4-1">系统文章</el-menu-item>
                    <el-menu-item index="4-2">会员协议</el-menu-item>
                </el-menu-item-group>
            </el-submenu>
            <el-submenu index="5">
                <template slot="title">
                    <i class="el-icon-location"></i>
                    <span>广告管理</span>
                </template>
                <el-menu-item-group>
                    <el-menu-item index="5-1">首页广告</el-menu-item>
                </el-menu-item-group>
            </el-submenu>
            <el-submenu index="6">
                <template slot="title">
                    <i class="el-icon-location"></i>
                    <span>系统公告</span>
                </template>
                <el-menu-item-group>
                    <el-menu-item index="6-1">系统公告</el-menu-item>
                </el-menu-item-group>
            </el-submenu>
            <el-submenu index="7">
                <template slot="title">
                    <i class="el-icon-location"></i>
                    <span>意见反馈</span>
                </template>
                <el-menu-item-group>
                    <el-menu-item index="7-1">反馈信息</el-menu-item>
                </el-menu-item-group>
            </el-submenu>
        </el-menu>
    </el-aside>
</template>

<script>
    export default {
        
        methods: {
            handleOpen(key, keyPath) {
                console.log(key, keyPath)
            },
            handleClose(key, keyPath) {
                console.log(key, keyPath)
            }
        }
    }
</script>

<style lang="scss" scoped>
    #aside {
        height: 100vh;
    }
</style>
