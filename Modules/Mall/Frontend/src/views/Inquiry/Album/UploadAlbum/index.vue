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
                                <Select v-model="model1" :style="{ width: '100%' }" :transfer="true" placeholder="Default  Album">
                                    <Option v-for="item in cityList" :value="item.value" :key="item.value">{{ item.label }}</Option>
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
                                        <button type="button" class="uploadAlbum-sub">Upload</button>
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

                },
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
                model1: ''
            }
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
