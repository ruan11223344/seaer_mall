<template>
    <div class="main-goods-content">
        <header class="main-goods-content-title">tachograph Time-limited spike tachograph Time-limited spike tac tachograph Time-limited spike tac</header>
        <dl class="main-goods-content-dl">
            <dd class="main-goods-content-dl-dd">
                <div>MOQ:5-8 Piece</div>
                <div>KSh {{ 500.22 }}</div>
            </dd>
            <dd class="main-goods-content-dl-dd">
                <div>MOQ:2-4 Piece</div>
                <div>KSh {{ 500.22 }}</div>
            </dd>
            <dd class="main-goods-content-dl-dd">
                <div>MOQ:2-4 Piece</div>
                <div>KSh {{ 500.22 }}</div>
            </dd>
            <dd class="main-goods-content-dl-dd">
                <div>MOQ:2-4 Piece</div>
                <div>KSh {{ 500.22 }}</div>
            </dd>
        </dl>
        <ul class="main-goods-content-item">
            <li class="main-goods-content-item-list">
                <div>Color:</div>
                <div>

                </div>
            </li>
            <li class="main-goods-content-item-list">
                <div>Model Number:</div>
                <div>ISO9001</div>
            </li>
            <li class="main-goods-content-item-list">
                <div>Specification:</div>
                <div>Bulb E12/E14</div>
            </li>
        </ul>

        <button type="button" class="main-goods-content-btn">Send Squirly</button>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                
            }
        },
        methods: {
            
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

        &-dl {
            .flex(space-between, center);
            .width(566px, 84px);
            background-color: #f5f5f8;
            padding: 10px 20px;

            &-dd {
                .flex(space-around, center, column);
                height: 100%;

                & > div:first-of-type {
                    font-size: 14px;
                    line-height: 1;
                    color: #666666;
                }

                & > div:last-of-type {
                    font-size: 16px;
                    line-height: 1;
                    color: #cd2525;
                }
            }
        }

        &-item {
            .flex(space-around, flex-start, column);
            width: 566px;
            height: 142px;
            background-color: #f5f5f8;
            margin-top: 10px;
            padding: 0px 20px;

            &-list {
                .flex();

                & > div:first-of-type {
                    width: 170px;
                }
                & > div:last-of-type {
                    width: 566px - 40px - 170px;
                }
                & > div:first-of-type, & > div:last-of-type {
                    .textHidden();
                    font-size: 14px;
                    line-height: 1;
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
