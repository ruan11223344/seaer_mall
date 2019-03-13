<template>
    <div class="products">
        <v-title title="Group & Sort Products"></v-title>
        <template>
            <section class="products-btns">
                <button type="button" @click="deletAlbum=true">Delete</button>
                <button type="button" @click="NewCategory=true">New Category</button>
            </section>
        </template>
        <template>
            <section class="products-table">
                <div class="products-table-head">
                    <div class="products-table-head-checkbox">
                        <template>
                            <Checkbox v-model="single" @on-change="onSingle" size="large"></Checkbox>
                        </template>
                    </div>
                    <div class="products-table-head-text products-table-head-name">
                        <span>Name</span>
                    </div>
                    <div class="products-table-head-text products-table-head-sort">Sort</div>
                    <div class="products-table-head-text products-table-head-display">Display</div>
                    <div class="products-table-head-text products-table-head-operation">Operation</div>
                </div>
                <div class="products-table-body">
                    <!-- 最多有5个 -->
                    <template v-if="ProductsData != null">
                        <template v-if="ProductsData.length">
                            <template v-for="(item, index) in ProductsData">
                                <div  :key="index">

                                    <dl class="products-table-body-dl">
                                        <dd class="products-table-body-dl-checkbox">
                                            <template>
                                                <span v-if="ActiveId.length > 0">
                                                    <Checkbox v-model="ActiveId[index].active" @on-change="onChange" size="large"></Checkbox>
                                                </span>
                                            </template>
                                        </dd>
                                        <dd class="products-table-body-dl-text products-table-body-dl-name ">
                                            <template>
                                                <div
                                                    class="products-table-body-dl-name-open"
                                                    :class="active == index ? 'products-table-body-dl-name-open-add' : 'products-table-body-dl-name-open-remove'"
                                                    @click="active==index ? active = -1 : active = index">
                                                </div>
                                                <span class="products-table-body-dl-name-text">{{ item.group_name }} </span>
                                                <button type="button" class="products-table-body-dl-name-btn" @click="SubCategory=true,ListId=item.id">Add Sub-category</button>
                                            </template>
                                        </dd>
                                        <dd class="products-table-body-dl-text products-table-body-dl-sort">
                                            <template>
                                                <span>
                                                    {{ item.sort }}
                                                </span>
                                            </template>
                                        </dd>
                                        <dd class="products-table-body-dl-text products-table-body-dl-display">
                                            <template>
                                                <span>
                                                    {{ item.show_home_page ? "Yes" : 'No' }}
                                                </span>
                                            </template>
                                        </dd>
                                        <dd class="products-table-body-dl-text products-table-body-dl-operation">
                                            <template>
                                                <section class="products-table-body-dl-operation-btns">
                                                    <button type="button" @click="id=item.id,delAlbum=true">Delete</button>
                                                    <button type="button" @click="EditCategory=true,onEdit,ListId=item.id">Edit</button>
                                                </section>
                                            </template>
                                        </dd>
                                    </dl>
                                    <!-- 滚动 -->
                                    <!-- 子元素 -->
                                    <div class="products-table-body-content" :style="active == index ? 'height: 250px;' : ''">
                                        <swiper :options="swiperOption" style="height: 250px;overflow: hidden;zIndex: 0">
                                            <swiper-slide style="height: auto;">
                                                <template v-if="item.children">
                                                    <dl class="products-table-body-dl" v-for="(list, i) in item.children" :key="i">
                                                        <dd class="products-table-body-dl-checkbox">
                                                        </dd>
                                                        <dd class="products-table-body-dl-text products-table-body-dl-name ">
                                                            <template>
                                                                <div class="products-table-body-dl-name-seat"></div>
                                                                <span class="products-table-body-dl-name-text products-table-body-dl-name-dot">{{ list.group_name }} </span>
                                                            </template>
                                                        </dd>
                                                        <dd class="products-table-body-dl-text products-table-body-dl-sort">
                                                            <template>
                                                                <span>
                                                                    {{ list.sort }}
                                                                </span>
                                                            </template>
                                                        </dd>
                                                        <dd class="products-table-body-dl-text products-table-body-dl-display">
                                                            <template>
                                                                <span>
                                                                    {{ list.show_home_page ? "Yes" : 'No' }}
                                                                </span>
                                                            </template>
                                                        </dd>
                                                        <dd class="products-table-body-dl-text products-table-body-dl-operation">
                                                            <template>
                                                                <section class="products-table-body-dl-operation-btns">
                                                                    <button type="button" @click="id=list.id,delAlbum=true">Delete</button>
                                                                    <button type="button" @click="EditCategory=true,onEdit,ListId=list.id">Edit</button>
                                                                </section>
                                                            </template>
                                                        </dd>
                                                    </dl>
                                                </template>
                                                <template v-else>
                                                    <div style="textAlign: center;lineHeight: 250px;fontSize: 30px;">
                                                        No subcategories, please create
                                                    </div>
                                                </template>
                                            </swiper-slide>
                                            <div class="swiper-scrollbar" slot="scrollbar"></div>
                                        </swiper>
                                    </div>
                                </div>
                            </template>
                        </template>
                        <template v-else>
                            <div style="height: 500px;textAlign: center;paddingTop:200px;">
                                You haven't created the category yet. Please click the button above to create it as soon as possible.
                            </div>
                        </template>
                    </template>
                    <template v-else>
                        <div style="height: 100px;">
                            <Spin style="width: 30px;margin: 0px auto;marginTop: 100px;" size="large"></Spin>
                        </div>
                    </template>
                </div>
            </section>
            
            <!-- 分页 -->
            <section style="marginTop:20px;">
                <template>
                    <Page :total="total.total" :page-size="8" style="textAlign: center" @on-change="onPages"/>
                </template>
            </section>

            <!-- 删除多个 -->
            <template>
                <v-deletealbum v-show="deletAlbum" @on-show="onDeleteShow" @on-delete="onDelete"></v-deletealbum>
            </template>

            <!-- 删除单个 -->
            <template>
                <v-deletealbum v-show="delAlbum" @on-show="onDelShow" @on-delete="onDel"></v-deletealbum>
            </template>

            <!-- 排序----新类别 -->
            <template>
                <v-sort-template title="New Category" @on-create="onCreate" v-show="NewCategory" @on-show="onNewCategory"></v-sort-template>
            </template>

            <!-- 排序----子类-新类别 -->
            <template>
                <v-sort-template title="Add Sub-category" @on-create="onCreate" v-show="SubCategory" @on-show="onSubCategory"></v-sort-template>
            </template>

            <!-- 排序----编辑-新类别 -->
            <template>
                <v-sort-template title="Edit  Category" @on-create="onEdit" v-show="EditCategory" @on-show="onEditCategory"></v-sort-template>
            </template>
        </template>
    </div>
