'use strict';

var controllers = angular.module('controllers', ['ui.bootstrap']);

controllers.controller('MainController', ['$scope', '$location', '$window',
    function ($scope, $location, $window) {
        $scope.loggedIn = function() {
            return Boolean($window.sessionStorage.access_token);
        };

        $scope.logout = function () {
            delete $window.sessionStorage.access_token;
            $location.path('/login').replace();
        };
    }
]);

controllers.controller('ContactController', ['$scope', '$http', '$window',
    function($scope, $http, $window) {
        $scope.captchaUrl = 'site/captcha';
        $scope.contact = function () {
            $scope.submitted = true;
            $scope.error = {};
            $http.post('api/contact', $scope.contactModel).success(
                function (data) {
                    $scope.contactModel = {};
                    $scope.flash = data.flash;
                    $window.scrollTo(0,0);
                    $scope.submitted = false;
                    $scope.captchaUrl = 'site/captcha' + '?' + new Date().getTime();
            }).error(
                function (data) {
                    angular.forEach(data, function (error) {
                        $scope.error[error.field] = error.message;
                    });
                }
            );
        };

        $scope.refreshCaptcha = function() {
            $http.get('site/captcha?refresh=1').success(function(data) {
                $scope.captchaUrl = data.url;
            });
        };
    }]);

controllers.controller('DashboardController', ['$scope', '$http',
    function ($scope, $http) {
        $http.get('api/dashboard').success(function (data) {
           $scope.dashboard = data;
        })
    }
]);

controllers.controller('LoginController', ['$scope', '$http', '$window', '$location',
    function($scope, $http, $window, $location) {
        $scope.login = function () {
            $scope.submitted = true;
            $scope.error = {};
            $http.post('api/login', $scope.userModel).success(
                function (data) {
                    $window.sessionStorage.access_token = data.access_token;
                    $location.path('/dashboard').replace();
            }).error(
                function (data) {
                    angular.forEach(data, function (error) {
                        $scope.error[error.field] = error.message;
                    });
                }
            );
        };
    }
]);

controllers.controller('FeedbackController', ['$scope', '$http', '$window', '$location',
    function($scope, $http, $window, $location) {

        $scope.activeTab = 1;
                
        $scope.setActiveTab = function(tabToSet) {
            $scope.activeTab = tabToSet;
        }

        // function feedback() will handle the ng-submit event for the feedback form
        $scope.feedback = function () {
            $scope.submitted = true;
            $scope.error = {};
            $http.post('api/feedback', $scope.feedbackModel).success(
                function (data) {
                    $scope.feedbackModel = {};
                    $scope.flash = data.flash;
                    $window.scrollTo(0,0);
                    $scope.submitted = false;
                    //$location.path('/dashboard').replace();
            }).error(
                function (data) {
                    angular.forEach(data, function (error) {
                        $scope.error[error.field] = error.message;
                    });
                }
            );
        };
    }
]);