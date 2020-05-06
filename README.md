# Woodkit v2 - les nouveautés

* Woodkit devient plus robuste
* Woodkit gère les tools dans les thèmes (notamment Wooden)
* Woodkit prend en charge Gutenberg (toutes les metaboxes ont été migrées en ReactJS)
* Le fameux Wall a été migré dans Wooden et devient un Block Gutenberg extraordinaire !

**Note :** Woodkit v2 nécessite Wordpress > v5 avec Gutenberg d'activé

# Migration

* avant de migrer de Woodkit v1 à la v2, vous devez vous assurer que votre Worpress est en >v5 et que Gutenberg est activé.
* vous devez bien avoir consciences des tools que vous utilisez peut-être et qui ne sont plus supportés.
* la plupart des tools abandonnés par Woodkit ont été migrés vers le thème Wooden.
* lors du passage de Woodkit v1 à la v2, les metadata et options changent de key/slug, on ne peut donc plus revenir en arrière.

**Pour continuer à utiliser Woodkit v1, utilisez la branche v1 de ce dépôt.**

# Les releases

* les releases doivent être gérées avec un numéro de version au format x.x.x (où x est numérique) afin d'être gérée par Woodmanager (gestionnaire de nos packages).

* les releases doivent être gérées avec un numéro de version majeur cohérent. En effet, Woodmanager sépare les versions majeures de Woodkit. Ainsi les sites en 1.x.x reste en 1.x.x et les sites en 2.x.x restent en 2.x.x. Donc les releases de Woodkit v2 doivent avoir une version du format 2.x.x. Les releases de la v1 doivent êtres faites depuis la branche v1 avec la version au format 1.x.x.

# Context Gutenberg

Pour ajouter un block
* dupliquer le dossier 'woodblocks/blocks/_blank_' au même niveau et le renommer avec un nouveau slug
* dans ce dossier, faire un rechercher/remplacer global dans ce nouveau dossier sur "_blank_" par le slug de votre block
* ajoutez l'import de ce block dans 'woodblocks/blocks/index.php : require_once (WOODBLOCKS_PATH.'blocks/[NEW_SLUG]/index.php');
* ouvrir webpack.config.js et ajouter le slug de votre nouveau block à la liste blocks
* lancez $ npm run dev (si webpack est déjà en route, vous devez le redémarrer)
* commencez à developper

Pour ajouter un store
* dans le dossier 'woodblocks/stores/', ajoutez le fichier JS représentant votre store
* dans le fichier 'woodblocks/stores/index.js', ajoutez la dépendance à votre nouveau store (avec un import)
