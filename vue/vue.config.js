module.exports = {
	publicPath:"/wp-content/plugins/merrweb-esbd/dist/",
	filenameHashing: false,
}

/*
	#####################################################################
	Before building with npm run build:
	
	Switch out the public path before build to the following:
	'/wp-content/plugins/merrweb-api/dist/'
	
	Then, in /wp-content/plugins/merrweb-api/werrweb-api.php find the PHP constant 
	'MERRWEBAPI_ENV' and change it to production.
	#####################################################################
	
*/