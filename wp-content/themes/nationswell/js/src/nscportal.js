(function() {
    var app = angular.module("nsc_portal", []);

    app.filter("sanitize", ['$sce', function($sce) {
        return function (htmlCode) {
            return $sce.trustAsHtml(htmlCode);
        }
    }]);

    app.service("NSCContactData", function ($http, $log) {

        this.initContacts = function(callback) {
            return $http({
                method: 'POST',
                url: '/wp-admin/admin-ajax.php',
                params: {action: 'initialize_nscdirectory'}
            }).success(function (data, status, headers, config) {
                $log.info(data, status);
                callback(data);

            }).error(function (data, status, headers, config) {
                $log.warn(data, status, headers, config);
            });
        };
    });

    app.service("NSCEventData", function ($http, $log) {

        var events = function() {
            $http({
                method: 'POST',
                url: '/wp-admin/admin-ajax.php',
                params: {action: 'initialize_nscevents'}
            }).success(function (data, status, headers, config) {
                $log.info(data, status);
                return data;

            }).error(function (data, status, headers, config) {
                $log.warn(data, status, headers, config);
            });
        };

        this.upcomingEvents = events['upcoming'];
        this.pastEvents = events['past'];

    });

    app.service("NSCEventData", function ($http, $log) {

        this.eventData = function(post_id) {
            $http({
                method: 'POST',
                url: '/wp-admin/admin-ajax.php',
                params: {action: 'get_nscevent', postid: post_id}
            }).success(function (data, status, headers, config) {
                $log.info(data, status);
                return data;

            }).error(function (data, status, headers, config) {
                $log.warn(data, status, headers, config);
            });
        };
    });


    app.controller("directoryController", ['$scope', 'NSCContactData', function($scope, NSCContactData) {
        var contacts = [];
        $scope.AtoE = [],
        $scope.FtoJ = [],
        $scope.KtoO = [],
        $scope.PtoT= [],
        $scope.UtoZ = [];
        NSCContactData.initContacts(function(response) {

            contacts = response;
            var index;
            for (index = 0; index < contacts.length; index++) {
                var firstChar = contacts[index]["surname"][0].charCodeAt(0);

                if( firstChar <= 69) {
                    $scope.AtoE.push(contacts[index]);
                } else if (firstChar > 69 && firstChar <= 74) {
                    $scope.FtoJ.push(contacts[index]);
                } else if (firstChar > 74 && firstChar <= 79) {
                    $scope.KtoO.push(contacts[index]);
                } else if (firstChar > 79 && firstChar <= 84) {
                    $scope.PtoT.push(contacts[index]);
                } else {
                    $scope.UtoZ.push(contacts[index]);
                }
            }
            $scope.allContacts = contacts;
        });
        this.tab = 0;

        this.isSet = function(checkTab) {
            return this.tab === checkTab;
        };

        this.setTab = function(activeTab) {
            this.tab = activeTab;
        };

        $scope.renderHtml = function(html_code) {
            return $sce.trustAsHtml(html_code);
        };
    }]);

    app.controller("eventController", ['$scope', 'NSCEventData', function($scope, NSCEventData) {
        $scope.upcomingEvents = NSCEventData.upcomingEvents;
        $scope.pastEvents = NSCEventData.pastEvents;

    }]);

})();

