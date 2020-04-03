const path = require('path');

/** gutenberg blocks names */
let blocks = [
	{'slug': 'wall', 'path': 'tools/wall/gutenberg/blocks/wall/'},
];

/** gutenberg plugins names */
let plugins = [];

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
 * gutenberg blocks configuration
 */
for (var block of blocks) {
	configs.push(Object.assign({}, config, {
		name: block.slug,
		entry: './src/'+block.path+'index.jsx',
		output: {
			path: path.resolve(__dirname, 'src/' + block.path),
			filename: 'build.js'
		},
	}));
}

/** return configurations */
module.exports = configs;
