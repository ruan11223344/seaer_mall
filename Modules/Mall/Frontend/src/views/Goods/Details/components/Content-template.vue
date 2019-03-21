<template>
    <div class="main-goods-content">
        <header class="main-goods-content-title">{{ dataFrom.product_info.product_name }}</header>
        <dl class="main-goods-content-dl">
            <dd class="main-goods-content-dl-dd" v-for="(item, index) in dataFrom.product_info.price_array" :key="index">
                <div>
                    <Tooltip :content="item.moq">
                        {{ item.moq }}
                    </Tooltip>
                </div>
                <div>
                    <Tooltip :content="'KSh ' + item.price">
                        KSh {{ item.price }}
                    </Tooltip>
                </div>
            </dd>
        </dl>
        <ul class="main-goods-content-item">
            <!-- <li class="main-goods-content-item-list">
                <div>Color:</div>
                <div>
                    <div class="main-goods-content-item-list-img" :style="active==index ? 'border: 1px solid #d72b2b' : 'border: 1px solid #dddddd'" v-for="(item, index) in dataFrom.product_info.product_images_url" :key="index" @click="onClickImg(index)">
                        <img :src="item" alt="">
                    </div>
                </div>
            </li> -->
            <li class="main-goods-content-item-list" v-for="(item, index) in attr" :key="index">
                <div>{{ item.name }}</div>
                <div>
                    <span v-for="(v, i) in item.value" :key="i" style="marginRight: 10px;">{{ v }}</span>
                </div>
            </li>
            <!-- <li class="main-goods-content-item-list">
                <div>Model Number:</div>
                <div>{{ dataFrom.product_info.product_sku_no }}</div>
            </li> -->
            <!-- <li class="main-goods-content-item-list">
                <div>Specification:</div>
                <div>Bulb E12/E14</div>
            </li> -->
        </ul>
        <router-link
            tag="button"
            type="button"
            class="main-goods-content-btn"
            :to="'/goods/consulting?af_id=' + id + '&url=' + url + '&name=' + dataFrom.product_info.product_name + '&contactCompany=false'">
                Send Inquiry
        </router-link>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                
            }
        },
        computed: {
            attr() {
                const attr = this.dataFrom.product_attr_array
                const keys = Object.keys(attr)
                const arr = []
                keys.forEach((v, i) => {
                    arr.push({ name: v, value: attr[v] })
                })
                return arr
            }
        },
        props: [ 'dataFrom', 'active', 'id', 'url'],
        methods: {
            onClickImg(index) {
                this.$emit('on-click', index)
            }
        },
        mounted() {

        }
    }
</script>

<style lang="less" scoped>
    @import url('../../../../assets/css/index.less');

    .main-goods-content {
        &-title {
            .color(blackDark);
            width: 566px;
            font-size: 18px;
            line-height: 23px;
            letter-spacing: 0px;
            position: relative;
            top: -2px;
            margin-bottom: 11px;
            font-weight: bold;
            overflow: hidden;
            // text-align: center;
            .textHiddens(2);
        }

        &-dl {
            .flex(flex-start, center);
            .width(566px, 84px);
            background-color: #f5f5f8;
            padding: 10px 20px;

            &-dd {
                .flex(space-around, center, column);
                width: 125px;
                margin-right: 10px;
                height: 100%;

                & > div:first-of-type {
                    width: 125px;
                    font-size: 14px;
                    line-height: 1;
                    color: #666666;
                    .textHidden();
                }

                & > div:last-of-type {
                    width: 125px;
                    font-size: 16px;
                    line-height: 1;
                    color: #cd2525;
                    .textHidden();
                }
            }

            &-dd:last-of-type {
                & > div:first-of-type {
                    margin-right: 0px;
                }
            }
        }

        &-item {
            .flex(space-around, flex-start, column);
            width: 566px;
            height: auto;
            background-color: #f5f5f8;
            margin-top: 10px;
            padding: 10px 20px;

            &-list {
                .flex();

                &-img {
                    width: 30px;
                    height: 30px;
                    border: solid 1px #dddddd;
                    display: inline-block;
                    margin-right: 10px;
                    cursor: pointer;

                    & > img {
                        width: 100%;
                        height: 100%;
                        display: block;
                    }
                }

                & > div:first-of-type {
                    width: 170px;
                }
                & > div:last-of-type {
                    width: 566px - 40px - 170px;
                }
                & > div:first-of-type, & > div:last-of-type {
                    .textHidden();
                    font-size: 14px;
                    line-height: 30px;
                    color: #666666;
                }
            }
        }

        &-btn {
            border: none;
            width: 179px;
            height: 46px;
            background-color: #ef873a;
            font-size: 20px;
            line-height: 1;
            color: #ffffff;
            margin: 0px auto;
            margin-top: 81px;
            cursor: pointer;
            display: block;
        }
    }
</style>
