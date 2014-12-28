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
                callback(data);

            }).error(function (data, status, headers, config) {
                $log.warn(data, status, headers, config);
            });
        };
    });

    app.service("NSCEventData", function ($http, $log) {

        this.initEvents = function(callback) {
            $http({
                method: 'POST',
                url: '/wp-admin/admin-ajax.php',
                params: {action: 'initialize_nscevents'}
            }).success(function (data, status, headers, config) {
                callback(data);

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
        $scope.loading = true;
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
        }).then(function() {
            $scope.loading = false;
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

    app.controller("eventsController", ['$scope', 'NSCEventData', function($scope, NSCEventData) {
        $scope.upcomingEvents = [];
        $scope.pastEvents = [];
        NSCEventData.initEvents(function(response) {
            $scope.upcomingEvents = response['upcoming'];
            $scope.pastEvents = response['past'];

            $scope.upcomingEvents.sort(function(a,b){
                return parseInt(a['sortdate']) - parseInt(b['sortdate']);
            });
            /*$scope.pastEvents.sort(function(a,b){
                return parseInt(a['sortdate']) - parseInt(b['sortdate']);
            }).reverse();*/

            var index;
            for (index = 0; index < $scope.upcomingEvents.length; index++) {
                var dateString = $scope.upcomingEvents[index]['date'].split('-');
                $scope.upcomingEvents[index]['day'] = dateString[0];
                $scope.upcomingEvents[index]['month'] = dateString[1].toUpperCase();
            }

            for (index = 0; index < $scope.pastEvents.length; index++) {
                var dateString = $scope.pastEvents[index]['date'].split('-');
                $scope.pastEvents[index]['day'] = dateString[0];
                $scope.pastEvents[index]['month'] = dateString[1].toUpperCase();
            }
        });
    }]);

    app.controller("portalController", ['$scope', '$location', function($scope, $location) {
        this.tab = -1;

        if ($location.path() === "/events") {
            this.tab = 1;
        }

        this.isSet = function(checkTab) {
            return this.tab === checkTab;
        };

        this.setTab = function(activeTab) {
            this.tab = activeTab;

            if (this.tab === 1) {
                $location.path('/events');
            } else {
                $location.path('/contacts');
            }
        };
    }]);
})();

