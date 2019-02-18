<template>
    <div>
        <v-modality-template :title="title" @on-show="onShow">
            <section slot="main" class="deleteAlbum-main">
                <div class="deleteAlbum-main-body">
                    <Form ref="" :model="FormData" :rules="FormData">
                        <FormItem>
                            <Row :gutter="20">
                                <Col span="6" class-name="deleteAlbum-main-body-name">
                                    Name
                                </Col>
                                <Col span="14">
                                    <Input v-model="FormData.value" size="large" placeholder="large size" />
                                </Col>
                            </Row>
                        </FormItem>
                        <FormItem>
                            <Row :gutter="20">
                                <Col span="6" class-name="deleteAlbum-main-body-name">
                                    Sort
                                </Col>
                                <Col span="14">
                                    <Input v-model="FormData.value" size="large" placeholder="large size" />
                                </Col>
                            </Row>
                        </FormItem>
                        <FormItem>
                            <Row :gutter="20">
                                <Col span="6" class-name="deleteAlbum-main-body-name">
                                    Display Status
                                </Col>
                                <Col span="14">
                                     <RadioGroup v-model="disabledGroup">
                                        <Radio label="Yes"></Radio>
                                        <Radio label="No"></Radio>
                                    </RadioGroup>
                                </Col>
                            </Row>
                        </FormItem>
                    </Form>
                </div>
                <div class="deleteAlbum-main-btn">
                    <button type="button">Submit</button>
                </div>
            </section>
        </v-modality-template>
    </div>
</template>

<script>
    // 模态框模板
    import ModalityTemplateVue from '../../Album/components/Modality-template.vue'

    export default {
        data() {
            return {
                FormData: {
                    value: ''
                },
                disabledGroup: 'Yes'
            }
        },
        props: {
            title: ''
        },
        methods: {
            onShow() {
                this.$emit('on-show')
            }
        },
        components: {
            "v-modality-template": ModalityTemplateVue
        }
    }
</script>

<style lang="less" scoped>
    @import url('../../../../assets/css/index.less');

    .deleteAlbum-main {
        .flex(center, center);
        flex-direction: column;
        height: 433px - 70px;

        &-body {
            width: 800px;

            &-name {
                font-size: 16px;
                color: #333333;
                text-align: right;
            }
        }

        &-btn {
            & > button:first-child {
                width: 107px;
                height: 40px;
                background-color: #f0883a;
                font-size: 18px;
                color: #ffffff;
                border: none;
            }
        }
    }
</style>
