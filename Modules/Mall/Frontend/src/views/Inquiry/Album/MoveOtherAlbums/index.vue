<template>
    <div>
        <v-modality-template title="Move to other album" @on-show="onShow">
            <section slot="main" class="deleteAlbum-main">
                <Row type="flex" :gutter="40" class-name="deleteAlbum-main-row">
                    <Col span="6" class-name="deleteAlbum-main-lable">
                        Select Album
                    </Col>
                    <Col span="18" class-name="deleteAlbum-main-select">
                        <Select v-model="model" style="width:483px" placeholder="Default  Album">
                            <Option v-for="item in fromAlbum" :value="item.id" :key="item.id">{{ item.album_name }}</Option>
                        </Select>
                    </Col>
                </Row>
                <div class="deleteAlbum-main-btn">
                    <button type="button" @click="onSub">Submit</button>
                </div>
            </section>
        </v-modality-template>
    </div>
</template>

<script>
    // 模态框模板
    import ModalityTemplateVue from '../components/Modality-template.vue'

    export default {
        data() {
            return {
                fromAlbum: [],
                model: ''
            }
        },
        props: {
            dataId: {
                type: Array
            }
        },
        methods: {
            onShow(bool) {
                this.$emit('on-show', bool)
            },
            onSub() {
                this.onMove()
            },
            // 移动图片到其他文件夹
            onMove() {
                if(this.model > 0 && this.dataId != false) {
                    this.$request({
                        url: '/album/modify_photos',
                        method: 'post',
                        data: {
                            'photo_id_list': this.dataId,
                            action: 'move',
                            to_album_id: this.model
                        }
                    }).then(res => {
                        if(res.code == 200) {
                            this.onShow(true)

                            this.$Message.info({
                                content: res.message,
                                duration: 3
                            })
                        }else {
                            this.onShow(false)

                            this.$Message.error({
                                content: res.message,
                                duration: 3
                            })
                        }
                    }).catch(err => {
                        return false
                    })
                }else {
                    this.onShow(false)
                }
            },
            // 获取相册文件夹列表
            onGetAlbumList() {
                this.$request(
                    {
                        url: '/album/album_list',
                        method: 'get',
                    }
                ).then(res => {
                    if(res.code == 200) {
                        this.fromAlbum = res.data
                    }
                }).catch(err => {
                    return false
                })
            }
        },
        mounted() {
            this.onGetAlbumList()
        },
        components: {
            "v-modality-template": ModalityTemplateVue
        }
    }
</script>

<style lang="less">
    @import url('../../../../assets/css/index.less');

    .deleteAlbum-main {
        flex-direction: column;
        height: 278px - 70px;
        font-size: 0px;

        &-row {
            padding-top: 45px;
        }

        &-lable {
            font-size: 16px;
            color: #333333;
            line-height: 36px;
            text-align: right;
        }

        &-btn {
            margin-top: 38px;
            text-align: center;

            & > button {
                width: 135px;
                height: 37px;
                background-color: #f0883a;
                font-size: 18px;
                color: #ffffff;
                border: none;
            }
        }
    }

    .ivu-select-dropdown {
        z-index: 10001 !important;
    }
</style>
