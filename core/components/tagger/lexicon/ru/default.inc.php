<?php
/**
 * Default Russian Lexicon Entries for Tagger
 *
 * @package tagger
 * @subpackage lexicon
 */

$_lang['tagger'] = 'Tagger';

$_lang['tagger.global.search'] = 'Поиск';
$_lang['tagger.global.loading'] = 'Загрузка';
$_lang['tagger.global.change_order'] = 'Изменить заказ от: [[+name]]';

$_lang['tagger.menu.tagger'] = 'Tagger';
$_lang['tagger.menu.tagger_desc'] = 'Управление Вашими тэгами или группами';

$_lang['tagger.field.tagfield'] = 'Поле тэга';
$_lang['tagger.field.combobox'] = 'Выпадающий список';

$_lang['tagger.group.groups'] = 'Группы';
$_lang['tagger.group.intro_msg'] = 'Здесь Вы можете управлять группами. Затем каждая группа наполняется тэгами.';
$_lang['tagger.group.name'] = 'Название';
$_lang['tagger.group.name_desc'] = 'Метка поля, которое добавляется на панель ресурса';
$_lang['tagger.group.description'] = 'Описание';
$_lang['tagger.group.description_desc'] = 'Опишите цель группы';
$_lang['tagger.group.field_type'] = 'Тип поля';
$_lang['tagger.group.field_type_desc'] = 'Тип поля тэга - поле с множественным выбором, выпадающий список';
$_lang['tagger.group.remove_unused'] = 'Удалять неиспользуемые тэги';
$_lang['tagger.group.remove_unused_desc'] = 'Если установлено в <strong>Да</strong>, все тэги, которые не привязаны хотя бы к одному ресурсу, будут удалены.';
$_lang['tagger.group.allow_new'] = 'Разрешать создание новых';
$_lang['tagger.group.allow_new_desc'] = 'Если установлено в <strong>да</strong>, пользователи смогут создавать новые тэги при редактировании ресурсов. Установите в <strong>нет</strong>, чтобы заблокировать создание новых тэгов при редактировании ресурсов';
$_lang['tagger.group.allow_blank'] = 'Разрешать пустые';
$_lang['tagger.group.allow_blank_desc'] = 'Если установлено в <strong>нет</strong>, поле будет отмечено как обязательное, и пользователи не смогут сохранить ресурс, пока не укажут хотя бы один тэг';
$_lang['tagger.group.allow_type'] = 'Разрешенные типы';
$_lang['tagger.group.allow_type_desc'] = 'Если установлено в <strong>нет</strong>, пользователям не доступен ввод в это поле. Щелчок по полю отобразит список доступных тэгов.';
$_lang['tagger.group.show_autotag'] = 'Показывать автотэги';
$_lang['tagger.group.show_autotag_desc'] = 'Если установлено в <strong>да</strong>, все тэги будут показаны ниже поля. Пользователям необходимо будет щелкнуть на них для выбора / снятия выбора. Доступно только для поля с тэгами.';
$_lang['tagger.group.show_for_templates'] = 'Показывать для шаблонов';
$_lang['tagger.group.show_for_templates_desc'] = 'Разделенный запятыми список <strong>ID</strong>s шаблонов, которым доступна эта группа.';
$_lang['tagger.group.position'] = 'Позиция';
$_lang['tagger.group.all'] = 'Все группы';
$_lang['tagger.group.create'] = 'Создать новую группу';
$_lang['tagger.group.update'] = 'Обновить группу';
$_lang['tagger.group.remove'] = 'Удалить группу';
$_lang['tagger.group.remove_confirm'] = 'Вы уверены, что хотите удалить группу? Все тэги этой группы тоже будут удалены.';
$_lang['tagger.group.import'] = 'Импорт';
$_lang['tagger.group.auto_import'] = 'Автоматический импорт';
$_lang['tagger.group.import_from'] = 'Импорт из TV';
$_lang['tagger.group.import_to'] = 'Импорт в группу';
$_lang['tagger.group.place'] = 'Место';
$_lang['tagger.group.place_desc'] = 'Расположение Tagger при редактированни ресурса. Варианты: В отдельной вкладке, Во вкладке Доп. параметров, Выше содержимого, Ниже содержимого, В самом низу страницы';
$_lang['tagger.group.place_in_tab'] = 'В отдельной вкладке';
$_lang['tagger.group.place_tvs_tab'] = 'Во вкладке Доп. параметров';
$_lang['tagger.group.place_above_content'] = 'Над содержимым';
$_lang['tagger.group.place_below_content'] = 'Ниже содержимого';
$_lang['tagger.group.place_bottom_page'] = 'В самом низу страницы';
$_lang['tagger.group.hide_input'] = 'Спрятать поле ввода';
$_lang['tagger.group.hide_input_desc'] = 'Если отмечено, поле ввода с привязанной кнопкой будет спрятано.';
$_lang['tagger.group.tag_limit'] = 'Лимит тэгов';
$_lang['tagger.group.tag_limit_desc'] = 'Количество тэгов, которое может быть присвоено ресурсу';
$_lang['tagger.group.alias'] = 'Псевдоним';
$_lang['tagger.group.alias_desc'] = 'Псевдоним, который будет использован при включенных дружественных адресах. Оставьте пустым для автоматического создания.';
$_lang['tagger.group.in_tvs_position'] = 'Расположение Tagger на вкладке Доп. параметров';
$_lang['tagger.group.in_tvs_position_desc'] = 'Расположение Tagger на вкладке Доп. параметров';

