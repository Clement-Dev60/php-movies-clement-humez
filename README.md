# Examen PHP - Application de Collection de Films/Séries

**Durée : 3 heures**  
**Documents autorisés : Aucun**  
**Accès internet : Documentation PHP officielle uniquement**

---

## Contexte

Vous êtes développeur junior dans une entreprise de streaming. Votre responsable vous demande de créer un prototype d'application web permettant aux utilisateurs de **gérer leur collection personnelle de films et séries**.

L'application doit permettre de :
- Voir la liste des films/séries de sa collection
- Ajouter un nouveau film ou une série
- Indiquer si on l'a vu ou non

---

## Prérequis

Avant de commencer, assurez-vous que Docker est lancé :
```bash
docker-compose up -d
```

Accédez à phpMyAdmin sur `http://localhost:8080` pour créer votre base de données.

---

## Partie 1 : Base de données (4 points)

### 1.1 Création de la table (2 points)

Créez une table `movies` dans la base de données avec les colonnes suivantes :

| Colonne | Type | Contraintes |
|---------|------|-------------|
| id | INT | PRIMARY KEY, AUTO_INCREMENT |
| title | VARCHAR(255) | NOT NULL |
| type | ENUM('film', 'serie') | NOT NULL |
| genre | VARCHAR(100) | NULL (optionnel) |
| rating | INT | NULL (note de 1 à 5) |
| is_watched | BOOLEAN | DEFAULT FALSE |
| created_at | DATETIME | DEFAULT CURRENT_TIMESTAMP |

### 1.2 Données de test (2 points)

Insérez au moins 4 entrées de test dans votre table :
- 2 films (1 vu, 1 non vu)
- 2 séries (1 vue, 1 non vue)

---

## Partie 2 : Le Modèle Movie (6 points)

### 2.1 Création du fichier (1 point)

Créez le fichier `src/Models/Movie.php`.

### 2.2 Structure de la classe (5 points)

Votre classe `Movie` doit :

1. **Utiliser le bon namespace** (0.5 point)

2. **Hériter de la classe `Database`** (0.5 point)

3. **Avoir les propriétés privées suivantes** (1 point) :
   - `$id`
   - `$title`
   - `$type`
   - `$genre`
   - `$rating`
   - `$is_watched`

4. **Implémenter les getters et setters pour `title`** (1 point) :
   - Le getter retourne le titre
   - Le setter doit vérifier que le titre n'est pas vide
   - Le setter doit vérifier que le titre fait moins de 255 caractères
   - Le setter doit protéger contre les failles XSS avec `htmlspecialchars()`

5. **Implémenter le getter et setter pour `type`** (0.5 point) :
   - Le setter doit vérifier que la valeur est soit "film" soit "serie"
   - Lever une exception si la valeur est invalide

6. **Implémenter le getter et setter pour `rating`** (0.5 point) :
   - Le setter doit vérifier que la note est entre 1 et 5 (ou null)

7. **Implémenter la méthode `getAll()`** (1 point) :
   - Retourne tous les films/séries de la base de données
   - Trie les résultats par date de création décroissante (plus récent en premier)
   - Utilise une requête préparée
   - Retourne un tableau de résultats

---

## Partie 3 : Le Contrôleur (4 points)

### 3.1 Création du fichier (1 point)

Créez le fichier `src/controllers/moviesController.php`.

### 3.2 Logique du contrôleur (3 points)

Le contrôleur doit :

1. **Récupérer tous les films/séries** pour les afficher (1 point)

2. **Gérer l'ajout d'un film/série** via formulaire POST (2 points) :
   - Vérifier si une requête POST est reçue
   - Créer une instance de `Movie`
   - Utiliser des try-catch pour gérer les erreurs de validation
   - Stocker les erreurs dans un tableau `$error`
   - Si aucune erreur : sauvegarder et rediriger vers `/movies`
   - Si erreurs : les transmettre à la vue

3. **Appeler la fonction `render()`** avec les données nécessaires (movies, error)

---

## Partie 4 : La Vue (4 points)

### 4.1 Création du fichier (1 point)

Créez le fichier `src/views/movies.php`.

### 4.2 Contenu de la vue (3 points)

La vue doit :

1. **Utiliser le système de template** avec `ob_start()` et `ob_get_clean()` (0.5 point)

2. **Afficher un titre h1** : "Ma Collection" (0.5 point)

3. **Afficher un formulaire d'ajout** avec (1 point) :
   - Un champ texte pour le titre (name="title")
   - Un select pour le type avec options "Film" et "Série" (name="type")
   - Un champ texte pour le genre (name="genre") - optionnel
   - Un bouton de soumission
   - L'attribut `method="POST"`
   - Afficher les erreurs s'il y en a

4. **Afficher la liste des films/séries** (1 point) :
   - Parcourir le tableau `$movies` avec une boucle
   - Afficher le titre et le type (Film ou Série)
   - Afficher le genre s'il existe
   - Indiquer visuellement si c'est vu ou non (ex: "Vu" / "A voir")

---

## Partie 5 : Sécurité (2 points)

Ces points sont attribués de manière transversale sur l'ensemble du projet :

- **Protection XSS** (1 point) : Utilisation de `htmlspecialchars()` sur les données utilisateur
- **Protection injection SQL** (1 point) : Utilisation de requêtes préparées avec `bindValue()`

---

## Barème récapitulatif

| Partie | Points |
|--------|--------|
| Base de données | 4 |
| Modèle Movie | 6 |
| Contrôleur | 4 |
| Vue | 4 |
| Sécurité | 2 |
| **Total** | **20** |

---

## Bonus (2 points maximum)

Points bonus possibles si vous terminez en avance :

- (+1) Ajouter un champ pour la note (1 à 5) et l'afficher
- (+0.5) Ajouter un bouton pour marquer un élément comme "vu"
- (+0.5) Filtrer l'affichage par type (films uniquement / séries uniquement)

---

## Conseils

1. **Commencez par la base de données** - Sans elle, rien ne fonctionnera
2. **Testez régulièrement** - Après chaque étape, vérifiez que ça fonctionne
3. **Regardez les fichiers existants** - `User.php` et `indexController.php` sont des exemples
4. **Lisez les erreurs** - PHP vous indique souvent où est le problème
5. **Gérez votre temps** - Ne restez pas bloqué trop longtemps sur une partie

---

**Bonne chance !**
