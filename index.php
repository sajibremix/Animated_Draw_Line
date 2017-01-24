<!DOCTYPE html>
<html>
<head>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
</head>
<body >
	<style>
		body {
			background-color: ivory;
		}
		canvas {
			border:1px solid red;
		}
	</style>
	
<canvas id="canvas" width=350 height=350></canvas>
<script>
		(function () {
			var lastTime = 0;
			var vendors = ['ms', 'moz', 'webkit', 'o'];
			for (var x = 0; x < vendors.length && !window.requestAnimationFrame; ++x) {
				window.requestAnimationFrame = window[vendors[x] + 'RequestAnimationFrame'];
				window.cancelAnimationFrame = window[vendors[x] + 'CancelAnimationFrame'] || window[vendors[x] + 'CancelRequestAnimationFrame'];
			}

			if (!window.requestAnimationFrame) window.requestAnimationFrame = function (callback, element) {
				var currTime = new Date().getTime();
				var timeToCall = Math.max(0, 16 - (currTime - lastTime));
				var id = window.setTimeout(function () {
					callback(currTime + timeToCall);
				},
				timeToCall);
				lastTime = currTime + timeToCall;
				return id;
			};

			if (!window.cancelAnimationFrame) window.cancelAnimationFrame = function (id) {
				clearTimeout(id);
			};
		}());


		var canvas = document.getElementById("canvas");
		var ctx = canvas.getContext("2d");
		ctx.lineCap = "round";

		// variable to hold how many frames have elapsed in the animation
		var t = 1;

		// define the path to plot
		var vertices = [];
		vertices.push({
			x: 0,
			y: 0
		});
		vertices.push({
			x: 300,
			y: 100
		});
		vertices.push({
			x: 80,
			y: 200
		});
		vertices.push({
			x: 10,
			y: 100
		});
		vertices.push({
			x: 0,
			y: 0
		});

		// draw the complete line
		ctx.lineWidth = 1;
		// tell canvas you are beginning a new path
		ctx.beginPath();
		// draw the path with moveTo and multiple lineTo's
		ctx.moveTo(0, 0);
		ctx.lineTo(300, 100);
		ctx.lineTo(80, 200);
		ctx.lineTo(10, 100);
		ctx.lineTo(0, 0);
		// stroke the path
		ctx.stroke();


		// set some style
		ctx.lineWidth = 5;
		ctx.strokeStyle = "blue";
		// calculate incremental points along the path
		var points = calcWaypoints(vertices);
		// extend the line from start to finish with animation
		animate(points);


		// calc waypoints traveling along vertices
		function calcWaypoints(vertices) {
			var waypoints = [];
			for (var i = 1; i < vertices.length; i++) {
				var pt0 = vertices[i - 1];
				var pt1 = vertices[i];
				var dx = pt1.x - pt0.x;
				var dy = pt1.y - pt0.y;
				for (var j = 0; j < 100; j++) {
					var x = pt0.x + dx * j / 100;
					var y = pt0.y + dy * j / 100;
					waypoints.push({
						x: x,
						y: y
					});
				}
			}
			return (waypoints);
		}


		function animate() {
			if (t < points.length - 1) {
				requestAnimationFrame(animate);
			}
			// draw a line segment from the last waypoint
			// to the current waypoint
			ctx.beginPath();
			ctx.moveTo(points[t - 1].x, points[t - 1].y);
			ctx.lineTo(points[t].x, points[t].y);
			ctx.stroke();
			// increment "t" to get the next waypoint
			t++;
		}
	</script>
</body>
</html>
