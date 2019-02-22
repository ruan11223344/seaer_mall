<template>
    <div class="albumlist">
        <v-title title="Manage Photos"></v-title>

        <!-- 切换 -->
        <v-table-switch title="My Album" :num="num" :tableSwitch="['List of Image']" style="marginBottom: 20px;" @on-click="onTableSwitch"></v-table-switch>

        <section class="albumlist-title">
            <v-img width="63" height="50" imgSrc="" style="border: 1px solid #ccc;"></v-img>
            <div class="albumlist-title-right">
                <div>{{ $route.query.name }}</div>
                <div>{{ $route.query.description ? $route.query.description : '' }}</div>
            </div>
        </section>

        <!-- 按钮集合 -->
        <section class="albumlist-buttonAggregate">
            <div class="albumlist-buttonAggregate-left">
                <span @click="onSelect(!single)">
                    <Checkbox v-model="single"></Checkbox>
                </span>
                <!-- <button type="button" class="albumlist-buttonAggregate-left-btn">Cancel</button> -->
                <button type="button" class="albumlist-buttonAggregate-left-btn" @click="deletAlbum=true">Delete</button>
                <button type="button" class="albumlist-buttonAggregate-left-btn" @click="moveAlbum=true">Move to other ablum</button>
            </div>
            <!-- <div class="albumlist-buttonAggregate-right">
                <span class="albumlist-buttonAggregate-right-sort">Sort by</span>
                <Select v-model="model1" style="width:200px" placeholder="Descending date">
                    <Option v-for="item in cityList" :value="item.value" :key="item.value">{{ item.label }}</Option>
                </Select>
            </div> -->
        </section>

        <!-- 提示 -->
        <section class="albumlist-Tips">
            When use 'Replace' function, please make sure you upload the same image format.
        </section>

        <!-- 图片 -->
        <template>
            <div style="marginTop: 13px;" class="albumlist-card">
                <v-card-info :item="item" v-for="(item, index) in formData" :key="index" @on-changes="onChanges" @on-getData="onGetAlbumList" class="albumlist-card-list"></v-card-info>
            </div>

            
        </template>

        <!-- 删除图片 -->
        <template>
            <v-deletealbum :dataId="formData | GetAlbumId" v-show="deletAlbum" @on-show="onDeleteShow"></v-deletealbum>
        </template>

        <!-- 移动到其他相册 -->
        <!-- <template>
            <v-move-other-album v-show="AlbumTips"></v-move-other-album>
        </template> -->

        <!-- 移动到其他相册操作 -->
        <template>
            <v-move-other-albums :dataId="formData | GetAlbumId" v-show="moveAlbum" @on-show="onMoveAlbum"></v-move-other-albums>
        </template>

        <section style="marginTop:20px;">
            <template>
                <Page :total="total.total" :page-size="10" style="textAlign: center" @on-change="onPages"/>
            </template>
        </section>
    </div>
</template>

