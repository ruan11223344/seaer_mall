<template>
    <div class="details-head">
        <header class="container details-head-container">
            <v-img width="181" height="53" :imgSrc="require('@/assets/img/home/logo.png')"></v-img>
            <h1>{{ name }}</h1>
            <div class="details-head-container-collection">
                <img
                    @click="onCollection"
                    :src="bool ? require('@/assets/img/details/sc2.png') : require('@/assets/img/details/sc1.png')" class="details-head-container-collection-icon" />
                <span>Favorites Supplier</span>
            </div>
        </header>
    </div>
</template>

<script>
    import Img from '@/components/Img'
    import getData from "@/utils/getData"
    import upData from "@/utils/upData"

    export default {
        props: [ 'name', 'bool' ],
        methods: {
            onSetFavorites: upData.onSetFavorites,
            onDelFavorites: upData.onDelFavorites,
            onCollection(id) { // 收藏商品
                if(this.User_Info == '') {
                    this.$router.push('/login')
                }else {
                    if(this.bool) {
                        // 删除
                        this.onDelFavorites({ 
                            product_or_company_id_list: [ this.$route.query.company_id ],
                            type: "company"
                        })
                            .then(res => {
                                this.$emit('on-click')
                            }
                        )
                    }else {
                        // 添加
                        this.onSetFavorites({
                            product_or_company_id: this.$route.query.company_id,
                            type: "company"
                        })
                            .then(res => {
                                this.$emit('on-click')
                            }
                        )
                    }
                }
            },
        },
        components: {
            'v-img': Img
        }
    }
</script>

<style lang="less" scoped>
    @import url('../../../../assets/css/index.less');

    .details-head {
        width: 100%;
        min-width: 1220px;
        height: 100px;
        background-color: #ffffff;

        &-container {
            height: 100px;
            .flex(space-between, center);

            & > h1 {
                font-size: 22px;
                font-weight: normal;
                font-stretch: normal;
                line-height: 1;
                letter-spacing: 0px;
                color: #666666;
            }

            &-collection {
                .flex(space-around, center);
                width: 157px;
                height: 29px;
                border: solid 1px #f0883a;
                font-size: 14px;
                line-height: 1;
                color: #f0883a;
                padding: 0px 5px;

                &-icon {
                    position: relative;
                    top: -1px;
                    cursor: pointer;
                }
            }
        }
    }
</style>
