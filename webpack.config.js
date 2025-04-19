const path = require('path');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const TerserPlugin = require('terser-webpack-plugin');
const CssMinimizerPlugin = require('css-minimizer-webpack-plugin');

module.exports = (env, argv) => {
    const isProduction = argv.mode === 'production';

    return {
        entry: {
            'thesampleplugincore-admin': './src/admin/index.js',
            'thesampleplugincore-public': './src/public/index.js',
        },
        output: {
            filename: 'js/[name].js',
            path: path.resolve(__dirname, 'build'),
            clean: true
        },
        devtool: isProduction ? false : 'source-map',
        module: {
            rules: [
                {
                    test: /\.js$/,
                    exclude: /node_modules/,
                    use: {
                        loader: 'babel-loader',
                        options: {
                            presets: ['@babel/preset-env']
                        }
                    }
                },
                {
                    test: /\.scss$/,
                    use: [
                        MiniCssExtractPlugin.loader,
                        'css-loader',
                        {
                            loader: 'sass-loader',
                            options: {
                                sassOptions: {
                                    outputStyle: 'compressed',
                                },
                                implementation: require('sass'),
                            }
                        }
                    ]
                }
            ]
        },
        optimization: {
            minimizer: [
                new TerserPlugin({
                    extractComments: false,
                    terserOptions: {
                        format: {
                            comments: false,
                        },
                        compress: {
                            drop_console: isProduction,
                        },
                    },
                }),
                new CssMinimizerPlugin()
            ],
            minimize: isProduction
        },
        plugins: [
            new MiniCssExtractPlugin({
                filename: 'css/[name].css'
            })
        ]
    };
};
