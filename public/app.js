var SimpleGame = (function () {
    function SimpleGame() {
        this.game = new Phaser.Game(560 , 428, Phaser.AUTO, 'content', { preload: this.preload, create: this.create, update: this.update, render: this.render });
    }
    SimpleGame.prototype.preload = function () {
        this.game.load.image('Map1', '/assets/misc/Map1/Viridian_City_Map.png');
        this.game.load.image('heightmap', 'assets/misc/Map1/Heightmap.png');
		this.game.load.image('texBox', 'assets/misc/Chat/chatBox.png');
      //  this.game.load.spritesheet('button', 'assets/buttons/button_sprite_sheet.png', 100, 100);
        this.game.load.spritesheet('player', 'assets/misc/Player/Player_Sprite.png', 19, 27);
    };
    SimpleGame.prototype.create = function () {
        this.game.scale.scaleMode = Phaser.ScaleManager.SHOW_ALL;
        this.game.scale.pageAlignHorizontally = true;
        this.game.scale.pageAlignVertically = true;

		
        this.bmd = this.game.make.bitmapData(1120, 928);
        this.bmd.draw('heightmap',0,0,this.game.width,this.game.height);
        this.bmd.update();
		
		this.map1 = this.game.add.sprite(0, 0, 'Map1');

		this.map1.width = this.game.width;
		this.map1.height = this.game.height;
		
        this.player = this.game.add.sprite(300,400, 'player');
        this.player.name = "undefined";

		
		this.texBox = this.game.add.sprite(this.world.centerX, this.world.centerY, 'texBox');
        this.texBox.name = "chat";
        this.texBox.visible = false;
		
        //Reservieren der Pfeiltasten für das Spiel. Dadurch wird verhindert, dass die Scrollbars der Website nicht darauf reagieren.
        var upKey;
        var downKey;
        var leftKey;
        var rightKey;
        upKey = this.game.input.keyboard.addKey(Phaser.Keyboard.UP);
        downKey = this.game.input.keyboard.addKey(Phaser.Keyboard.DOWN);
        leftKey = this.game.input.keyboard.addKey(Phaser.Keyboard.LEFT);
        rightKey = this.game.input.keyboard.addKey(Phaser.Keyboard.RIGHT);
       // this.game.stage.backgroundColor = '#000000';

		
		this.text = this.game.add.text(516,1015, "- You have clicked -\n0 times !", {
        font: "20px Arial",
        fill: "#ff0044",
        align: "center"
    });
	this.text.visible = false;
		
    };
    SimpleGame.prototype.update = function () {
        var speed = 2;
	if (this.game.input.keyboard.isDown(Phaser.Keyboard.LEFT)) {
			
			var isMoveable = 0; 

			for(var y = 0; y <= 27; y++)
			{
				if (this.bmd.getPixelRGB(this.player.x - speed, this.player.y + y).r == 0 && this.bmd.getPixelRGB(this.player.x - speed, this.player.y + y).g == 0 && this.bmd.getPixelRGB(this.player.x - speed, this.player.y + y).b == 0)
				{
					isMoveable = 1;
					break;
				}
				else if (this.bmd.getPixelRGB(this.player.x + speed + 18, this.player.y + y).r == 0 && this.bmd.getPixelRGB(this.player.x + speed + 18, this.player.y + y).g == 255 && this.bmd.getPixelRGB(this.player.x + speed + 18, this.player.y + y).b == 96)
				{
					if(getRndInteger(0,4000) == 1)
					{	
						this.text.visible = true;
						this.texBox.visible = true;
						this.text.setText("Pokemon appeard");
					}
				}
			}
			if(isMoveable == 0)
				this.player.x -= speed;
            this.player.frame = 1;
        }
        else if (this.game.input.keyboard.isDown(Phaser.Keyboard.RIGHT)) {
			
			var isMoveable = 0; 
			for(var y = 0; y <= 27; y++)
			{
				if (this.bmd.getPixelRGB(this.player.x + speed + 18, this.player.y + y).r == 0 && this.bmd.getPixelRGB(this.player.x + speed + 18, this.player.y + y).g == 0 && this.bmd.getPixelRGB(this.player.x + speed + 18, this.player.y + y).b == 0)
				{
					isMoveable = 1;
					break;
				}
				else if (this.bmd.getPixelRGB(this.player.x + speed + 18, this.player.y + y).r == 0 && this.bmd.getPixelRGB(this.player.x + speed + 18, this.player.y + y).g == 255 && this.bmd.getPixelRGB(this.player.x + speed + 18, this.player.y + y).b == 96)
				{
					if(getRndInteger(0,4000) == 1)
					{	
						this.text.visible = true;
						this.texBox.visible = true;
						this.text.setText("Pokemon appeard");
					}
				}
			}
			if(isMoveable == 0)
				this.player.x += speed;
            this.player.frame = 2;
        }
        else if (this.game.input.keyboard.isDown(Phaser.Keyboard.UP)) {
			
			var isMoveable = 0; 
			for(var x = 0; x <= 18; x++)
			{
				if (this.bmd.getPixelRGB(this.player.x + x, this.player.y - speed).r == 0 && this.bmd.getPixelRGB(this.player.x + x, this.player.y - speed).g == 0 && this.bmd.getPixelRGB(this.player.x + x, this.player.y - speed).b == 0)
				{
					isMoveable = 1;
					break;
				}
			}
			if(isMoveable == 0)
				this.player.y -= speed;
            this.player.frame = 3;
        }
        else if (this.game.input.keyboard.isDown(Phaser.Keyboard.DOWN)) {
			
			var isMoveable = 0; 
			for(var x = 0; x <= 18; x++)
			{
				if (this.bmd.getPixelRGB(this.player.x + x, this.player.y + speed + 27).r == 0 && this.bmd.getPixelRGB(this.player.x + x, this.player.y + speed + 27).g == 0 && this.bmd.getPixelRGB(this.player.x + x, this.player.y + speed + 27).b == 0)
				{
					isMoveable = 1;
					break;
				}
			}
			if(isMoveable == 0)
				this.player.y += speed;
            this.player.frame = 4;
        }
        //if (this.player.name != "undefined" && this.house.name != "undefined")
        //    this.game.physics.arcade.collide(this.player, this.house);
    };
    SimpleGame.prototype.render = function () {
        //if (this.player.name != "undefined")
        //    this.game.debug.bodyInfo(this.house, 19, 27);
    };
	
	function getRndInteger(min, max) {
		return Math.floor(Math.random() * (max - min + 1) ) + min;
	}
    return SimpleGame;
})();



function up() {
    console.log('button up', arguments);
}
function over() {
    console.log('button over');
}
function out() {
    console.log('button out');
}
function actionOnClick() {
	
  /*   this.logo.visible = false;
    this.button.visible = false; */

    this.player.frame = 1;
    //this.house.visible = true;
//    this.game.stage.backgroundColor = '#2d2d2d';
    //  This will check Sprite vs. Sprite collision
    this.player.name = 'player';
    //this.house.name = 'house';
}
window.onload = function () {
    var game = new SimpleGame();
};
//# sourceMappingURL=app.js.map
