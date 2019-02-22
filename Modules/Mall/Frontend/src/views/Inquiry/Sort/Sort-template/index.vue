<template>
    <div>
        <v-modality-template :title="title" @on-show="onShow">
            <section slot="main" class="deleteAlbum-main">
                <div class="deleteAlbum-main-body">
                    <Form ref="" :model="FormData" :rules="RuleData">
                        <FormItem>
                            <Row :gutter="20">
                                <Col span="6" class-name="deleteAlbum-main-body-name">
                                    Name
                                </Col>
                                <Col span="14">
                                    <Input v-model="FormData.name" size="large" placeholder="large size" />
                                </Col>
                            </Row>
                        </FormItem>
                            <Row :gutter="20">
                                <Col span="6" class-name="deleteAlbum-main-body-name">
                                    Sort
                                </Col>
                                <Col span="14">
                                    <FormItem prop="sort">
                                        <Input type="text" :number="true" v-model="FormData.sort" size="large" placeholder="large size" />
                                    </FormItem>
                                </Col>
                            </Row>
                        <FormItem>
                            <Row :gutter="20">
                                <Col span="6" class-name="deleteAlbum-main-body-name">
                                    Display Status
                                </Col>
                                <Col span="14">
                                     <RadioGroup v-model="FormData.active">
                                        <Radio :label="1">{{ 'Yes' }}</Radio>
                                        <Radio :label="0">{{ 'No' }}</Radio>
                                    </RadioGroup>
                                </Col>
                            </Row>
                        </FormItem>
                    </Form>
                </div>
                <div class="deleteAlbum-main-btn">
                    <button type="button" @click="onClick">Submit</button>
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
            const validateSort =  (rule, value, callback) => {
                if (value > 128 || value < 0) {
                    callback(new Error());
                }else {
                    callback()
                }
            }
            return {
                FormData: {
                    name: '',
                    sort: '',
                    active: 1,
                    id: null
                },
                RuleData: {
                    sort: [
                        { type: 'number', message: 'Must be number type || Enter only numbers under 128', validator: validateSort, trigger: 'blur' }
                    ],
                }
            }
        },
        props: {
            title: ''
        },
        methods: {
            onShow() {
                this.$emit('on-show')
            },
            onClick() {
                this.$refs[name].validate((valid) => {
                    if (valid) {
                        this.$emit('on-create', this.FormData)
                        this.$emit('on-show')
                    }
                })
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
                height: 36px;
                line-height: 36px;
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
