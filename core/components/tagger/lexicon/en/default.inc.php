<?php
/**
 * Default English Lexicon Entries for Tagger
 *
 * @package tagger
 * @subpackage lexicon
 */

$_lang['tagger'] = 'Tagger';

$_lang['tagger.global.search'] = 'Search';
$_lang['tagger.global.loading'] = 'Loading';
$_lang['tagger.global.change_order'] = 'Change order of: [[+name]]';

$_lang['tagger.menu.tagger'] = 'Tagger';
$_lang['tagger.menu.tagger_desc'] = 'Manage your groups and tags';

$_lang['tagger.field.tagfield'] = 'Tag field';
$_lang['tagger.field.combobox'] = 'Combo box';

$_lang['tagger.group.groups'] = 'Groups';
$_lang['tagger.group.intro_msg'] = 'In this section you can manage Groups. Each group will later contain tags.';
$_lang['tagger.group.name'] = 'Name';
$_lang['tagger.group.name_desc'] = 'Label of the field that will be added to Resource panel';
$_lang['tagger.group.description'] = 'Description';
$_lang['tagger.group.description_desc'] = 'Describe the purpose of the group';
$_lang['tagger.group.field_type'] = 'Field type';
$_lang['tagger.group.field_type_desc'] = 'Tag field - multi select field, Combo box - classic one item select field';
$_lang['tagger.group.remove_unused'] = 'Remove unused tags';
$_lang['tagger.group.remove_unused_desc'] = 'If set to <strong>yes</strong>, all tags, that are not assigned to at least one resource will be removed from database.';
$_lang['tagger.group.allow_new'] = 'Allow new tags from field';
$_lang['tagger.group.allow_new_desc'] = 'If set to <strong>yes</strong>, users will be able to add new tags from field. Setting to no can be useful for example for list of categories';
$_lang['tagger.group.allow_blank'] = 'Allow blank';
$_lang['tagger.group.allow_blank_desc'] = 'If set to <strong>no</strong>, field will be marked as required and users will have to select at least on tag before saving the Resource';
$_lang['tagger.group.allow_type'] = 'Allow type';
$_lang['tagger.group.allow_type_desc'] = 'If set to <strong>no</strong>, users will not be able to type in the field. Clicking to the field will trigger showing list of available tags.';
$_lang['tagger.group.show_autotag'] = 'Show autotag';
$_lang['tagger.group.show_autotag_desc'] = 'If set to <strong>yes</strong>, all tags will be displayed below the field. Users will be bale to click on them to select/unselect. Available only for Tag field.';
$_lang['tagger.group.show_for_templates'] = 'Show for Templates';
$_lang['tagger.group.show_for_templates_desc'] = 'Comma separated list of template <strong>ID</strong>s for that should be this group displayed.';
$_lang['tagger.group.position'] = 'Position';
$_lang['tagger.group.all'] = 'All groups';
$_lang['tagger.group.create'] = 'Create a new Group';
$_lang['tagger.group.update'] = 'Update Group';
$_lang['tagger.group.remove'] = 'Remove Group';
$_lang['tagger.group.remove_confirm'] = 'Are you sure, you want to remove this Group? All tags in this group will be also removed.';
$_lang['tagger.group.import'] = 'Import';
$_lang['tagger.group.auto_import'] = 'Automatic import';
$_lang['tagger.group.import_from'] = 'Import from TV';
$_lang['tagger.group.import_to'] = 'Import to Group';
$_lang['tagger.group.place'] = 'Place';
$_lang['tagger.group.place_desc'] = 'Where will be this group rendered. Options are: In tab, In TVs section, Above content, Below content, Bottom page';
$_lang['tagger.group.place_in_tab'] = 'In tab';
$_lang['tagger.group.place_tvs_tab'] = 'In TVs section';
$_lang['tagger.group.place_above_content'] = 'Above content';
$_lang['tagger.group.place_below_content'] = 'Below content';
$_lang['tagger.group.place_bottom_page'] = 'Bottom page';
$_lang['tagger.group.hide_input'] = 'Hide input';
$_lang['tagger.group.hide_input_desc'] = 'When checked the input field with assign button will be hidden.';
$_lang['tagger.group.tag_limit'] = 'Tag limit';
$_lang['tagger.group.tag_limit_desc'] = 'Number of tags that can be assigned to a resource';
$_lang['tagger.group.alias'] = 'Alias';
$_lang['tagger.group.alias_desc'] = 'Alias that will be used in URL when FURLs are enabled. Leave field blank to generate alias automatically.';
$_lang['tagger.group.in_tvs_position'] = 'Position of Tagger tab in TVs section';
$_lang['tagger.group.in_tvs_position_desc'] = 'Position in TVs section on which will be added Tagger tab';

$_lang['tagger.tab.label'] = 'Tagger';

