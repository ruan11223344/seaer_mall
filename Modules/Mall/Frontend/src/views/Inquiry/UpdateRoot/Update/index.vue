<template>
    <div class="product">
        <v-head :imgSrc="require('@/assets/img/login/bg1.png')"></v-head>
        <v-title title="Upload Product" subtitle="(1 added, maximum 200）"></v-title>

         <!-- 切换 -->
        <v-table-switch title="Search" :num="num" :tableSwitch="['Latest Selected']" style="marginBottom: 20px;" @on-click="onTableSwitch"></v-table-switch>

        <section v-show="num == 0">
            <section class="product-search" v-show="bool != false">
                <input type="text" v-model="search" class="product-search-input" @keyup.enter="onSearch">
                <button type="button" class="product-search-btn" @click="onSearch">Search</button>
            </section>

            <!-- 模糊搜索 -->
            <section class="product-blurry" v-show="search.length != 0">
                <span class="product-blurry-title">All Categories</span>

                <!-- 分类一 -->
                <swiper :options="swiperOption" class="product-blurry-item">
                    <swiper-slide style="height: auto;">
                        <Card shadow style="width: 863px;border:none;boxShadow: none;">
                            <CellGroup @on-click="onClickActive">
                                <Cell
                                    :title="item.name + ''"
                                    :class="SearchActive.id == item.categories_id ? 'product-blurry-item-list product-blurry-item-active' : 'product-blurry-item-list'"
                                    v-for="(item, index) in SearchData"
                                    :key="index"
                                    :name="item.categories_id + '~#' + item.name"
                                    />
                            </CellGroup>
                        </Card>
                    </swiper-slide>
                    <div class="swiper-scrollbar" slot="scrollbar"></div>
                </swiper>
            </section>

            <!-- 地址 -->
            <section class="product-category" v-show="search.length == 0">
                <!-- 分类一 -->
                <swiper :options="swiperOption" class="product-category-item">
                    <swiper-slide style="height: auto;">
                        <Card shadow style="width: 260px;border:none;boxShadow: none;">
                            <CellGroup @on-click="onClickRootActive">
                                <Cell
                                    :title="item.name + ''"
                                    :class="rootActive.id == item.id ? 'product-category-item-list product-category-item-active' : 'product-category-item-list'"
                                    v-for="(item, index) in rootData"
                                    :key="index"
                                    :name="item.id + '~#' + item.name"
                                />
                            </CellGroup>
                        </Card>
                    </swiper-slide>
                    <div class="swiper-scrollbar" slot="scrollbar"></div>
                </swiper>
                <!-- 分类二 -->
                <swiper :options="swiperOption" class="product-category-item" v-show="parentData.length">
                    <swiper-slide style="height: auto;">
                        <Card shadow style="width: 260px;border:none;boxShadow: none;">
                            <CellGroup @on-click="onClickParentActive">
                                <Cell
                                    :title="item.name + ''"
                                    :class="parentActive.id == item.id ? 'product-category-item-list product-category-item-active' : 'product-category-item-list'"
                                    v-for="(item, index) in parentData"
                                    :key="index"
                                    :name="item.id + '~#' + item.name"
                                />
                            </CellGroup>
                        </Card>
                    </swiper-slide>
                    <div class="swiper-scrollbar" slot="scrollbar"></div>
                </swiper>
                <!-- 分类三 -->
                <swiper :options="swiperOption" class="product-category-item" style="borderRight: none;" v-show="childData.length">
                    <swiper-slide style="height: auto;">
                        <Card shadow style="width: 260px;border:none;boxShadow: none;">
                            <CellGroup @on-click="onClickChildActive">
                                <Cell
                                    :title="item.name + ''"
                                    :class="childActive.id == item.id ? 'product-category-item-list product-category-item-active' : 'product-category-item-list'"
                                    v-for="(item, index) in childData"
                                    :key="index"
                                    :name="item.id + '~#' + item.name"
                                />
                            </CellGroup>
                        </Card>
                    </swiper-slide>
                    <div class="swiper-scrollbar" slot="scrollbar"></div>
                </swiper>
            </section>
            <!-- 选择的地址 -->
            <section class="product-footer" v-show="search">
                {{ SearchActive.name }}
            </section>

            <section class="product-footer" v-show="!search">
                {{ (rootActive.id ? rootActive.name + '>' : '') + (parentActive.id ? parentActive.name + '>' : '') + childActive.name }}
            </section>
        </section>

        <section v-show="num == 1">
            <!-- 模糊搜索 -->
            <section class="product-blurry">
                <swiper :options="swiperOption" class="product-blurry-item">
                    <swiper-slide style="height: auto;">
                        <Card shadow style="width: 863px;border:none;boxShadow: none;">
                            <CellGroup @on-click="onClickActive">
                                <Cell
                                    :title="item.name + ''"
                                    :class="SearchActive.id == item.categories_id ? 'product-blurry-item-list product-blurry-item-active' : 'product-blurry-item-list'"
                                    v-for="(item, index) in SearchData"
                                    :key="index"
                                    :name="item.categories_id + '~#' + item.name"
                                    />
                            </CellGroup>
                        </Card>
                    </swiper-slide>
                    <div class="swiper-scrollbar" slot="scrollbar"></div>
                </swiper>
            </section>
            <!-- 选择的地址 -->
            <section class="product-footer">
                {{ SearchActive.name }}
            </section>
        </section>

        <button type="button" class="product-btn" @click="onSub">Select</button>
    </div>
