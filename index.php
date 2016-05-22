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
<!--
    <div class="text text-1">TEXT</div>
    <div class="text text-2">TEXT</div>
    <div class="text text-3">TEXT</div>
 -->
    <script src="sources/javascript/CircularCalendar.class.js"></script>
    <script>

        // // Wait font loading
        // window.setTimeout( function()
        // {
            // Circular Calendar
            var circularCalendar = new CircularCalendar( {
                colors:
                {
                    background: '#0d0503',
                    active    : '#f7f5e6',
                    circles   :
                    [
                        // ['#002A4A','#17607D','#FFF1CE','#FF9311','#D64700'],
                        ['#9b677a','#8CBEB2','#F2EBBF','#F3B562','#F06060'],
                        // ['#106EFF','#476799','#10ECFF','#FF7F50','#CC3621'],
                        // ['#25F98A','#9B2DCC','#2FFFFF','#F7FF6F','#FF5D3B'],
                        // ['#D93644','#F24968','#A63F52','#D9D3C1','#592222'],
                        // ['#FF7B5B','#E85A53','#FF689A','#E853CE','#E25BFF'],
                        // ['#FBDD79','#F5E3B9','#F08948','#D66031','#3C0C01'],
                        // ['#F20274','#7C65BF','#58B5F5','#F2A005','#F24402'],
                        // ['#F77087','#F77087','#792880','#591E8B','#26D6CE'],
                        // ['#225C5D','#B2D0C6','#FDB165','#EB7449','#D7472D'],
                        // ['#14ABCC','#3D8899','#00FFA1','#FF4640','#CC145B'],
                        // ['#96CEB4','#FFEEAD','#FF6F69','#FFCC5C','#AAD8B0'],
                        // ['#8FFF36','#FA397D','#3086FC','#FFF7FA','#FF7FA8'],
                    ]
                },
                canvas        : document.querySelector( '.circular-calendar' ),
                // width         : 800 * 4,
                // height        : 800 * 4,
                width         : 4961,
                height        : 7087,
                sectors       : <?= $data->sectors ?>,
                thickness     : 0.013,
                circumferences:
                {
                    start: -Math.PI * 0.5,
                    end  : Math.PI * 1.25
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
