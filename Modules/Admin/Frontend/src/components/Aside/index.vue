<template>
    <el-aside width="305px" v-loading="Jurisdiction == null">
        <el-menu
            v-if="Jurisdiction != null"
            :default-active="$route.path"
            id="aside"
            :router="true"
            :collapse="false"
            @open="handleOpen"
            @close="handleClose"
            background-color="#4c4c4c"
            text-color="#9b9b9b"
            active-text-color="#f0883a"
            :unique-opened="true"
            >
            <el-menu-item index="/home" v-if="Jurisdiction.includes('首页')">
                <img :src="require('@/assets/sy.png')" alt="" class="icon">
                <span slot="title" class="title">首页</span>
            </el-menu-item>
            <el-submenu index="2" v-if="Jurisdiction.includes('用户管理')">
                <template slot="title">
                    <img :src="require('@/assets/yhgl.png')" alt="" class="icon">
                    <span slot="title" class="title">用户管理</span>
                </template>
                <el-menu-item-group>
                    <el-menu-item index="/user" class="item" v-if="Jurisdiction.includes('用户')">用户</el-menu-item>
                    <el-menu-item index="/business" class="item" v-if="Jurisdiction.includes('商家')">商家</el-menu-item>
                    <el-menu-item index="/admin/home" class="item" v-if="Jurisdiction.includes('管理员')">管理员</el-menu-item>
                </el-menu-item-group>
            </el-submenu>
            <el-submenu index="3" v-if="Jurisdiction.includes('商品管理')">
                <template slot="title">
                    <img :src="require('@/assets/spgl.png')" alt="" class="icon">
                    <span slot="title" class="title">商品管理</span>
                </template>
                <el-menu-item-group>
                    <el-menu-item index="/products/allproducts" class="item" v-if="Jurisdiction.includes('全部商品')">全部商品</el-menu-item>
                    <el-menu-item index="/products/wait" class="item" v-if="Jurisdiction.includes('待审核商品')">待审核商品</el-menu-item>
                </el-menu-item-group>
            </el-submenu>
            <el-submenu index="4" v-if="Jurisdiction.includes('文章管理')">
                <template slot="title">
                    <img :src="require('@/assets/wzgl.png')" alt="" class="icon">
                    <span slot="title" class="title">文章管理</span>
                </template>
                <el-menu-item-group>
                    <el-menu-item index="/article/systemarticle" class="item" v-if="Jurisdiction.includes('系统文章')">系统文章</el-menu-item>
                    <el-menu-item index="/article/agreement" class="item" v-if="Jurisdiction.includes('会员协议')">会员协议</el-menu-item>
                </el-menu-item-group>
            </el-submenu>
            <el-submenu index="5" v-if="Jurisdiction.includes('广告管理')">
                <template slot="title">
                    <img :src="require('@/assets/gggl.png')" alt="" class="icon">
                    <span slot="title" class="title">广告管理</span>
                </template>
                <el-menu-item-group>
                    <el-menu-item index="/advertisement/home" class="item" v-if="Jurisdiction.includes('首页广告')">首页广告</el-menu-item>
                </el-menu-item-group>
            </el-submenu>
            <el-submenu index="6" v-if="Jurisdiction.includes('系统公告')">
                <template slot="title">
                    <img :src="require('@/assets/xtgg.png')" alt="" class="icon">
                    <span slot="title" class="title">系统公告</span>
                </template>
                <el-menu-item-group>
                    <el-menu-item index="/bulletin" class="item">系统公告</el-menu-item>
                </el-menu-item-group>
            </el-submenu>
            <el-submenu index="7" v-if="Jurisdiction.includes('意见反馈')">
                <template slot="title">
                    <img :src="require('@/assets/yjfk.png')" alt="" class="icon">
                    <span slot="title" class="title">意见反馈</span>
                </template>
                <el-menu-item-group v-if="Jurisdiction.includes('反馈信息')">
                    <el-menu-item index="/opinion/feedback" class="item">反馈信息</el-menu-item>
                </el-menu-item-group>
            </el-submenu>
        </el-menu>
    </el-aside>
</template>

<script>
    export default {
        data() {
            return {
                Jurisdiction: null
            }
        },
        methods: {
            handleOpen(key, keyPath) {
            },
            handleClose(key, keyPath) {
            },
            GetRouter() {
                this.$GetRequest.getAccessRoute()
                    .then(res => {
                        this.filtersData(res)
                    })
            },
            filtersData(data) {
                const arr = []
                for(let item in data) {
                    arr.push(item)
                    if(Object.prototype.toString.call(data[item]) == '[object Object]') {
                        for(let list in data[item]) {
                            arr.push(list)
                        }
                    }
                }
                this.Jurisdiction = arr
            }
        },
        created() {
            this.GetRouter()
        },
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