</template>

<script>
    import Title from "../../components/Title"
    import Img from "@/components/Img"
    import Head from "../../components/Head"
    import getData from "@/utils/getData.js"

    // 滚动条
    // import { HappyScroll } from 'vue-happy-scroll'
    import { swiper, swiperSlide } from 'vue-awesome-swiper'
    import 'swiper/dist/css/swiper.css'

    // 切换
    import TableSwitch from "../../components/TableSwitch/index.vue"
    import { mapMutations } from "vuex"
    import Cookies from "@/utils/auth"

    export default {
        data() {
            return {
                num: 0,
                switchValue: true,
                bool: true,
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
                search: '',
                SearchData: [],
                SearchActive: {
                    id: null,
                    name: ''
                },
                SearchBool: false,
                // 分类
                rootData: [],
                rootActive: {
                    id: null,
                    name: ''
                },
                parentData: [],
                parentActive: {
                    id: null,
                    name: ''
                },
                childData: [],
                childActive: {
                    id: null,
                    name: ''
                },

                SelectId: null,
                name: null
            }
        },
        methods: {
            onGetLastProductsCategories: getData.onGetLastProductsCategories,
            ...mapMutations(['SET_CLASSIFICATION']),
            // 切换
            onTableSwitch(num) {
                this.num = num
                switch (num) {
                    case 0:

                        break
                    case 1:
                        this.onGetLastProductsCategories().then(res => this.SearchData = res)
                        break
                }
            },
            // 搜索关键词获取分类列表
            onSearch() {
                if(this.SearchBool) {
                    
                    return
                }else {
                    this.$request({
                        url: '/shop/category/search_category',
                        params: {
                            keywords: this.search
                        }
                    }).then(res => {
                        if(res.code == 200) {
                            this.SearchData = res.data
                        }else {
                            this.$Message.error(res.message)
                        }
                    }).catch(err => {
                        return false
                    })

                    this.SearchBool = true

                    setTimeout(() => {
                        this.SearchBool = false
                    }, 500)
                }
            },
            // 选中搜索列表
            onClickActive(name) {
                const arr = name.split('~#')
                this.$set(this.SearchActive, 'id', arr[0])
                this.$set(this.SearchActive, 'name', arr[1])

                this.SelectId = this.SearchActive.id

                const item = this.SearchActive.name.split('>')
                this.name = item[item.length - 1]
            },
            // 获取根分类列表
            GetRootList() {
                this.$request({
                    url: '/shop/category/get_category_root'
                }).then(res => {
                    if(res.code == 200) {
                        this.rootData = res.data
                    }else {
                        this.$Message.error(res.message)
                    }
                }).catch(err => {
                    return false
                })
            },
            onClickRootActive(name) {
                const arr = name.split('~#')
                this.$set(this.rootActive, 'id', arr[0])
                this.$set(this.rootActive, 'name', arr[1])

                this.parentActive = {
                    id: null,
                    name: ''
                }

                this.childActive = {
                    id: null,
                    name: ''
                }
                this.SelectId = null
                this.name = null

                this.childData = []

                this.GetChildList(this.rootActive.id, true)
            },
            // 获取分类的子分类列表
            GetChildList(id, bool) {
                this.$request({
                    url: '/shop/category/get_category_child',
                    params: {
                        categories_id: id
                    }
                }).then(res => {
                    if(res.code == 200) {
                        if(bool) {
                            this.parentData = res.data
                        }else {
                            this.childData = res.data
                        }
                    }else {
                        this.$Message.error(res.message)
                    }
                }).catch(err => {
                    return false
                })
            },
            onClickChildActive(name) {
                const arr = name.split('~#')
                this.$set(this.childActive, 'id', arr[0])
                this.$set(this.childActive, 'name', arr[1])

                this.SelectId = this.childActive.id
                this.name = this.childActive.name

            },
            onClickParentActive(name) {
                const arr = name.split('~#')
                this.$set(this.parentActive, 'id', arr[0])
                this.$set(this.parentActive, 'name', arr[1])

                this.childActive = {
                    id: null,
                    name: ''
                }
                this.GetChildList(this.parentActive.id, false)

                this.SelectId = this.parentActive.id
                this.name = this.parentActive.name

            },
            // 查看选中的分类是否还有子分类
            GetSeachList(id) {
                return new Promise((resolve, reject) => {
                    this.$request({
                        url: '/shop/category/get_category_child',
                        params: {
                            categories_id: id
                        }
                    }).then(res => {
                        if(res.code == 200) {
                            resolve(true)
                        }else {
                            resolve(false)
                        }
                    }).catch(err => {
                        return false
                    })
                })
            },
            // 提交
            onSub() {
                if(this.SelectId) {
                    this.GetSeachList(this.SelectId)
                        .then(bool => {
                            if(!bool) {
                                // 存储在vuex
                                this.SET_CLASSIFICATION(this.SelectId)

                                this.$router.push('/inquiryList/uploadroot/uploadinfo?name=' + this.name)
                            }
                        })
                }else {
                    this.$Message.error('Please choose the category')
                }
            },
            getSessionStorage: Cookies.getSessionStorage
        },
        created() {
            const user = this.getSessionStorage()
            const bool = user.publish_product.status
            if(bool == true) {
                return true
            }else {
                return this.$router.push('/inquiryList/uploadroot/tips')
            }
        },
        mounted() {
            this.GetRootList()
        },
        components: {
            "v-title": Title,
            "v-img": Img,
            "v-head": Head,
            "v-table-switch": TableSwitch,
            swiper,
            swiperSlide
        },
        watch: {
            search(add) {
                if(add == '') {
                    this.SearchActive = {
                        id: null,
                        name: ''
                    }

                    this.SelectId = this.childActive.id
                    
                }
            }
        },
    }
