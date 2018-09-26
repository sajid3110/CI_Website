var app = angular.module('myApp', ["ngRoute", "angularUtils.directives.dirPagination"]).run(function ($rootScope, $location) {
    $rootScope.location = $location;
});

app.controller('PController', ['$scope', '$rootScope', 'coService', 'functionNames', '$location', '$timeout', 'fileModelDirective', '$window',
    function ($scope, $rootScope, coService, functionNames, $location, $timeout, fileModelDirective, $window) {
        //scope declarations
        $scope.selectedData = {};
        $scope.searchName = '';
        $scope.showSuccess = false;
        $scope.showDanger = false;
        var formdata = new FormData();
        //grid load data

        $scope.mydata = {};
        $scope.mydata.data = [];
        $scope.mydata.pageno = 1;
        $scope.mydata.total_count = 0;
        $scope.mydata.itemsPerPage = 5;
        $scope.mydata.getData = function (pageno) {
            if ($location.path() != '/Login' && $location.path() != '/' && $location.path() != '/Homepage' && $location.path() != '' && $location.path() != '/UpdatePassword') {
                $scope.mydata.data = [];
                var data = { itemsPerPage: $scope.mydata.itemsPerPage, pgno: pageno, search: $scope.searchName };
                $("#loading").addClass("loading");
                coService.Get(getConstant($location.path() + "Grid"), data).then(function (response) {
                    $scope.mydata.data = response.data;
                    $scope.mydata.total_count = response.total;
                    $scope.pgShowing = (($scope.mydata.itemsPerPage * $scope.__default__currentPage) - ($scope.mydata.itemsPerPage - 1));
                    $scope.pgShowing += " to ";
                    $scope.pgShowing += (($scope.mydata.itemsPerPage * $scope.__default__currentPage) >= response.total) ? response.total : ($scope.mydata.itemsPerPage * $scope.__default__currentPage)
                });
                coService.Get(getConstant("/CategoriesGrid"), null).then(function (response) {
                    $scope.categoryDropDown = response.data;
                });
                $("#loading").removeClass("loading");
            }
        };
        $scope.mydata.getData($scope.mydata.pageno);

        //scope functions
        $scope.search = function () {
            $scope.mydata.getData(1);
        }


        $scope.edit = function (value, secondary) {
            $scope.selectedData = angular.copy(value);
        }

        $scope.insert = function (data) {
            $("#loading").addClass("loading");
            coService.PostFile(getConstant($location.path() + "Insert"), $scope.selectedData, $scope.myFile)
                .then(function (response) {
                    $("#loading").removeClass("loading");
                    var modal = "#add" + $location.path().substring(1, $location.path().length) + "Modal";
                    $(modal).modal("hide");
                    $scope.clearData();
                    $scope.mydata.getData($scope.__default__currentPage);
                    showResponse(response);
                });
        }

        $scope.update = function (data) {
            $("#loading").addClass("loading");
            coService.PostFile(getConstant($location.path() + "Update"), $scope.selectedData, $scope.myFile)
                .then(function (response) {
                    $("#loading").removeClass("loading");
                    var modal = "#edit" + $location.path().substring(1, $location.path().length) + "Modal";
                    $(modal).modal("hide");
                    $scope.clearData();
                    $scope.mydata.getData($scope.__default__currentPage);
                    showResponse(response);
                });
        }

        $scope.delete = function (data) {
            $("#loading").addClass("loading");
            coService.PostFile(getConstant($location.path() + "Delete"), $scope.selectedData, $scope.myFile)
                .then(function (response) {
                    $("#loading").removeClass("loading");
                    var modal = "#delete" + $location.path().substring(1, $location.path().length) + "Modal";
                    $(modal).modal("hide");
                    $scope.clearData();
                    $scope.mydata.getData($scope.__default__currentPage);
                    showResponse(response);
                });
        }

        $scope.getTheFiles = function ($files) {
            angular.forEach($files, function (value, key) {
                formdata.append(key, value);
            });
        };

        $scope.clearData = function () {
            $scope.selectedData = {};
            if ($('#myFile').length) {
                document.getElementById("myFile").value = "";
            }
            $scope.myFile = "";
        }

        $scope.getAlbumList = function () {
            coService.Get(getConstant($location.path() + "Album"), $scope.selectedData).then(function (response) {
                $scope.AlbumList = response.data;
            });
            coService.Get(getConstant("/AlbumsGrid"), null).then(function (response) {
                $scope.AlbumDropDown = response.data;
            });
        }

        $scope.addToAlbum = function () {
            $("#loading").addClass("loading");
            coService.Post(getConstant($location.path() + "AlbumInsert"), $scope.selectedData)
                .then(function (response) {
                    var modal = "#album" + $location.path().substring(1, $location.path().length) + "Modal";
                    $(modal).modal("hide");
                    $scope.clearData();
                    $scope.mydata.getData($scope.__default__currentPage);
                    showResponse(response);
                    $("#loading").removeClass("loading");
                });
        }

        $scope.getDataFromAlbum = function () {
            $("#loading").addClass("loading");
            coService.Get(getConstant($location.path() + "Data"), $scope.selectedData).then(function (response) {
                $scope.AlbumData = response.data;
            });
            $("#loading").removeClass("loading");
        }

        $scope.deleteAlbumData = function () {
            $("#loading").addClass("loading");
            coService.PostFile(getConstant("/AlbumsDataDelete"), $scope.selectedData)
                .then(function (response) {
                    $("#deleteAlbumsDataModal").modal("hide");
                    $scope.getDataFromAlbum();
                    $scope.mydata.getData($scope.__default__currentPage);
                    $("#loading").removeClass("loading");
                });
        }

        $scope.setAsMaster = function () {
            $("#loading").addClass("loading");
            coService.PostFile(getConstant($location.path() + "Update"), $scope.selectedData)
                .then(function (response) {
                    $scope.getDataFromAlbum();
                    $scope.mydata.getData($scope.__default__currentPage);
                    $("#loading").removeClass("loading");
                });
        }

        $scope.setForCategory = function () {
            $("#loading").addClass("loading");
            coService.PostFile(getConstant("/CategoriesSetPic"), $scope.selectedData)
                .then(function (response) {
                    $("#setForCategoryModal").modal("hide");
                    $scope.mydata.getData($scope.__default__currentPage);
                    showResponse(response);
                    $("#loading").removeClass("loading");
                });
        }

        $scope.login = function () {
            $("#loading").addClass("loading");
            coService.PostFile(getConstant("/Login"), $scope.selectedData)
                .then(function (response) {
                    if (response.success) {
                        $location.path('/Homepage');
                    } else {
                        $scope.loginError = true;
                        $scope.selectedData = {};
                        $location.path('/Login');
                    }
                    $("#loading").removeClass("loading");
                });
        }

        $scope.updatePassword = function () {
            $("#loading").addClass("loading");
            coService.PostFile(getConstant("/UpdatePassword"), $scope.selectedData)
                .then(function (response) {
                    $scope.selectedData = {};
                    $("#loading").removeClass("loading");
                    showResponse(response);
                });
        }

        $scope.logout = function () {
            $("#loading").addClass("loading");
            coService.Get(getConstant("/Logout"), $scope.selectedData)
                .then(function (response) {
                    $("#loading").removeClass("loading");
                    $location.path('/Login');
                });
        }

        //private functions
        function getConstant(value) {
            return functionNames[value];
        }

        function showResponse(response) {
            (response.success) ? ($scope.showSuccess = true) : ($scope.showDanger = true);
            $scope.errorMsg = (response.error != null) ? response.error : "Operation could not be performed";
            $timeout(function () {
                (response.success) ? ($scope.showSuccess = false) : ($scope.showDanger = false);
                $scope.errorMsg = "";
            }, 3000);
        }
    }]
);



