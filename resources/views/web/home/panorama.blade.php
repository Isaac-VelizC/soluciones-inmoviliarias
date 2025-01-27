<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panorama</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pannellum@2.5.6/build/pannellum.css"/>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/pannellum@2.5.6/build/pannellum.js"></script>
    <style>
        #panorama {
            width: 800px;
            height: 600px;
        }
    </style>
</head>
<body>
<div id="panorama"></div>
<script>
    pannellum.viewer('panorama', {
        "type": "equirectangular",
        "panorama": "https://pannellum.org/images/alma.jpg"
    });
</script>

</body>
</html>
