app.factory('coService', function ($http, $location) {
    return {
        'Get': function (endpoint, data) {
            $http({
                url: 'isLoggedIn',
                method: "GET",
            }).then(function (response) {
                if (!response.data.loggedIn) {
                    $location.path('/Login');
                }
            });
            var promise = $http({
                url: endpoint,
                method: "GET",
                params: { data: data }
            }).then(function (response) {
                return response.data;
            });
            return promise;
        },
        'Post': function (endpoint, data) {
            $http({
                url: 'isLoggedIn',
                method: "GET",
            }).then(function (response) {
                if (!response.data.loggedIn) {
                    $location.path('/Login');
                }
            });
            var promise = $http({
                url: endpoint,
                method: "POST",
                params: { data: data }
            }).then(function (response) {
                return response.data;
            });
            return promise;
        },
        'PostFile': function (endpoint, data, file) {
            $http({
                url: 'isLoggedIn',
                method: "GET",
            }).then(function (response) {
                if (!response.data.loggedIn) {
                    $location.path('/Login');
                }
            });
            var fd = new FormData();
            if (file != undefined) {
                if (file.length > 1) {
                    for (var i = 0; i < file.length; i++) {
                        fd.append('file[]', file[i]);
                    }
                } else {
                    fd.append('file', file);
                }
            }
            fd.append('data', JSON.stringify(data));
            var promise = $http.post(endpoint, fd, {
                transformRequest: angular.identity,
                headers: { 'Content-Type': undefined }
            }).then(function (response) {
                return response.data;
            });
            return promise;
        }

    }
});

app.directive('fileModel', ['$parse', function ($parse) {
    return {
        restrict: 'A',
        link: function (scope, element, attrs) {
            var model = $parse(attrs.fileModel);
            var modelSetter = model.assign;

            element.bind('change', function () {
                scope.$apply(function () {
                    if (attrs.$attr.multiple == undefined) {
                        modelSetter(scope, element[0].files[0]);
                    } else {
                        modelSetter(scope, element[0].files);
                    }
                });
            });
        }
    };
}]);