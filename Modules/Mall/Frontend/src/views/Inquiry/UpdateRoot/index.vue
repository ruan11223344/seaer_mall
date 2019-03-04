<template>
    <div>
        <router-view></router-view>
    </div>
</template>

<script>
    import { mapState } from 'vuex'

    export default {
        computed: {
            ...mapState([ 'User_Info' ])
        },
        beforeRouteEnter : (to, from, next) => {
            next(vm => {
                if(to.path == "/inquiryList/uploadroot/tips") {
                    return true
                }else {
                    const bool = vm.User_Info.publish_product.status
                    if(bool) {
                        return true
                    }else {
                        return vm.$router.push('/inquiryList/uploadroot/tips')
                    }
                }
            })
        }
    }
</script>

<style lang="less" scoped>

</style>
