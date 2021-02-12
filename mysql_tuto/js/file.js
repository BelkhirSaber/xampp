/*global console*/
/*var canvas = document.getElementById('canvas'),
	context = canvas.getContext('2d');
	context.fillStyle = '#2ecc71';
	context.fillRect(10, 10, 100, 50);
	context.fillStyle = '#9b59b6';
	context.fillRect(50, 50, 100, 50);
	context.strokeStyle = '#9b59b6';
	context.lineWidth = 10;
	context.strokeRect(100, 60, 100, 50);
	context.clearRect(20, 20, 30, 30);*/

/*var canvas1 = document.getElementById('canvas1'),
	context1 = canvas1.getContext('2d'),
	canvasWidth = canvas1.width,
	canvasHeight = canvas1.height;
	context1.fillStyle="#F5F5F5";
	context1.fillRect(0, 0, canvasWidth, canvasHeight);
	context1.strokeStyle="#0F0";
	context1.lineWidth = 5;

	// line top left 
	context1.moveTo(10, 10);
	context1.lineTo(230, 230);

	// line top right
	context1.moveTo(490, 10);
	context1.lineTo(270, 230);

	//line bottom left
	context1.moveTo(10, 490);
	context1.lineTo(230, 270);

	//line bottom right
	context1.moveTo(490, 490);
	context1.lineTo(270, 270);
	context1.stroke();*/
	var elementCanvas = document.createElement('canvas');
		elementCanvas.id = 'canvas';
		elementCanvas.style.display = 'block';
		elementCanvas.style.border = '1px solid #CCC';
		elementCanvas.style.margin = '50px auto';
		elementCanvas.width = 600;
		elementCanvas.height = 100;

		document.body.appendChild(elementCanvas);

	var canvas = document.getElementById('canvas'),
		context = canvas.getContext('2d');
		context.fillStyle = '#000';
		context.strokeStyle = '#000';
		context.font = '50px Arial';
		context.strokeText('saber', 50, 60, 200);
		context.fillText('belkhir', 50, 80, 200);



















