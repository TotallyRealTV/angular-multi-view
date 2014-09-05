/**
 * @description Jonathan Blackburn : Developer
 * @version 0.0.1
 * @author Jonathan Blackburn <jonathan.m.blackburn@gmail.com>
 * @license MIT
 * @year 2014
 *
 * @topPageModel.js
 * @model for work history and about pages
 */
	
	/**
	 *	@topPageModel
	 *	@houses data for a top-level section view
	 */
	angular.module('jbApp').service("topPageModel", [function() {
		this.id = null;
		this.data = null;
		
		this.setId = function(value) {
			this.id = value;	
		}
		
		this.setData = function(value) {
			this.data = value;	
		}
	}]);
