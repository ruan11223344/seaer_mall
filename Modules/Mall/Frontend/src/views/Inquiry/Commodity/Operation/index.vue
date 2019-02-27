<template>
    <div class="commodity">
        <v-title title="Manage Products"></v-title>
        <!-- 切换 -->
        <v-table-switch title="Selling" :num="num" :tableSwitch="['Check Pending', 'Unapprove', 'In the warehouse']" style="marginBottom: 20px;" @on-click="onTableSwitch"></v-table-switch>


        <!-- 点击功能 -->
        <div class="Send-main-btn">
            <button type="button" v-show="actives[3]" @click="onReversal('selling')">Resume</button>
            <button type="button" @click="onDelete(activeProductId)">Delete</button> 
            <button type="button" v-show="actives[0]" @click="onReversal('in_the_warehouse')">Pause</button>
            <span>Total {{ this.activeProductId.length }}</span>
        </div>

        <!-- 表格 -->
        <section class="commodity-table">
            <Row class-name="commodity-header">
                <Col span="1" class-name="commodity-table-checkboxs">
                    <Checkbox v-model="single" @on-change="onChange"></Checkbox>
                </Col>
                <Col span="11" class-name="commodity-table-head">
                    Product Title
                </Col>
                <Col span="4" class-name="commodity-table-head">
                    Price
                </Col>
                <Col span="4" class-name="commodity-table-head">
                    Publish time
                </Col>
                <Col span="4" class-name="commodity-table-head">
                    Operation
                </Col>
            </Row>
            <Row v-for="(list, index) in pendingActiveData" :key="index" v-show="pendingActiveData.length">
                <Col span="24" class-name="commodity-table-title">
                    <Checkbox v-model="list.single" @on-change="onChanges"></Checkbox>
                    <div class="commodity-table-title-text">Product ID:{{ list.product_id }}</div>
                </Col>
                <Col span="24" class-name="commodity-table-content">
                    <Row>
                        <Col span="11" offset="1" class-name="commodity-table-content-title">
                            <img style="width: 74px; height: 74px; border: 1px solid #eeeeee; " :src="list.product_main_pic_url" alt="">
                            <section class="commodity-table-content-title-text">
                                <p>{{ list.product_name }}</p>
                                <p>SKU:{{ list.product_sku }}</p>
                            </section>
                        </Col>
                        <Col span="4" class-name="commodity-table-content-price">
                            <p class="commodity-table-content-title-price-ksh">{{ list.product_price }}</p>
                            <p class="commodity-table-content-title-price-moq">{{ list.product_moq }}</p>
                        </Col>
                        <Col span="4" class="commodity-table-content-date">
                            <p>{{ dayjs( list.publish_time ).format('MMM DD,YYYY HH:mm') }}</p>
                        </Col>
                        <Col span="4" class="commodity-table-content-select">
                            <router-link tag="button" type="button" :to="'/inquiryList/commodity/edit?id=' + list.product_id">Edit</router-link>
                        </Col>
                    </Row>
                </Col>
            </Row>
            <Row>
                <Col span="24" class-name="commodity-table-content" v-show="!pendingActiveData.length">
                    <Spin style="width: 30px;margin: 0px auto;" size="large"></Spin>
                </Col>
            </Row>
        </section>
        <!-- 分页 -->
        <section style="marginTop:20px;">
            <template>
                <Page :total="total.total" :page-size="total.size" style="textAlign: center" @on-change="onPages"/>
            </template>
        </section>
    </div>
</template>