$_lang['tagger.tab.label'] = 'Tagger';

$_lang['tagger.tag.tags'] = 'Тэги';
$_lang['tagger.tag.intro_msg'] = 'Вкладка управления тэгами';
$_lang['tagger.tag.name'] = 'Название';
$_lang['tagger.tag.alias'] = 'Псевдоним';
$_lang['tagger.tag.group'] = 'Группа';
$_lang['tagger.tag.create'] = 'Создать новый тэг';
$_lang['tagger.tag.update'] = 'Обновить тэг';
$_lang['tagger.tag.remove'] = 'Удалить тэг';
$_lang['tagger.tag.remove_confirm'] = 'Вы уверены, что хотите удалить этот тэг?';
$_lang['tagger.tag.assigned_resources'] = 'Привязанные ресурсы';
$_lang['tagger.tag.assigned_resources_to'] = 'Привязанные ресурсы к тэгу [[+tag]]';
$_lang['tagger.tag.resource_update'] = 'Обновить ресурс';
$_lang['tagger.tag.resource_unassign'] = 'Отвязать ресурс';
$_lang['tagger.tag.resource_unassign_confirm'] = 'Вы уверены, что хотите отвязать этот ресурс?';
$_lang['tagger.tag.resource_unassign_multiple_confirm'] = 'Вы уверены, что хотите отвязать эти ([[+resources]]) ресурсы?';
$_lang['tagger.tag.resource_unasign_selected'] = 'Выбранные отвязаны';
$_lang['tagger.tag.bulk_actions'] = 'Набор действий';
$_lang['tagger.tag.merge_selected'] = 'Соединить выбранные тэги';
$_lang['tagger.tag.remove_selected'] = 'Удалить выбранные тэги';
$_lang['tagger.tag.remove_selected_confirm'] = 'Вы уверены, что хотите удалить все выбранные тэги?';
$_lang['tagger.tag.merge'] = 'Соединить тэги';
$_lang['tagger.tag.assign'] = 'Привязать';

