(function(){
    'use strict';
    app.constant("functionNames",{
        "/CategoriesGrid": "get_categories",
        "/CategoriesInsert": "insert_categories",
        "/CategoriesUpdate": "update_categories",
        "/CategoriesDelete": "delete_categories",
        "/CategoriesSetPic": "set_category_pic",

        "/PicturesGrid": "get_pictures",
        "/PicturesInsert": "insert_pictures",
        "/PicturesUpdate": "update_pictures",
        "/PicturesDelete": "delete_pictures",
        "/PicturesAlbum": "get_album_picture",
        "/PicturesAlbumInsert": "insert_album_picture",

        "/VideosGrid": "get_videos",
        "/VideosInsert": "insert_videos",
        "/VideosUpdate": "update_videos",
        "/VideosDelete": "delete_videos",
        "/VideosAlbum": "get_album_video",
        "/VideosAlbumInsert": "insert_album_video",

        "/AlbumsGrid": "get_albums",
        "/AlbumsInsert": "insert_albums",
        "/AlbumsUpdate": "update_albums",
        "/AlbumsDelete": "delete_albums",
        "/AlbumsData": "get_album_data",
        "/AlbumsDataDelete": "delete_album_data",

        "/RentalsGrid": "get_rentals",
        "/RentalsInsert": "insert_rentals",
        "/RentalsUpdate": "update_rentals",
        "/RentalsDelete": "delete_rentals",

        "/TestimonialsGrid": "get_testimonials",
        "/TestimonialsInsert": "insert_testimonials",
        "/TestimonialsUpdate": "update_testimonials",
        "/TestimonialsDelete": "delete_testimonials",

        "/Login": "login",
        "/Logout": "logout",
        "/IsloggedIn": "isLoggedIn",
        "/UpdatePassword": "update_password"
    });
})();