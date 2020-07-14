module.exports = {
	publicPath:"http://localhost:4000",
	devServer: {
		disableHostCheck: true,
		proxy: 'http://wp.local/',
		headers: {
		"Access-Control-Allow-Origin": "*",
		"Access-Control-Allow-Methods": "GET, POST, PUT, DELETE, PATCH, OPTIONS",
		"Access-Control-Allow-Headers": "X-Requested-With, content-type, Authorization"
  	}
	},
	configureWebpack: {
    	devtool: 'source-map',
  },
}


/*
	#####################################################################
	Before building with npm run build:
	
	Switch out the public path before build to the following:
	'/wp-content/plugins/merrweb-api/dist/'
	
	Then, in /wp-content/plugins/godat-harvest/godat-harvest.php find the PHP constant 
	'MERRWEBAPI_ENV' and change it to production.
	#####################################################################
	
*/