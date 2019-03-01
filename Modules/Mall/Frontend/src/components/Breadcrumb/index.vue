<template>
    <div class="breadcrumb">
        <template>
            <router-link tag="div" :to="url" class="breadcrumb-text breadcrumb-text-active">{{ title }}</router-link>
        </template>
        <template v-for="item in Breadcrumbs">
            <div class="breadcrumb-text" :key="item">&nbsp;>&nbsp;{{ item }}</div>
        </template>
    </div>
</template>

<script>
    export default {
        // props: {
        //     url: {
        //         type: String
        //     },
        //     title: '',
        //     Breadcrumbs: {
        //         type: Array
        //     }
        // },
        props: [ 'url', 'title', 'Breadcrumbs' ]
    }
</script>

<style lang="less" scoped>
    @import url('../../assets/css/index.less');

    .breadcrumb {
        .flex();

        & > .breadcrumb-text {
            font-size: 14px;
            color: #666666;
            cursor: pointer;
        }
        
        & > .breadcrumb-text-active:hover {
            color: #ef873a;
        }
    }
</style>