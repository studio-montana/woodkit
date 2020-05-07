# Woodkit v2 - les nouveautés

* Woodkit devient plus robuste
* Woodkit gère les tools dans les thèmes (notamment Wooden)
* Woodkit prend en charge Gutenberg (toutes les metaboxes ont été migrées en ReactJS)
* Le fameux Wall a été migré dans Wooden et devient un Block Gutenberg extraordinaire !
* La sécurité est améliorée, notamment avec l'intégration du Google Recaptcha (plus aprécié parfois que le captcha numérique)
* Suppression de réglages et outils obsolètes ou inutilisés
* Certains tools ont été abandonnés par manque de pertinence ou prise en charge par un thème.
* Le nouveau thème Wooden a vu le jour pour venir compléter Woodkit v2 pour une expérience optimale, ce thème propose un contexte de développement pour Gutenberg et des outils "maison". Ce thème est voué à être surchargé (par défaut il ne propose aucun style).

**Note :** Woodkit v2 nécessite Wordpress > v5 avec l'édieur Gutenberg activé.

# Migration

* Avant de migrer de Woodkit v1 à la v2, vous devez vous assurer que votre version de Worpress est > v5 et que Gutenberg est activé.
* Vous devez bien avoir consciences des tools que vous utilisez peut-être et qui ne sont plus supportés.
* La plupart des tools abandonnés par Woodkit ont été migrés vers le thème Wooden.
* Lors du passage de Woodkit v1 à la v2, les metadata et options changent de key/slug, on ne peut donc plus revenir en arrière.

**Pour continuer à utiliser Woodkit v1, utilisez la branche v1 de ce dépôt.**

# Les releases

* les releases doivent être gérées avec un numéro de version au format x.x.x (où x est numérique) afin d'être gérée par Woodmanager (gestionnaire de nos packages).

* les releases doivent être gérées avec un numéro de version majeur cohérent. En effet, Woodmanager sépare les versions majeures de Woodkit. Ainsi les sites en 1.x.x reste en 1.x.x et les sites en 2.x.x restent en 2.x.x. Donc les releases de Woodkit v2 doivent avoir une version du format 2.x.x. Les releases de la v1 doivent êtres faites depuis la branche v1 avec la version au format 1.x.x.

# Context Gutenberg

Pour ajouter un block :
* Dupliquer le dossier 'woodblocks/blocks/_blank_' au même niveau et le renommer avec un nouveau slug
* Dans ce dossier, faire un rechercher/remplacer global dans ce nouveau dossier sur "_blank_" par le slug de votre block
* Ajoutez l'import de ce block dans 'woodblocks/blocks/index.php : require_once (WOODBLOCKS_PATH.'blocks/[NEW_SLUG]/index.php');
* Ouvrir webpack.config.js et ajouter le slug de votre nouveau block à la liste blocks
* Lancez $ npm run dev (si webpack est déjà en route, vous devez le redémarrer)
* Commencez à developper

Pour ajouter un store
* Dans le dossier 'woodblocks/stores/', ajoutez le fichier JS représentant votre store
* Dans le fichier 'woodblocks/stores/index.js', ajoutez la dépendance à votre nouveau store (avec un import)