$_lang['tagger.tag.tags'] = 'Tags';
$_lang['tagger.tag.intro_msg'] = 'In this section you can manage Tags.';
$_lang['tagger.tag.name'] = 'Name';
$_lang['tagger.tag.alias'] = 'Alias';
$_lang['tagger.tag.group'] = 'Group';
$_lang['tagger.tag.create'] = 'Create a new Tag';
$_lang['tagger.tag.update'] = 'Update Tag';
$_lang['tagger.tag.remove'] = 'Remove Tag';
$_lang['tagger.tag.remove_confirm'] = 'Are you sure, you want to remove this Tag?';
$_lang['tagger.tag.assigned_resources'] = 'Assigned resources';
$_lang['tagger.tag.assigned_resources_to'] = 'Assigned resources to [[+tag]]';
$_lang['tagger.tag.resource_update'] = 'Update resource';
$_lang['tagger.tag.resource_unassign'] = 'Unassign resource';
$_lang['tagger.tag.resource_unassign_confirm'] = 'Are you sure, you want to unassign this resource?';
$_lang['tagger.tag.resource_unassign_multiple_confirm'] = 'Are you sure, you want to unassign selected ([[+resources]]) resources?';
$_lang['tagger.tag.resource_unasign_selected'] = 'Unassign selected';
$_lang['tagger.tag.bulk_actions'] = 'Bulk actions';
$_lang['tagger.tag.merge_selected'] = 'Merge selected Tags';
$_lang['tagger.tag.remove_selected'] = 'Remove selected Tags';
$_lang['tagger.tag.remove_selected_confirm'] = 'Are you sure, you want to remove all selected Tags?';
$_lang['tagger.tag.merge'] = 'Merge Tags';
$_lang['tagger.tag.assign'] = 'Assign';

$_lang['setting_tagger.place_above_content_header'] = 'Above content header';
$_lang['setting_tagger.place_above_content_header_desc'] = 'Show or hide header of the Tagger block, that shows above the content block.';
$_lang['setting_tagger.place_below_content_header'] = 'Below content header';
$_lang['setting_tagger.place_below_content_header_desc'] = 'Show or hide header of the Tagger block, that shows below the content block.';
$_lang['setting_tagger.place_bottom_page_header'] = 'Bottom page header';
$_lang['setting_tagger.place_bottom_page_header_desc'] = 'Show or hide header of the Tagger block, that shows at the bottom of the page.';
$_lang['setting_tagger.place_in_tab_label'] = 'In tab label';
$_lang['setting_tagger.place_in_tab_label_desc'] = 'Label of the Tagger block, that shows in the tab.';
$_lang['setting_tagger.place_tvs_tab_label'] = 'In TVs section label';
$_lang['setting_tagger.place_tvs_tab_label_desc'] = 'Label of the Tagger block, that shows in the TVs section.';
$_lang['setting_tagger.place_above_content_label'] = 'Above content label';
$_lang['setting_tagger.place_above_content_label_desc'] = 'Label of the Tagger block, that shows above the content block.';
$_lang['setting_tagger.place_below_content_label'] = 'Below content label';
$_lang['setting_tagger.place_below_content_label_desc'] = 'Label of the Tagger block, that shows below the content block.';
$_lang['setting_tagger.place_bottom_page_label'] = 'Bottom page label';
$_lang['setting_tagger.place_bottom_page_label_desc'] = 'Label of the Tagger block, that shows at the bottom of the page.';

$_lang['area_places'] = 'Places';
$_lang['area_default'] = 'Default';

$_lang['tagger.err.group_name_ns'] = 'Group name is not specified. Please fill Group name.';
$_lang['tagger.err.group_name_ae'] = 'Group with this name already exists. Please choose a different name.';
$_lang['tagger.err.tag_name_ns'] = 'Tag name is not specified. Please fill Tag name.';
$_lang['tagger.err.tag_name_ae'] = 'Tag with this name already exists in given group. Please choose a different name or group.';
$_lang['tagger.err.tag_group_changed'] = 'Tag group can not be changed.';
$_lang['tagger.err.bad_sort_column'] = 'Sort grid by <strong>[[+column]]</strong> to use drag & drop sorting.';
$_lang['tagger.err.clear_filter'] = 'Please clear <strong>search</strong> to use drag & drop sorting.';
$_lang['tagger.err.import_group_ns'] = 'Group is not specified. Please select a Group.';
$_lang['tagger.err.import_tv_ns'] = 'Template Variable is not specified. Please select a TV.';
$_lang['tagger.err.import_tv_ne'] = 'Template Variable was not found. Please try to repeat your action.';
$_lang['tagger.err.import_tv_nsp'] = 'Type of selected Template Variable is not supported. Supported types are: [[+supported]]';
$_lang['tagger.err.tag_assigned_resources_tag_ns'] = 'Tag is not specified. Please try to repeat your action.';
$_lang['tagger.err.tags_ns'] = 'Tags are not specified.';
$_lang['tagger.err.merge_same_groups'] = 'You can\'t merge those Tags';
$_lang['tagger.err.merge_same_groups_desc'] = 'Selected Tags can not be merged, because they belongs to different groups.';
$_lang['tagger.err.tag_alias_ae'] = 'Tag with this alias already exists in given group. Please choose a different alias or group.';
$_lang['tagger.err.group_alias_ae'] = 'Group with this alias already exists. Please choose a different alias.';
