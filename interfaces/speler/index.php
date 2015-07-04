<!DOCTYPE html>
<html><head>
        <meta charset="utf-8">
        <title>Watkseburde</title>
    	<meta name="viewport" content="width=580">
    	<meta name="viewport" content="width=device-width, user-scalable=no">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/normalize/3.0.3/normalize.css" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.3.0/animate.min.css" rel="stylesheet">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="pico-ui.js"></script>
        <style>
            *, *:before, *:after {
              box-sizing: border-box;
            }

            body {
                line-height: 1.5em;
            }
            /* entire container, keeps perspective */
            .flip-container {
                perspective: 1000;
                margin: 0 auto;
            }
                /* flip the pane */
                /*.flip-container:hover .flipper,*/ 
                .flip-container.turn .flipper {
                    /*transform: rotateY(180deg);*/
                }

            .flip-container, .front, .back {
                width: 320px;
                height: 480px;
            }

            /* flip speed goes here */
            .flipper {
                transition: 0.6s;
                transform-style: preserve-3d;

                position: relative;
            }

            /* hide back of pane during swap */
            .front, .back {
                /*backface-visibility: hidden;*/

                position: absolute;
                top: 0;
                left: 0;
            }
            .card {
                text-align: center;
                cursor: pointer;
                background-size: cover;
                border: 10px solid #fff;
                border-radius: 10px;
                margin-top: 20px;
                box-shadow: 1px 1px 4px #ccc;
                background: #ffcb66;

            }
            .card form {
                padding: 0 25px 50px;
            }
            /* front pane, placed above back */
            .front {
                z-index: 2;
                /* for firefox 31 */
                /*transform: rotateY(0deg);*/
                background: #ffcb66;

            }

            /* back, initially hidden pane */
            .back {
                /*transform: rotateY(180deg);*/
                background: url(marsbg.jpg);
                background-size: cover;
            }
            .gametitle {
                font-size: 40px;
                color: #fff;
                /*text-shadow: 1px 1px 0px rgba(0,0,0,0.5);*/
            }       
            button[type=submit] {
                display: block;
                margin: 20px auto;
                background: #BB7627;
                padding: 10px 20px;
                text-align: center;
                color: #fff;
                border-radius: 5px;
                border: 0;
                border-bottom: 3px solid rgba(129, 94, 15, 0.5);
                font-size: 20px;
            }
        h1 {
            font-size: 22px;
            color: rgba(0,0,0,0.4);
        } 
        input[type=number] {
            font-size: 30px;
            max-width: 100%;
            color: #888;
            text-align: center;
            letter-spacing: 5px;
        }
        .rules {
            font-size: 14px;
            font-style: italic;
            color: rgba(0,0,0,0.5);
        }
        .answer {
            font-size: 100px;
            color: #fff;
            text-shadow: 0 4px 0 rgba(255, 255, 255, 0.6);
        }
        </style>
    </head>
    <body>

        <div class="flip-container" pico-id="flipcontainer">
            <div class="flipper">
                <div class="front card">
                   	<p class="gametitle">Watskeburde</p>
                    <form>
			         <h1>Welk jaar dacht je?</h1>
                        <input type="number" class="digits" placecholder="jjjj" maxlength="4">
                        <button type="submit">Weet zeker!</button>
                        <p class="rules">Wie het dichtst bij het goede jaartal zit, wint de ronde. Zorg ervoor dat je de snelste bent. Gewoon. Voor de leuk.</p>
                    </form>
                </div>
                <div class="back card">
                    <p class="gametitle">Watskeburde</p>
                    <p class="answer"></p>
                </div>
            </div>
        </div>
    <script>
        var id = Math.floor(1000000 * Math.random());
        var answer = "";
        $("button").click(function(e) {
            e.preventDefault();
            answer = $("input").val();
            if (!answer) return;
            $(".answer").html("");
            $("input").val("");
            $(".answer").hide();
            $(".answer").html(answer);
            $(".back").fadeIn();
            $(".front").fadeOut();
            $.ajax({
                url: "https://watskeburt-jgroenen-1.c9.io/apis/spel/",
                data: JSON.stringify({
                    id: id,
                    answer: answer
                }),
                type: "POST",
                processData: false,
                contentType: "application/json"
            });
        });
        $(".back").click(function () {
            if ($(".answer").is(":visible")) {
                $(".back").fadeOut();
                $(".front").fadeIn();
            } else {
                $(".answer").fadeIn(1000);
            }
        });
    </script>
</body>
</html>