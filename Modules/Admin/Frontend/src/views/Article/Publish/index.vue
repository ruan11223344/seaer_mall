<template>
    <el-main>
        <el-row :gutter="20" class="block">
            <el-col :span="4" class="title">
                文章类型
            </el-col>
            <el-col :span="6">
                <el-select v-model="select" placeholder="请选择" style="width: 100%">
                    <el-option label="买家注册协议" value="buyers_register_agreement"></el-option>
                    <el-option label="商户注册协议" value="merchants_register_agreement"></el-option>
                    <el-option label="系统公告" value="system_announcement"></el-option>
                    <el-option label="系统文章" value="system_article"></el-option>
                </el-select>
            </el-col>
        </el-row>
        <el-row :gutter="20" class="block">
            <el-col :span="4" class="title">
                标题
            </el-col>
            <el-col :span="6">
                <el-input v-model="title" placeholder="请输入内容"></el-input>
            </el-col>
        </el-row>
        <el-row :gutter="20" class="block" style="height:565px;">
            <el-col :span="4" class="title">
                文章内容
            </el-col>
            <el-col :span="16">
                <quill-editor ref="myTextEditor"
                    class="editor"
                    theme="Snow"
                    v-model="editor"
                    :options="editorOption"
                    >
                </quill-editor>
            </el-col>
        </el-row>
        <el-row :gutter="20" class="block">
            <el-col :span="4" class="title">
                图片上传
            </el-col>
            <el-col :span="6">
                <el-upload
                    action=""
                    multiple
                    :limit="3"
                    :before-upload="onBeforeUpload"
                    >
                    <el-button size="" type="primary">点击上传</el-button>
                </el-upload>
            </el-col>
        </el-row>

        <el-row :gutter="20" class="block">
            <el-col :offset="4" :span="20">
                <figure class="block-box">
                    <img src="" alt="">
                    <figcaption></figcaption>
                </figure>
                <figure class="block-box">
                    <img src="" alt="">
                    <figcaption></figcaption>
                </figure>
                <figure class="block-box">
                    <img src="" alt="">
                    <figcaption></figcaption>
                </figure>
                <figure class="block-box">
                    <img src="" alt="">
                    <figcaption></figcaption>
                </figure>
            </el-col>
        </el-row>

        <el-row :gutter="20" class="block">
            <el-col :offset="4" :span="20">
                <el-button size="" type="primary" @click="onSave">确认提交</el-button>
            </el-col>
        </el-row>
    </el-main>
</template>

<script>
    import { quillEditor } from 'vue-quill-editor'
    // 富文本编辑器
    import 'quill/dist/quill.core.css'
    import 'quill/dist/quill.snow.css'
    import 'quill/dist/quill.bubble.css'

    export default {
        data() {
            return {
                // 编辑器
                editorOption: {
                    modules: {
                        toolbar: [
                            [
                                'bold', 'italic', 'underline', 'strike'
                            ],
                            [
                                'blockquote', 'code-block'
                            ],
                            [
                                { 'header': 1 }, { 'header': 2 }
                            ],
                            [
                                { 'list': 'ordered' }, { 'list': 'bullet' }
                            ],
                            // [
                            //     // { 'script': 'sub' }, { 'script': 'super' }
                            // ],
                            [
                                { 'indent': '-1' }, { 'indent': '+1' }
                            ],
                            [
                                { 'direction': 'rtl' }
                            ],
                            [
                                { 'size': ['small', false, 'small', 'huge'] }
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
                                { 'align': [] }
                            ]
                        ]
                    }
                },
                title: '',
                editor: '',
                select: ''
            }
        },
        methods: {
            onBeforeUpload(file) {
                this.$PutRequest.putUploadImg(file)
                    .then(({ url }) => {
                        this.editor = this.editor + `<p><img src="${url}"></p>`
                    })
                    .catch(err => {
                        this.$message.error(err.message)
                    })
                return false
            },
            // 发布
            onSave() {
                const data = {
                    // 文章类型   四个值可选 buyers_register_agreement,merchants_register_agreement,system_announcement,system_article
                    "type": this.select,
                    // 必填!
                    "content": this.editor,
                    // 标题 非必填！
                    "title": this.title
                }

                this.$PutRequest.putProductArticle(data)
                    .then(res => {
                        this.$router.go(-1)
                    })
                    .catch(err => {
                        this.$message.error(err.message);
                    })
            }
        },
        created() {
            this.select = this.$route.query.type
        },
        components: {
            quillEditor
        }
    }
</script>

<style lang="scss" scoped>

    .block {
        margin-bottom: 25px;

        .title {
            font-size: 16px;
            height: 40px;
            line-height: 40px;
            text-align: right;
            @include mixin-color(grey);
        }

        .editor {
            height: 500px;
        }

        &-box {
            width: 104px;
            height: 136px;
            border: solid 1px #eeeeee;
            display: inline-block;
            margin-right: 35px;
            @include mixin-bg-color(white);
        }

        &-box:last-child {
            margin-right: 0px;
        }
    }
</style>
