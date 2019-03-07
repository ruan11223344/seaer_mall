<template>
    <div id="bannerEdit">
        <el-form ref="form" :model="sizeForm" label-width="120px">
            <el-form-item label="广告位名称">
                <el-input v-model="sizeForm.name" style="width: 100%;maxWidth: 658px;"></el-input>
            </el-form-item>
            <el-form-item label="宽度">
                1200
            </el-form-item>
            <el-form-item label="高度">
                150
            </el-form-item>
            <el-form-item label="广告位图片预览">
                <img style="width: 660px; height: 82px;backgroundColor: #eeeeee;display: block;" src="" alt="">
            </el-form-item>
            <el-form-item label="图片上传">
                <el-upload
                    class="upload-demo"
                    action="https://jsonplaceholder.typicode.com/posts/"
                    :on-preview="handlePreview"
                    :on-remove="handleRemove"
                    :before-remove="beforeRemove"
                    multiple
                    :limit="3"
                    :on-exceed="handleExceed"
                    :file-list="fileList">
                    <el-button style="backgroundColor: #dfdfdf;border: none;color: #666666;fontSize: 16px;" type="primary">点击上传</el-button>
                    <div slot="tip" class="tips">系统支持的图片格式为:gif,jpg,jpeg,png</div>
                </el-upload>
            </el-form-item>
            <el-form-item label="URL 跳转">
                <el-input v-model="sizeForm.name" style="width: 100%;maxWidth: 658px;"></el-input>
            </el-form-item>
            <el-form-item label="广告状态">
                <template>
                    <el-radio v-model="radio" label="1">开启</el-radio>
                    <el-radio v-model="radio" label="2">关闭</el-radio>
                </template>
                <div>可将广告关闭,将不会显示广告,开启则显示</div>
            </el-form-item>
        </el-form>

        <el-button type="primary" @click="onSubmit">确认提交</el-button>

    </div>
</template>

<script>
  export default {
    data() {
      return {
        radio: '1',
        sizeForm: {
          name: '',
          region: '',
          date1: '',
          date2: '',
          delivery: false,
          type: [],
          resource: '',
          desc: ''
        }
      };
    },
    methods: {
      onSubmit() {
        console.log('submit!');
      }
    }
  };
</script>

<style lang="scss" scoped>

    #bannerEdit {
        margin-top: 60px;
        @include mixin-flex(center, center, column);

        .tips {
            font-size: 14px;
            color: #999999;
        }
    }
</style>
