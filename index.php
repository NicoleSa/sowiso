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
                            <input v-model.number="result" type="number" required autocomplete="off" id="result"/>
                            <span class="material-icons success">
                                check_circle_outline
                            </span>
                        </div>
                        <p v-bind:class="{ alert: message }">
                            {{ message }}
                        </p>
                    </div>

                    <div class="button-wrap">
                    
                        <button v-on:click="reset" class="button button-block danger" formnovalidate/>
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
                message: null
            }
        },
        methods: {
            // Initialize arithmetic operation
            init: function() {

                if(!this.a) {
                    this.a = this.getRandomInt(this.min, this.max);
                }

                if(!this.b) {
                    this.b = this.getRandomInt(this.min, this.max);
                }

                this.message = null
            },
            /**
            * Returns a random integer between min (inclusive) and max (inclusive).
            * Using Math.round() will a non-uniform distribution!
            */
            getRandomInt: function(min, max) {
                min = Math.ceil(min);
                max = Math.floor(max);
                return Math.floor(Math.random() * (max - min + 1)) + min;
            },
            reset: function() {
                this.a = this.getRandomInt(this.min, this.max);
                this.b = this.getRandomInt(this.min, this.max);
                this.result = null;
                this.message = null;
            },
            check: function() {
                if(!this.result) {
                    this.message = "Please fill in your answer.";
                } else {
                    switch(this.operation) {
                        case '+':
                            if((this.a + this.b) != this.result) {
                                this.message = "Oops, that answer is not correct.";
                                return;
                            }
                        default:
                            if((this.a + this.b) != this.result) {
                                this.message = "Oops, that answer is not correct.";
                                return;
                            }
                        }
                    
                    // Default when correct answer
                    this.message = null;
                }
            },
            onSubmit: function() {
                return false;
            }
        },
        mounted: function() {
            this.init()
        }
      })
    </script>
</body>
</html>

