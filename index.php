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
                    <input type="text"required autocomplete="off"/>
                </div>
            </div>

            <button type="submit" class="button button-block"/>Check</button>
            
            </form>
            
        </div><!-- tab-content -->
        
    </div> <!-- /form -->
    
    <script>
      const App = new Vue({
        el: '#app',
        data: {
          exercise_type: 'addition',
        },
      })
    </script>
</body>
</html>

