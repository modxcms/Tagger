<?php
/**
 * Snippet's properties Russian Lexicon Entries for Tagger
 *
 * @package tagger
 * @subpackage lexicon
 */

$_lang['tagger.getresourceswhere.tags_desc'] = 'Разделенный запятыми список тэгов, которые будут сгенерированы для запроса where. По умолчанию тэги из GET параметра будут использованы';
$_lang['tagger.getresourceswhere.groups_desc'] = 'Разделенный запятыми список групп тэгов. По умолчанию тэги только из этих групп будут разрешены';
$_lang['tagger.getresourceswhere.where_desc'] = 'Оригинальный getResources where запрос. Если вы используете where запрос в текущем вызове getResources, перенесите его сюда';

$_lang['tagger.gettags.resources_desc'] = 'Разделенный запятыми список ресурсов, для которых будут отображены тэги';
$_lang['tagger.gettags.groups_desc'] = 'Разделенный запятыми список групп тэгов, для которых будут отображены тэги';
$_lang['tagger.gettags.rowTpl_desc'] = 'Имя чанка, который будет использован для каждого тэга. Если не указано, массив свойств будет распечатан';
$_lang['tagger.gettags.outTpl_desc'] = 'Имя чанка-обертки для тэгов. Если не указано, тэги будут выведены без "обертки"';
$_lang['tagger.gettags.separator_desc'] = 'Строковый разделитель, который будет использован для разделения тэгов';
$_lang['tagger.gettags.target_desc'] = 'ID ресурса, который будет использован для создания URI для тэга. Если ID не указан, текущий ID ресурс будет использован';
$_lang['tagger.gettags.showUnused_desc'] = 'Если включено (указано 1), непривязанные к ресурсам тэги будут включены в вывод';
$_lang['tagger.gettags.contexts_desc'] = 'Если указано, будут отображены тэги только для ресурсов в указанных контекстах. Список контекстов разделяется запятыми';
$_lang['tagger.gettags.toPlaceholder_desc'] = 'Если указано, весь вывод будет сохранен в плейсхолдер с указанным именем';
$_lang['tagger.gettags.showUnpublished_desc'] = 'Если включено (указано 1), привязанные к неопубликованным ресурсам тэги будут включены в вывод';
$_lang['tagger.gettags.showDeleted_desc'] = 'Если включено (указано 1), привязанные к удаленным ресурсам тэги будут включены в вывод';
$_lang['tagger.gettags.limit_desc'] = 'Лимит возвращаемых тэгов';
$_lang['tagger.gettags.offset_desc'] = 'Число пропускаемых от начала тэгов';
$_lang['tagger.gettags.totalPh_desc'] = 'Плейсхолдер для вывода общего количества тэгов без учета &limit и &offset';
$_lang['tagger.getresourceswhere.likeComparison_desc'] = 'Если включено (указано 1), поиск тэгов будет осуществляться с использованием оператора LIKE';
$_lang['tagger.gettags.sort_desc'] = 'Опции сортировки в JSON. К примеру: {"tag": "ASC"} или множественная сортировка: {"group_id": "ASC", "tag": "ASC"}';
$_lang['tagger.getresourceswhere.tagField_desc'] = 'Поле для сравнения с указанным тэгом. По умолчанию: псевдоним';
$_lang['tagger.getresourceswhere.matchAll_desc'] = 'Если включено (указано 1), ресурс должен иметь все указанные тэги. По умолчанию: 0';
