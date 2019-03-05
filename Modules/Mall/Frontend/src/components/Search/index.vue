<template>
    <div class="box">
        <router-link to="/home" tag="div">
            <img :src="require('@/assets/img/home/logo.png')" alt="">
        </router-link>
        <div>
            <Input v-model="value" style="width: 597px" size="default">
                <Select v-model="select" slot="prepend" style="width:127px;background: #f5f5f5" size="default">
                    <Option v-for="item in cityList" :value="item.value" :key="item.value">{{ item.label }}</Option>
                </Select>
                <div slot="append" style="width:115px;position: relative;" class="box-search" @click="onClick">
                </div>
            </Input>
        </div>
    </div>
</template>

<script>
    import getData from "@/utils/getData"
    import { mapMutations } from "vuex"

    export default {
        data() {
            return {
                select: 'Products',
                cityList: [
                    {
                        value: 'Products',
                        label: 'Products'
                    },
                    {
                        value: 'Suppliers',
                        label: 'Suppliers'
                    }
                ],
                value: ''
            }
        },
        methods: {
            ...mapMutations([ 'SET_PRODUCT_ALL', 'SET_SHOP_ALL' ]),
            onSearchProduct: getData.onSearchProduct,
            onSearchShop: getData.onSearchShop,
            onClick() {
                if(this.select == 'Products') {
                    // 搜索商品
                    this.onSearchProduct(this.value).then(async res => {
                        await this.SET_PRODUCT_ALL(res)
                        this.$router.push('/goods/list')
                    }).catch(async err => {
                        await this.SET_PRODUCT_ALL([])
                        this.$router.push('/goods/list')
                        // this.$Message.error(err.message)
                    })
                }else {
                    this.onSearchShop(this.value).then(res => {
                        this.SET_SHOP_ALL(res)
                        this.$router.push('/goods/companylist')
                    }).catch(err => {
                        this.$Message.error(err.message)
                    })
                }
            }
        },
    }
</script>

<style lang="less" scoped>
    @import url('../../assets/css/index');

    .box {
        height: 100px;
        .flex(flex-start, center, row);

        & > div:first-child {
            margin-left: 10px;
            cursor: pointer;
        }

        & > div:last-child {
            .width(597px, 54px);
            // .bg-color(light);
            margin-left: 187px;
            position: relative;
        }

        &-search::before {
            content: 'Search';
            width: 130px;
            height: 54px;
            line-height: 54px;
            position: absolute;
            top: -54px / 2;
            left: -7px;
            font-size: 16px;
            color: #333333;
            background-color: #dcdcdc;
            cursor: pointer;
        }
    }
</style>
