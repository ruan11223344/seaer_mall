<template>
    <nav class="goods-nav">
        <ul class="container goods-nav-item">
            <li>Home</li>
            <li>
                Products
                <Icon type="ios-arrow-down"></Icon>
            </li>
            <li>About us</li>
            <li>Coutact us</li>
        </ul>
    </nav>
</template>

<script>
    export default {
        
    }
</script>

<style lang="less" scoped>
    @import url('../../../assets/css/index');

    .goods-nav {
        width: 100%;
        min-width: 1220px;
        height: 50px;
        background-color: #666666;

        &-item {
            .flex();
            height: 50px;
            
            & > li {
                height: 50px;
                line-height: 50px;
                font-family: ArialMT;
                font-size: 16px;
                letter-spacing: 0px;
                color: #ffffff;
                margin-right: 85px;
                cursor: pointer;
            }
        }
    }
</style>