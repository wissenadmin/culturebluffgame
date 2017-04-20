<html>
    <head>
        <title>Game</title>
        <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport">
        <meta charset="utf-8">
        <meta content="telephone=no" name="format-detection">
        <meta content="SKYPE_TOOLBAR_PARSER_COMPATIBLE" name="SKYPE_TOOLBAR">
        <meta content="IE=edge" http-equiv="X-UA-Compatible">

        <meta content="width=device-width, initial-scale=1" name="viewport">
          <link href="{{url('')}}/resources/dashboard/css/bootstrap.css" rel="stylesheet">
        <link type="text/css" rel="stylesheet" href="{{url('/resources/views/front/game/htmlQuiz')}}/css/bootstrap.css">
        <link type="text/css" rel="stylesheet" href="{{url('/resources/views/front/game/htmlQuiz')}}/css/main.css">
        <script src="{{url('/resources/views/front/game/htmlQuiz')}}/js/jquery.js"></script>
        <script src="{{url('/resources/views/front/game/htmlQuiz')}}/js/bootstrap.js"></script>
        <script src="{{url('/resources/views/front/game/htmlQuiz')}}/js/controller.js"></script>
        <script src="{{url('')}}/resources/dashboard/js/bootstrap.min.js"></script>
    </head>
    <body>
        <audio id="swirl" src="{{url('/resources/views/front/game/htmlQuiz')}}/sound/swirl.wav" ></audio>
        <audio id="correct" src="{{url('/resources/views/front/game/htmlQuiz')}}/sound/correct.wav" ></audio>
        <audio id="wrong" src="{{url('/resources/views/front/game/htmlQuiz')}}/sound/wrong.wav"></audio>


        <div id="main-page start-page" class="firstdiv" >
            <header>
                <div class="top-heading">
                    <h1>Culture Buff Britain <br>GAME 1</h1>
                </div>
            </header>
            <main>
                <div class="container">
                    <div class="wrapper clearfix">
                        <div class="main-scren-img">
                            <img src="{{url('/resources/views/front/game/htmlQuiz')}}/images/mainscreen-img.jpg">
                        </div>
                        <a  class="next-btn btn button goinstructions">Go to Game</a> 
                    </div>
                </div>
            </main>
        </div>


        <div id="main-page"  class="instructions hide">
            <header>
                <div class="top-heading">
                    <h1>Instructions</h1>
                </div>
            </header>
            <main>
                <div class="container">
                    <div class="wrapper instructions-page clearfix">
                        <div class="instruction-wrap">
                            <div class="small-cartoon">
                                <img src="{{url('/resources/views/front/game/htmlQuiz')}}/images/big-cartoon.jpg">
                            </div>
                            <div class="inst-text">
                                <h3>Match the<br> 
                                    cartoon<br> 
                                    with the value<br>
                                    Good luck !
                                </h3>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-10">
                                <ul>
                                    <li>1st attempt 4 points</li>
                                    <li>2nd attempt 3 points</li>
                                    <li>3rd attempt 2 points</li>
                                    <li>4th attempt 1 point</li>
                                </ul>
                            </div>
                        </div>
                        <a  class="start-game btn button startbtn">Start Game</a> 
                    </div>
                </div>
            </main>
        </div>


        <div id="main-page" class="game1play hide" >
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-3 col-sm-3">
                        <div class="top-logo">
                            <img src="{{url('/resources/views/front/game/htmlQuiz')}}/images/main-logo.png">
                        </div>
                        <div class="difficulty"></div>
                        <div class="question_number"></div>
                        <div class="left-part"></div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                    </div>
                    <div class="col-md-3 col-sm-3">
                        <div class="score-box">
                            <p>Score:</p>
                            <div class="score">0</div>
                        </div>
                        <div class="title">
                            <div class="questionText">What is the value?</div>
                        </div>
                        <div class="ques-box clearfix"></div>
                        <div class="right-part"></div>
                    </div>
                </div>
            </div>
        </div>

        <script type="text/javascript">
            $(document).ready(function(){
              //alert("ad");
              $(".goinstructions").click(function(){
                $(".firstdiv").addClass("hide");
                $(".instructions").removeClass("hide");
              })

              $(".startbtn").click(function(){
                $(".instructions").addClass("hide");
                $(".game1play").removeClass("hide");
              })
            })
        </script>
    </body>
</html>