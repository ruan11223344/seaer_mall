<template>
    <div>
        
    </div>
</template>

<script>
    export default {
        data() {
            return {
                tableData: {}
            }
        },
        created() {
            const obj = JSON.parse(this.$route.query.obj)

            this.tableData = obj
        }
    }
</script>

<style lang="scss" scoped>

</style>
