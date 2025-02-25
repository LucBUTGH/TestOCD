#Partie 3

## Évolution des Données

### Propositions de Modifications

- **Création d'une Proposition** :
  - Lorsqu'un utilisateur propose une modification, une nouvelle entrée est créée dans la table `proposals` avec le statut "en attente".
  - Les utilisateurs concernés peuvent voir cette proposition et voter (accepter ou refuser) via la table `votes`.

### Validation des Modifications

- **Validation d'une Proposition** :
  - Si une proposition reçoit au moins 3 votes "accepté", elle est validée et les modifications sont appliquées aux tables `people` ou `relationships`.
  - Si une proposition reçoit 3 votes "refusé", elle est définitivement invalidée et son statut est mis à jour en conséquence.

## Conclusion

Cette structure de base de données permet de gérer les propositions de modifications et leur validation par la communauté, assurant ainsi l'intégrité des données et empêchant les modifications malveillantes. Vous pouvez copier la syntaxe ci-dessus dans [dbdiagram.io](https://dbdiagram.io/) pour visualiser le diagramme de la base de données.
