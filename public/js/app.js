var SimpleGame = (function () {
    function SimpleGame() {
        this.game = new Phaser.Game(720 , 588, Phaser.AUTO, 'content', { preload: this.preload, create: this.create, update: this.update, render: this.render });
    }
    SimpleGame.prototype.preload = function () {
        this.game.load.image('map1', '/assets/misc/Screens/Map1/Viridian_City_Map.png');
		this.game.load.image('battle', '/assets/misc/Screens/Battle.png');
        this.game.load.image('heightmap', 'assets/misc/Screens/Map1/Heightmap.png');
		this.game.load.image('texBox', 'assets/misc/Chat/chatBox.png');
		this.game.load.image('labor', 'assets/misc/Screens/labor.png');
      //  this.game.load.spritesheet('button', 'assets/buttons/button_sprite_sheet.png', 100, 100);
        this.game.load.spritesheet('player', 'assets/misc/Player/Player_Sprite.png', 19, 27);
		this.game.load.spritesheet('prof', 'assets/misc/NPC/Prof Halil.png', 389, 377);
		this.game.load.spritesheet('nextDialog', 'assets/buttons/nextDialog.png', 75, 74);
		this.game.load.image('myPokemon', 'assets/misc/Pokemon/Bisasam_Back.png');
		this.game.load.spritesheet('aiPokemon', 'assets/misc/Pokemon/pokemon_sprite.png',35,43);
		
    };
    SimpleGame.prototype.create = function () {
        this.game.scale.scaleMode = Phaser.ScaleManager.SHOW_ALL;
        this.game.scale.pageAlignHorizontally = true;
        this.game.scale.pageAlignVertically = true;

		
        this.bmd = this.game.make.bitmapData(1120, 928);
        this.bmd.draw('heightmap',0,0,this.game.width,this.game.height);
        this.bmd.update();
		
		this.map1 = this.game.add.sprite(0, 0, 'map1');
		this.map1.width = this.game.width;
		this.map1.height = this.game.height;
		
		this.labor = this.game.add.sprite(0, 0, 'labor');
		this.labor.width = this.game.width;
		this.labor.height = this.game.height;
		this.labor.visible = false;
		
		this.battle = this.game.add.sprite(0, 0, 'battle');
		this.battle.width = this.game.width;
		this.battle.height = this.game.height;
		this.battle.visible = false;		
		
        this.player = this.game.add.sprite(300,400, 'player');
		this.player.width = this.player.width / 2;
		this.player.height = this.player.height / 2;
        this.player.name = "undefined";

		this.prof = this.game.add.sprite(0,this.game.height - 163, 'prof');
		this.prof.width = this.prof.width / 2;
		this.prof.height= this.prof.height / 2;
		this.prof.visible = false;
		
		var offset = this.game.width / 2 - 499 / 2;
		
		this.texBox = this.game.add.sprite(Math.round(offset),this.game.height - 98, 'texBox');

        this.texBox.name = "chat";
        this.visible = true;
		
		this.nextDialog = this.game.add.button(this.texBox.x + this.texBox.width - 50,this.game.height - 45, 'nextDialog', nextDialogEvent, this, 0,1,2);
		this.nextDialog.width /= 2;
		this.nextDialog.height /= 2;
		this.nextDialog.visible = false;
		
		this.aiPokemon = this.game.add.sprite(this.game.width / 2 + 120,this.game.height / 7 + 20, 'aiPokemon');
		this.aiPokemon.width *= 3;
		this.aiPokemon.height*= 3;
		this.aiPokemon.visible = false;
		
		this.myPokemon = this.game.add.sprite(this.game.width / 7 - 35,this.game.height / 3 + 25, 'myPokemon');
		this.myPokemon.width *= 3;
		this.myPokemon.height*= 3;
		this.myPokemon.visible = false;
		
		
		 var infoBattle = this.game.add.text(30,this.game.height / 2 + 140,"Kampf beginnt", { fill: "#ff0044"});
		
		    var atk1 = this.game.add.text(this.game.width / 5 + 200,this.game.height / 2 + 140,"atk1");
		    atk1.inputEnabled = true;
			atk1.events.onInputDown.add(down, this, 0, 1);
			
		    var atk2 = this.game.add.text(this.game.width / 2 + 200,this.game.height / 2 + 140,"atk2");
		    atk2.inputEnabled = true;
			atk2.events.onInputDown.add(down, this, 0, 2);
			
		    var atk3 = this.game.add.text(this.game.width / 5 + 200,this.game.height / 2 + 230,"atk3");
		    atk3.inputEnabled = true;
			atk3.events.onInputDown.add(down, this, 0, 3);
								
		    var atk4 = this.game.add.text(this.game.width / 2 + 200,this.game.height / 2 + 230,"atk4");
		    atk4.inputEnabled = true;
			atk4.events.onInputDown.add(down, this, 0, 4);
		
		atk1.input.useHandCursor = true;
		atk2.input.useHandCursor = true;
		atk3.input.useHandCursor = true;
		atk4.input.useHandCursor = true;
		infoBattle.visible = false;
		atk1.visible = false;
		atk2.visible = false;
		atk3.visible = false;
		atk4.visible = false;
		
		
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
	   
		
		this.text = this.game.add.text(this.texBox.x + 15,this.texBox.y + 5, "", {
        font: "20px Arial",
        fill: "#ff0044",
        align: "center"
    });
	this.text.visible = false;
	
			this.enemyText = this.game.add.text(54,72, "Enemy", {
        font: "20px Arial",
        fill: "#292929",
        align: "center"
    });
	
			this.myText = this.game.add.text(420,280, "My Text", {
        font: "20px Arial",
        fill: "#292929",
        align: "center"
    });	

	
	this.enemyText.visible = false;
	this.myText.visible = false;
	this.texBox.visible = false;
	
	setUp(this.myText,this.enemyText,this.myPokemon,this.aiPokemon, atk1,atk2,atk3,atk4,infoBattle);
	//newPlayer(this.labor,this.map1,this.player,this.prof,this.texBox,this.text,this.nextDialog);
	
	//writeBattleInfo(this.enemyText,this.myText,randomPokemon(), loadMyPokemon());
    };
    SimpleGame.prototype.update = function () {      

	if(this.map1.visible == true && this.texBox.visible == false)
	{
	var speed = 2;
	if (this.game.input.keyboard.isDown(Phaser.Keyboard.LEFT)) {
			
			var isMoveable = 0; 
			this.prof.frame = 1;
			
			for(var y = 0; y <= Math.round(this.player.height); y++)
			{
				if (this.bmd.getPixelRGB(this.player.x - speed, this.player.y + y).r == 0 && this.bmd.getPixelRGB(this.player.x - speed, this.player.y + y).g == 0 && this.bmd.getPixelRGB(this.player.x - speed, this.player.y + y).b == 0)
				{
					isMoveable = 1;
					break;
				}
				else if (this.bmd.getPixelRGB(this.player.x - speed, this.player.y + y).r == 0 && this.bmd.getPixelRGB(this.player.x - speed, this.player.y + y).g == 255 && this.bmd.getPixelRGB(this.player.x - speed, this.player.y + y).b == 96)
				{
					if(getRndInteger(0,3000) == 1)
					{	
						openDialog(this.texBox,0,this.text,this.nextDialog);
					}
				}
			}
			if(isMoveable == 0)
				this.player.x -= speed;
            this.player.frame = 1;
        }
        else if (this.game.input.keyboard.isDown(Phaser.Keyboard.RIGHT)) {
				
			var isMoveable = 0; 
			this.prof.frame = 2;
			
			for(var y = 0; y <= Math.round(this.player.height); y++)
			{
				if (this.bmd.getPixelRGB(this.player.x + speed + Math.round(this.player.width), this.player.y + y).r == 0 && this.bmd.getPixelRGB(this.player.x + speed + Math.round(this.player.width), this.player.y + y).g == 0 && this.bmd.getPixelRGB(this.player.x + speed + Math.round(this.player.width), this.player.y + y).b == 0)
				{
					isMoveable = 1;
					break;
				}
				else if (this.bmd.getPixelRGB(this.player.x + speed + Math.round(this.player.width), this.player.y + y).r == 0 && this.bmd.getPixelRGB(this.player.x + speed + Math.round(this.player.width), this.player.y + y).g == 255 && this.bmd.getPixelRGB(this.player.x + speed + Math.round(this.player.width), this.player.y + y).b == 96)
				{
					if(getRndInteger(0,3000) == 1)
					{	
						openDialog(this.texBox,0,this.text,this.nextDialog);
					}
				}
			}
			if(isMoveable == 0)
				this.player.x += speed;
            this.player.frame = 2;
        }
        else if (this.game.input.keyboard.isDown(Phaser.Keyboard.UP)) {
			
			var isMoveable = 0; 
			this.prof.frame = 3;
			
			for(var x = 0; x <= Math.round(this.player.width); x++)
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
			for(var x = 0; x <= Math.round(this.player.width); x++)
			{
				if (this.bmd.getPixelRGB(this.player.x + x, this.player.y + speed + Math.round(this.player.height)).r == 0 && this.bmd.getPixelRGB(this.player.x + x, this.player.y + speed + Math.round(this.player.height)).g == 0 && this.bmd.getPixelRGB(this.player.x + x, this.player.y + speed + Math.round(this.player.height)).b == 0)
				{
					isMoveable = 1;
					break;
				}
			}
			if(isMoveable == 0)
				this.player.y += speed;
            this.player.frame = 4;
        }
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

var myText;
var pokemonSprite;
var ai_Sprite;
var my_Pokemon;
var ai_Pokemon;

var enemyText;
var dialog0 = "Pokemon erscheint,openBattle";
var dialog1 = "Oh wie ich sehe haben wir einen\rneues Gesicht in der Stadt,Möchtest du dir ein Pokemon aussuchen?,Wir haben 3 zur Auswahl";
var currentText;
var dialogIndex;

var atk1;
var atk2;
var atk3;
var atk4;
var infoBattle;

function setUp(myT,enemyT,mySprite,aiSprite, a1,a2,a3,a4,info)
{
	myText = myT;
	enemyText = enemyT;
	pokemonSprite = mySprite;
	ai_Sprite = aiSprite;
	atk1 = a1;
	atk2 = a2;
	atk3 = a3;
	atk4 = a4;
	infoBattle = info;
	loadMyPokemon();
}

function openDialog(dialogBox, dialogNum,line, nextButton)
{
	switch(dialogNum)
	{
		case 0:
		dialogIndex = 0;
		currentText= dialog0.split(",");
		line.setText(currentText[dialogIndex]);
		break;
		case 1:
		dialogIndex = 0;
		currentText= dialog1.split(",");
		line.setText(currentText[dialogIndex]);
		break;
		case 2:
		break;
	}
	
	dialogBox.visible = true;
	line.visible = true;
	nextButton.visible = true;
	
}
	
	function openFightWindow(mapPic,battlePic,player)
	{
		mapPic.visible = false;
		player.visible = false;
		battlePic.visible = true;
		randomPokemon();
	}
	
	function writeBattleInfo(ai /* ,attk1,attk2,attk3,attk4 */)
	{	
		enemyText.visible = true;
		myText.visible = true;
		pokemonSprite.visible = true;
		ai_Sprite.visible = true;
		ai_Pokemon = ai;
		
		enemyText.setText(ai_Pokemon.pokename + "\nKP:" + ai_Pokemon.kp);
		myText.setText(my_Pokemon.pokename + "\nKP:" + my_Pokemon.kp);
				
		atk1.setText(my_Pokemon.attname1);
		atk2.setText(my_Pokemon.attname2);
		atk3.setText(my_Pokemon.attname3);
		atk4.setText(my_Pokemon.attname4);
		
		infoBattle.visible = true;
		atk1.visible = true;
		atk2.visible = true;
		atk3.visible = true;
		atk4.visible = true;

	}
	
	function loadMyPokemon() {
       if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
            	var json = JSON.parse(this.responseText);
            	var objJSON = eval("(function(){return " + json + ";})()");
            	my_Pokemon = objJSON;
            }
        };
        xmlhttp.open("GET","get_Pokemon.php",true);
        xmlhttp.send();
		
		}
		
	function randomPokemon() {
			
       if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
            	var json = JSON.parse(this.responseText);
            	var objJSON = eval("(function(){return " + json + ";})()");

            	ai_Sprite.frame = objJSON.id - 1;
            	writeBattleInfo(objJSON);
            }
        };
        xmlhttp.open("GET","get_Pokemon_AI.php",true);
        xmlhttp.send();  

		}
		
		function wonFight() {
			
       if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
            	//this.responseText
            }
        };
        xmlhttp.open("GET","wonFight.php",true);
        xmlhttp.send();  

		}
	

