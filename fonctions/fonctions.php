<?php
require 'firebase.php';

// Fonction pour insérer un utilisateur dans Firestore
function insertUser($ID_user, $displayName, $img) {
    global $database;

    $userRef = $database->collection('users')->document($ID_user);

    $userRef->set([
        'ID_user' => $ID_user,
        'displayName' => $displayName,
        'img' => $img
    ]);

    echo "New record created successfully in Firestore";
}

// Fonction pour récupérer les utilisateurs depuis Firestore
function getUsers() {
    global $database;

    $usersRef = $database->collection('users');
    $documents = $usersRef->documents();

    foreach ($documents as $document) {
        if ($document->exists()) {
            echo 'ID: ' . $document->id() . ' - Name: ' . $document['displayName'] . ' ' . $document['img'] . '<br>';
        } else {
            echo 'Document ' . $document->id() . ' does not exist!' . '<br>';
        }
    }
}
?>