$_lang['setting_tagger.place_above_content_header'] = 'Заголовок, если выше содержимого';
$_lang['setting_tagger.place_above_content_header_desc'] = 'Показать или спрятать заголовок блока тэгов, который отображается выше содержимого.';
$_lang['setting_tagger.place_below_content_header'] = 'Заголовок, если ниже содержимого';
$_lang['setting_tagger.place_below_content_header_desc'] = 'Показать или спрятать заголовок блока тэгов, который отображается ниже содержимого.';
$_lang['setting_tagger.place_bottom_page_header'] = 'Заголовок, если в самом низу страницы';
$_lang['setting_tagger.place_bottom_page_header_desc'] = 'Показать или спрятать заголовок блока тэгов, который отображается в самом низу страницы.';
$_lang['setting_tagger.place_in_tab_label'] = 'Заголовок, если в отдельной вкладке';
$_lang['setting_tagger.place_in_tab_label_desc'] = 'Заголовок блока  Tagger, который отображается на отдельной вкладке.';
$_lang['setting_tagger.place_tvs_tab_label'] = 'Заголовок, если во вкладке Доп. параметров';
$_lang['setting_tagger.place_tvs_tab_label_desc'] = 'Заголовок блока Tagger, который отображается на вкладке Доп. параметров.';
$_lang['setting_tagger.place_above_content_label'] = 'Метка, если выше содержимого';
$_lang['setting_tagger.place_above_content_label_desc'] = 'Заголовок блока Tagger, который отображается выше содержимого ресурса.';
$_lang['setting_tagger.place_below_content_label'] = 'Метка, если ниже содержимого';
$_lang['setting_tagger.place_below_content_label_desc'] = 'Заголовок блока Tagger, который отображается ниже содержимого ресурса.';
$_lang['setting_tagger.place_bottom_page_label'] = 'Метка, если в самом низу страницы';
$_lang['setting_tagger.place_bottom_page_label_desc'] = 'Заголовок блока Tagger, который отображается в самом низу страницы.';

$_lang['area_places'] = 'Места';
$_lang['area_default'] = 'По умолчанию';

$_lang['tagger.err.group_name_ns'] = 'Название группы не заполнено. Пожалуйста, укажите название группы';
$_lang['tagger.err.group_name_ae'] = 'Такое название группы уже существует. Пожалуйста, выберите другое название.';
$_lang['tagger.err.tag_name_ns'] = 'Название тэга не заполнено. Пожалуйста, укажите название тэга';
$_lang['tagger.err.tag_name_ae'] = 'Тэг с таким названием уже существует в этой группе. Пожалуйста, выберите другое название или группу.';
$_lang['tagger.err.tag_group_changed'] = 'Группа тэга не может быть изменена.';
$_lang['tagger.err.bad_sort_column'] = 'Отсортируйте таблицу по столбцу <strong>[[+column]]</strong> для использования drag & drop сортировки.';
$_lang['tagger.err.clear_filter'] = 'Пожалуйста, очистите <strong>поиск</strong> для сортировки перетаскиванием.';
$_lang['tagger.err.import_group_ns'] = 'Группа не указана. Пожалуйста, выберите группу.';
$_lang['tagger.err.import_tv_ns'] = 'Дополнительное поле не указано. Пожалуйста, выберите TV.';
$_lang['tagger.err.import_tv_ne'] = 'Дополнительное поле не существует.  Пожалуйста, повторите попытку.';
$_lang['tagger.err.import_tv_nsp'] = 'Тип выбранного TV не поддерживается. Поддерживаемые типы: [[+supported]]';
$_lang['tagger.err.tag_assigned_resources_tag_ns'] = 'Тэг не указан. Пожалуйста, выполните действие еще раз.';
$_lang['tagger.err.tags_ns'] = 'Тэги не указаны.';
$_lang['tagger.err.merge_same_groups'] = 'Вы не можете соединить эти тэги';
$_lang['tagger.err.merge_same_groups_desc'] = 'Выбранные тэги не могут быть соединены, так как относятся к разным группам';
$_lang['tagger.err.tag_alias_ae'] = 'Тэг с таким псевдонимом уже существует в этой группе. Пожалуйста, выберите другой псевдоним или группу.';
$_lang['tagger.err.group_alias_ae'] = 'Такой псевдоним группы уже существует. Пожалуйста, выберите другой псевдоним.';
