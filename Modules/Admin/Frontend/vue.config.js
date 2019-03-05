const path = require('path')

module.exports = {
    css: {
        loaderOptions: { // 向 CSS 相关的 loader 传递选项
            sass: {
                data: `@import "@/style/index.scss";`
            }
        }
    }
}