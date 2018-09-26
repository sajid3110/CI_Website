mySiteApp.factory('coService', function ($http, $location) {
    return {
        'Get': function (endpoint, data) {
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
            var promise = $http({
                url: endpoint,
                method: "POST",
                params: { data: data }
            }).then(function (response) {
                return response.data;
            });
            return promise;
        }

    }
});