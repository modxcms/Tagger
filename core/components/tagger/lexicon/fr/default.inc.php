<?php
/**
 * Default French Lexicon Entries for Tagger
 *
 * @package tagger
 * @subpackage lexicon
 */

$_lang['tagger'] = 'Tagger';

$_lang['tagger.global.search'] = 'Rechercher';
$_lang['tagger.global.loading'] = 'Chargement';
$_lang['tagger.global.change_order'] = 'Changer l\'ordre de : [[+name]]';

$_lang['tagger.menu.tagger'] = 'Tagger';
$_lang['tagger.menu.tagger_desc'] = 'Gérez vos groupes & tags';

$_lang['tagger.field.tagfield'] = 'Liste de tags';
$_lang['tagger.field.combobox'] = 'Combo box';

$_lang['tagger.group.groups'] = 'Groupes';
$_lang['tagger.group.intro_msg'] = 'Dans cette section, vous pouvez gérer vos groupes. Chaque groupe contiendra ses propres tags.';
$_lang['tagger.group.name'] = 'Nom';
$_lang['tagger.group.name_desc'] = 'Intitulé du champ qui sera ajouté au formulaire des ressources';
$_lang['tagger.group.description'] = 'Description';
$_lang['tagger.group.description_desc'] = 'Description du groupe';
$_lang['tagger.group.field_type'] = 'Type de champ';
$_lang['tagger.group.field_type_desc'] = 'Liste de tags - sélection multiple, Combo box - sélection unique';
$_lang['tagger.group.remove_unused'] = 'Supprimer les tags non utilisés';
$_lang['tagger.group.remove_unused_desc'] = 'Sélectionnez <strong>oui</strong> pour que tous les tags qui ne sont pas assignés à une ressource soient supprimés de la base de données.';
$_lang['tagger.group.allow_new'] = 'Autoriser la création de tag depuis le champ';
$_lang['tagger.group.allow_new_desc'] = 'Sélectionnez <strong>oui</strong> pour que les utilisateurs puissent créer de nouveaux tags depuis le champ. Désactiver cette option peut être utile pour, par exemple, définir une liste de catégories fixe';
$_lang['tagger.group.allow_blank'] = 'Optionnel';
$_lang['tagger.group.allow_blank_desc'] = 'Sélectionnez <strong>non</strong> pour que le champ soit obligatoire (les utilisateurs devront sélectionner au moins un tag avant de pouvoir enregistrer la ressource)';
$_lang['tagger.group.allow_type'] = 'Saisie autorisée';
$_lang['tagger.group.allow_type_desc'] = 'Sélectionnez <strong>non</strong> pour empêcher la saisie au clavier. Cliquer sur le champ entrainera l\'affichage des tags disponibles.';
$_lang['tagger.group.show_autotag'] = 'Afficher les tags';
$_lang['tagger.group.show_autotag_desc'] = 'Sélectionnez <strong>oui</strong> pour que les tags soient affichés en dessous du champ. Les utilisateurs pourront cliquer les les tags pour les sélectionner/déselectionner. Disponible uniquement pour les listes de tags.';
$_lang['tagger.group.show_for_templates'] = 'Afficher pour les templates';
$_lang['tagger.group.show_for_templates_desc'] = 'Liste, séparée par des virgules, d\'<strong>ID</strong>s de templates pour lesquels ce groupe sera affiché.';
$_lang['tagger.group.position'] = 'Position';
$_lang['tagger.group.all'] = 'Tous les groupes';
$_lang['tagger.group.create'] = 'Créer un groupe';
$_lang['tagger.group.update'] = 'Mettre à jour';
$_lang['tagger.group.remove'] = 'Supprimer';
$_lang['tagger.group.remove_confirm'] = 'Êtes-vous sûr de vouloir supprimer ce groupe ? Tous les tags du groupe seront également supprimés.';
$_lang['tagger.group.import'] = 'Import';
$_lang['tagger.group.auto_import'] = 'Import automatique';
$_lang['tagger.group.import_from'] = 'Import depuis une TV';
$_lang['tagger.group.import_to'] = 'Importer dans le groupe';
$_lang['tagger.group.place'] = 'Place';
$_lang['tagger.group.place_desc'] = 'Où sera affiché ce groupe ? Les choix sont : Un onglet, Au dessus du contenu, En dessous du contenu, En pied de page';
$_lang['tagger.group.place_in_tab'] = 'Un onglet';
$_lang['tagger.group.place_above_content'] = 'Au dessus du contenu';
$_lang['tagger.group.place_below_content'] = 'En dessous du contenu';
$_lang['tagger.group.place_bottom_page'] = 'En pied de page';
$_lang['tagger.group.hide_input'] = 'Hide input';
$_lang['tagger.group.hide_input_desc'] = 'When checked the input field with assign button will be hidden.';
$_lang['tagger.group.tag_limit'] = 'Limite';
$_lang['tagger.group.tag_limit_desc'] = 'Nombre de tags pouvant être assignés à une ressource. 0 = illimité';
$_lang['tagger.group.alias'] = 'Alias';
$_lang['tagger.group.alias_desc'] = 'Alias qui sera utilisé dans les URLs lorsque les FURLs sont activées. Laissez vide pour générer l\'alias automatiquement.';

$_lang['tagger.tab.label'] = 'Tags';

