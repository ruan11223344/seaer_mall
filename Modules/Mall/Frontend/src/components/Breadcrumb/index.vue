<template>
    <div class="breadcrumb">
        <template>
            <router-link tag="div" :to="'/company/home?company_id=' + $route.query.company_id" class="breadcrumb-text breadcrumb-text-active">{{ title }}</router-link>
        </template>
        <template v-for="item in Breadcrumbs">
            <div class="breadcrumb-text" :key="item">&nbsp;>&nbsp;</div>
            <div class="breadcrumb-text" :key="item">{{ item }}</div>
        </template>
    </div>
</template>

<script>
    export default {
        props: {
            title: '',
            Breadcrumbs: {
                type: Array
            }
        }
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