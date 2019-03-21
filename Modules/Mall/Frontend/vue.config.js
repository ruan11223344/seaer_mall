const debug = process.env.NODE_ENV !== 'production'

module.exports = {
    css: {
        loaderOptions: { // 向 CSS 相关的 loader 传递选项
            less: {
                javascriptEnabled: true
            }
        }
    },
    // proxy API requests to Valet during development
    devServer: {
        // proxy: 'http://laracon.test'
        overlay: {
            warnings: false,
            errors: true
        }
    },
    publicPath: process.env.NODE_ENV === 'production' ? '/mall' : '/',
    // output built static files to Laravel's public dir.
    // note the "build" script in package.json needs to be modified as well.
    // 输出目录
    outputDir: '../public',
    // 静态资源目录
    // assetsDir: '../../public',
    configureWebpack: (config) => {
        if (debug) { // 开发环境配置
            config.devtool = 'cheap-module-eval-source-map'
        } else { // 生产环境配置
            config.devtool = 'cheap-module-source-map'
        }
    },
    pluginOptions: {

    },
    // 不生成map
    productionSourceMap: true,
    // modify the location of the generated HTML file.
    // make sure to do this only in production.
    indexPath: process.env.NODE_ENV === 'production' ? '../Resources/views/index.blade.php' : 'index.html'
}