$_lang['tagger.tag.tags'] = 'Tags';
$_lang['tagger.tag.intro_msg'] = 'Dans cette section, vous pouvez gérer les tags.';
$_lang['tagger.tag.name'] = 'Nom';
$_lang['tagger.tag.alias'] = 'Alias';
$_lang['tagger.tag.group'] = 'Groupe';
$_lang['tagger.tag.create'] = 'Créer un tag';
$_lang['tagger.tag.update'] = 'Mettre à jour';
$_lang['tagger.tag.remove'] = 'Supprimer';
$_lang['tagger.tag.remove_confirm'] = 'Êtes-vous sûr de vouloir supprimer ce tag ?';
$_lang['tagger.tag.assigned_resources'] = 'Ressources assignées/tagguées';
$_lang['tagger.tag.assigned_resources_to'] = 'Ressources assignées au tag : [[+tag]]';
$_lang['tagger.tag.resource_update'] = 'Mettre à jour la ressource';
$_lang['tagger.tag.resource_unassign'] = 'Dé-tagguer la ressource';
$_lang['tagger.tag.resource_unassign_confirm'] = 'Êtes-vous sûr de vouloir supprimer ce tag de la ressource ?';
$_lang['tagger.tag.resource_unassign_multiple_confirm'] = 'Êtes-vous sûr de vouloir supprimer ce tag des ([[+resources]]) ressources sélectionnées ?';
$_lang['tagger.tag.resource_unasign_selected'] = 'Dé-tagguer la sélection';
$_lang['tagger.tag.bulk_actions'] = 'Actions de groupe';
$_lang['tagger.tag.merge_selected'] = 'Fusionner les tags sélectionnés';
$_lang['tagger.tag.remove_selected'] = 'Supprimer les tags sélectionnés';
$_lang['tagger.tag.remove_selected_confirm'] = 'Êtes-vous sûr de vouloir supprimer tous les tags sélectionnés ?';
$_lang['tagger.tag.merge'] = 'Fusionner les tags';
$_lang['tagger.tag.assign'] = 'Assigner';

$_lang['setting_tagger.tag_key'] = 'Variable de tag';
$_lang['setting_tagger.tag_key_desc'] = 'Nom de la variable GET utilisée pour stocker les tags. Défaut: tags';
$_lang['setting_tagger.place_above_content_header'] = 'Entête "Au dessus"';
$_lang['setting_tagger.place_above_content_header_desc'] = 'Affiche ou masque l\'entête pour le bloc "Au dessus du contenu".';
$_lang['setting_tagger.place_below_content_header'] = 'Entête "En dessous"';
$_lang['setting_tagger.place_below_content_header_desc'] = 'Affiche ou masque l\'entête pour le bloc "En dessous du contenu".';
$_lang['setting_tagger.place_bottom_page_header'] = 'Entête "Pied de page"';
$_lang['setting_tagger.place_bottom_page_header_desc'] = 'Affiche ou masque l\'entête pour le bloc "Pied de page".';

$_lang['area_places'] = 'Places';
$_lang['area_default'] = 'Défault';

$_lang['tagger.err.group_name_ns'] = 'Veuillez indiquer un nom de groupe.';
$_lang['tagger.err.group_name_ae'] = 'Groupe existant, veuillez indiquer un autre nom.';
$_lang['tagger.err.tag_name_ns'] = 'Veuillez indiquer un nom de tag.';
$_lang['tagger.err.tag_name_ae'] = 'Tag existant dans le groupe, veuillez indiquer un nom de tag différent ou un autre groupe.';
$_lang['tagger.err.tag_group_changed'] = 'Le groupe du tag ne peut être changé.';
$_lang['tagger.err.bad_sort_column'] = 'Utiliser <strong>[[+column]]</strong> pour le classement par drag & drop dans la grille.';
$_lang['tagger.err.clear_filter'] = 'Veuillez effacer la <strong>recherche</strong> afin de pouvoir utiliser le classement par drag & drop.';
$_lang['tagger.err.import_group_ns'] = 'Groupe non indiqué, veuillez sélectionner un groupe.';
$_lang['tagger.err.import_tv_ns'] = 'TV non indiquée, veuillez sélectionner une TV.';
$_lang['tagger.err.import_tv_ne'] = 'TV non trouvée, veuillez corriger.';
$_lang['tagger.err.import_tv_nsp'] = 'Le type de TV sélctionné n\'est pas supporté. Les types supportés sont : [[+supported]]';
$_lang['tagger.err.tag_assigned_resources_tag_ns'] = 'Tag non défini, veuillez recommencer.';
$_lang['tagger.err.tags_ns'] = 'Tags non définis.';
$_lang['tagger.err.merge_same_groups'] = 'Vous ne pouvez pas fusionner ces tags';
$_lang['tagger.err.merge_same_groups_desc'] = 'Les tags sélectionnés ne peuvent être fusionnés car ils appartiennent à des groupes différents.';
$_lang['tagger.err.tag_alias_ae'] = 'Un tag utilisant cet alias existe déjà dans ce groupe, veuillez indiquer un autre alias ou sélectionner un autre groupe.';
$_lang['tagger.err.group_alias_ae'] = 'Un groupe utilisant cet alias existe déjà, veuillez indiquer un autre alias.';
