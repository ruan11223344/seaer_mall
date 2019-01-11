<template>
    <div class="main-goods-content">
        <header class="main-goods-content-title">tachograph Time-limited spike tachograph Time-limited spike tac tachograph Time-limited spike tac</header>
        <div class="main-goods-content-block">
            <div>Quantity</div>
            <div>Price</div>
        </div>
        <!-- 商品价格 -->
        <dl class="main-goods-content-dl">
            <dt class="main-goods-content-dt">
                <div>5-8 Piece</div>
                <div>
                    <strong>KSh 503.22</strong>
                </div>
            </dt>
            <dt class="main-goods-content-dt">
                <div>2-4 Piece</div>
                <div>
                    <strong>KSh 500.22</strong>
                </div>
            </dt>
            <dt class="main-goods-content-dt">
                <div>>= 9</div>
                <div>
                    <strong>KSh 500.22</strong>
                </div>
            </dt>
        </dl>
        <div class="main-goods-content-block">
            <div>Attribute Name</div>
            <div>Attribute Value</div>
        </div>
        <!-- 商品参数 -->
        <div :style="{position: 'relative'}">
            <!-- 下拉判断 -->
            <ul class="main-goods-content-ul" :style="dataAttribute.lenth <= 3 ? 'height:' + dataAttribute.length * 40 + 'px' : (isBool ? 'height:' + dataAttribute.length * 40 + 'px' : 'height:' + 3 * 40 + 'px')">
                <li class="main-goods-content-list" v-for="(item, index) in dataAttribute" :key="index">
                    <div v-text="item.name"></div>
                    <div v-text="item.value"></div>
                </li>
            </ul>
            <div class="main-goods-content-ul-btn" @click="onSubmit" v-if="!(dataAttribute.length <= 3)">
                <Icon :type="isBool ? 'md-arrow-dropup' : 'md-arrow-dropdown'" size="24" color="#dddddd"/>
            </div>
        </div>

        <div class="main-goods-content-btn" @click="onSend">Send Squirly</div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                dataAttribute: [
                    {
                        name: 'Color Temperature2321321321321321321313',
                        value: 'Color Temperature'
                    },
                    {
                        name: 'Color Temperature2321321321321321321313',
                        value: 'Color Temperature'
                    },
                    {
                        name: 'Color Temperature2321321321321321321313',
                        value: 'Color Temperature'
                    },
                    {
                        name: 'Color Temperature2321321321321321321313',
                        value: 'Color Temperature'
                    },
                    {
                        name: 'Color Temperature2321321321321321321313',
                        value: 'Color Temperature'
                    },
                    {
                        name: 'Color Temperature2321321321321321321313',
                        value: 'Color Temperature'
                    }
                ],
                isBool: false
            }
        },
        methods: {
            onSubmit() {
                this.isBool = !this.isBool
            },
            onSend() { // Send
                this.$Message.success('去购物车?')
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
        }

        &-block {
            .width(566px, 40px);
            .flex(flex-start, center);
            .bg-color(light);

            & > div {
                .color(blackLight);
                width: 163px;
                font-size: 14px;
                letter-spacing: 0px;
            }

            & > div:first-child {
                margin-left: 17px;
                margin-right: 20px;
            }
        }

        &-dl {
            width: 100%;
            padding: 5px 0px;
            padding-left: 17px;
        }

        &-dt {
            .flex();	
            .color(blackLight);
            line-height: 37px;
            letter-spacing: 0px;

            & > div:first-child {
                width: 70px;
                font-size: 14px;
                margin-right: 112px;
            }

            & > div:last-child {
                .textHidden();
                .color(redDark);
                width: 340px;
                letter-spacing: 0;
                font-weight: bold;
                
                & > strong {
                    .color(redDark);
                    font-size: 22px;
                    text-shadow: 0 1px 0 #6C0900;
                }
            }
        }

        &-ul {
            width: 100%;
            overflow: hidden;
            transition: all 1s;
            &-btn {
                .flex(center, center);
                .width(47px, 20px);
                .bg-color(white);
                border: solid 1px #dddddd;
                border-top: none;
                position: absolute;
                left: 30px;
                bottom: -19px;
                cursor: pointer;
            }
        }

        &-list {
            .flex();
            .color(blackLight);
            height: 40px;
            padding-left: 17px;
            line-height: 37px;
            letter-spacing: 0px;
            border-bottom: 1px solid #eeeeee;

            & > div:first-child {
                .textHidden();
                width: 162px;
                font-size: 14px;
                margin-right: 20px;
            }
        }

        &-btn {
            .lineHeight(50px);
            .color(white);
            .bg-color(orange2);
            width: 368px;
            margin-top: 34px;
            font-size: 20px;
            letter-spacing: 0px;
            text-align: center;
            cursor: pointer;
        }
    }
</style>
