var mySiteApp = angular.module('mySiteApp', ["ngRoute"]).run(function ($rootScope, $location) {
    $rootScope.location = $location;
});

mySiteApp.controller('mySiteAppController', ['$scope', '$rootScope', 'coService', 'functionNames', '$location',
    function ($scope, $rootScope, coService, functionNames, $location, $routeParams) {
        //scope declarations
        $scope.selectedData = {};
        //scope functions
        $scope.getData = function (path, home, video) {
            $("#loading").addClass("loading");
            $scope.selectedData.album_id = localStorage.getItem('album_id');
            $scope.selectedData.category_id = localStorage.getItem('category_id');
            coService.Get(getConstant(path), $scope.selectedData).then(function (response) {
                $scope.data = response;
                if (home) {
                    var html = ``;
                    for (var i = 0; i < $scope.data.testimonial_data.length; i++) {
                        html += `<div class="testimonial">`;
                        html += `<div class="pic">
                            <img src="` + $scope.data.testimonial_data[i].pic_path + `">
                        </div>
                        <h3 class="title">` + $scope.data.testimonial_data[i].comment_by + `</h3>
                        <p class="description">` + $scope.data.testimonial_data[i].comment + `</p>`;
                        html += `</div>`;
                    }
                    $('#testimonial-slider').html(html);
                    var owl = $("#testimonial-slider");
                    owl.owlCarousel({
                        items: 1,
                        itemsDesktop: [1000, 1],
                        itemsDesktopSmall: [979, 1],
                        itemsTablet: [768, 1],
                        pagination: true,
                        transitionStyle: "backSlide",
                        stopOnHover: true,
                        autoPlay: true
                    });
                }
                if(video){
                    var html = `<div id="playerholder" style="padding:56.25% 0 0 0;position:relative;">
                    <iframe src="` + $scope.data.videodetail_data["0"].link + `" style="position:absolute;top:0;left:0;background-color:black;" frameborder="0" webkitallowfullscreen
                        mozallowfullscreen allowfullscreen>
                    </iframe>
                    </div>`;
                    console.log(html);
                    $('#videoplayer').html(html);
                }
            });

            $("#loading").removeClass("loading");
        }

        $scope.redirect = function () {
            if ($location.path() !== "/Homepage" && $location.path() !== "/") {
                $location.path("/Homepage");
            }
        }

        // $scope.storeData = function (data, album) {
        //     if (album) {
        //         localStorage.setItem('album_id', data);
        //     } else {
        //         localStorage.setItem('category_id', data);
        //     }
        // }

        //private functions
        function getConstant(value) {
            return functionNames[value];
        }
    }]
);
