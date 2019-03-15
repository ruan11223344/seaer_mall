<template>
    <el-main>
        <div class="content">
            <p>会员ID：{{ obj.member_id }}</p>
        </div>
        <div class="content">
            <p>联系方式：{{ obj.contact_way }}</p>
        </div>
        <div class="content">
            <p>内容：{{ obj.user_message }}</p>
        </div>
        <div class="content">
            <p>添加时间：{{ obj.add_time }}</p>
        </div>
    </el-main>
</template>

<script>
    export default {
        data() {
            return {
                obj: {}
            }
        },
        created() {
            this.obj = JSON.parse(this.$route.query.obj)
        }
    }
</script>

<style lang="scss" scoped>
    .content {
        font-size: 14px;
        line-height: 1.5;
        color: #666666;
        margin-top: 10px;
    }
</style>
