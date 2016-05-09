<?php

    require_once './classes/cache.class.php';
    $cache = new Cache();
    $data = $cache->get('data');

    if(!$data)
        die('no data');

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Circular Calendar</title>
    <link rel="stylesheet" href="sources/stylesheets/main.css">
</head>
<body>
    <canvas class="circular-calendar"></canvas>

    <div class="text text-1">TEXT</div>
    <div class="text text-2">TEXT</div>
    <div class="text text-3">TEXT</div>

    <script src="sources/javascript/CircularCalendar.class.js"></script>
    <script>

        // // Wait font loading
        // window.setTimeout( function()
        // {
            // Circular Calendar
            var circularCalendar = new CircularCalendar( {
                background    : '#111',
                canvas        : document.querySelector( '.circular-calendar' ),
                width         : 800 * 4,
                height        : 800 * 4,
                sectors       : <?= $data->sectors ?>,
                thickness     : 0.012,
                circumferences:
                {
                    start: -Math.PI * 0.5,
                    end  : Math.PI
                },
                diameters:
                {
                    inner: 0.4,
                    outer: 0.9
                },

                circles: <?= json_encode($data->circles) ?>

                // circles:
                // [
                //     {
                //         style : '#B0FF00',
                //         name  : 'Tim',
                //         values: [1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1]
                //     },
                //     {
                //         style : '#FF0072', //FF0095
                //         name  : 'Tommy',
                //         values: [1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1]
                //     },
                //     {
                //         style : '#00FFE0',
                //         name  : 'Jerry',
                //         values: [1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1]
                //     },
                //     {
                //         style : '#FFFB00',
                //         name  : 'John',
                //         values: [1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1]
                //     },
                //     {
                //         style : '#00FF76',
                //         name  : 'Patrick',
                //         values: [1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1]
                //     },
                //     {
                //         style : '#FF00E7',
                //         name  : 'Jim',
                //         values: [1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1]
                //     }
                // ]

                // circles:
                // [
                //     {
                //         style : '#FFFB00',
                //         name  : 'John',
                //         values: [1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1]
                //     },
                //     {
                //         style : '#B0FF00',
                //         name  : 'Tim',
                //         values: [1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1]
                //     },
                //     {
                //         style : '#00FF76',
                //         name  : 'Patrick',
                //         values: [1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1]
                //     },
                //     {
                //         style : '#00FFE0',
                //         name  : 'Jerry',
                //         values: [1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1]
                //     },
                //     {
                //         style : '#FF00E7',
                //         name  : 'Jim',
                //         values: [1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1]
                //     },
                //     {
                //         style : '#FF0072', //FF0095
                //         name  : 'Tommy',
                //         values: [1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1]
                //     },
                //     {
                //         style : '#FFB500', //FF0095
                //         name  : 'Gerad',
                //         values: [1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1]
                //     }
                // ]
            } );
        // }, 100 );

    </script>
</body>
</html>
