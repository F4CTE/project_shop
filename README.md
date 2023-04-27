# boutique e-commerce avec symfony

Vous allez commencer la réalisation d'une boutique en ligne :

- Cette boutique présentera des produits, chaque produit ayant une catégorie
- Pour un produit, on aura un nom, une description, un prix hors taxe, une et une seule catégorie, un attribut "visible" et un attribut "discount" qui sera à true si le produit est en promotion, et false sinon
- Vous rédigerez les fixtures permettant de créer des catégories et des produits portant une catégorie existante
- On aura les pages suivantes :
  - Accueil => Liste des produits en promotion
  - Produits => Liste de tous les produits
  - Produit => Fiche produit, accessible depuis une liste de produits
  - Contact => Formulaire de contact
- Le formulaire de contact déclenchera l'envoi d'un email à une adresse d'administration, en reprenant dans l'email les données saisies dans le formulaire
- En plus, on aura une section derrière l'URL "/admin/products" présentant un CRUD (réalisé à la main, sans make:crud) permettant d'administrer les produits