<script>
    import Img from "@/components/Img"
    import Title from "../../components/Title"
    // 商品组件
    import CardInfoTemplateVue from '../components/Card-info-template.vue'
    // 删除功能
    import DeletAlbum from "../DeleteAlbum/index.vue"
    // 移动到其他相册提示
    import MoveOtherAlbum from '../MoveOtherAlbum/index.vue'
    // 移动到其他相册操作
    import MoveOtherAlbums from '../MoveOtherAlbums/index.vue'
    // 切换
    import TableSwitch from "../../components/TableSwitch/index.vue"


    export default {
        data() {
            return {
                num: 1,
                createShow: false,
                uploadShow: false,
                cityList: [
                    {
                        value: 'New York',
                        label: 'New York'
                    },
                    {
                        value: 'London',
                        label: 'London'
                    },
                    {
                        value: 'Sydney',
                        label: 'Sydney'
                    },
                    {
                        value: 'Ottawa',
                        label: 'Ottawa'
                    },
                    {
                        value: 'Paris',
                        label: 'Paris'
                    },
                    {
                        value: 'Canberra',
                        label: 'Canberra'
                    }
                ],
                AlbumTips: false,
                model1: '',
                single: false,
                deletAlbum: false,
                moveAlbum: false,
                formData: [],
                data: [],
                total: {
                    size: 10,
                    total: 0,
                    num: 1
                }
            }
        },
        filters: {
            // 图片id列表
            GetAlbumId(data) {
                const arr = []

                for(let item of data) {
                    if(item.single == true) {
                        arr.push(item.id)
                    }
                }

                return arr
            },
        },
        methods: {
            onDeleteShow(bool) {
                this.deletAlbum = false
                if(bool) {
                    this.onGetAlbumList()
                }
            },
            onMoveAlbum(bool) {
                this.moveAlbum = false
                if(bool) {
                    this.onGetAlbumList()
                }
            },
            // 切换
            onTableSwitch(num) {
                this.num = num
                switch (num) {
                    case 0:
                        this.$router.push('/inquiryList/Album/administration')
                        break
                    case 1:
                        
                        break
                }
            },
            onGetAlbumList() {
                this.$request(
                    {
                        url: '/album/album_photo_list',
                        method: 'get',
                        params: {
                            album_id: this.$route.query.id
                        }
                    }
                ).then(res => {
                    if(res.code == 200) {
                        this.filterAll(res.data)
                        this.data = this.filterFormData(res.data)
                    }
                }).catch(err => {
                    return false
                })
            },
            // 显示对应数据
            filterAll(data) {
                this.total.total = data.length
                this.formData = []
                const { num, size } = this.total
                const dataFrom = data.slice(num * size - 10, num * size)

                dataFrom.forEach((value, index) => {
                    this.formData.push(value)
                })

                this.filterFormData(this.formData)
            },
            // 过滤
            filterFormData(data) {
                
                const datas = data
                for(let item of datas) {
                    item.single = false
                }
                return datas
            },
            
            // 全选
            onSelect(bool) {
                for(let index in this.formData) {
                    this.$set(this.formData[index], 'single', bool)
                }
            },
            // 全选
            onChanges() {
                const arr = []
                for(let i = 0; i < this.formData.length; i++) {
                    arr.push(this.formData[i].single)
                }

                if(arr.includes(false)) {
                    this.single = false
                }else {
                    this.single = true
                }
                
                return false
            },
            // 分页
            onPages(index) {
                this.$set(this.total, 'num', index)
                this.filterAll(this.data)
            }
        },
        mounted() {
            if(!this.$route.query.id) {
                this.$router.push('/inquiryList/Album/administration')
            }else {
                // 获取相册列表
                this.onGetAlbumList()
            }
        },
        components: {
            "v-title": Title,
            "v-img": Img,
            "v-card-info": CardInfoTemplateVue,
            "v-deletealbum": DeletAlbum,
            "v-move-other-album": MoveOtherAlbum,
            "v-move-other-albums": MoveOtherAlbums,
            "v-table-switch": TableSwitch
        }
    }
</script>

<style lang="less" scoped>
    @import url('../../../../assets/css/index.less');

    .albumlist {
        .width(945px, auto);
        min-height: 772px;
        .bg-color(white);
        padding: 21px 30px;

        &-title {
            .flex();

            &-right {
                margin-left: 18px;
                .flex(center, flex-start);
                flex-direction: column;

                & > div {
                    line-height: 1;
                }

                & > div:first-child {
                    font-size: 14px;
                    color: #666666;
                    margin-bottom: 13px;
                }

                & > div:last-child {
                    font-size: 12px;
                    color: #999999;
                }
            }
        }

        &-buttonAggregate {
            .flex(space-between, center);
            margin-top: 15px;

            &-left {

                &-btn {
                    margin-left: 20px;
                    padding: 0px 13px;
                    height: 25px;
                    background-color: #f0883a;
                    font-size: 14px;
                    color: #ffffff;
                    border: none;
                }
            }

            &-right {
                &-sort {
                    font-size: 14px;
                    color: #666666;
                    margin-right: 13px;
                }
            }
        }

        &-Tips {
            width: 885px;
            height: 38px;
            line-height: 38px;
            padding: 0px 14px;
            background-color: #fff8f3;
            border: solid 1px #f0883a;
            margin-top: 13px;
            font-size: 14px;
            color: #f0883a;
        }

        &-card {
            font-size: 0px;

            &-list {
                margin-right: (885px - (5 * 174px)) / 4;
                margin-bottom: (885px - (5 * 174px)) / 4;
                display: inline-block;
            }

            &-list:nth-child(5n) {
                margin-right: 0px;
            }
        }
    }
</style>