<script>
    import Title from "../../components/Title"
    import Img from "@/components/Img"
    import upData from "@/utils/upData.js"
    import getData from "@/utils/getData.js"
    import utils from "@/utils/utils.js"
    
    // 切换
    import TableSwitch from "../../components/TableSwitch/index.vue"
    import dayjs from "dayjs"

    export default {
        data() {
            return {
                num: 0,
                total: {
                    size: 5,
                    total: 0,
                    num: 1
                },
                actives: [ true, false, false, false ],
                model1: '',
                single: false,
                // 数据
                pendingData: [],
                pendingActiveData: [],
                activeProductId: []
            }
        },
        methods: {
            dayjs: dayjs,
            upDelProduct: upData.upDelProduct,
            onChangeWarehouse: upData.onChangeWarehouse,
            onGetReleaseProductList: getData.onGetReleaseProductList,
            filterAll: getData.filterAll,
            sleep: utils.sleep,
            // 切换
            onTableSwitch(num) {
                this.pendingData = []
                this.pendingActiveData = []

                this.num = num
                let path = 'selling'
                
                switch (num) {
                    case 0:
                        path = 'selling'
                        break
                    case 1:
                        path = 'check_pending'
                        break
                    case 2:
                        path = 'unapprove'
                        break
                    case 3:
                        path = 'in_the_warehouse'
                        break
                }
                
                this.onGetReleaseProductList({ status: path })
                    .then(async res => {
                        this.pendingData = res.data_list
                        
                        this.onSelectKey(res.data_list)
                        // 暂停2秒
                        // await this.sleep(2000)
                        this.total.total = res.total
                        this.filterAll(this.pendingData, this.total).then(res => this.pendingActiveData = res)
                    }
                )

                this.onClick(this.num)
            },
            onClick(i) {
                for (let index = 0; index < this.actives.length; index++) {
                    if(index == i) {
                        this.$set(this.actives, index, true)
                    }else {
                        this.$set(this.actives, index, false)
                    }
                }
            },
            // 分页
            onPages(index) {
                this.$set(this.total, 'num', index)
                this.filterAll(this.pendingData, this.total).then(res => this.pendingActiveData = res)
            },
            // 添加全选key
            onSelectKey(data) {
                const arr = []

                data.forEach((element) => {
                    const obj = element
                    obj.single = false
                    arr.push(obj)
                })

                this.pendingData = arr
            },
            onChange(bool) {
                this.activeProductId = []

                this.pendingActiveData.forEach((element, index )=> {
                    this.$set(this.pendingActiveData[index], 'single', bool)

                    if(element.single) {
                        this.activeProductId.push(element.product_id)
                    }
                })
            },
            onChanges(bool) {
                this.activeProductId = []
                const arr = []


                this.pendingActiveData.forEach((element, index )=> {
                    arr.push(element.single)

                    if(element.single) {
                        this.activeProductId.push(element.product_id)
                    }
                })

                arr.includes(false) ? this.single = false : this.single = true
            },
            // 删除
            onDelete(data) {
                let path = 'selling'
                
                switch (this.num) {
                    case 0:
                        path = 'selling'
                        break
                    case 1:
                        path = 'check_pending'
                        break
                    case 2:
                        path = 'unapprove'
                        break
                    case 3:
                        path = 'in_the_warehouse'
                        break
                }

                this.upDelProduct({ product_id_list: data, status: path }).then(async res => {
                    this.pendingData = res.data_list

                    this.onSelectKey(res.data_list)
                    this.total.total = res.total
                    this.filterAll(this.pendingData, this.total).then(res => this.pendingActiveData = res)
                    this.single = false
                }).catch(err => this.$Message.error(err))
            },
            onReversal(path) {
                this.onChangeWarehouse({ product_id_list: this.activeProductId, status: path }).then(res => {
                    this.pendingData = res.data_list

                    this.onSelectKey(res.data_list)
                    this.total.total = res.total
                    this.filterAll(this.pendingData, this.total).then(res => this.pendingActiveData = res)
                    this.single = false
                })
            }
        },
        mounted() {
            this.onGetReleaseProductList({ status: 'selling' })
                .then(async res => {
                    this.pendingData = res.data_list

                    // 暂停2秒
                    // await this.sleep(2000)
                    this.total.total = res.total
                    this.filterAll(this.pendingData, this.total).then(res => this.pendingActiveData = res)
                }
            )
        },
        components: {
            "v-title": Title,
            "v-img": Img,
            "v-table-switch": TableSwitch,
        }
    }
</script>

<style lang="less" scoped>
    @import url('../../../../assets/css/index.less');

    .commodity {
        width: 944px;
        height: auto;
        min-height: 772px;
        .bg-color(white);
        padding: 21px 30px;
        border: solid 1px #eeeeee;

        &-table {
            border-top: solid 1px #eeeeee;
            border-bottom: solid 1px #eeeeee;
            
            &-header {
                height: 36px;
            }

            &-checkboxs {
                .flex(flex-start, center);
                height: 36px;
                padding-left: 10px;
            }

            &-head {
                .flex(center, center);
                height: 36px;
                font-size: 14px;
                color: #666666;
                text-align: center;
            }

            &-title {
                .flex(flex-start, center);
                width: 882px;
                height: 47px;
                padding-left: 10px;
                padding-right: 15px;
                background-color: #f5f5f9;

                &-text {
                    font-size: 14px;
                    color: #666666;
                }
            }

            &-content {
                padding: 12px 0px;
                cursor: pointer;

                &-price, &-date, &-select {
                    .flex(center, center, column);
                    height: 74px;
                }
                &-select > button {
                    width: 66px;
                    height: 25px;
                    background-color: #f0883a;
                    border: none;
                    font-size: 14px;
                    color: #ffffff;
                }

                &-title {
                    .flex(space-between, center);
                    height: 74px;
                    
                    &-text {
                        width: 320px;
                        display: inline-block;
                        font-size: 14px;
                        line-height: 1.2;
                        color: #666666;

                        & > p:last-child {
                            font-size: 12px;
                            color: #999999;
                            margin-top: 10px;
                        }
                    }
                }

                &-price {
                    & > p:first-of-type {
                        font-size: 14px;
                        color: #de2727;
                    }

                    & > p:last-of-type {
                        font-size: 12px;
                    	color: #999999;
                    }
                }

                &-date {
                    font-size: 14px;
                    color: #666666;
                }
            }
        }
    }

    .Send-main-btn {
            .flex();
            margin-top: 15px;
            margin-bottom: 12px;
            & > button {
                .color(white);
                .lineHeight(25px);
                .bg-color(Orange);
                width: 66px;
                font-size: 14px;
                border: none;
                margin-right: 10px;
            }
            & > span {
                .lineHeight(25px);
                font-size: 14px;
                color: #f0883a;
                display: inline-block;
                cursor: pointer;
            }
        }
</style>
