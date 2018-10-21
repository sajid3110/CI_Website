mySiteApp.config(function ($routeProvider,$locationProvider) {

    $locationProvider.hashPrefix('!');
    $locationProvider.html5Mode(true);
    $routeProvider
        .when("/Photos", {
            templateUrl: "index.php/welcome/photocategory_page",
        })
        .when("/PhotoAlbum/:id", {
            templateUrl: "index.php/welcome/photoalbum_page",
            resolve: {
                note: function($route) {
                    localStorage.setItem('category_id', $route.current.params.id);
               }
            }
        })
        .when("/PhotoDetail/:id", {
            templateUrl: "index.php/welcome/photodetail_page",
            resolve: {
                note: function($route) {
                    localStorage.setItem('album_id', $route.current.params.id);
               }
            }
        })
        .when("/Videos", {
            templateUrl: "index.php/welcome/videocategory_page",
        })
        .when("/VideoAlbum/:id", {
            templateUrl: "index.php/welcome/videoalbum_page",
            resolve: {
                note: function($route) {
                    localStorage.setItem('category_id', $route.current.params.id);
               }
            }
        })
        .when("/VideoDetail/:id", {
            templateUrl: "index.php/welcome/videodetail_page",
            resolve: {
                note: function($route) {
                    localStorage.setItem('album_id', $route.current.params.id);
               }
            }
        })
        .when("/Rental", {
            templateUrl: "index.php/welcome/rental_page",
        })
        .when("/Faq", {
            templateUrl: "index.php/welcome/faq_page",
        })
        .when("/Homepage", {
            templateUrl: "index.php/welcome/home_page"
        })
        .when("/Aboutus", {
            templateUrl: "index.php/welcome/aboutus_page",
        })
        .when("/", {
            templateUrl: "index.php/welcome/home_page"
        })

});
