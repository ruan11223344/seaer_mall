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
                                <Input v-model="formLeft.input1"></Input>
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
    import ModalityTemplateVue from '../components/Modality-template.vue'

    export default {
        data() {
            return {
                formLeft: {

                }
            }
        },
        props: {
        },
        methods: {
            // 隐藏模态框
            onShow() {
                this.$emit('on-show', false)
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
