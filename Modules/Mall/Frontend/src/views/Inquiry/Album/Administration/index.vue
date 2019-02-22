<template>
    <div class="administration">
        <v-title title="Manage Photos"></v-title>

        <v-table-switch title="My Album" style="marginBottom: 20px;"></v-table-switch>

        <div>
            <button type="button" class="administration-btn" style="marginRight: 10px;" @click="uploadShow=true">Upload Picture</button>
            <button type="button" class="administration-btn" @click="createShow=true">Create Album</button>
        </div>

        <template>
            <div class="administration-main">
                <v-card-template
                    :fromData="item"
                    @on-get="onGetAlbumList"
                    v-for="(item, index) in fromAlbum"
                    :key="index"
                    class="administration-main-card">
                </v-card-template>
            </div>
        </template>

        <template>
            <v-create @on-show="onCreateShow" v-show="createShow"></v-create>
        </template>

        <template>
            <v-upload @on-show="onUploadShow" v-show="uploadShow" :AlbumListId="fromAlbum | FiltersAlbumListId"></v-upload>
        </template>

        <section style="marginTop:20px;">
            <template>
                <Page :total="total.total" :page-size="8" style="textAlign: center" @on-change="onPages"/>
            </template>
        </section>
    </div>
</template>

<script>
    import Img from "@/components/Img"
    import Title from "../../components/Title"
    import TableSwitch from "../../components/TableSwitch/index.vue"
    import CardTemplateVue from '../components/Card-template.vue';
    import CreateAlbum from '../CreateAlbum/index.vue'
    import UploadAlbum from '../UploadAlbum/index.vue'
    
    export default {
        data() {
            return {
                createShow: false,
                uploadShow: false,
                fromAlbum: [],
                total: {
                    size: 8,
                    total: 0,
                    num: 1
                },
                data: []
            }
        },
        filters: {
            FiltersAlbumListId(data) {
                const AlbumId = []
                console.log(data);
                
                for(let i of data) {
                    AlbumId.push({ label: i.album_name, value: i.id })
                }
                
                return AlbumId
            }
        },
        methods: {
            onCreateShow(index) {
                this.onGetAlbumList()
                this.createShow = false
            },
            onUploadShow(index) {
                this.uploadShow = false
            },
            onGetAlbumList() {
                this.$request(
                    {
                        url: '/album/album_list',
                        method: 'get',
                    }
                ).then(res => {
                    if(res.code == 200) {
                        this.data = res.data
                        this.filterAll(this.data)
                    }
                }).catch(err => {
                    return false
                })
            },
            filterAll(data) {
                this.fromAlbum = []
                const { num, size } = this.total
                const dataFrom = data.slice(num * size - 8, num * size)
                this.total.total = data.length
                dataFrom.forEach((value, index) => {
                    this.fromAlbum.push(value)
                })
            },
            // 分页
            onPages(index) {
                this.$set(this.total, 'num', index)
                this.filterAll(this.data)
            },
        },
        mounted() {
            // 获取相册列表
            this.onGetAlbumList()
        },
        components: {
            "v-title": Title,
            "v-img": Img,
            "v-card-template": CardTemplateVue,
            "v-create": CreateAlbum,
            "v-upload": UploadAlbum,
            "v-table-switch": TableSwitch
        }
    }
</script>

<style lang="less" scoped>
    @import url('../../../../assets/css/index.less');

    .administration {
        .width(945px, auto);
        min-height: 772px;
        .bg-color(white);
        padding: 21px 30px;

        &-btn {
            width: 105px;
            height: 25px;
            background-color: #f0883a;
            font-size: 14px;
            color: #ffffff;
            border: none;
        }

        &-main {
            margin-top: 20px;

            &-card {
                margin-bottom: 20px;
                margin-right: (885px - (4 * 211px)) / 3;
            }

            &-card:nth-child(4n) {
                margin-right: 0px;
            }
        }
    }
</style>