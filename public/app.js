var SimpleGame = (function () {
    function SimpleGame() {
        this.game = new Phaser.Game(2000 , 2000, Phaser.CANVAS, 'content', { preload: this.preload, create: this.create, update: this.update, render: this.render });
    }
    SimpleGame.prototype.preload = function () {
        this.game.load.image('background', '/bilder/background.jpg');
        this.game.load.image('Map1', '/assets/misc/Map1/Viridian_City_Map.png');
        this.game.load.image('house', '/assets/misc/Map1/TopLeftN.png');
        this.game.load.image('heightmap', 'assets/misc/Map1/Heightmap.png');
        this.game.load.spritesheet('button', 'assets/buttons/button_sprite_sheet.png', 100, 100);
        this.game.load.spritesheet('player', 'assets/misc/Player/Player_Sprite.png', 19, 27);
    };
    SimpleGame.prototype.create = function () {
        this.game.scale.scaleMode = Phaser.ScaleManager.SHOW_ALL;
        this.game.scale.pageAlignHorizontally = true;
        this.game.scale.pageAlignVertically = true;
        this.logo = this.game.add.sprite(this.game.world.centerX, this.game.world.centerY, 'background');
        this.logo.anchor.setTo(0.5, 0.5);
        this.logo.scale.setTo(0.2, 0.2);
        this.game.add.tween(this.logo.scale).to({ x: 1, y: 1 }, 2000, Phaser.Easing.Circular.Out, true);
        this.button = this.game.add.button(this.game.world.centerX - 95, 750, 'button', actionOnClick, this, 2, 1, 0);
        this.button.onInputOver.add(over, this);
        this.button.onInputOut.add(out, this);
        this.button.onInputUp.add(up, this);
        this.map1 = this.game.add.sprite(560, 464, 'Map1');
        //this.map1.anchor.setTo(0.5, 0.5);
        this.map1.visible = false;
        this.player = this.game.add.sprite(this.game.world.centerX / 2, this.game.world.centerY, 'player');
        this.player.name = "undefined";
        this.player.visible = false;
        //this.house = this.game.add.sprite(380,0, 'house');
        //this.house.name = "undefined";
        //this.house.visible = false;
        //Reservieren der Pfeiltasten für das Spiel. Dadurch wird verhindert, dass die Scrollbars der Website nicht darauf reagieren.
        var upKey;
        var downKey;
        var leftKey;
        var rightKey;
        upKey = this.game.input.keyboard.addKey(Phaser.Keyboard.UP);
        downKey = this.game.input.keyboard.addKey(Phaser.Keyboard.DOWN);
        leftKey = this.game.input.keyboard.addKey(Phaser.Keyboard.LEFT);
        rightKey = this.game.input.keyboard.addKey(Phaser.Keyboard.RIGHT);
        this.game.stage.backgroundColor = '#000000';
        this.bmd = this.game.make.bitmapData(1120, 928);
        this.bmd.draw('heightmap');
        this.bmd.update();
    };
    SimpleGame.prototype.update = function () {
        var speed = 4;
  if (this.game.input.keyboard.isDown(Phaser.Keyboard.LEFT)) {
          //  alert("Oke");
            if (this.bmd.getPixelRGB(this.player.x - 1, this.player.y).r > 0 && this.bmd.getPixelRGB(this.player.x - 1, this.player.y).g > 0 && this.bmd.getPixelRGB(this.player.x - 1, this.player.y).b > 0)
                this.player.x -= speed;
            this.player.frame = 1;
        }
        else if (this.game.input.keyboard.isDown(Phaser.Keyboard.RIGHT)) {
            if (this.bmd.getPixelRGB(this.player.x + 1, this.player.y).r > 0 && this.bmd.getPixelRGB(this.player.x + 1, this.player.y).g > 0 && this.bmd.getPixelRGB(this.player.x + 1, this.player.y).b > 0)
                this.player.x += speed;
            this.player.frame = 2;
        }
        else if (this.game.input.keyboard.isDown(Phaser.Keyboard.UP)) {
            if (this.bmd.getPixelRGB(this.player.x, this.player.y + 1).r > 0 && this.bmd.getPixelRGB(this.player.x, this.player.y + 1).g > 0 && this.bmd.getPixelRGB(this.player.x, this.player.y + 1).b > 0)
                this.player.y -= speed;
            this.player.frame = 5;
        }
        else if (this.game.input.keyboard.isDown(Phaser.Keyboard.DOWN)) {
            if (this.bmd.getPixelRGB(this.player.x, this.player.y - 1).r > 0 && this.bmd.getPixelRGB(this.player.x, this.player.y - 1).g > 0 && this.bmd.getPixelRGB(this.player.x, this.player.y - 1).b > 0)
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
    this.logo.visible = false;
    this.button.visible = false;
    this.map1.visible = true;
    this.player.visible = true;
    this.player.frame = 1;
    //this.house.visible = true;
    this.game.stage.backgroundColor = '#2d2d2d';
    //  This will check Sprite vs. Sprite collision
    this.player.name = 'player';
    //this.house.name = 'house';
}
window.onload = function () {
    var game = new SimpleGame();
};
//# sourceMappingURL=app.js.map
