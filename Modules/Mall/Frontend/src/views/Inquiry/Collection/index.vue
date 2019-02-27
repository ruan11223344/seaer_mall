<template>
    <div class="Send-main">
        <v-title title="Favorites"></v-title>

        <!-- <section class="Send-main-screening">
            <div class="Send-main-screening-text Send-main-screening-text-active">Products <span>10</span></div>
            <div class="Send-main-screening-hr"></div>
            <div class="Send-main-screening-text">Suppliers <span>10</span></div>
        </section> -->

        <v-table-switch title="Products" :num="num" :tableSwitch="['Suppliers']" style="marginTop: 20px;"  @on-click="onTableSwitch"></v-table-switch>

        <div class="Send-main-btn">
            <button @click="onDel">Delete</button>
            <span>Total {{ activeArr.length }}</span>
            <span style="color: #999999;">&nbsp;&nbsp;(Maximum:{{ num == 0 ? product.length : company.length }})</span>
        </div>

        <Table v-show="num == 0" :height="formData.length > 8 ? 530 : ''" :columns="columns12" :data="formData" @on-selection-change="onChange">
            <!-- 内容 -->
            <template slot-scope="{ row }" slot="Content">
                <div class="Send-main-content">
                    <span>{{ row.product_name }}</span>
                </div>
            </template>
            <!-- 时间 -->
            <template slot-scope="{ row }" slot="time">
                <div>
                    <time>{{ dayjs(row.updated_at ).format('MMM DD,YYYY HH:mm') }}</time>
                </div>
            </template>
        </Table>

        <Table v-show="num == 1" :height="formData.length > 8 ? 530 : ''" :columns="columns12" :data="formData">
            <!-- 内容 -->
            <template slot-scope="{ row }" slot="Content">
                <div class="Send-main-content">
                    <span>{{ row.company_name }}</span>
                </div>
            </template>
            <!-- 时间 -->
            <template slot-scope="{ row }" slot="time">
                <div>
                    <time>{{ dayjs(row.updated_at ).format('MMM DD,YYYY HH:mm') }}</time>
                </div>
            </template>
        </Table>
        
        <section style="marginTop:20px;">
            <template>
                <Page :total="total.total" :page-size="total.size" style="textAlign: center" @on-change="onPages"/>
            </template>
        </section>
        
    </div>
</template>

<script>
    import Title from "../components/Title"
    import Img from "@/components/Img"
    import getData from "@/utils/getData"
    import upData from "@/utils/upData"
    // 切换
    import TableSwitch from "../components/TableSwitch/index.vue"
    import dayjs from "dayjs"

    export default {
        data () {
            return {
                num: 0,
                total: {
                    size: 8,
                    total: 0,
                    num: 1
                },
                columns12: [
                    {
                        type: 'selection',
                        width: 60,
                        align: 'center',
                    },
                    {
                        title: 'Products Name',
                        slot: 'Content',
                        align: 'center',
                        sortable: true
                    },
                    {
                        title: 'Date',
                        slot: 'time',
                        key: 'time',
                        align: 'center',
                        sortable: true
                    },
                    
                ],
                formData: [],
                product: [],
                company: [],
                activeArr: []
            }
        },
        methods: {
            dayjs: dayjs,
            onGetFavorites: getData.onGetFavorites,
            onSetFavorites: upData.onSetFavorites,
            onDelFavorites: upData.onDelFavorites,
            filterAll: getData.filterAll,
            // 切换
            onTableSwitch(num) {
                this.num = num
                
                this.GetData()
            },
            // 分页
            onPages(index) {
                this.$set(this.total, 'num', index)
                this.filterAll(this.num == 0 ? this.product : this.company, this.total).then(res => {
                    this.formData = res
                })
            },
            GetData() {
                this.onGetFavorites().then(res => {
                    this.onPage(res)
                })
            },
            onChange(selection) {
                const arr = []
                selection.forEach((element, index) => {
                    arr.push(element.product_or_company_id)
                })

                this.activeArr = arr
            },
            onDel() {
                this.onDelFavorites({
                    product_or_company_id_list: this.activeArr,
                    type: this.num == 0 ? 'product' : 'company'
                }).then(res => {
                    this.onPage(res)
                    this.activeArr = []
                })
            },
            onPage(res) {
                this.product = res.product
                this.company = res.company
                this.total.total = this.num == 0 ? this.product.length : this.company.length
                this.filterAll(this.num == 0 ? this.product : this.company, this.total).then(res => {
                    this.formData = res
                })
            }
        },
        mounted() {
            this.GetData()
        },
        components: {
            "v-title": Title,
            "v-img": Img,
            "v-table-switch": TableSwitch
        }
    }
</script>

<style lang="less" scoped>
    @import url('../../../assets/css/index.less');

    .Send-main {
        .width(945px, 772px);
        .bg-color(white);
        padding: 21px 30px;

        // &-screening {
        //     width: 886px;
        //     height: 47px;
        //     background-color: #f5f5f9;
        //     margin-top: 19px;
        //     .flex(flex-start, center);
        //     padding-left: 27px;

        //     &-text {
        //         .lineHeight(47px);
        //         font-size: 14px;
        //         color: #666666;

        //         & > span {
        //             color: #d72b2b;
        //         }
        //         cursor: pointer;
        //     }
        //     &-text-active {
        //         border-bottom: 2px solid #f0883a;
        //     }

        //     &-hr {
        //         width: 1px;
        //         height: 11px;
        //         background-color: #cccccc;
        //         margin: 0px 18px;
        //     }
        // }

        &-btn {
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

        &-name {
            .flex(center);

            & > span {
                .textHidden();
                text-align: left;
                max-width: 192px;
                margin-left: 7px;
                font-size: 14px;
                color: #666666;
            }
        }

        &-content {
            .flex();
            text-align: left;
        }   
    }
</style>
