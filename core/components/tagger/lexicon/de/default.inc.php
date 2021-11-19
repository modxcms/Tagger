<?php
/**
 * Default German Lexicon Entries for Tagger
 *
 * @package tagger
 * @subpackage lexicon
 */

$_lang['tagger'] = 'Tagger';

$_lang['tagger.global.search'] = 'Suche';
$_lang['tagger.global.loading'] = 'Lädt';
$_lang['tagger.global.change_order'] = 'Reihenfolge ändern von: [[+Name]]';

$_lang['tagger.menu.tagger'] = 'Tagger';
$_lang['tagger.menu.tagger_desc'] = 'Verwalten Sie Ihre Gruppen und Tags';

$_lang['tagger.field.tagfield'] = 'Tag-Feld';
$_lang['tagger.field.combobox'] = 'Drop-Down Feld';

$_lang['tagger.group.groups'] = 'Gruppen';
$_lang['tagger.group.intro_msg'] = 'In diesem Abschnitt können Sie Gruppen verwalten. Jede Gruppe wird später Tags enthalten.';
$_lang['tagger.group.name'] = 'Name';
$_lang['tagger.group.name_desc'] = 'Bezeichnung des Feldes, das dem Ressourcen-Panel hinzugefügt wird';
$_lang['tagger.group.description'] = 'Beschreibung';
$_lang['tagger.group.description_desc'] = 'Beschreiben Sie den Zweck der Gruppe';
$_lang['tagger.group.field_type'] = 'Feldtyp';
$_lang['tagger.group.field_type_desc'] = 'Tag-Feld - Mehrfachauswahlfeld, Drop-Down Feld - klassisches Auswahlfeld für ein Element';
$_lang['tagger.group.remove_unused'] = 'Unbenutzte Tags entfernen';
$_lang['tagger.group.remove_unused_desc'] = 'Wenn <strong>Ja</strong> gewählt ist, werden alle Tags, die nicht mindestens einer Ressource zugeordnet sind, aus der Datenbank entfernt.';
$_lang['tagger.group.allow_new'] = 'Neue Tags aus dem Feld zulassen';
$_lang['tagger.group.allow_new_desc'] = 'Wenn <strong>Ja</strong> gewählt ist, können Benutzer neue Tags aus dem Feld hinzufügen. Die Einstellung no kann z.B. für eine Liste von Kategorien nützlich sein';
$_lang['tagger.group.allow_blank'] = 'Leerzeichen zulassen';
$_lang['tagger.group.allow_blank_desc'] = 'Wenn <strong>Nein</strong> gewählt ist, wird das Feld als erforderlich markiert und die Benutzer müssen mindestens ein Tag auswählen, bevor sie die Ressource speichern';
$_lang['tagger.group.allow_type'] = 'Eingabe zulassen';
$_lang['tagger.group.allow_type_desc'] = 'Wenn <strong>Nein</strong> gewählt ist, können Benutzer das Feld nicht frei befüllen. Wenn man auf das Feld klickt, wird eine Liste der verfügbaren Tags angezeigt.';
$_lang['tagger.group.show_autotag'] = 'Autotag anzeigen';
$_lang['tagger.group.show_autotag_desc'] = 'Wenn <strong>Ja</strong> gewählt ist, werden alle Tags unterhalb des Feldes angezeigt. Die Benutzer können sie anklicken, um sie auszuwählen oder die Auswahl aufzuheben. Nur für das Tag-Feld verfügbar.';
$_lang['tagger.group.show_for_templates'] = 'Für diese Templates anzeigen';
$_lang['tagger.group.show_for_templates_desc'] = 'Kommagetrennte Liste von Template <strong>ID</strong>s, in der diese Gruppe angezeigt werden soll.';
$_lang['tagger.group.position'] = 'Position';
$_lang['tagger.group.all'] = 'Alle Gruppen';
$_lang['tagger.group.create'] = 'Eine neue Gruppe erstellen';
$_lang['tagger.group.update'] = 'Gruppe bearbeiten';
$_lang['tagger.group.remove'] = 'Gruppe entfernen';
$_lang['tagger.group.remove_confirm'] = 'Sind Sie sicher, dass Sie diese Gruppe entfernen wollen? Alle Tags in dieser Gruppe werden ebenfalls entfernt.';
$_lang['tagger.group.import'] = 'Importieren';
$_lang['tagger.group.auto_import'] = 'Automatischer Import';
$_lang['tagger.group.import_from'] = 'Von TV importieren';
$_lang['tagger.group.import_to'] = 'In Gruppe importieren';
$_lang['tagger.group.place'] = 'Ort';
$_lang['tagger.group.place_desc'] = 'Wo wird diese Gruppe ausgegeben. Optionen sind: Im Tab, Im TV-Bereich, Über dem Inhalt, Unter dem Inhalt, Unter der Seite';
$_lang['tagger.group.place_in_tab'] = 'In der Registerkarte';
$_lang['tagger.group.place_tvs_tab'] = 'Im TV-Bereich';
$_lang['tagger.group.place_above_content'] = 'Über dem Inhalt';
$_lang['tagger.group.place_below_content'] = 'Unter dem Inhalts';
$_lang['tagger.group.place_bottom_page'] = 'Unter Seite';
$_lang['tagger.group.hide_input'] = 'Eingabe ausblenden';
$_lang['tagger.group.hide_input_desc'] = 'Wenn die Option aktiv ist, wird das Eingabefeld mit Zuweisungsschaltfläche ausgeblendet.';
$_lang['tagger.group.tag_limit'] = 'Tag-Limit';
$_lang['tagger.group.tag_limit_desc'] = 'Anzahl der Tags, die einer Ressource zugewiesen werden können';
$_lang['tagger.group.alias'] = 'Alias';
$_lang['tagger.group.alias_desc'] = 'Alias, der in der URL verwendet wird, wenn FURLs aktiviert sind. Lassen Sie das Feld leer, um den Alias automatisch zu generieren.';
$_lang['tagger.group.in_tvs_position'] = 'Position der Tagger-Registerkarte im TV-Bereich';
$_lang['tagger.group.in_tvs_position_desc'] = 'Position im TV-Bereich, an der die Registerkarte Tagger hinzugefügt wird';
$_lang['tagger.group.as_radio'] = 'Als Radio';
$_lang['tagger.group.as_radio_desc'] = 'Auto-Tag wird wie ein Radiobutton funktionieren.';
$_lang['tagger.group.sort_asc'] = 'ASC';
$_lang['tagger.group.sort_desc'] = 'DESC';
$_lang['tagger.group.sort_dir'] = 'Sortierrichtung';
$_lang['tagger.group.sort_dir_desc'] = 'Sortierrichtung - Richtung der Sortierung beim Holen der Tags.';
$_lang['tagger.group.sort_field'] = 'Sortierfeld';
$_lang['tagger.group.sort_field_desc'] = 'Sortierfeld - Feld, das zum Sortieren von Tags verwendet wird';
$_lang['tagger.group.sort_field_alias'] = 'Alias';
$_lang['tagger.group.sort_field_rank'] = 'Rang';
$_lang['tagger.group.show_for_contexts'] = 'Für Kontexte anzeigen';
$_lang['tagger.group.show_for_contexts_desc'] = 'Kommagetrennte Liste von Kontext <strong>KEY</strong>s, für die diese Gruppe angezeigt werden soll. Standardmäßig wird die Gruppe für alle Kontexte angezeigt.';

