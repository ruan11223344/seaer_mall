<template>
    <div>
        <v-modality-template title="Select album" @on-show="onShow">
            <section slot="main" class="uploadAlbum">
                <Form :model="formLeft">
                    <FormItem>
                        <Row :gutter="20">
                            <Col span="6" style="textAlign: right;">
                                <span class="uploadAlbum-text">Select album</span>
                            </Col>
                            <Col span="16">
                                <Select v-model="formLeft.model" :style="{ width: '100%' }" placeholder="Default  Album">
                                    <Option v-for="(item, index) in AlbumListId" :value="item.value" :key="index">{{ item.label }}</Option>
                                </Select>
                            </Col>
                        </Row>
                    </FormItem>
                    <FormItem>
                        <Row :gutter="20">
                            <Col span="6" style="textAlign: right;">
                                <span class="uploadAlbum-text">Select  File</span>
                            </Col>
                            <Col span="16">
                                <Row>
                                    <Col span="24">
                                        <template>
                                            <Upload
                                                multiple
                                                action=""
                                                :before-upload="onBeforeUpload"
                                                >
                                                <button type="button" class="uploadAlbum-sub">Upload</button>
                                            </Upload>
                                        </template>
                                    </Col>
                                    <Col span="24">
                                        <p class="uploadAlbum-tips">I supports jpg, gif, png format, which does not exceed 1MB. </p>
                                    </Col>
                                </Row>
                            </Col>
                        </Row>
                    </FormItem>
                </Form>
            </section>
        </v-modality-template>
    </div>
</template>

<script>
    import ModalityTemplateVue from '../components/Modality-template.vue'

    export default {
        data () {
            return {
                formLeft: {
                    model: '',
                    files: []
                },
            }
        },
        props: {
            AlbumListId: {
                type: Array,
            }
        },
        methods: {
            // 隐藏模态框
            onShow() {
                this.$emit('on-show', false)
            },
            onBeforeUpload(files) {
                const arr = (files.name.split('.'))
                const name = arr[arr.length - 1]
                // 判断上传图片是否符合格式
                if(files.size > 1048576 || !(['jpg','gif','png'].includes(name))) { // 图片大于1M
                    this.onShow()
                    this.$Message.warning('I supports jpg, gif, png format, which does not exceed 1MB. ')
                }else {
                    // 获取图片
                    this.formLeft.files = files
                    this.onUpload()
                }
                // 阻止默认上传
                return false;
            },
            // 上传图片到阿里云
            onUpload() {
                let formData = new FormData();

                formData.append('images[]', this.formLeft.files);

                this.$request({
                    url: '/album/upload_img_to_album',
                    method: 'post',
                    data: formData,
                    headers:{'Content-Type':'multipart/form-data'}
                }).then(res => {
                    if(res.code == 200) {
                        this.onPreservation(res.data)
                    }else {
                        this.$Message.error({
                            content: res.message,
                            duration: 3
                        })
                    }
                }).catch(err => {
                    return false
                })
            },
            // 保存上传图片到目录
            onPreservation(data) {
                const name = data.name

                this.$request({
                    url: '/album/save_img_to_album',
                    method: 'post',
                    data: {
                        "photo_name_url_list": [data],
                        "album_id": this.formLeft.model
                    }
                }).then(res => {
                    if(res.code == 200) {
                        this.onShow()
                        this.$Message.info({
                            content: name + ',' + res.message,
                            duration: 3
                        })
                    }else {
                        this.onShow()
                        this.$Message.error({
                            content: name + ',' + res.message,
                            duration: 3
                        })
                    }
                }).catch(err => {
                    return false
                })
            }
        },
        mounted() {
            
        },
        components: {
            "v-modality-template": ModalityTemplateVue
        },
    }
</script>

<style lang="less">
    @import url('../../../../assets/css/index.less');

    .uploadAlbum {
        height: auto;
        padding-top: 40px;

        &-text {
            font-size: 16px;
            color: #333333;
        }

        &-sub {
            width: 174px;
            height: 40px;
            background-color: #f0883a;
            border: none;
            font-size: 18px;
            color: #ffffff;
            // margin: 44px auto;
        }

        &-tips {
            font-size: 14px;
            color: #999999;
        }
    }

    .ivu-select-dropdown {
        z-index: 10001 !important;
    }
</style>
