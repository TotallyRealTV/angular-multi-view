/**
 * @description Jonathan Blackburn : Developer
 * @version 0.0.1
 * @author Jonathan Blackburn <jonathan.m.blackburn@gmail.com>
 * @license MIT
 * @year 2014
 */

	'use strict';
	
	var jbApp = angular.module('jbApp', [
		'ngRoute',
		'ngAnimate', 
		'ngTouch', 
		'jbControllers'
	]);
	 
	jbApp.config(['$routeProvider',
		function($routeProvider, $locationProvider) {
			$routeProvider.
		  	when('/', { 
				templateUrl: 'pages/index.html', 
				activetab: 'projects', 
				controller: 'HomeCtrl' 
			}).
			when('/project/:projectId', {
			  	templateUrl: function (params) { return 'pages/project.html'; },
			  	controller: 'ProjectsCtrl',
			  	activetab: 'projects'
			}).
			when('/work-history', {
			  	templateUrl: 'pages/work-history.html',
			  	controller: 'TopPageCtrl',
			  	activetab: 'work-history'
			}).
			when('/about', {
			  	templateUrl: 'pages/about.html',
			  	controller: 'TopPageCtrl',
			  	activetab: 'about'
			}).
			otherwise({ 
				redirectTo: '/' 
			});
	  	}
	]);
	
	jbApp.config(['$locationProvider', function($location) {
		$location.html5Mode(false).hashPrefix('!');
	}]);