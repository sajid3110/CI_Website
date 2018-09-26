<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap CRUD Data Table for Database with Modal Form</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
    <script>
        $(document).ready(function () {
            $("#pic").click(function () {
                $("#contentDiv").load('<?php echo base_url();?>' + "/index.php/welcome/picgrid");
            });

            $('#logout').click(function () {
                console.log('logout');
            });
        });
    </script>
</head>
<style>
    .navbar-fixed-left {
        width: 140px;
        position: fixed;
        border-radius: 0;
        height: 100%;
    }

    .navbar-fixed-left .navbar-nav>li {
        float: none;
        /* Cancel default li float: left */
        width: 139px;
    }

    .navbar-fixed-left+.container {
        padding-left: 160px;
    }

    /* On using dropdown menu (To right shift popuped) */

    .navbar-fixed-left .navbar-nav>li>.dropdown-menu {
        margin-top: -50px;
        margin-left: 140px;
    }
</style>
<!------ Include the above in your HEAD tag ---------->
<body ng-app="">
<div class="navbar navbar-inverse navbar-fixed-left">
    <a class="navbar-brand" href="#">Brand</a>
    <ul class="nav navbar-nav">
        <li><a href="#">Home</a></li>
        <li><a href="#" id="pic">Pictures</a></li>
        <li><a href="#">Videos</a></li>
        <li><a href="#">Testimonials</a></li>
        <li><a href="#" id="logout">Logout</a></li>
    </ul>
</div>
<div class="container">
    <div class="row"  id="contentDiv">
        <h2>Left side Navigation bar (Fixed)</h2>

        <p>Left side Navigation</p>
        <p>

            
                        Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy
                        text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen
                        book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially
                        unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages,
                        and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
        </p>
    </div>
</div>
</body>