</script>

<style lang="less" scoped>
    @import url('../../../../assets/css/index.less');

    .product {
        width: 945px;
        height: 931px;
        background-color: #ffffff;
        padding: 21px 30px;
        position: relative;
        z-index: 1;

        &-search {
            margin-bottom: 20px;

            &-input {
                width: 527px - 114px;
                height: 54px;
                border: solid 1px #dddddd;
                border-right: none;
            }

            &-btn {
                border: none;
                width: 114px;
                height: 54px;
                font-size: 16px;
                color: #666666;
            }
        }

        &-category {
            width: 885px;
            font-size: 0px;
            border: solid 1px #dddddd;
            border-bottom: none;

            &-item {
                width:( 885px - 2px) / 3;
                height: 462px;
                border-right: solid 1px #dddddd;
                padding: 0px 10px;
                display: inline-block;
                z-index: 0px;

                &-list {
                    height: 36px;
                    font-size: 14px;
                    .textHidden();
                }

                &-list:hover {
                    background-color: #f5f5f9 !important;
                }

                &-active {
                    background-color: #f5f5f9;
                    color: #f0883a;
                }
            }
        }

        &-blurry {
            width: 885px;

            &-title {
                font-size: 16px;
                color: #f0883a;
                margin-left: 22px;
                margin-bottom: 8px;
                cursor: pointer;
                display: inline-block;
            }

            &-item {
                width: 885px;
                height: 462px;
                border: solid 1px #dddddd;
                padding: 0px 10px;

                &-list {
                    height: 36px;
                    font-size: 14px;
                    .textHidden();
                }

                &-list:hover {
                    background-color: #f5f5f9 !important;
                }

                &-active {
                    background-color: #f5f5f9;
                    color: #f0883a;
                }
            }
        }

        &-footer {
            width: 885px;
            height: 40px;
            border: solid 1px #dddddd;
            font-size: 14px;
            line-height: 40px;
            color: #666666;
            padding-left: 42px;
            padding-right: 20px;
            .textHidden();
        }

        &-btn {
            border: none;
            width: 118px;
            height: 44px;
            background-color: #f0883a;
            font-size: 18px;
            color: #ffffff;
            display: block;
            margin: 0px auto;
            margin-top: 40px;
        }
    }
</style>
