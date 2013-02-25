<?php
?>
<!DOCTYPE HTML>
<html>
<head>
<meta name="viewport" content="initial-scale=1"/>
<style type="text/css">
body
{
	padding: 1em !important;
}

#testWrapper
{
	width: 100%;
	background-color: #aaa;
	border: 1px solid black;
}

#swipe > *
{
    white-space: nowrap;
	padding: 0.5em;
	height: 100px;
}
</style>
<link type="text/css" rel="stylesheet" href="css/budget.css.php">
<script src="../KrisSkarboApi/javascript/api/jquery-1.7.1.min.js" type="text/javascript"></script>
<script src="../KrisSkarboApi/javascript/api/jquery.event.drag-2.0.min.js" type="text/javascript"></script>
<script type="text/javascript" src="javascript/budget.js.php"></script>
<script type="text/javascript">

var start = {};
var swipe = {};

$(function() {

    var logElement = $("#log");
    var swipeElement = $("#swipe");
    var swipeWidth = swipeElement.width();
    var elementElement = $("#element");
    var elementWidth = elementElement.width();

    /*this.getElementById("swipe").addEventListener('touchstart', function(event){
    	logElement.text("Touch start");
        console.log("Touch start", event);
        }, false);*/
    /*
    swipeElement.bind("touchstart", function(event) {
        logElement.text("Touch start");
        start = { x : event.originalEvent.touches[0].pageX, y : event.originalEvent.touches[0].pageY};
        swipe = start;
        //console.log("Touch start", event);
        });

    swipeElement.bind("touchmove", function(event) {
        logElement.text("Touch move");

        // ensure swiping with one touch and not pinching
        if(event.originalEvent.touches.length > 1 || event.originalEvent.scale && event.originalEvent.scale !== 1) return;

        if (!jQuery.isEmptyObject(swipe))
        {

            // Get delta x
            var deltaX = Math.round(event.originalEvent.touches[0].pageX - swipe.x);

            // Move procentile
            var moveProcentile = (deltaX / swipeWidth);

            // Get element margin
            var elementMargin = parseInt(elementElement.css("margin-left").replace("px",""));

            var moveElement = Math.round((swipeWidth * moveProcentile)*100);

            elementElement.css("margin-left", Math.max(0, Math.min(swipeWidth - elementWidth, elementMargin + deltaX)));

            logElement.text("Touch move, delta: " + deltaX + ", procentile: " +  moveProcentile + ", move element: " + moveElement);

            // Set swipe
            swipe = { x : event.originalEvent.touches[0].pageX, y : event.originalEvent.touches[0].pageY};

        }
        });

    swipeElement.bind("touchend", function(event) {
        //logElement.text("Touch end");
        //console.log("Touch end", event);
    	swipe = {}, start = {};
        });
    */

    $("#swipe").slider();



});

</script>
</head>
<body>

    <div id="test">

        <div id="testWrapper">
            <div class="table" id="swipe" data-width-parent="#testWrapper" data-resize="true">
                <?php
                for( $i = 0; $i < 40; $i++ ){
                    echo "<div>Cell ${i}</div>\n";
                } ?>
            </div>
        </div>

        <b>Log:</b>
        <div id="log"></div>

    </div>

</body>
</html>