// 更改vuex状态的方法
const mutations = {
    // 个人信息
    SET_USER_INFO(state, data) {
        state.User_Info = data
    },
    // 地区
    SET_COUNTRIES(state) {
        state.Countries = !state.Countries
    },
    // 注册邮箱
    SET_REGEMAIL(state, email) {
        state.RegEmail = email
    },
    // 设置收件箱所有数据
    SET_INBOX_FROM(state, From) {
        state.Inbox_From = From
    },
    // 阿里云oss url前缀
    SET_OSS_URL_CONFIG(state, data) {
        state.Oss_Url_Config = data
    },
    // 选择的分类Id
    SET_CLASSIFICATION(state, id) {
        state.Classification = id
    },
    // 改变搜索的商品数据
    SET_PRODUCT_ALL(state, data) {
        state.Product_All = data
    },
    // 改变搜索的店铺数据
    SET_SHOP_ALL(state, data) {
        state.Shop_All = data
    }
}

export default mutations