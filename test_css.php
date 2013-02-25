<?php
?>
<!DOCTYPE HTML>
<html>
<head>
<meta http_equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport" content="initial-scale=1" />
<style type="text/css">
body {
	margin: 10em;
	background-color: #DDD;
	color: #333333;
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 90%;
}

#test {
	width: 400px;
	height: 300px;
	background: white;
}

.actionbar {
	width: 100%;
	background-color: #666666;
	border: 1px solid #999999;
	color: white;
	cursor: default;
	font-size: 1.5em;
	height: 2em;
	background-color: #666666;
	display: table;
	width: 100%;
	height: 100%;
}

.actionbar>* {
	display: table-cell;
	white-space: nowrap;
	vertical-align: middle;
}

.actionbar .actionbar_viewcontrol {

}

.actionbar .actionbar_viewcontrol .double {

}

.actionbar .actionbar_viewcontrol .double>*:FIRST-CHILD
	{
	font-size: 0.8em;
	font-weight: bold;
}

.actionbar .actionbar_viewcontrol .double>*:LAST-CHILD
	{
	display: inline-block;
}

.actionbar .actionbar_viewcontrol .double>*+* {
	font-size: 0.6em;
}

.actionbar .actionbar_icon {
	padding: 0 0.2em;
	width: 1px;
	outline: medium none;
	color: white;
	text-decoration: none;
}

.actionbar .actionbar_icon .actionbar_icon_referral {
	padding-right: 0.2em;
	display: inline;
}

.actionbar .actionbar_icon .actionbar_icon_icon {
	display: inline;
}
</style>
<link type="text/css" rel="stylesheet" href="css/budget.css.php">
<!--
<script src="../KrisSkarboApi/javascript/api/jquery-1.7.1.min.js" type="text/javascript"></script>
<script type="text/javascript" src="javascript/budget.js.php"></script> -->
<script type="text/javascript">

</script>
</head>
<body>

    <div id="test">

        <div class="actionbar_wrapper">
            <div class="actionbar">
                <a href="#" class="actionbar_icon">
                    <div class="actionbar_icon_referral">&lt;</div>
                    <div class="actionbar_icon_icon">W</div>
                </a>
                <div class="actionbar_viewcontrol">
                    <div class="double">
                        <div>Building w/address and øæå</div>
                        <div>Test Facility</div>
                    </div>
                </div>
                <div class="actionbar_buttons"></div>
            </div>
        </div>

    </div>

</body>
</html>