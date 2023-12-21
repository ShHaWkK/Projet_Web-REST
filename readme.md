# Projet Dev Web API
Création d'une API
## Participants :
- Alexandre Helleux     (AlexandreDjazz)
- Alexandre Uzan        (ShHaWkK)
- Marc Lecomte          (Spatulox)

# IL FAUT PRENDRE LA BRANCHE MAIN 2 POUR QUE CA FONCTIONNE

### Sujet :
Création d'une API de gestion d'appartements

<hr>

## Aide

La solution se divise en plusieurs parties :

### Le routeur

Le routeur est le composant du contrôleur qui gère ici la distribution des requêtes vers la ressource demandée.

Il lit l'URL et redirige en fonction du chemin (`path`) de la requête reçue.

### Le contrôleur des To-Dos

Dans le cas où le chemin demandé est `todos`, alors la requête est dispatchée vers le contrôleur des To-Dos.

Il lit la méthode HTTP et vérifie s'il y a un ID fourni dans le chemin de la ressource afin de dispatcher ensuite les demandes à la couche Modèle.

Lorsqu'il transmet les demandes à la couche modèle, il doit abstraire la couche réseau : il doit passer des données de types et de formats indépendants de la nature des requêtes qu'il reçoit. Le contexte HTTP ne doit pas sortir du contrôleur.

### Les fonctions de retour

Deux cas de figures se distinguent :

- On doit renvoyer du contenu récupéré dans la base de données.
- On n'a pas de contenu et on doit plutôt renvoyer un message.

On a une fonction pour chacun de ces cas avec un moyen de régler le message ou le contenu.
Cela permet de centraliser les "echo" et la pose des headers HTTP, qui ne doivent être faits qu'une fois.

De plus, cela permet un code qui respecte le concept DRY : Don't Repeat Yourself.

### La gestion d'erreurs

Ici, afin de gérer les erreurs, on fait remonter les erreurs au contrôleur, qui doit les attraper.

Lorsqu'on attrape une exception, le contrôleur joue le rôle de la traduction de l'exception native en réponse HTTP.

Une API doit être indépendante de la technologie dans laquelle elle est codée, et ne doit répondre qu'à des contraintes établies d'échanges entre deux programmes.

Ici, on transforme les exceptions en messages que l'on renvoie quand une requête n'a pas abouti.

Encore une fois, c'est donc le contrôleur qui assure la traduction du contexte "web/HTTP" en logique pure.

En soit, une exception descendant de l'Exception de base suffit avec PHP car elle peut porter un message et un code d'erreur, ce qui correspond à ce que l'on doit renvoyer.

### Modèle TodoModel

La classe TodoModel correspond à la couche "Model" de MVC.

Elle ne doit pas savoir qu'elle répond indirectement à des requêtes HTTP, elle doit se contenter d'implémenter les règles métier, ainsi que la communication avec la BDD pour la gestion de son modèle.

Ici, TodoModel implémente directement les requêtes SQL afin de récupérer des données qu'elle renvoie par des fonctions qu'elle expose.

Ces fonctions représentent un `CRUD` : Create, Read, Update, Delete.

## Amélioration possible

### Les exceptions

Elles sont nommées `HTTPException` mais se retrouvent quand même dans le modèle.

C'est mieux que si on renvoyait la réponse HTTP depuis le modèle, mais cela fait apparaître la notion de HTTP dans le modèle, ce qui doit être évité.
Pour éviter cela, on pourrait faire des `DatabaseExceptions`, par exemple, et réserver les `HTTPExceptions` aux contrôleurs.

De plus, peu de cas sont réellement gérés et les messages d'erreurs ne sont pas précis. Notre API devrait refléter un peu mieux ces [contraintes](https://www.rfc-editor.org/rfc/rfc7807).

Dans le même élan, on pourrait implémenter une meilleure validation.

### Séparations

Plusieurs éléments méritent d'être séparés dans ce projet :

On pourrait regrouper la logique par entité, avoir un todo-model.php, et un todo-controller.php.
On aurait alors simplement le routeur dans le index.php.

Les contrôleurs pourraient être gérés par des classes pour mieux gérer l'instantiation des TodoModels.

Les TodoModels gèrent à la fois la logique métier, la transformation des données, et la communication avec la base de données.
Pour rendre un code plus maintenable, il serait intéressant de séparer cela :

Un TodoRepository s'occuperait de la communication avec la base de données, et un TodoService de la communication avec le contrôleur. De ce fait, si on change de moteur de BDD, on n'aura qu'à réimplémenter un Repository.

Actuellement, on n'utilise pas de classe pour transporter les instances de Todo, mais cela sera nécessaire pour abstraire la couche base de données, et avoir un type indépendant de la base de données qui arrive en retour pour le contrôleur.

Lors du prochain cours, nous parlerons de tous ces concepts, et nous verrons une meilleure façon de coder ce projet.
