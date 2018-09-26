app.config(function ($routeProvider) {
    $routeProvider
        .when("/Pictures", {
            templateUrl: "pictures_page",
        })
        .when("/Videos", {
            templateUrl: "videos_page",
        })
        .when("/Categories", {
            templateUrl: "categories_page",
        })
        .when("/Albums", {
            templateUrl: "albums_page",
        })
        .when("/Rentals", {
            templateUrl: "rentals_page",
        })
        .when("/Testimonials", {
            templateUrl: "testimonials_page",
        })
        .when("/UpdatePassword", {
            templateUrl: "update_password_page"
        })
        .when("/Login", {
            templateUrl: "login_page"
        })
        .when("/AdminPanel", {
            templateUrl: "homepage"
        })
        .when("/Homepage", {
            templateUrl: "homepage"
        })
        .otherwise({
            templateUrl: "login_page"
        });
});