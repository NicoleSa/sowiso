<!doctype html>

<html lang="en">
<head>
  <meta charset="utf-8">

    <title>SOWISO</title>
	<link rel="shortcut icon" type="image/jpg" href="favicon-96x96.png"/>
    <meta name="description" content="SOWISO">
    <meta name="author" content="Nicole Sang-Ajang">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">

    <link href="https://fonts.googleapis.com/css?family=Work+Sans:300,400" rel="stylesheet"> 
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
      rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.12/dist/vue.js"></script>
	
	<!-- For mathmetical expression evaluation -->
	<!-- Lexer -->
	<script src="node_modules/lex/lexer.js"></script>
	<!-- Dijkstra's Shunting Yard Algorithm -->
	<script src="shunt.js"></script>
</head>

<body>
    <div id="app">
        <div class="logo">
            <div class="gradient"></div>
            <h4 class="text">{{ title }}</h4>
        </div>
        <div class="form-wrapper">
            <hr class="gradient"/>
            <div class="info-wrapper">
                <h4>{{ description_title }}</h4>
                <p>{{ description }}</p>
            </div>

            <div class="question-wrapper">
                <div class="form">
                    <h1>
                        <span class="material-icons">
                            calculate
                        </span>
                        Exercise
                    </h1>                    
                    
                    <!-- the submit event will no longer reload the page -->
                    <form v-on:submit.prevent="onSubmit">
                    
						<div class="column">
							<div class="field-wrap">
								<span>
									{{ expression }}									
								</span>
								<span>
									=
								</span>
								<input v-model.number="result" v-bind:class="{ error: !valid }" type="number" autocomplete="off" id="result"/>
								<span class="material-icons success" v-if="correct">
									check_circle_outline
								</span>
							</div>
							<p v-bind:class="{ alert: message }">
								{{ message }}
							</p>
						</div>

						<div class="button-wrap">
							<!-- This button won't be triggered when pressing enter -->
							<button v-on:click="reset" class="button button-block danger" formnovalidate type="button"/>
								<span class="material-icons">
									replay
								</span>
							</button>
							<button v-on:click="check" class="button button-block"/>Check</button>
						</div>
                    
                    </form>
                    
                </div><!-- tab-content -->
            </div>
        
        </div> <!-- /form -->
    </div>


	<script>
		// Lexical analyzer
		var lexer = new Lexer;

		lexer.addRule(/\s+/, function () {
			/* skip whitespace */
		});

		lexer.addRule(/[a-z]/, function (lexeme) {
			return lexeme; // symbols
		});

		// BE AWARE ONLY NUMBERS IN THE RANGE OF 0-1000 are processed
		lexer.addRule(/[1-9][0-9]{0,2}|1000/, function (lexeme) {
			return lexeme; // numbers
		});

		lexer.addRule(/[\(\+\-\*\/\)]/, function (lexeme) {
			return lexeme; // punctuation (i.e. "(", "+", "-", "*", "/", ")")
		});

		// Parser
		var factor = {
			precedence: 2,
			associativity: "left"
		};

		var term = {
			precedence: 1,
			associativity: "left"
		};

		var parser = new Parser({
			"+": term,
			"-": term,
			"*": factor,
			"/": factor
		});

		// Parses input stream of tokens to postfix notation
		function parse(input) {
			lexer.setInput(input);
			var tokens = [], token;
			while (token = lexer.lex()) tokens.push(token);
			return parser.parse(tokens);
		}
	</script>

	<!-- Vue component -->
	<script>
      const App = new Vue({
        el: '#app',
        // Form data
        data() {
            return {
                title: 'SOWISO',
                description_title: 'Homework',
                description: 'These exercises will evaluate your arithmetic skills.',
                min: 1,
                max: 10, // !! Can't be higher than the lex parser range i.e. 1000 !!
                // Mathmetical expression
				//expression_format: 'a + b * c',
				expression_format: 'a + b',
				expression: '',
                result: null,
				valid: true,
				correct: false,
                message: null
            }
        },
        methods: {
            // Initialize random arithmetic operation
            init: function() {

				// When <expression> known from previous time closing browser
				if(localStorage.expression) {
					this.expression = localStorage.expression;
				} else {
                    this.expression = this.getRandomNumberExpression();
                }

				// When <result> value known from previous time closing browser
				if(localStorage.result) {
					this.result = localStorage.result;
				}
            },
			// Returns desired expression format with random numbers
			getRandomNumberExpression: function() {
				var expression = [];

				// Convert desired expression to expression containing random numbers
				for (var i = 0; i < this.expression_format.length; i++) {
					// When letter replace char with random number
					if(this.isCharacterALetter(this.expression_format.charAt(i))) {
						expression.push(this.getRandomInt(this.min, this.max));
					// Otherwise leave untouched
					} else {
						expression.push(this.expression_format.charAt(i));
					}
				}

				return expression.join('');
			},
			isCharacterALetter: function(char) {
				return (/[a-zA-Z]/).test(char);
			},
            /**
            * Returns a random integer between min (inclusive) and max (inclusive)
            * drawn from an uniform distribution.
            */
            getRandomInt: function(min, max) {
				min = Math.ceil(min);
  				max = Math.floor(max);
  				return Math.floor(Math.random() * (max - min + 1) + min); //The maximum is inclusive and the minimum is inclusive
            },
			getExpressionValue: function() {
				var stack = [];

				var operator = {
					"+": function (a, b) { return a + b; },
					"-": function (a, b) { return a - b; },
					"*": function (a, b) { return a * b; },
					"/": function (a, b) { return a / b; }
				};

				// Parse expression to postfix notation and evaluate using stack
				parse(this.expression).forEach(function (c) {
					switch (c) {
					case "+":
					case "-":
					case "*":
					case "/":
						var b =+ stack.pop();
						var a =+ stack.pop();
						stack.push(operator[c](a, b));
						break;
					default:
						stack.push(c);
				 	}
				});

				return stack.pop();
			},
			// Resets content
            reset: function() {
                this.expression = this.getRandomNumberExpression();
                this.result = null;
				this.valid = true;
				this.correct = false;
                this.message = null;
            },
			// Change content when incorrect answer given
			setIncorrect: function(errorMessage) {
				this.valid = false;
				this.correct = false;
				this.message = errorMessage;
			},
			// Change content when correct answer given
			setCorrect: function() {
				this.valid = true;
				this.correct = true;
                this.message = null;
			},
			// Checks input given by user
            check: function() {
				// When no answer given
                if(!this.result) {
					this.setIncorrect("Please fill in your answer.");
                } else {
					let errorMessage = "Oops, that answer is not correct.";
					// Check for correct anwer
					if(this.getExpressionValue() != this.result) {
						this.setIncorrect(errorMessage);
						return;
					}
                    
                	// Default when correct answer
					this.setCorrect();
                }
            },
			// Prevents form submitting
            onSubmit: function() {
                return false;
            }
        },
        mounted: function() {
        	this.init();
        },
		watch: {
			// Save current newest state of expression and result input
			expression(newExpression) {
				localStorage.expression = newExpression;
			},
			result(newResult) {
				localStorage.result = newResult;
			}
		}
      })
    </script>
</body>
</html>