</template>

<script>
    import Img from "@/components/Img"
    import Title from "../components/Title/index.vue"
    // 删除功能
    import DeletAlbum from "./DeleteAlbum/index.vue"
    // 排序
    import SortTemplate from './Sort-template/index.vue'

    // 切换
    import { swiper, swiperSlide } from 'vue-awesome-swiper'
    import 'swiper/dist/css/swiper.css'

    export default {
        data() {
            return {
                single: false,
                deletAlbum: false,
                delAlbum: false,
                NewCategory: false,
                SubCategory: false,
                EditCategory: false,
                swiperOption: {
                    direction: 'vertical',
                    slidesPerView: 'auto',
                    freeMode: true,
                    scrollbar: {
                        el: '.swiper-scrollbar',
                        hide: false, //滚动条是否自动隐藏。默认：false，不会自动隐藏。
                        draggable: true, //该参数设置为true时允许拖动滚动条。
                        snapOnRelease: true, //如果设置为false，释放滚动条时slide不会自动贴合。
                        dragSize: 30, //设置滚动条指示的尺寸。默认'auto': 自动，或者设置num(px)。
                    },
                    mousewheel: true
                },
                total: {
                    size: 8,
                    total: 0,
                    num: 1
                },
                data: [],
                ProductsData: null,
                // ProductsDataList: [],
                active: -1,
                ListId: null,
                ActiveId: [],
                id: null
            }
        },
        methods: {
            onDeleteShow() {
                this.deletAlbum = false
            },
            onDelShow() {
                this.delAlbum = false
            },
            onNewCategory() {
                this.NewCategory = false
            },
            onSubCategory() {
                this.SubCategory = false
            },
            onEditCategory() {
                this.EditCategory = false
            },
            // 获取商品分组列表
            GetProductItem() {
                this.$request({
                    url: '/shop/product_group/product_group_list'
                }).then(res => {
                    if(res.code == 200) {
                        this.data = res.data
                        this.filterAll(this.data)
                    }
                }).catch(err => {
                    return false
                })
            },
            // 创建商品分组
            onCreateProduct(item) {
                this.$request({
                    url: '/shop/product_group/create_products_group',
                    method: 'post',
                    data: {
                        group_parent_id: this.ListId,   //父分组id 必填 没有为null
                        group_name: item.name, //必填 分组名称
                        show_home_page: item.active ? true : false ,  //必填 布尔类型 是否在首页显示
                        sort: item.sort ? item.sort : 0   // 必填 排序 数字 不排序 填0
                    }
                }).then(res => {
                    if(res.code == 200) {
                        this.$Message.info(res.message)
                        this.data = res.data
                        this.filterAll(this.data)
                    }else {
                        this.$Message.error(res.message)
                    }
                    this.ListId = null
                }).catch(err => {
                    return false
                })
            },
            // 修改商品分组
            onEdit(item) {
                this.$request({
                    url: '/shop/product_group/edit_products_group',
                    method: 'post',
                    data: {
                        product_group_id: this.ListId,  //分组id 必填
                        group_name: item.name,  //修改后的分组名称 必填
                        show_home_page: item.active ? true : false,  //必填 布尔类型 是否在首页显示
                        sort: item.sort ? item.sort : 0  //必填 排序 数字 不排序 填0
                    }
                }).then(res => {
                    if(res.code == 200) {
                        this.$Message.info(res.message)
                        this.data = res.data
                        this.filterAll(this.data)
                    }else {
                        this.$Message.error(res.message)
                    }
                    this.ListId = null
                }).catch(err => {
                    return false
                })
            },
            // 删除多个商品分组
            onDelete() {
                const ArrId = []

                for (let index = 0; index < this.ActiveId.length; index++) {
                    if(this.ActiveId[index].active) {
                        ArrId.push(this.ActiveId[index].id)
                    }
                }
                
                this.$request({
                    url: '/shop/product_group/delete_products_group',
                    method: 'post',
                    data: {
                        product_group_id: ArrId
                    }
                }).then(res => {
                    if(res.code == 200) {
                        this.data = res.data
                        this.filterAll(this.data)
                        this.$Message.info(res.message)
                    }else {
                        this.$Message.error(res.message)
                    }
                    this.single = false
                    this.active = -1
                }).catch(err => {
                    return false
                })
                this.onDeleteShow()
            },
            // 删除单个商品分组
            onDel() {
                this.$request({
                    url: '/shop/product_group/delete_products_group',
                    method: 'post',
                    data: {
                        product_group_id: [ this.id ]
                    }
                }).then(res => {
                    if(res.code == 200) {
                        this.data = res.data
                        this.filterAll(this.data)
                        this.$Message.info(res.message)
                    }else {
                        this.$Message.error(res.message)
                    }
                    this.single = false
                    this.id = null
                    this.active = -1
                }).catch(err => {
                    return false
                })

                this.onDelShow()
            },
            // 创建新类别
            onCreate(data) {
                this.onCreateProduct(data)
            },
            // 显示对应的数据
            filterAll(data) {
                this.ProductsData = []
                const { num, size } = this.total
                const dataFrom = data.slice(num * size - 8, num * size)
                this.total.total = data.length

                dataFrom.forEach((value, index) => {
                    this.ProductsData.push(value)
                })

                this.onSelect(this.ProductsData)
            },
            // 分页
            onPages(index) {
                this.active = -1
                this.$set(this.total, 'num', index)
                this.filterAll(this.data)
            },
            // 全选
            onSelect(data) {
                this.ActiveId = []
                for(let item of data) {
                    this.ActiveId.push({ id: item.id, active: false })
                }
            },
            // 点击选中按钮
            onChange() {
                const arr = []
                for(let item of this.ActiveId) {
                    arr.push(item.active)
                }

                if(arr.includes(false)) {
                    this.single = false
                }else {
                    this.single = true
                }
            },
            onSingle(value) {
                for (let index = 0; index < this.ActiveId.length; index++) {
                    this.$set(this.ActiveId[index], 'active', value)
                }
            }
        },
        mounted() {
            this.GetProductItem()
        },
        components: {
            "v-title": Title,
            "v-img": Img,
            "v-deletealbum": DeletAlbum,
            "v-sort-template": SortTemplate,
            swiper,
            swiperSlide
        }
    }
