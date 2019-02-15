<template>
    <div class="card">
        <figure>
            <!-- <img src="" alt=""> -->
            <v-img width="211" height="167" imgSrc=""></v-img>
            <figcaption class="card-footer">
                <div class="card-footer-title">Default Album</div>
                <div class="card-footer-subheading">Total {{ '1754' }} photos</div>
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
                                <Input v-model="formLeft.input1" placeholder="Default  Album"></Input>
                            </Col>
                        </Row>
                    </FormItem>
                    <FormItem>
                        <Row :gutter="20">
                            <Col span="5" style="textAlign: right;">
                                <span class="createAlbum-text">Description</span>
                            </Col>
                            <Col span="16">
                                <Input v-model="formLeft.input1" type="textarea" :autosize="{minRows: 8,maxRows: 8}" placeholder=""></Input>
                            </Col>
                        </Row>
                    </FormItem>
                </Form>

                <button type="button" class="createAlbum-sub">Submit</button>
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

                },
                editShow: false
            }
        },
        methods: {
            onShow() {
                this.editShow = false
            }
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
        border:1px solid #ccc;
        display: inline-block;
        
        &-footer {
            .flex(center, center);
            flex-direction: column;
            width: 211px;
            height: 54px;
            border: solid 1px #eeeeee;
            // border-top: 0px;

            &-title {
                font-size: 16px;
                color: #666666;
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
