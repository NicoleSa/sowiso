<!doctype html>

<html lang="en">
<head>
  <meta charset="utf-8">

    <title>SOWISO</title>
    <meta name="description" content="SOWISO">
    <meta name="author" content="Nicole Sang-Ajang">

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
      rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.12/dist/vue.js"></script>

</head>

<body>
    <div id="app">
        <div class="form">
            <h1>
                <span class="material-icons">
                    assignment
                </span>
                Exercise {{ exercise_type }}
            </h1>                    
            
            <form action="/" method="post">
            
            <div>
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
                    <input type="number" required autocomplete="off" id="result"/>
                </div>
            </div>

            <div class="button-wrap">
            
                <button type="submit" class="button button-block"/>Check</button>
            
            </div>

            </form>
            
        </div><!-- tab-content -->
        
    </div> <!-- /form -->
    
    <script>
      const App = new Vue({
        el: '#app',
        // Form data
        data() {
            return {
                min: 1,
                max: 100,
                // Arithmetic operation values
                exercise_type: 'addition',
                a: null,
                operation: '+',
                b: null,
                result: null
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
            },
            /**
            * Returns a random integer between min (inclusive) and max (inclusive).
            * Using Math.round() will a non-uniform distribution!
            */
            getRandomInt: function(min, max) {
                min = Math.ceil(min);
                max = Math.floor(max);
                return Math.floor(Math.random() * (max - min + 1)) + min;
            }
        },
        mounted: function() {
            this.init()
        }
      })
    </script>
</body>
</html>

