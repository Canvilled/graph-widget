const path = require( 'path' );
const defaults = require( '@wordpress/scripts/config/webpack.config.js' );

module.exports = {
	...defaults,
	entry: {
		scripts: path.resolve( process.cwd(), 'resources/src', 'main.tsx' ),
	},
	output: {
		filename: '[name].js',
		path: path.resolve( process.cwd(), 'resources/public' ),
	},
	module: {
		...defaults.module,
		rules: [
			...defaults.module.rules,
			{
				test: /\.tsx?$/,
				use: [
					{
						loader: 'ts-loader',
						options: {
							configFile: 'tsconfig.json',
							transpileOnly: true,
						},
					},
				],
			},
		],
	},
	resolve: {
		extensions: [
			'.ts',
			'.tsx',
			...( defaults.resolve
				? defaults.resolve.extensions || [ '.js', '.jsx' ]
				: [] ),
		],
	},
	externals: {
		react: 'React',
		'react-dom': 'ReactDOM',
		"@wordpress/i18n" : ["wp", "i18n"],
		"@wordpress/element" : ["wp", "element"],
		"@wordpress/components" : ["wp"	, "components"],
		"@wordpress/api-fetch" : ["wp"	, "apiFetch"],
	},
};