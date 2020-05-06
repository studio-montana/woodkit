# Woodkit v2

Woodkit v2 nécessite Wordpress > v5 avec Gutenberg d'activé

IMPORTANT : lors du passage de Woodkit v1 (ou Woodkitsupport) à Woodkit v2, les metadata et options changent de key/slug, on ne peut donc plus revenir en arrière.

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