</script>

<style lang="less" scoped>
    @import url('../../../assets/css/index.less');

    .products {
        .width(945px, auto);
        min-height: 772px;
        .bg-color(white);
        padding: 21px 30px;

        &-btns {
            margin-top: 20px;

            & > button {
                background-color: #f0883a;
                height: 25px;
                padding: 0px 13px;
                font-size: 14px;
                color: #ffffff;
                border: none;
            }

            & > button:last-child {
                margin-left: 10px;
            }
        }

        &-table {
            margin-top: 12px;

            &-head {
                width: 885px;
                height: 47px;
                background-color: #f5f5f9;
                .flex(flex-start, center);
                // margin-bottom: 16px;

                &-text {
                    font-size: 14px;
                    color: #666666;
                    text-align: center;
                }
               

                &-checkbox {
                    width: 62px;
                    text-align: center;
                }

                &-name {
                    width: 350px;
                    text-align: left;
                    & > span {
                        padding-left: 138px - 62px;
                    }
                }

                &-sort {
                    width: 135px;
                }
                &-display {
                    width: 170px;
                }

                &-operation {
                    width: 180px;
                }
            }

            &-body {
                
                &-content {
                    height: 0px;
                    overflow: hidden;
                    transition: 0.5s height ;
                }

                &-dl {
                    margin-top: 12px;
                    .flex(flex-start, center);
                    padding-bottom: 12px;
                    border-bottom: 1px solid #f5f5f9;

                    &-text {
                        font-size: 14px;
                        color: #666666;
                        text-align: center;
                    }

                    &-checkbox {
                        width: 62px;
                        text-align: center;

                    }

                    &-name {
                        width: 350px;
                        text-align: left;
                        .flex(flex-start, center);

                        &-open {
                            width: 20px;
                            height: 20px;
                            background-color: #f5f5f9;
                            margin-right: 20px;

                            &-add {
                                position: relative;
                                cursor: pointer;

                                &::before, &::after {
                                    content: '';
                                    position: absolute;
                                    top: 50%;
                                    left: 50%;
                                    transform: translate(-50%, -50%);
                                    background-color: #666666;
                                }

                                &::before {
                                    width: 12px;
                                    height: 2px;
                                }

                                &::after {
                                    width: 2px;
                                    height: 12px;
                                }
                            }

                            &-remove {
                                position: relative;
                                cursor: pointer;

                                &::before, &::after {
                                    content: '';
                                    position: absolute;
                                    top: 50%;
                                    left: 50%;
                                    transform: translate(-50%, -50%);
                                    background-color: #666666;
                                }

                                &::before {
                                    width: 12px;
                                    height: 2px;
                                }
                            }
                        }

                        &-seat {
                            width: 20px;
                            height: 20px;
                            margin-right: 20px;
                        }

                        &-text {
                            width: 130px;
                            font-size: 14px;
                            color: #666666;
                            .textHidden()
                        }

                        // 装饰点
                        &-dot {
                            &::before {
                                content: '';
                                width: 4px;
                                height: 4px;
                                background-color: #bfbfbf;
                                display: inline-block;
                                border-radius: 50%;
                                margin-right: 10px;
                                margin-bottom: 4px;
                            }
                        }

                        &-btn {
                            width: 110px;
                            height: 23px;
                            font-size: 12px;
                            color: #f0883a;
                            margin-left: 10px;
                            background: transparent;
                            border: solid 1px #f0883a;
                        }
                    }

                    &-sort {
                        width: 135px;
                    }
                    &-display {
                        width: 170px;
                    }

                    &-operation {
                        width: 180px;

                        &-btns {
                            button {
                                height: 25px;
                                padding: 0px 13px;
                                font-size: 14px;
                                color: #ffffff;
                                border: none;
                            }

                            & > button:first-child {
                                background-color: #cfcfcf;
                            }

                            & > button:last-child {
                                background-color: #f0883a;
                                margin-left: 10px;
                            }
                        } 
                    }
                }
            }
        }
    }
</style>