function nextDialogEvent() {
	
	if(currentText.length == dialogIndex + 1)
	{
		this.texBox.visible = false;
		this.nextDialog.visible = false;
		this.text.visible = false;		
	}
	else 
	{
		dialogIndex += 1;
		this.text.setText(currentText[dialogIndex]);
		if(currentText[dialogIndex] == "openBattle")
		{
			this.texBox.visible = false;
			this.nextDialog.visible = false;
			this.text.visible = false;	
			openFightWindow(this.map1,this.battle,this.player);
		}
		this.prof.frame = this.prof.frame + 1;
	}
}

function newPlayer(labor,town,player,profHalil,chatBox,line,nextDialog)
{
	labor.visible = true;
	profHalil.visible = true;
	town.visible = false;
	player.visible = false;
	line.visible = true;
	nextDialog.visible = true;
	openDialog(chatBox,1,line,nextDialog);
}

function down(item,parm,atkID,mapPic,battlePic,player) {

	if(ai_Pokemon.kp == 0 || my_Pokemon.kp == 0)
		return;
    infoBattle.setText(my_Pokemon.pokename + " setzt \n" + item.text + " ein");
    var damage = 0;
    switch(atkID)
    {
    	case 1:
    	damage = my_Pokemon.attschaden1;
    	break;
      	case 2:
      	damage = my_Pokemon.attschaden2;
    	break;
       	case 3:
       	damage = my_Pokemon.attschaden3;
    	break;
       	case 4:
    	damage = my_Pokemon.attschaden4;       	
    	break;    	
    }
    
    ai_Pokemon.kp -= damage;
  	if(ai_Pokemon.kp <= 0)
  	{
  		ai_Pokemon.kp = 0;
  		infoBattle.setText("Du hast gewonnen");
  		wonFight();
  		//closeFightWindow(mapPic,battlePic,player)
  	}
  	else 
  	{
  	  switch(Math.floor(Math.random() * 4) + 1 )
    {
    	case 1:
    	damage = ai_Pokemon.attschaden1;
    	infoBattle.setText(my_Pokemon.pokename + " setzt \n" + item.text + " ein\n" + ai_Pokemon.pokename + " setzt\n" + ai_Pokemon.attname1 + " ein");
    	break;
      	case 2:
      	damage = ai_Pokemon.attschaden2;
      	infoBattle.setText(my_Pokemon.pokename + " setzt \n" + item.text + " ein\n" + ai_Pokemon.pokename + " setzt\n" + ai_Pokemon.attname2 + " ein");
    	break;
       	case 3:
       	damage = ai_Pokemon.attschaden3;
    	infoBattle.setText(my_Pokemon.pokename + " setzt \n" + item.text + " ein\n" + ai_Pokemon.pokename + " setzt\n" + ai_Pokemon.attname3 + " ein");       	
    	break;
       	case 4:
    	damage = ai_Pokemon.attschaden4;  
    	infoBattle.setText(my_Pokemon.pokename + " setzt \n" + item.text + " ein\n" + ai_Pokemon.pokename + " setzt\n" + ai_Pokemon.attname4 + " ein");
    	break;    	
    }
    my_Pokemon.kp -= damage;
   	if(my_Pokemon.kp <= 0)
  	{
  			my_Pokemon.kp = 0;
  			infoBattle.setText("Du wurdest besiegt!");
 	 }
  	}
    enemyText.setText(ai_Pokemon.pokename + "\nKP:" + ai_Pokemon.kp);
	myText.setText(my_Pokemon.pokename + "\nKP:" + my_Pokemon.kp);
}
	function closeFightWindow()
	{
		mapPic.visible = true;
		player.visible = true;
		battlePic.visible = false;
	}

window.onload = function () {
    var game = new SimpleGame();
};
//# sourceMappingURL=app.js.map
