<template>
    <div id="list">
        <section class="title">
            <div class="title-left">
                <span>用户列表</span>
                <span>共{{ total.total }}条</span>
            </div>

            <div class="title-right">
                <el-input
                    placeholder="请输入商品名称或者商品ID搜索相关数据"
                    v-model="search"
                    class="title-right-input"
                    >
                    <el-button  type="primary" slot="append" icon="el-icon-search" class="title-right-search" @click="onChangeSearch"></el-button>
                </el-input>
            </div>
        </section>

        <section class="box" v-loading="productData == null">
            <div class="box-block" v-for="({ product_id, product_name, product_price, company_name, product_create_time, product_sku, product_moq, product_main_pic_url }, index) in productData" :key="index">
                <section class="box-block-title">
                    Product ID:{{ product_id }}
                </section>
                <section class="content">
                    <div class="figure">
                        <img :src="product_main_pic_url" alt="">
                        <div>
                            <p class="figure-p">{{ product_name }}</p>
                            <p class="figure-sku">SKU:{{ product_sku }}</p>
                        </div>
                    </div>
                    <div class="price">
                        <p class="ksh">{{ product_price }}</p>
                        <p class="moq">{{ product_moq }}</p>
                    </div>
                    <div class="shop">{{ company_name }}</div>
                    <div class="time">{{ dayjs(product_create_time).format('MMM DD,YYYY') }}</div>
                    <button :class="allProductId.includes(product_id) ? 'btn btn-active' : 'btn'" @click="allProductId.includes(product_id) ? '' : onSub(product_id)">
                        Select
                    </button>
                </section>
            </div>
        </section>

        <section class="page">
            <el-pagination
                background
                layout="prev, pager, next"
                :total="total.total"
                :page-size="total.size"
                @current-change="onCurrentChange"
                >
            </el-pagination>
        </section>
    </div>
</template>

<script>
    import dayjs from 'dayjs'

    export default {
        data() {
            return {
                time: null,
                productData: null,
                total: {
                    total: 0,
                    size: 5,
                    num: 1
                },
                search: '',
                allProductId: null
            }
        },
        methods: {
            dayjs: dayjs,
            // 分页
            onCurrentChange(num) {
                this.$set(this.total, 'num', num)
                this.onGetData()
            },
            // 搜索
            onChangeSearch(val) {
                clearTimeout(this.time)

                this.time = setTimeout(() => {
                    this.productData = null
                    if(this.search != '') {
                        this.$GetRequest.getSearchProduct(this.total.size, this.total.num, this.search)
                        .then(res => {
                            this.total.total = res.total_size
                            this.productData = res.data
                        })
                        .catch(err => {
                            this.productData = []
                            this.$message.error(err.message)
                        })
                    }else {
                        this.onGetData()
                    }
                }, 500)
            },
            onGetData() {
                this.productData = null
                this.$GetRequest.getSaleProduct(this.total.size, this.total.num)
                    .then(res => {
                        this.total.total = res.total_size
                        this.productData = res.data
                    })
                    .catch(err => {
                        this.productData = []
                        this.$message.error(err.message)
                    })
            },
            onSub(product_id) {
                this.$PutRequest.putEditProductRecommend({
                    index_product_recommend_id: this.$route.query.index_product_recommend_id,
                    product_id
                })
                    .then(res => {
                        this.$router.go(-1)
                    })
                    .catch(err => {
                        this.$message.error(err.message)
                    })
            }
        },
        created() {
            this.allProductId = JSON.parse(this.$route.query.allProductId)
            this.onGetData()
        },
        watch: {
            search(newVal) {
                this.onChangeSearch(newVal)
            }
        },
    }
</script>

<style lang="scss" scoped>

    #list {
        width: 100%;

        .title {
            height: 40px;
            margin-bottom: 20px;
            @include mixin-flex(space-between, center);

            &-left {
                font-size: 16px;
                @include mixin-color(grey);

                & > span:last-of-type {
                    font-size: 12px;
                    margin-left: 11px;
                    @include mixin-color(dark);
                }
            }

            &-right {

                &-input {
                    width: 331px + 71px;
                }
            }
        }
        
        .box {
            min-height: 725px;

            &-block {
                &-title {
                    width: 100%;
                    height: 47px;
                    font-size: 14px;
                    line-height: 47px;
                    padding: 0px 17px;
                    box-sizing: border-box;
                    @include mixin-color(grey);
                    @include mixin-bg-color(lead);
                }

                .content {
                    width: 100%;
                    height: 98px;
                    @include mixin-flex(space-between, center);

                    .figure {
                        @include mixin-flex(space-between, center);

                        & > img {
                            width: 74px;
                            height: 74px;
                            margin-left: 18px;
                            border: solid 1px #eeeeee;
                            display: block;
                            @include mixin-bg-color(white);
                        }

                        & > div {
                            margin-left: 18px;
                            @include mixin-flex(space-between, flex-start, column);
                        }
                        
                        &-p {
                            width: 335px;
                            font-size: 14px;
                            line-height: 1.5em;
                            @include mixin-color(grey);
                            @include mixin-textHiddens(2);
                        }

                        &-sku {
                            font-size: 12px;
                            line-height: 1;
                            margin-top: 10px;
                            @include mixin-color(dark);
                        }
                    }

                    .price {
                        width: 150px;
                        @include mixin-flex(space-between, center, column);

                        .ksh {
                            font-size: 14px;
                            line-height: 1;
                            @include mixin-color(red);
                        }

                        .moq {
                            margin-top: 12px;
                            font-size: 12px;
                            line-height: 1;
                            @include mixin-color(dark);
                        }
                    }

                    .shop {
                        width: 200px;
                        font-size: 14px;
                        line-height: 1.5;
                        @include mixin-textHidden;
                        @include mixin-color(grey);
                    }

                    .time {
                        width: 120px;
                        font-size: 14px;
                        line-height: 1;
                        @include mixin-textHidden;
                        @include mixin-color(grey);
                    }

                    .btn {
                        width: 70px;
                        height: 26px;
                        font-size: 16px;
                        line-height: 26px;
                        text-align: center;
                        border: none;
                        @include mixin-color(white);
                        @include mixin-bg-color(yellow);
                        cursor: pointer;
                    }

                    .btn-active {
                        background-color: #dddddd;
                    }
                }
            }
        }

        .page {
            margin-top: 16px;
            @include mixin-flex(center, center);
        }
    }
</style>



