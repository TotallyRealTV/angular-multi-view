/**
 * @description Jonathan Blackburn : Developer
 * @version 0.0.1
 * @author Jonathan Blackburn <jonathan.m.blackburn@gmail.com>
 * @license MIT
 * @year 2014
 */
	/**
	 *	define toonFeudControllers
	 */
	
	var jbControllers = angular.module('jbControllers', ['jbServices']);

	/**
	 *	AppCtrl
	 *	- Top-level controller. All other controllers are children (grand children, etc)
	 *	- manages any views that might be common to more than one page
	 */
	jbControllers.controller('AppCtrl', ['$scope', '$http', '$browser', '$window', '$timeout', '$route', '$location', 'apiRequest', function ($scope, $http, $browser, $window, $timeout, $route, $location, apiRequest) {
		$scope.master = {};
		
		/**
		 *	route to a new section
		 */
		$scope.$on("$routeChangeSuccess", function (scope, next, current) {
        	$scope.part = $route.current.activetab;
			$window.ga('send', $location.path());
		});

		/**
		 *	form methods
		 */
        $scope.showForm = function () {
        	$('.contactRow').slideToggle();
        };
        $scope.closeForm = function () {
          	$('.contactRow').slideUp(function() {
				$scope.resetForm();	
			});
        };
				
		$scope.resetForm = function() {
			$scope.success = false;
			$scope.process = false;
			$scope.loaded = false;
			$scope.message = angular.copy($scope.master);
		};

        $scope.save = function (message) {
			$window.ga('send', 'event', 'contact-button', 'submit', 'contact-form-submit');
			$scope.master = angular.copy(message);			
			$scope.loaded = true;
			$scope.process = true;
			
			apiRequest.query({name:$scope.message.name, email:$scope.message.email, text:$scope.message.text}, function(data) {
				$window.ga('send', 'event', 'contact-button', 'submit', 'contact-form-submit-complete');
				$scope.success = true;
				$scope.process = false;
			});
		};
						
		/**
		 *	popup window
		 */
		$scope.openUrl = function(url) {
    		var h = $window.innerHeight * 0.5;
		 	var w = $window.innerWidth * 0.5;
			$window.ga('send', 'event', 'button', 'openWindow', url);
		 	window.open(url, 'frame','resizeable=no,top=' + ($window.innerWidth / 2) - (w /2) +',left=' + ($window.innerHeight / 2) - (h / 2) +  ',width=' + w + ',height='+ h); 
  		};
		
		/**
		 *	slideToggle broadcast
		 */
		$scope.toggle = function() {
			if ($scope.checkMobileNav() == "none") $scope.$broadcast('event:toggle');
		}
		
		$scope.checkMobileNav = function() {
			return $window.innerWidth < 560 ? "none" : "block";	
		}
		
		$(window).resize(function() {
			$(".clearfix").css("display", $scope.checkMobileNav());	
		});
		
		$scope.resetForm();
		$scope.checkMobileNav();
	}])
	.directive('toggle', function() {
    	return function(scope, elem, attrs) {
        	scope.$on('event:toggle', function() {
            	elem.slideToggle();
        	});
    	};
	});
	
	/**
	 *	HomeCtrl
	 *	- manages main view
	 */
	jbControllers.controller('HomeCtrl', ['$scope', '$timeout', '$window', 'homeModel', 'fileRequest', 'projectsIndex', function ($scope, $timeout, $window, homeModel, fileRequest, projectsIndex) {
		$window.ga('send', 'pageview', {'page': '/home'});
		
		$scope.homeModel = homeModel;
		$scope.containerDiv = $scope.homeModel.containerDiv;

		/**
		 *	projectIndex, deferred promise on projects index data load
		 *	- load our JSON data
		 */
		projectsIndex.then(function(projectData) {
    		$scope.data = projectData.items;
			$timeout(function(){
				setLayout();
			});
  		});
		
		/**
		 *	updateLayout
		 *	- updates the Blocksit info, causing redraw if necessary
		 */
		updateLayout = function(cols) {
			$($scope.containerDiv).BlocksIt({
				numOfCol:cols,
				offsetX:8,
				offsetY:8
			});		
		}
		
		/**
		 *	setLayout
		 *	- reads screen width and sets layout params to send to blocksit module
		 *	- invokes updateLayout to instruct Blocksit component
		 */
		setLayout = function(isResize) {
			$scope.homeModel.updateContainer();
			updateLayout($scope.homeModel.cols);
		}
		
		/**
		 *	resize event for blocks
		 */
		$(window).resize(function() {
			setLayout();	
		});
	}]);
	
	
	/**
	 *	ProjectsCtrl
	 *	- connects the data of an individual project json file to its view via ProjectModel
	 *	
	 */
	jbControllers.controller('ProjectsCtrl', ['$scope', '$window', '$location', 'fileRequest', 'projectsIndex', function ($scope, $window, $location, fileRequest, projectsIndex) {
		// get curretn ID, set on projectsIndexModel
		var id = $location.path().split("/");
		$scope.currentID = id[id.length - 1];    //path will be /person/show/321/, and array looks like: ["","person","show","321",""]
		$window.ga('send', 'pageview', {'page': '/projects/' + $scope.currentID});
		/**
		 *	projectIndex, deferred promise on projects index data load
		 *	- data is used to get next / previous IDs for project view
		 */
		projectsIndex.then(function(projectData) {
    		$scope.projectData = projectData.items;
			$scope.getProjectIDs();
			fileRequest.get({id:$scope.currentID}, function(data) {
				$scope.data = data;
			});
  		});
		
		/**
		 *	getProjectID
		 *	- determines "next" or "prev" projectID, by passed in type
		 */
		$scope.getProjectIDs = function() {
			var count = $scope.projectData.length;
			for (var i = 0; i < count; i++) {
				if ($scope.currentID == $scope.projectData[i]['id']) {
					$scope.nextID = i >= count - 1 ? $scope.projectData[0]['id'] : $scope.projectData[i + 1]['id'];
					$scope.prevID = i == 0 ? $scope.projectData[count - 1]['id'] : $scope.projectData[i - 1]['id'];
					break;	
				}
			}
		};
		
		/**
		 *	image gallery methods
		 */
		$scope.direction = 'left';
        $scope.currentIndex = 0;

        $scope.setCurrentSlideIndex = function (index) {
            $scope.direction = (index > $scope.currentIndex) ? 'left' : 'right';
            $scope.currentIndex = index;
        };

        $scope.isCurrentSlideIndex = function (index) {
            return $scope.currentIndex === index;
        };

        $scope.prevSlide = function () {
            $scope.direction = 'left';
            $scope.currentIndex = ($scope.currentIndex < $scope.data.gallery.length - 1) ? ++$scope.currentIndex : 0;
			$window.ga('send', 'event', 'gallery-button', 'project-gallery', $scope.direction);
        };

        $scope.nextSlide = function () {
            $scope.direction = 'right';
            $scope.currentIndex = ($scope.currentIndex > 0) ? --$scope.currentIndex : $scope.data.gallery.length - 1;
			$window.ga('send', 'event', 'gallery-button', 'project-gallery', $scope.direction);
        };
		
	}]).animation('.slide-animation', function () {
        return {
            addClass: function (element, className, done) {
                var scope = element.scope();

                if (className == 'ng-hide') {
                    var finishPoint = element.parent().width();
                    if(scope.direction !== 'right') {
                        finishPoint = -finishPoint;
                    }
                    TweenMax.to(element, 0.5, {left: finishPoint + 5, onComplete: done });
                }
                else {
                    done();
                }
            },
            removeClass: function (element, className, done) {
                var scope = element.scope();

                if (className == 'ng-hide') {
                    element.removeClass('ng-hide');

                    var startPoint = element.parent().width();
                    if(scope.direction === 'right') {
                        startPoint = -startPoint;
                    }

                    TweenMax.set(element, { left: startPoint });
                    TweenMax.to(element, 0.5, {left: 5, onComplete: done });
                }
                else {
                    done();
                }
            }
        };
    });
	
	
	/**
	 *	TopPageCtrl
	 *	- manages work history, about sections 
	 */
	jbControllers.controller('TopPageCtrl', ['$scope', '$window', '$location', 'fileRequest', function ($scope, $window, $location, fileRequest) {
		var id = $location.path().split("/");
		$scope.id = id[id.length - 1];
		$window.ga('send', 'pageview', {'page': '/' + $scope.currentID});
		$scope.$broadcast('event:toggle');
		
		fileRequest.get({id:$scope.id}, function(data) {
			$scope.data = data;
		});	
	}]);