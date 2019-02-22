<template>
    <div id="app">
        <router-view/>
    </div>
</template>

<script>
import { mapMutations, mapState  } from 'vuex'

export default {
    computed: {
        ...mapState(['oss_url_prefix'])
    },
    methods: {
        ...mapMutations([ 'SET_OSS_URL_CONFIG' ]),
        onGetConfig() {
            if(this.oss_url_prefix == "") {
                this.$request({
                    url: "/get_sys_config"
                }).then(res => {
                    if(res.code == 200) {
                        this.SET_OSS_URL_CONFIG(res.data.oss_url_prefix)
                    }
                }).catch(err => {
                    return false;
                })
            }
        }
    },
    mounted() {
        this.onGetConfig()
    }
};
</script>

<style lang="less">
    * {
        letter-spacing: 0px;
        padding: 0px;
        margin: 0px;
        font-family: Arial;
    }
</style>