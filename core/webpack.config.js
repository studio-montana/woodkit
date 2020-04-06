const path = require('path');

/** gutenberg modules declaration */
let gutenberg_modules = [
	{'slug': 'wall', 'path': 'tools/wall/gutenberg/blocks/wall/'},
	{'slug': 'seometa', 'path': 'tools/seo/gutenberg/plugins/seometa/'},
];

/** all configurations */
let configs = [];

/** common configuration */
var config = {
	module: {
		rules: [
			{
				test: /\.jsx?$/,
				exclude: /node_modules/,
				use: "babel-loader"
			}
		]
	},
	resolve: {
		alias: {
		  wkgcomponents: path.resolve(__dirname, 'src/gutenberg/components/'), // import ... from 'wkgcomponents/...'
		},
    	extensions: ['.js', '.jsx'], // import without extension
	}
};

/**
 * gutenberg modules configuration
 */
for (var gutenberg_module of gutenberg_modules) {
	configs.push(Object.assign({}, config, {
		name: gutenberg_module.slug,
		entry: './src/'+gutenberg_module.path+'index.jsx',
		output: {
			path: path.resolve(__dirname, 'src/' + gutenberg_module.path),
			filename: 'build.js'
		},
	}));
}

/** return configurations */
module.exports = configs;
