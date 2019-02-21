<template>
    <div class="card">
        <figure>
            <router-link :to="'/inquiryList/Album/listalbum?id=' + fromData.id + '&name=' + fromData.album_name + '&description=' + album_description" tag='div' style="margin: 40px 60px;cursor: pointer;">
                <v-img width="91" height="81" :imgSrc="require('@/assets/img/wenjianj.png')"></v-img>
            </router-link>
            <figcaption class="card-footer">
                <div class="card-footer-title">{{ fromData.album_name }}</div>
                <div class="card-footer-subheading">Total {{ len }} photos</div>
            </figcaption>
        </figure>
        <button type="button" class="card-edit" @click="editShow=true">Edit</button>

        <!-- 模态框 -->
        <v-modality-template title="Edit Album" @on-show="onShow" v-show="editShow">
            <section slot="main" class="createAlbum">
                 <Form :model="formLeft">
                    <FormItem>
                        <Row :gutter="20">
                            <Col span="5" style="textAlign: right;">
                                <span class="createAlbum-text">Album name</span>
                            </Col>
                            <Col span="16">
                                <Input v-model="formLeft.name" placeholder="Default  Album"></Input>
                            </Col>
                        </Row>
                    </FormItem>
                    <FormItem>
                        <Row :gutter="20">
                            <Col span="5" style="textAlign: right;">
                                <span class="createAlbum-text">Description</span>
                            </Col>
                            <Col span="16">
                                <Input v-model="formLeft.info" type="textarea" :autosize="{minRows: 8,maxRows: 8}" placeholder=""></Input>
                            </Col>
                        </Row>
                    </FormItem>
                </Form>

                <button type="button" class="createAlbum-sub" @click="onEdit">Submit</button>
            </section>
        </v-modality-template>
    </div>
</template>

<script>
    import Img from "@/components/Img"
    import ModalityTemplateVue from './Modality-template.vue';


    export default {
        data() {
            return {
                formLeft: {
                    name: '',
                    info: '',
                },
                len: 0,
                editShow: false
            }
        },
        props: {
            fromData: {
                type: Object
            }
        },
        methods: {
            onShow() {
                this.editShow = false
            },
            // 获取图片列表
            onGetAlbumList() {
                this.$request({
                    url: '/album/album_photo_list',
                    method: 'get',
                    params: {
                        album_id: this.fromData.id
                    }
                }).then(res => {
                    console.log(res);

                    if(res.code == 200) {
                        this.len = this.res.data.length
                    }
                }).catch(err => {
                    return false
                })
            },
            // 修改相册
            onEdit() {
                this.$request({
                    url: '/album/edit_album',
                    method: 'post',
                    data: {
                        album_id: this.fromData.id,
                        album_name: this.formLeft.name,
                        album_description: this.formLeft.info
                    }
                }).then(res => {
                    
                    if(res.code == 200) {
                        this.$emit('on-get')
                        this.$Message.info({
                            content: res.message,
                            duration: 3
                        })
                        this.onShow()
                    }else {
                        this.$Message.error({
                            content: res.message,
                            duration: 3
                        })
                        this.onShow()
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
            "v-img": Img,
            "v-modality-template": ModalityTemplateVue
        }
    }
</script>

<style lang="less" scoped>
    @import url('../../../../assets/css/index.less');

    .card {
        width: 211px;
        // border:1px solid #ccc;
        display: inline-block;
        
        &-footer {
            .flex(center, center);
            flex-direction: column;
            width: 211px;
            height: 54px;
            // border: solid 1px #eeeeee;
            // border-top: 0px;

            &-title {
                font-size: 16px;
                color: #666666;
                cursor: pointer;
            }

            &-subheading {
                font-size: 12px;
                color: #999999;
            }
        }

        &-edit {
            display: block;
            width: 50px;
            height: 19px;
            background-color: #f0883a;
            border: none;
            font-size: 14px;
            color: #ffffff;
            margin: 0px auto;
            margin-top: 13px;
        }
    }

    .createAlbum {
        height: auto;
        padding-top: 40px;

        &-text {
            font-size: 16px;
            color: #333333;
        }

        &-sub {
            width: 107px;
            height: 40px;
            background-color: #f0883a;
            border: none;
            font-size: 18px;
            color: #ffffff;
            display: block;
            margin: 44px auto;
        }
    }
</style>
