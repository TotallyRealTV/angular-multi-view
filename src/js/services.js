/**
 *	jsServices.js
 *	- defines services for jb
 *
 *	Contact:
 *	http://localhost/api/?section=contact&formAction=sendmail&language=en
 *
 *	JSON Request:
 *	/jb/data/:id.json
 *	
 */

	'use strict';
	
	
	/**
	 *	define jbServices depedency
	 */
	var jbServices = angular.module('jbServices', ['ngResource']);
	
	
	/** 
	 *	jbServices: toonFeud
	 *	- all API services
	 */ 
	jbServices.factory('apiRequest', ['$resource',
		function($resource){
			
			return $resource('/api', {}, 
			{
			query: {
				method:'POST', 
				params:{
					section:'contact', 
					formAction:'sendmail', 
					language:'en',
					name:"@name",
					email:"@email",
					text:"@text"
				}, 
				isArray:false
			}
		});
	}]);
	
	/** 
	 *	jbServices: fileRequest
	 *	- json individual project json requests
	 */
	jbServices.factory('fileRequest', ['$resource',
		function($resource){
			return $resource('/data/:id.json', {id:'@id'}, 
			{
			get: {
				method:'POST', 
				isArray:false
			}
		});
	}]);
	
	/** 
	 *	jbServices: projectsIndex
	 *	- json projects index request
	 *	- NOTE: this implementation allows us to inject the projects-index.json data across multiple controllers
	 */
	jbServices.factory('projectsIndex', ['$http',
		function($http){
    		return $http.get('/data/projects-index.json').then(function(result) 
			{
       			var projectData = result.data;
       			return projectData; 
    		});
		}
	]);