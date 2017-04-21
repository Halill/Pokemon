var canvas;// the canvas element which will draw on
var ctx;// the "context" of the canvas that will be used (2D or 3D)
var dx = 3;// the rate of change (speed) horizontal object
var x = 500;// horizontal position of the object (with initial value)
var y = 0;// vertical position of the object (with initial value)
var WIDTH = 1120;// width of the rectangular area
var HEIGHT = 928;// height of the rectangular area
var tile1 = new Image ();// Image to be loaded and drawn on canvas
var newImg = new Image();
var heightmap;
var ctxHeightmap;
var posicao = 1;// display the current position of the character

	function KeyDown(evt){
    switch (evt.keyCode) {
        case 37:  /* Arrow to the left */
		posicao = 2;
            if (x - dx > 0){
				var color = "255,255,255,255";
				var pixelData = ctxHeightmap.getImageData(x - dx, y,1,1).data				
				if(pixelData == color)
				{
					x -= dx;
				}
			}
            break;  
        case 38:  /* Arrow up */
		posicao = 5;
            if (y - dx > 0){
				var color = "255,255,255,255";
				var pixelData = ctxHeightmap.getImageData(x, y - dx,1,1).data				
				if(pixelData == color)
				{
					y -= dx;
                }
            }
            break;  
        case 39:  /* Arrow to the right */
		posicao = 3;
            if (x + dx < WIDTH){             
				var color = "255,255,255,255";
				var pixelData = ctxHeightmap.getImageData(x + dx + 18, y,1,1).data
				
				if(pixelData == color)
				{
					  x += dx;
				}
            }
            break;  
        case 40:  /* Arrow down */
		posicao = 1;
            if (y + dx < HEIGHT){                           
				var color = "255,255,255,255";
				var pixelData = ctxHeightmap.getImageData(x, y + dx + 27,1,1).data				
				if(pixelData == color)
				{
					y += dx;
                }
            }
            break;  			
    }
}
	function Draw() {    
    tile1.src = "/Pics/" + posicao+".png";
    ctx.drawImage(tile1, x, y);
}
	function LimparTela() {
	newImg.src = '/Pics/Viridian_City_Map.png';
	ctx.drawImage(newImg,0,0) 
		newImg.src = '/Pics/Heightmap.png';
	ctxHeightmap.drawImage(newImg,0,0) 
}

	function Update() {
    LimparTela();    
    Draw();
}	
	function Start() {
	heightmap = document.getElementById("heightmap");
	ctxHeightmap = heightmap.getContext("2d");
    canvas = document.getElementById("canvas");
    ctx = canvas.getContext("2d");
    return setInterval(Update, 100);
}
	window.addEventListener('keydown', KeyDown);
Start();