$_lang['tagger.tab.label'] = 'Tagger';

$_lang['tagger.tag.tags'] = 'Tags';
$_lang['tagger.tag.intro_msg'] = 'In diesem Bereich können Sie Tags verwalten.';
$_lang['tagger.tag.name'] = 'Name';
$_lang['tagger.tag.alias'] = 'Alias';
$_lang['tagger.tag.group'] = 'Gruppe';
$_lang['tagger.tag.create'] = 'Einen neuen Tag erstellen';
$_lang['tagger.tag.update'] = 'Tag bearbeiten';
$_lang['tagger.tag.remove'] = 'Tag entfernen';
$_lang['tagger.tag.remove_confirm'] = 'Sind Sie sicher, dass Sie dieses Tag entfernen wollen?';
$_lang['tagger.tag.assigned_resources'] = 'Zugewiesene Ressourcen';
$_lang['tagger.tag.assigned_resources_to'] = 'Zugewiesene Ressourcen an [[+tag]]';
$_lang['tagger.tag.resource_update'] = 'Ressource bearbeiten';
$_lang['tagger.tag.resource_unassign'] = 'Zuweisung der Ressource aufheben';
$_lang['tagger.tag.resource_unassign_confirm'] = 'Sind Sie sicher, dass Sie die Zuweisung dieser Ressource aufheben wollen?';
$_lang['tagger.tag.resource_unassign_multiple_confirm'] = 'Sind Sie sicher, dass Sie die Zuweisung ausgewählter ([[+Ressourcen]]) Ressourcen aufheben wollen?';
$_lang['tagger.tag.resource_unasign_selected'] = 'Ausgewählte Zuweisung aufheben';
$_lang['tagger.tag.bulk_actions'] = 'Massen-Aktionen';
$_lang['tagger.tag.merge_selected'] = 'Ausgewählte Tags zusammenführen';
$_lang['tagger.tag.remove_selected'] = 'Ausgewählte Tags entfernen';
$_lang['tagger.tag.remove_selected_confirm'] = 'Sind Sie sicher, dass Sie alle ausgewählten Tags entfernen wollen?';
$_lang['tagger.tag.merge'] = 'Tags zusammenführen';
$_lang['tagger.tag.assign'] = 'Zuweisen';
$_lang['tagger.tag.rank'] = 'Rang';
$_lang['tagger.tag.label'] = 'Label';

