<template>
    <div>
        <v-modality-template title="Move to other album" @on-show="onShow">
            <section slot="main" class="deleteAlbum-main">
                <Row type="flex" :gutter="40" class-name="deleteAlbum-main-row">
                    <Col span="6" class-name="deleteAlbum-main-lable">
                        Select Album
                    </Col>
                    <Col span="18" class-name="deleteAlbum-main-select">
                        <Select v-model="model1" style="width:483px" placeholder="Default  Album">
                            <Option v-for="item in cityList" :value="item.value" :key="item.value">{{ item.label }}</Option>
                        </Select>
                    </Col>
                </Row>
                <div class="deleteAlbum-main-btn">
                    <button type="button">Submit</button>
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
            onShow() {
                this.$emit('on-show')
            }
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
