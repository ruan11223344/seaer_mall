<template>
    <main class="company-home-main">
        <div class="container company-home-main-container">
            <div>
                <v-aside></v-aside>
            </div>
            <div>
                <v-content></v-content>
            </div>
        </div>
    </main>
</template>

<script>
    import Aside from './Aside.vue'
    import Content from './Content.vue'


    export default {
        
        components: {
            "v-aside": Aside,
            "v-content": Content,
        }
    }
</script>

<style lang="less" scoped>
    @import url("../../../assets/css/index");

    .company-home-main {
        .layout(auto);
        padding: 24px 0px;
        background-color: #f5f5f5;

        &-container {
            width: 1220px;
            // .flex(space-between);
            
            & > div {
                display: inline-block;
                vertical-align: top;
            }

            & > div:first-child {
                margin-right: 1220px - 972px - 230px;
            }
        }
    }
</style>