$_lang['setting_tagger.place_above_content_header'] = 'Kopfzeile über dem Inhalt';
$_lang['setting_tagger.place_above_content_header_desc'] = 'Kopfzeile des Tagger-Blocks ein- oder ausblenden, die über dem Inhalts-Block angezeigt wird.';
$_lang['setting_tagger.place_below_content_header'] = 'Kopfzeile unter dem Inhalt';
$_lang['setting_tagger.place_below_content_header_desc'] = 'Kopfzeile des Tagger-Blocks ein- oder ausblenden, die unter dem Inhalts-Block angezeigt wird.';
$_lang['setting_tagger.place_bottom_page_header'] = 'Kopfzeile Seitenende';
$_lang['setting_tagger.place_bottom_page_header_desc'] = 'Kopfzeile des Tagger-Blocks ein- oder ausblenden, die am Seitenende angezeigt wird.';
$_lang['setting_tagger.place_in_tab_label'] = 'Tab-Label';
$_lang['setting_tagger.place_in_tab_label_desc'] = 'Label des Tagger-Blocks, der als Tab angezeigt wird.';
$_lang['setting_tagger.place_tvs_tab_label'] = 'TV-Abschnitt Label';
$_lang['setting_tagger.place_tvs_tab_label_desc'] = 'Label des Tagger-Blocks, der in der TV-Sektion angezeigt wird.';
$_lang['setting_tagger.place_above_content_label'] = 'Label über dem Inhalts-Block';
$_lang['setting_tagger.place_above_content_label_desc'] = 'Label des Tagger-Blocks, der über dem Inhalts-Block angezeigt wird.';
$_lang['setting_tagger.place_below_content_label'] = 'Label unter dem Inhalts-Block';
$_lang['setting_tagger.place_below_content_label_desc'] = 'Label des Tagger-Blocks, der unter dem Inhalts-Block angezeigt wird.';
$_lang['setting_tagger.place_bottom_page_label'] = 'Label Seitenende';
$_lang['setting_tagger.place_bottom_page_label_desc'] = 'Label des Tagger-Blocks, der am Seitenende angezeigt wird.';
$_lang['setting_tagger.remove_accents_tag'] = 'Sonderzeichen aus Tags entfernen';
$_lang['setting_tagger.remove_accents_tag_desc'] = 'Sonderzeichen aus dem Tag-Alias entfernen.';
$_lang['setting_tagger.remove_accents_group'] = 'Sonderzeichen aus Gruppen entfernen';
$_lang['setting_tagger.remove_accents_group_desc'] = 'Sonderzeichen aus dem Gruppen-Alias entfernen.';


$_lang['area_places'] = 'Orte';
$_lang['area_default'] = 'Standard';
$_lang['area_settings'] = 'Einstellungen';

$_lang['tagger.err.group_name_ns'] = 'Gruppenname ist nicht angegeben. Bitte Gruppenname eingeben.';
$_lang['tagger.err.group_name_ae'] = 'Gruppe mit diesem Namen existiert bereits. Bitte wählen Sie einen anderen Namen.';
$_lang['tagger.err.tag_name_ns'] = 'Tag-Name ist nicht angegeben. Bitte Tag-Name eingeben.';
$_lang['tagger.err.tag_name_ae'] = 'Tag mit diesem Namen existiert bereits in der angegebenen Gruppe. Bitte wählen Sie einen anderen Namen oder eine andere Gruppe.';
$_lang['tagger.err.tag_group_changed'] = 'Tag-Gruppe kann nicht geändert werden.';
$_lang['tagger.err.bad_sort_column'] = 'Sortiere die Tabelle nach <strong>[[+Spalte]]</strong>, um Drag & Drop-Sortierung zu verwenden.';
$_lang['tagger.err.clear_filter'] = 'Bitte deaktivieren Sie die <strong>Suche</strong>, um die Drag & Drop-Sortierung zu verwenden.';
$_lang['tagger.err.import_group_ns'] = 'Gruppe ist nicht angegeben. Bitte wählen Sie eine Gruppe aus.';
$_lang['tagger.err.import_tv_ns'] = 'Template-Variable ist nicht angegeben. Bitte wählen Sie eine TV.';
$_lang['tagger.err.import_tv_ne'] = 'Template-Variable wurde nicht gefunden. Bitte wiederholen Sie Ihre Aktion.';
$_lang['tagger.err.import_tv_nsp'] = 'Der Typ der ausgewählten Template-Variable wird nicht unterstützt. Unterstützte Typen sind: [[+unterstützt]]';
$_lang['tagger.err.tag_assigned_resources_tag_ns'] = 'Tag ist nicht angegeben. Bitte wiederholen Sie Ihre Aktion.';
$_lang['tagger.err.tags_ns'] = 'Es wurden keine Tags angegeben.';
$_lang['tagger.err.merge_same_groups'] = 'Sie können diese Tags nicht zusammenführen.';
$_lang['tagger.err.merge_same_groups_desc'] = 'Ausgewählte Tags können nicht zusammengeführt werden, da sie zu verschiedenen Gruppen gehören.';
$_lang['tagger.err.tag_alias_ae'] = 'Tag mit diesem Alias existiert bereits in der angegebenen Gruppe. Bitte wählen Sie einen anderen Alias oder eine andere Gruppe.';
$_lang['tagger.err.group_alias_ae'] = 'Gruppe mit diesem Alias existiert bereits. Bitte wählen Sie einen anderen Alias.';
