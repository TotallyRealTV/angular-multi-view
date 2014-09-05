/**
 * @description Jonathan Blackburn : Developer
 * @version 0.0.1
 * @author Jonathan Blackburn <jonathan.m.blackburn@gmail.com>
 * @license MIT
 * @year 2014
 *
 * @models.js
 * @define models
 */
	
	/**
	 *	HomeModel
	 *	- provides data for flexible grid layout on projects index page
	 *	- should only be available to pages/index.html
	 */
	angular.module('jbApp').service("homeModel", [function() {
	
		this.containerDiv = "#container";
		this.cols = 0;
		this.containerWidth = 0;
		
		
		this.setBlockProps = function() {
			var winWidth = $(window).width();
			
			if (winWidth < 440) {
				this.containerWidth = 220;
				this.cols = 1;		
			} else if(winWidth < 660) {
				this.containerWidth = 440;
				this.cols = 2
			} else if(winWidth < 880) {
				this.containerWidth = 660;
				this.cols = 3
			} else if(winWidth < 1100) {
				this.containerWidth = 880;
				this.cols = 4;
			} else if (winWidth < 1320) {
				this.containerWidth = 1100;
				this.cols = 5
			} else if (winWidth < 1540) {
				this.containerWidth = 1320;
				this.cols = 6;
			} else if (winWidth < 1760) {
				this.containerWidth = 1540;
				this.cols = 7;
			} else {
				this.containerWidth = 1760;
				this.cols = 8;	
			}
		}
		
		/**
		 *	updateBlocksView
		 *	- updates width of containerDiv
		 */
		this.updateBlocksView = function() {
			var currentWidth = $(window).width();
			if(this.containerWidth != currentWidth) {
				$(this.containerDiv).width(this.containerWidth);
			}	
		}
		
		/**
		 *	updateContainer
		 *	- unofficial facade method accessed by Controller
		 */
		this.updateContainer = function() {
			this.setBlockProps();
			this.updateBlocksView();
		}
	}]);
