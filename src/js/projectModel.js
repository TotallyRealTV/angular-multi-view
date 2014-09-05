/**
 * @description Jonathan Blackburn : Developer
 * @version 0.0.1
 * @author Jonathan Blackburn <jonathan.m.blackburn@gmail.com>
 * @license MIT
 * @year 2014
 *
 * @projectModel.js
 * @model for an individual project view
 */
	
	/**
	 *	ProjectModel
	 *	- provides data for an individual project view
	 *	- should only be available to pages/project.html
	 */
	angular.module('jbApp').service("projectModel", [function() {
		this.id = null;
		this.data = null;
		
		this.setId = function(value) {
			this.id = value;	
		}
		
		this.setData = function(value) {
			this.data = value;	
		}
	}]);
