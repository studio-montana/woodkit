const path = require('path');

/** gutenberg modules declaration */
let gutenberg_modules = [
	{'entry': 'index.js', 'name': 'commons', 'path': 'gutenberg/stores/commons/'}, // commons store
	{'entry': 'index.jsx', 'name': 'wall', 'path': 'tools/wall/gutenberg/blocks/wall/'}, // wall tool's block
	{'entry': 'index.jsx', 'name': 'seometa', 'path': 'tools/seo/gutenberg/plugins/seometa/', 'entry': 'index.jsx'}, // seo tool's metabox
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
		name: gutenberg_module.name,
		entry: './src/'+gutenberg_module.path+gutenberg_module.entry,
		output: {
			path: path.resolve(__dirname, 'src/' + gutenberg_module.path),
			filename: 'build.js'
		},
	}));
}

/** return configurations */
module.exports = configs;
