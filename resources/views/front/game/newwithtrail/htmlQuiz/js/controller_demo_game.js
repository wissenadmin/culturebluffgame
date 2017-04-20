$(document).ready(function () {
	
var questionNumber=0;
var questionBank=new Array();
var stage="#game1";
var stage2=new Object;
var questionLock=false;
var numberOfQuestions;
var score=0;
var isTest = false;
var currentQuestionChance = 0;
currentQuestionScore = new Array;
currentQuestionScore[0] = 4;
currentQuestionScore[1] = 3;
currentQuestionScore[2] = 2;
currentQuestionScore[3] = 1;
lastQuestionAnswered = 0;

 		$.getJSON('activity_demo.json', function(data) {

		for(i=0;i<data.quizlist.length;i++){ 
			questionBank[i]=new Array;			
			questionBank[i][0]=data.quizlist[i].question;
			questionBank[i][1]=data.quizlist[i].option1;
			questionBank[i][2]=data.quizlist[i].option2;
			questionBank[i][3]=data.quizlist[i].option3;
			questionBank[i][4]=data.quizlist[i].option4;
			questionBank[i][5]=data.quizlist[i].image;
			questionBank[i][6]=data.quizlist[i].description;
			questionBank[i][7]=data.quizlist[i].difficulty;
			questionBank[i][8]="";
		}
		
		numberOfQuestions=questionBank.length; 		
		
		
		displayQuestion(false);
		})//gtjson
 

 


function displayQuestion(isPrev){
 var rnd = 0;
 var s =  "";
 var flip = "";
 if(isPrev){ 	
 	rnd = questionBank[questionNumber][8];
 }else{
 	rnd=Math.random()*4;
    rnd=Math.ceil(rnd);
 	questionBank[questionNumber][8] = rnd; 
 }
 
 var q1;
 var q2;
 var q3;
 var q4;
if(rnd==1){q1=questionBank[questionNumber][1];q2=questionBank[questionNumber][2];q3=questionBank[questionNumber][3];q4=questionBank[questionNumber][4];}
if(rnd==2){q2=questionBank[questionNumber][1];q3=questionBank[questionNumber][2];q4=questionBank[questionNumber][3];q1=questionBank[questionNumber][4];}
if(rnd==3){q3=questionBank[questionNumber][1];q4=questionBank[questionNumber][2];q1=questionBank[questionNumber][3];q2=questionBank[questionNumber][4];}
if(rnd==4){q4=questionBank[questionNumber][1];q1=questionBank[questionNumber][2];q2=questionBank[questionNumber][3];q3=questionBank[questionNumber][4];}

if(isPrev == true){
	for (var i = 1; i <= 4; i++) {
			var qOpt = "";
				if(i==1){
					qOpt = q1;
				}else if(i==2){
					qOpt = q2;
				}else if(i==3){
					qOpt = q3;
				}else{
					qOpt = q4;
				}

			if(rnd != i){				
				s = s + '<div id="' + i + '" class="option wrong">' + qOpt + '</div>';
			}else{
				s = s + '<div id="' + i + '" class="option">' + qOpt + '<img src="right-icon.png"></div>';
			}
	}
	flip = '<img class="imgFlip" src="images/rotate-img.png">';
}else{

	s = '<div id="1" class="option">'+q1+'</div><div id="2" class="option">'+q2+'</div><div id="3" class="option">'+q3+'</div><div id="4" class="option">'+q4+'</div>';
}

var star = 1;

if(questionBank[questionNumber][7] == "H"){
 star = 3;
}

str = "";

for (var i = 1; i <= star; i++) {
	str = str + '<li><img src="star_gold_256.png"></li>';
}

$(".difficulty").empty();
$(".difficulty").append('<h4>Difficulty Level</h4><ul>' + str +'</ul>');
$(".question_number").html( (questionNumber+1) + " of " + questionBank.length);
$(".ques-box").empty();
$(".ques-box").append(s);
$(".col-md-6").empty();
$(".col-md-6").append('<div class="image"><div class="box-shad"><div class="img-box"><div id="f1_container"><div id="f1_card" class="shadow"><div class="front face"><img width="" height="" src="images/GAME1/'+questionBank[questionNumber][5]+'"> </div><div class="back face center">  <p>'+questionBank[questionNumber][6]+'</p> </div></div> </div> </div></div><div class="flip-front">'+ flip +'</div></div>');

$(".prev1").remove();
$(".left-part").append('<div class="prev1" title="Prev"></div>');
if(questionNumber == 0){
	$(".prev1").remove();
}

if(isPrev == true){
	$(".next").remove();
	$(".right-part").append('<div class="next" title="Next"></div>');
}
		



$('.option').click(function(){

  if(questionLock==false){	  
  	
  	if($(this).hasClass("wrong"))
  		{
  			return; //as this option is already clicked and no need to work on it
  		}

  $(".imgFlip").remove();	
  	$(".feedback2").remove();
  	$(".feedback1").remove();
  
  	currentQuestionChance++; 
  	if(currentQuestionChance > 4){
  		currentQuestionChance = 4;
  	}
  //correct answer
  if(this.id==rnd){
  	
   lastQuestionAnswered = questionNumber;
   questionLock=true;
  

   $(".option").addClass("wrong");
  // $(".option img").remove();
 //  $(".option").append('<img src="wrong-icon.png" class="w">');

   $(this).removeClass("wrong");//this is the right option hence remove wrong from correct option
 //  $(this).remove(".w");
   $(".next").remove();
   $(this).append('<img src="right-icon.png">');
   score += currentQuestionScore[currentQuestionChance-1];   
   playSound("correct.wav");
  setTimeout(function(){
  //	alert("hi");
   		$(".right-part").append('<div class="next" title="Next"></div>');
        $("#f1_container #f1_card").toggleClass("f1_container_flip");
		$(".flip-front").append('<img class="imgFlip" src="images/rotate-img.png">');
		playSound("swirl.wav");
	}, 1000); 
   
   }
  //wrong answer	
  if(this.id!=rnd){
  	$(this).addClass("wrong");
  	$(this).append('<img src="wrong-icon.png" class="w">');
   playSound("wrong.wav");
  }

  $(".score").html(score);
 }})
}//display question

function playSound(soundFile){ 	

//	$("audio").stop();
	//var audioElement = document.createElement('audio');       
    //audioElement.setAttribute('autoplay', 'autoplay');       

	//audioElement.setAttribute('src', 'sound/'+soundFile);
	
var res = soundFile.split("."); 
var audioElement = document.getElementById(res[0]);
	audioElement.pause();
	audioElement.currentTime=0;
    audioElement.play();
}

$(".right-part").on('click', '.next', function(){	
	currentQuestionChance = 0;
	
	changeQuestion();	
});

$(".left-part").on('click', '.prev1', function(){	
	if(questionNumber == 0){
		$this.css("display","none");
	}else{		
		prevQuestion();
	}

	
});

$(".col-md-6").on('click', '.imgFlip', function(){	
	playSound("swirl.wav");	
	$("#f1_container #f1_card").toggleClass("f1_container_flip");		
});



	
	
	function changeQuestion(){
		
		questionNumber++;
	
	if(questionNumber<numberOfQuestions){
		if(questionNumber>lastQuestionAnswered){
			displayQuestion(false);
		}else{
			displayQuestion(true);
		}

	}else{displayFinalSlide();}
	 
		 
 	 if(questionNumber <= lastQuestionAnswered) {
 	 	$(".next").remove();
		$(".right-part").append('<div class="next" title="Next"></div>'); 	 
	 }else{
	 	$(".next").remove();
	 }

	 if(questionNumber > lastQuestionAnswered) 
	 		questionLock=false; 
	 	else 
	 		questionLock=true;	 

	
	}//change question
	
	function prevQuestion(){
		
	questionNumber--;
	
	
	if(questionNumber>=0){displayQuestion(true);}
	

	 
	
	}//change question
		
	function displayFinalSlide(){
		$("#main-page").empty();
		$("#main-page").append('    <main><div class="container"><div class="wrapper clearfix"><div class="total-score"><div class="top-logo"><img src="images/big-cartoon.jpg"></div><div class="score-content"><h4>Congratulations you have finished <br>Culture Buff Britain trial game.</h4><ul><li><p>Your total score is <span> '+ score + '/8</span></p></li><li>Do you want to try again ?</li></ul> <a href="game_demo.html" class="btn button restartbtn"> Restart Game </a>   </div>  <div class="visit"> Visit www.culturebuff.com to purchase the complete game </div> </div> </div></div> </main>');

		//$("#main-page").append('<div class="questionText">You have finished the quiz!<br><br>Total questions: '+numberOfQuestions+'<br>Score: '+score+'</div> <div class="replay"><a href="http://ds08.projectstatus.co.uk/britishvalues/htmlQuiz/index.html">Replay</a></div> <div class="quit"><a href="index.html">Quit</a></div>');
		
	}//display final slide
	
});
