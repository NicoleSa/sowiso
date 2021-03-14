<!doctype html>

<html lang="en">
<head>
  <meta charset="utf-8">

    <title>SOWISO</title>
    <meta name="description" content="SOWISO">
    <meta name="author" content="Nicole Sang-Ajang">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">

    <link href="https://fonts.googleapis.com/css?family=Work+Sans:300,400" rel="stylesheet"> 
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
      rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.12/dist/vue.js"></script>

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
									{{ a }}
								</span>
								<span>
									{{ operation }}
								</span>
								<span>
									{{ b }}
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
      const App = new Vue({
        el: '#app',
        // Form data
        data() {
            return {
                title: 'SOWISO',
                description_title: 'Homework',
                description: 'These exercises will evaluate your arithmetic skills.',
                min: 1,
                max: 10,
                // Arithmetic operation values
                a: null,
                operation: '+',
                b: null,
                result: null,
				valid: true,
				correct: false,
                message: null
            }
        },
        methods: {
            // Initialize random arithmetic operation
            init: function() {

				// When <a> value known from previous time closing browser
				if(localStorage.a) {
					this.a = localStorage.a;
				} else {
                    this.a = this.getRandomInt(this.min, this.max);
                }

				// When <b> value known from previous time closing browser
				if(localStorage.b) {
					this.b = localStorage.b;
				} else {
                    this.b = this.getRandomInt(this.min, this.max);
                }

				// When <result> value known from previous time closing browser
				if(localStorage.result) {
					this.result = localStorage.result;
				}
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
			// Resets content
            reset: function() {
                this.a = this.getRandomInt(this.min, this.max);
                this.b = this.getRandomInt(this.min, this.max);
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
					// Check for correct anwers given for different kind of operations
                    switch(this.operation) {
                        case '+':
                            if((this.a + this.b) != this.result) {
								this.setIncorrect(errorMessage);
                                return;
                            }
                        default:
                            if((this.a + this.b) != this.result) {
								this.setIncorrect(errorMessage);
							    return;
                            }
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
			a(newA) {
				localStorage.a = newA;
			},
			b(newB) {
				localStorage.b = newB;
			},
			result(newResult) {
				localStorage.result = newResult;
			}
		}
      })
    </script>
</body>
</html>

