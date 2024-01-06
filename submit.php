<!DOCTYPE html>
<html>
  <head>
    <title>Recommandations</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous">
    <style>
      /* ... Votre CSS actuel ... */
      html, body {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100%;
      
      }
      body, div, p { 
      padding: 0;
      margin: 0;
      outline: none;
      font-family: Roboto, Arial, sans-serif;
      font-size: 16px;
      color:  #000000;
      }
      body {
        background-image: url('yes.jpg');
      background-size:cover;
      }

      h1 {
      margin: 0 0 10px 0;
      font-weight: 400;
      }
      .main-block {
        display: flex;
        flex-direction: column; /* Alignement vertical si nécessaire */
        width: calc(100% + 3cm); /* Ajustez la largeur selon vos besoins */
        padding: 10px; /* Ajustez le padding selon vos besoins */
        /* padding-right: 3cm; Retiré si vous voulez utiliser toute la largeur */
        border-radius: 5px;
        box-shadow: 1px 1px 8px 0px #666;
      background: #fff;
      }
      .block-item {
      width: 100%;
      padding: 20px; 
      }
      .block-item.right {
      border-left: none;
      }
      i {
      width: 50px;
      font-size: 24px;
      }
      .btn {
      display: flex;
      align-items: center;
      width: 100%;
      height: 40px;
      margin: 10px 0;
      outline: none;
      border: 0;
      border-radius: 5px;
      box-shadow: 2px 2px 2px #666;
      background: #e8e8e8;
      color: #fff;
      cursor: pointer;
      }
      .btn:hover {
      transform: scale(1.03);
      }
      .btn span {
      font-size: 16px;
      }
      .single-line {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .single-line-list li {
        white-space: normal;
        overflow: visible;
        text-overflow: clip;
        margin-right: 0;
      }
    </style>
  </head>
  <body>
    <div class="main-block">
      <div class="block-item">
        <h2>Recommandations</h2>
        <p class="single-line"><small>
        <ul class="single-line-list">
        <p><small>
          <?php
            // ... Votre code PHP de calcul de corrélation et d'affichage des recommandations ...
          function correlationPearson($x, $y) {
    $n = count($x);
    $sum_x = array_sum($x);
    $sum_y = array_sum($y);
    $sum_x2 = array_sum(array_map(function($val) { return $val * $val; }, $x));
    $sum_y2 = array_sum(array_map(function($val) { return $val * $val; }, $y));
    $sum_xy = array_sum(array_map(function($val1, $val2) { return $val1 * $val2; }, $x, $y));

    // Calcul des coefficients pour la formule
    $numerator = $n * $sum_xy - $sum_x * $sum_y;
    $denominator_term1 = $n * $sum_x2 - $sum_x * $sum_x;
    $denominator_term2 = $n * $sum_y2 - $sum_y * $sum_y;

    // Empêche la division par zéro
    if ($denominator_term1 == 0 || $denominator_term2 == 0) {
        return 0;
    }

    $denominator = sqrt($denominator_term1 * $denominator_term2);
    
    // Calcul et renvoi du coefficient de corrélation
    return $numerator / $denominator;
}

// Vérifie si les valeurs sont présentes
if(isset($_POST['question3']) && isset($_POST['question6']) && isset($_POST['question7']) && isset($_POST['question8']) && isset($_POST['question9'])
&& isset($_POST['question13']) && isset($_POST['question14']) && isset($_POST['question15']) && isset($_POST['question16'])) {
    // Récupère les valeurs GET
    

        $userRatings = [
            $_POST['question3'],
            $_POST['question6'],
            $_POST['question7'],
            $_POST['question8'],
            $_POST['question9'],  
            $_POST['question13'],
            $_POST['question14'],
            $_POST['question15'],
            $_POST['question16'],
        ];


    // Lire le fichier CSV
	// Ouvre le fichier en mode lecture
	$handle = fopen('CORR.csv', 'r');

	// Vérifie si le fichier a bien été ouvert
	if ($handle == true) {
		// création du tableau de réception
		$csv = array();
		$i = 0;
		// Boucle à travers chaque ligne du fichier
		while (($data = fgetcsv($handle, 1000, ',')) !== false) {
			// $data est un tableau contenant les valeurs de la ligne actuelle
			array_push($csv,$data);
			$i = $i+1;
		}
		// Ferme le fichier
		fclose($handle);
	}
    
    // Enlève la première ligne (entêtes)
    array_shift($csv);

    // Stocke les recommandations et calcule les corrélations
    $recommendations = [];
    foreach($csv as $row) {
        // Assure-toi que tu as toutes les données nécessaires dans $row ici avant de continuer
        $csvRatings = array_slice($row, 0, 8);
        $correlationValue = correlationPearson($userRatings, $csvRatings);
        
        if ($correlationValue > 0.95) {
            $recommendations[] = $row[9]; // la recommandation est à la colonne 10 donc index[9]
        }
    }

    // Affiche les recommandations

     
    if (!empty($recommendations)) {
        echo "Voici des suggestions susceptible de vous intéresser:";

        $recommendations=array_unique($recommendations);
        foreach($recommendations as $recommendation) {
            echo "<li>$recommendation</li>";
        }
    } else {
        echo "Ceci est susceptible de vous intéresser ";
        echo "<a href='https://www.youtube.com/watch?v=YJRX8yrEGXE'>La politique expliquée simplement #1 : la règle du jeu</a>";
    }
} else {
    echo "Nous vous remercions d'avoir repondu à ce formulaire mais il semblerait que vous n'avez pas répondu à toute les questions. Veuillez le faire s'il vous plaît ";
}
          ?>
        </small></p>
      </div>
    </div>
  </body>
</html>
