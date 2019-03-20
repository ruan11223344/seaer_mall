<template>
    <div>
        <v-modality-template title="Create Album" @on-show="onShow">
            <section slot="main" class="createAlbum">
                 <Form :model="formLeft">
                    <FormItem>
                        <Row :gutter="20">
                            <Col span="5" style="textAlign: right;">
                                <span class="createAlbum-text">Album name</span>
                            </Col>
                            <Col span="16">
                                <Input v-model="formLeft.name"></Input>
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

                <button type="button" class="createAlbum-sub" @click="onCreate">Submit</button>
            </section>
        </v-modality-template>
    </div>
</template>

<script>
    import ModalityTemplateVue from '../components/Modality-template.vue'

    export default {
        data() {
            return {
                formLeft: {
                    name: '',
                    info: ''
                }
            }
        },
        props: {
        },
        methods: {
            // 隐藏模态框
            onShow() {
                this.$emit('on-show', false)
            },
            onCreate() {
                if(this.formLeft.name != '' && this.formLeft.info != '') {
                    this.$request({
                        url: '/album/create_album',
                        method: 'post',
                        data: {
                            album_name: this.formLeft.name,
                            album_description: this.formLeft.info
                        }
                    }).then(res => {
                        if(res.code == 200) {
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
                }else {
                    return false
                }
            }
        },
        components: {
            "v-modality-template": ModalityTemplateVue
        }    
    }
</script>

<style lang="less" scoped>
    @import url('../../../../assets/css/index.less');

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
