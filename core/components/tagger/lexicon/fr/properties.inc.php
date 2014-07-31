<?php
/**
 * Snippet's properties French Lexicon Entries for Tagger
 *
 * @package tagger
 * @subpackage lexicon
 */

$_lang['tagger.getresourceswhere.tags_desc'] = 'Liste, séparée par des virgules, de tags qui seront utilisés pour générer la requête de ressources. Par défaut les tags de la variable GET seront utilisés';
$_lang['tagger.getresourceswhere.groups_desc'] = 'Liste, séparée par des virgules, de groupes. Seuls les tags de ces groupes seront utilisés';
$_lang['tagger.getresourceswhere.where_desc'] = 'Paramètre "where" original. Si vous utilisez le paramètre "where" dans votre appel original getResources, déplacez-le ici';

$_lang['tagger.gettags.resources_desc'] = 'Liste, séparée par des virgules, de ressources depuis lesquelles lister les tags';
$_lang['tagger.gettags.groups_desc'] = 'Liste, séparée par des virgules, de groupes depuis lesquels lister les tags';
$_lang['tagger.gettags.rowTpl_desc'] = 'Nom du chunk à utiliser pour chaque tag. i aucune chunk n\'est indiqué, un array contenant les placeholders disponibles sera affiché';
$_lang['tagger.gettags.outTpl_desc'] = 'Nom du chunk à utiliser pour contenir les tags. Si aucun chunk n\'est indiqué, les tags seront affichés sans conteneur';
$_lang['tagger.gettags.separator_desc'] = 'Séparateur utilisé pour délimiter les tags';
$_lang['tagger.gettags.target_desc'] = 'Un ID de ressource qui sera utilisé pour générer l\'URI d\'un tag. Si aucun ID n\'est indiqué, la ressource actuelle sera utilisée';
$_lang['tagger.gettags.showUnused_desc'] = 'Indiquez "1" pour que les tags qui ne sont pas assignés à une ressource soient également affichés';
$_lang['tagger.gettags.contexts_desc'] = 'Utilisez ce paramètre pour n\'afficher les tags des ressources uniquement présentes dans les contextes indiqués.';
$_lang['tagger.gettags.toPlaceholder_desc'] = 'Utilisez ce paramètre pour assigner le résultat dans le placeholder indiqué';
$_lang['tagger.gettags.showUnpublished_desc'] = 'Indiquez "1" pour que les tags assignés uniquement à des ressources non publiées soient également affichés';
$_lang['tagger.gettags.showDeleted_desc'] = 'Indiquez "1" pour que les tags assignés uniquement à des ressources supprimées soient également affichés';
$_lang['tagger.gettags.limit_desc'] = 'Nombre limite de tags retournés';
$_lang['tagger.gettags.offset_desc'] = 'Offset the output by this number of Tags';
$_lang['tagger.gettags.totalPh_desc'] = 'Placeholder pour afficher le nombre total de tags (sans tenir compte de &limit et &offset)';
$_lang['tagger.getresourceswhere.likeComparison_desc'] = 'Indiquez "1" pour utiliser une comparaison LIKE (SQL)';
$_lang['tagger.gettags.sort_desc'] = 'Option de classement, au format JSON. Exemple : {"tag": "ASC"} ou plusieurs options : {"group_id": "ASC", "tag": "ASC"}';
$_lang['tagger.getresourceswhere.tagField_desc'] = 'Champ utilisé pour lister les tags. Défaut : alias';
