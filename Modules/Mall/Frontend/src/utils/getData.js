import request from './request'

class getData {
    async getProvinceAddress(code) { // 获取省份地址
        return await new Promise((resolve, reject) => {
            request({
                url: '/utils/get_provinces_list',
                params: {
                    country_code: code // 国家代码
                }
            }).then(res => {
                resolve(res)
            }).catch(err => {
                reject(err)
            })
        })
    }

    async getCityAddress() { // 获取城市地址
        
    }
}

export default getData