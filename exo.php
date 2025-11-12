<?php
// caisse enregistreuse

// etat de caisse de base 
/**
 * 
 *  piece de 2 euro : 45
 *  piece de 1 euro : 30
 *  piece de 0,5 euro : 30
 *  piece de 0,2 euro : 45
 *  piece de 0,1 euro : 45
 *  piece de 0,05 euro : 45
 *  piece de 0,02 euro : 45
 *  piece de 0,01 euro : 45
 * 
 *  Billet de 10 : 10
 *  Billet de 20 : 5
 *  Billet de 50 : 10
 *  Billet de 100 : 1
 *  Billet de 200 : 1
 *  Billet de 500 : 0
 * 
 *  Logiciel de caisse, qui va calculer le reste dû au client (client qui donne une somme moins le montant total des articles)
 *  Le logiciel va aussi calculer le nombre de pièce ou billet (avec la valeur) à rendre au client.
 * 
 * ex : le client achète pour 33,40 de bonbons
 * il donne 1 billet de 50 euros
 * le logiciel calcule qu'il faut lui rendre 16,60 Euros 
 * le logiciel calcule qu'il faut rendre 1 billet de 10, 3 pièces de 2, 1 pièce de 0.50 et 1 pièce de 0.10
 * 
 */


$etat_caisse = [
    "billet500" => ["quantite" => 0, "valeur" => 500],
    "billet200" => ["quantite" => 1, "valeur" => 200],
    "billet100" => ["quantite" => 1, "valeur" => 100],
    "billet50" => ["quantite" => 10, "valeur" => 50],
    "billet20" => ["quantite" => 5, "valeur" => 20],
    "billet10" => ["quantite" => 10, "valeur" => 10],
    "piece2" => ["quantite" => 45, "valeur" => 2],
    "piece1" => ["quantite" => 30, "valeur" => 1],
    "piece05" => ["quantite" => 30, "valeur" => 0.5],
    "piece02" => ["quantite" => 45, "valeur" => 0.2],
    "piece01" => ["quantite" => 45, "valeur" => 0.1],
    "piece005" => ["quantite" => 45, "valeur" => 0.05],
    "piece002" => ["quantite" => 45, "valeur" => 0.02],
    "piece001" => ["quantite" => 45, "valeur" => 0.01],
];
$montantTotal = 433.404;
$montantPaye = 7750;

function verifier_la_somme_donnee_par_client($montantTotal, $montantPaye) {
    if ($montantPaye < $montantTotal) {
        echo "Le montant payé est inférieur au montant total\n";
        return false;
    }else{
        return true;
    }
}

function verfier_les_fond_de_caisse($etat_caisse) {
    $total = 0;
    foreach ($etat_caisse as $monnaie => $info) {
        $total += $info["quantite"] * $info["valeur"];
    }
    return $total;
}

function afficher_monnaie_a_rendre($montantTotal, $montantPaye, &$etat_caisse) {
    $reste = $montantPaye - $montantTotal;
    $pieces_billets_rendus = [];
    if ($reste > verfier_les_fond_de_caisse($etat_caisse)) {
        echo "Il n'y a pas assez de fonds dans la caisse pour rendre le reste\n";
        return;
    }else{
        $pieces_billets_rendus = calculer_nombre_piece_ou_billet($reste, $pieces_billets_rendus, $etat_caisse);
        echo "Il faut rendre : " . $reste . " euros\n";
        foreach ($pieces_billets_rendus as $monnaie => $quantite) {
            if ($quantite > 0) {
                echo "$quantite x $monnaie\n";
            }
        }
    }
}

function calculer_nombre_piece_ou_billet($reste, $pieces_billets_rendus, &$etat_caisse) {
    if (empty($pieces_billets_rendus)) {
        $pieces_billets_rendus = [
            "billet500" => 0,
            "billet200" => 0,
            "billet100" => 0,
            "billet50" => 0,
            "billet20" => 0,
            "billet10" => 0,
            "piece2" => 0,
            "piece1" => 0,
            "piece05" => 0,
            "piece02" => 0,
            "piece01" => 0,
            "piece005" => 0,
            "piece002" => 0,
            "piece001" => 0,
        ];
    }
    
    
    foreach ($etat_caisse as $nom => $info) {
        $valeur = $info["valeur"];
        if ($reste >= $valeur) {
            $quantite_a_prendre = intval($reste / $valeur);
            $quantite_a_prendre = min($quantite_a_prendre, $etat_caisse[$nom]["quantite"]); // Limiter à la quantité disponible
            if ($quantite_a_prendre > 0) {
                $pieces_billets_rendus[$nom] += $quantite_a_prendre;
                $etat_caisse[$nom]["quantite"] -= $quantite_a_prendre;
                $reste = round($reste - ($valeur * $quantite_a_prendre), 2);// cas de précision avec les décimales
            }
        }
    }

    return $pieces_billets_rendus;
}
        




function check_monnaie_disponible($etat_caisse, $monnaie_to_check,$quantite_a_prendre) {
    if ($etat_caisse[$monnaie_to_check]["quantite"] >= $quantite_a_prendre) {
        return true;
    } else {
        return false;
    }
}



afficher_monnaie_a_rendre($montantTotal, $montantPaye, $etat_caisse);





?>
