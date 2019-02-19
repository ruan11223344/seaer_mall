<template>
    <div class="navList">
        <!-- <div class="navList-title">
            <button type="button">Add Navigation</button>
        </div> -->
        <div class="navList-table">
            <div class="navList-table-head">
                <div>Sort</div>
                <div>Navigation Name</div>
                <div>Whether to show</div>
                <div>Operation</div>
            </div>
            <div class="navList-table-body">
                <div class="navList-table-body-list" style="borderTopWidth: 1px ">
                    <div>1</div>
                    <div>Products</div>
                    <div>YES</div>
                    <div class="navList-table-body-list-btns">
                            -
                    </div>
                </div>
                <div class="navList-table-body-list">
                    <div>2</div>
                    <div>Company Overview</div>
                    <div>YES</div>
                    <div class="navList-table-body-list-btns">
                        <button type="button">Edit</button>
                    </div>
                </div>
                <div class="navList-table-body-list">
                    <div>3</div>
                    <div>Contact</div>
                    <div>YES</div>
                    <div class="navList-table-body-list-btns">
                        <router-link tag="button" to="/inquiryList/companyedit">Edit</router-link>
                        <!-- <button type="button">Edit</button> -->
                    </div>
                </div>
            </div>
        </div>
        
        <!-- <section style="marginTop:20px;">
            <template>
                <Page :total="100" :page-size="8" style="textAlign: center" />
            </template>
        </section> -->

        <!-- 富文本编辑 -->
        <!-- <v-modality-template title="Company Overview">
            <div slot="main" class="navList-edit">
                <quill-editor ref="myTextEditor"
                    class="navList-edit-editor"
                    theme="Snow"
                    v-model="editor"
                    :options="editorOption"
                    >
                </quill-editor>

                <button type="button" class="navList-edit-Preservation">Preservation</button>
            </div>
        </v-modality-template> -->
    </div>
</template>

<script>
    import ModalityTemplate from '../../Album/components/Modality-template.vue'
    // 富文本编辑器
    import 'quill/dist/quill.core.css'
    import 'quill/dist/quill.snow.css'
    import 'quill/dist/quill.bubble.css'
    import { quillEditor } from 'vue-quill-editor'

    export default {
        data() {
            return {
                editor: null,
                // 编辑器
                editorOption: {
                    modules: {
                        toolbar: [
                            [
                                'bold', 'italic', 'underline', 'strike'
                                // 'bold', 'italic', 'underline'
                            ],
                            [
                                // 'blockquote', 'code-block',
                                'blockquote'
                            ],
                            [
                                { 'header': 1 }, { 'header': 2 }
                            ],
                            // [
                            //     { 'list': 'ordered' }, { 'list': 'bullet' }
                            // ],
                            [
                                { 'script': 'sub' }, { 'script': 'super' }
                            ],
                            [
                                { 'indent': '-1' }, { 'indent': '+1' }
                            ],
                            [
                                { 'direction': 'rtl' }
                            ],
                            [
                                { 'size': ['small', false, 'large', 'huge'] }
                            ],
                            [
                                { 'header': [1, 2, 3, 4, 5, 6, false] }
                            ],
                            [
                                { 'font': [] }
                            ],
                            [
                                { 'color': [] }, { 'background': [] }
                            ],
                            [
                                { 'color': [] }
                            ],
                            [
                                { 'align': [] }
                            ],
                            // ['clean'],
                            // ['link', 'image', 'video']
                            ['image']
                        ],
                        // syntax: {
                        //     // highlight: text => hljs.highlightAuto(text).value
                        // }
                    }
                },
            }
        },
        components: {
            "v-modality-template": ModalityTemplate,
            quillEditor
        }
    }
</script>

<style lang="less" scoped>
    @import url('../../../../assets/css/index.less');

    .navList {

        // &-title {
        //     & > button {
        //         width: 113px;
        //         height: 25px;
        //         background-color: #f0883a;
        //         font-size: 14px;
        //         color: #ffffff;
        //         border: none;
        //         margin-top: 20px;
        //         margin-bottom: 10px;
        //     }
        // }

        &-table {
            margin-top: 20px;

            &-head {
                width: 100%;
                height: 47px;
                background-color: #f5f5f9;
                .flex(space-between, center);

                & > div {
                    width: 25%;
                    text-align: center;
                    font-size: 14px;
                    color: #666666;
                }
            }

            &-body {

                &-list {
                    width: 100%;
                    height: 60px;
                    border: solid 1px #e0e0e0;
                    border-top-width: 0px;
                    .flex(space-between, center);

                    & > div {
                        width: 25%;
                        text-align: center;
                        font-size: 14px;
                        color: #666666;
                    }

                    &-btns {
                        
                        & > button {
                            font-size: 12px;
                            height: 21px;
                            border: none;
                        }

                        // & > button:first-child {
                        //     width: 53px;
                        //     border: solid 1px #f0883a;
                        //     color: #f0883a;
                        //     background-color: #ffffff;
                        // }

                        & > button:last-child {
                            width: 53px;
                            background-color: #f0883a;
                            color: #ffffff;
                            // margin-left: 20px;
                        }
                    }
                }
            }
        }

        &-edit {
            width: 802px;
            height: 500px;
            position: relative;

            &-editor {
                width: 802px;
                height: 350px - 42px;
                border: none !important;
            }

            &-Preservation {
                background-color: #f0883a;
                color: #ffffff;
                border: none;
                padding: 8px 15px;
                position: absolute;
                left: 50%;
                bottom: 45px;
                transform: translateX(-50%);
            }
        }
    }
</style>
