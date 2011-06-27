<?php
/** 
*
* attachment mod admin [RUSSIAN]
*
* @package attachment_mod
* @version $Id: lang_admin_attach.php,v 1.3 2005/11/20 13:38:55 acydburn Exp $
* @copyright (c) 2002 Meik Sievertsen
* @license http://opensource.org/licenses/gpl-license.php GNU Public License 
* Translated by  Makc666 (makc666@newmail.ru)
*/

/**
* DO NOT CHANGE
*/
if (!isset($lang) || !is_array($lang))
{
	$lang = array();
}

//
// Attachment Mod Admin Language Variables
//

// Modules, this replaces the keys used
$lang['CONTROL_PANEL'] = 'Контрольная Панель';
$lang['SHADOW_ATTACHMENTS'] = 'Теневые приложения';
$lang['FORBIDDEN_EXTENSIONS'] = 'Запрещённые Расширения';
$lang['EXTENSION_CONTROL'] = 'Контроль Расширений';
$lang['EXTENSION_GROUP_MANAGE'] = 'Контроль Групп Расширений';
$lang['SPECIAL_CATEGORIES'] = 'Специальные Категории';
$lang['SYNC_ATTACHMENTS'] = 'Синхронизация Приложений';
$lang['QUOTA_LIMITS'] = 'Ограничение Квоты';

// Attachments -> Management
$lang['ATTACH_SETTINGS'] = 'Конфигурация приложений';
$lang['MANAGE_ATTACHMENTS_EXPLAIN'] = 'Здесь Вы можете конфигурировать главные настройки для Мода Приложений. Если Вы нажмёте на кнопку "Проверить Настройки", Мод Приложений проведёт несколько тестов, чтобы проверить - всё ли правильно настроено. Если у Вас возникли проблемы с закачиванием файлов, используйте эту функцию, чтобы получить подробную информацию об ошибке.';
$lang['ATTACH_FILESIZE_SETTINGS'] = 'Настройки размеров приложений';
$lang['ATTACH_NUMBER_SETTINGS'] = 'Настройка количества приложений';
$lang['ATTACH_OPTIONS_SETTINGS'] = 'Настройка приложений';

$lang['UPLOAD_DIRECTORY'] = 'Папка для закачанных приложений';
$lang['UPLOAD_DIRECTORY_EXPLAIN'] = 'Задайте относительный путь от папки форума к папке приложений. Например, задайте \'files\', если путь к форуму http://www.yourdomain.com/phpBB2 и папка приложений находится в http://www.yourdomain.com/phpBB2/files.';
$lang['ATTACH_IMG_PATH'] = 'Иконка для приложений';
$lang['ATTACH_IMG_PATH_EXPLAIN'] = 'Эта картинка появляется возле ссылок к приложениям в персональных сообщениях. Оставьте это поле пустым, если не хотите видеть иконку. Эта конфигурация будет переписана настройками в Контроле Групп Расширений.';
$lang['ATTACH_TOPIC_ICON'] = 'Иконка для тем с приложениями';
$lang['ATTACH_TOPIC_ICON_EXPLAIN'] = 'Эта картинка появляется возле тем с приложениями. Оставьте это поле пустым, если не хотите видеть иконку.';
$lang['ATTACH_DISPLAY_ORDER'] = 'Последовательность отображения приложений';
$lang['ATTACH_DISPLAY_ORDER_EXPLAIN'] = 'Здесь Вы можете выбрать, как показывать приложения в постах/личных сообщениях - в порядке убывания (самое новое приложение сначала) или в порядке возрастания (самое старое приложение сначала).';
$lang['SHOW_APCP'] = 'Использовать новую панель контроля приложений';
$lang['SHOW_APCP_EXPLAIN'] = 'Выберите, хотите ли Вы использовать отдельную панель контроля приложений (да), или старый метод с двумя боксами для приложений и редактирования приложений (нет) в окне сообщения. Трудно объяснить, как это выглядит, поэтому попробуйте сами.';

$lang['MAX_FILESIZE_ATTACH'] = 'Максимальный размер приложений';
$lang['MAX_FILESIZE_ATTACH_EXPLAIN'] = 'Максимальный размер для приложений. Ноль значит неограниченно. Эта настройка зависит от конфигурации Вашего сёрвера. Например, если php на Вашем сервере позволяет закачивать файлы не более 2 МБ, то эту величину изменить невозможно.';
$lang['ATTACH_QUOTA'] = 'Квота приложений';
$lang['ATTACH_QUOTA_EXPLAIN'] = 'Максимальный размер для всех приложений. Ноль значит неограниченно.';
$lang['MAX_FILESIZE_PM'] = 'Максимальный размер в папке для личных сообщений';
$lang['MAX_FILESIZE_PM_EXPLAIN'] = 'Максимальная величина, которую приложения могут занимать в личных почтовых ящиках каждого пользователя. Ноль значит неограниченно.';
$lang['DEFAULT_QUOTA_LIMIT'] = 'Стандартное ограничение квоты';
$lang['DEFAULT_QUOTA_LIMIT_EXPLAIN'] = 'Здесь Вы можете конфигурировать стандартное ограничение квоты для новых пользователей или пользователей без установленных ограничений. Настройка "Без Ограничений" для тех, кто не хочет использовать квоты приложений. Вместо этого будут использованы стандартные настройки, заданные в контрольной панеле.';

$lang['MAX_ATTACHMENTS'] = 'Максимальное количество приложений';
$lang['MAX_ATTACHMENTS_EXPLAIN'] = 'Максимальное количество приложений, разрешённых в каждом сообщении.';
$lang['MAX_ATTACHMENTS_PM'] = 'Максимальное количество приложений разрешённых в каждом личном сообщении';
$lang['MAX_ATTACHMENTS_PM_EXPLAIN'] = 'Задайте максимальное количество приложений, разрешённое в каждом личном сообщении.';

$lang['DISABLE_MOD'] = 'Выключить мод приложений';
$lang['DISABLE_MOD_EXPLAIN'] = 'Эта настройка используется главным образом для проверки новых скинов, она выключает все функции Мода Приложений, кроме административной панели.';
$lang['PM_ATTACHMENTS'] = 'Разрешить приложения в личных сообщениях';
$lang['PM_ATTACHMENTS_EXPLAIN'] = 'Разрешить/Запретить добавлять приложения к личным сообщениям.';
$lang['FTP_UPLOAD'] = 'Включить FTP закачивание';
$lang['FTP_UPLOAD_EXPLAIN'] = 'Включить  закачивание через FTP. Если поставите на "да", Вам нужно будет сконфигурировать настройки для FTP и папка для приложений не будет использоваться.';
$lang['ATTACHMENT_TOPIC_REVIEW'] = 'Показывать приложения в окне обзора сообщений темы при написании ответа?';
$lang['ATTACHMENT_TOPIC_REVIEW_EXPLAIN'] = 'Если поставите "да", все приложения будут показываться в окне обзора сообщений темы.';

$lang['FTP_SERVER'] = 'FTP сервер для загрузки';
$lang['FTP_SERVER_EXPLAIN'] = 'Здесь Вы можете задать IP адрес или домен FTP сервера, который будет использоваться для загрузки файлов. Если оставите это поле пустым, будет использоваться сервер, на котором установлен Ваш форум. Заметьте, что нельзя добавлять ftp:// или что то ещё к адресу, только ftp.foo.com или просто IP адрес.';

$lang['ATTACH_FTP_PATH'] = 'FTP путь к папке для закаченных файлов';
$lang['ATTACH_FTP_PATH_EXPLAIN'] = 'Папка для приложений. CMOD не нужен. Пожалуйста не вставляйте Ваш IP или FTP адрес, только относительный  или абсолютный путь к папке на самом сервере.<br />Например: /home/web/uploads';
$lang['FTP_DOWNLOAD_PATH'] = 'Ссылка для скачивания файлов c FTP';
$lang['FTP_DOWNLOAD_PATH_EXPLAIN'] = 'Задайте ссылку к FTP, где лежат приложения.<br />Если Вы используете удаленный FTP сервер, задайте полный адрес, например: http://www.mystorage.com/phpBB2/upload.<br />Если Вы используете локальный сервер для приложений, задайте относительный адрес к папке форума "upload".<br />Слеш будет удален. Оставьте поле пустым, если FTP недоступен из интернета. Если поле будет пустым, физический метод скачивания будет недоступен.';
$lang['FTP_PASSIVE_MODE'] = 'Задействовать пассивный FTP режим';
$lang['FTP_PASSIVE_MODE_EXPLAIN'] = 'Команда PASV просит удаленный сервер открыть порт для связи и сообщить номер данного порта. Удалённый сервер открывает порт и клиент подключается к нему.';

$lang['NO_FTP_EXTENSIONS_INSTALLED'] = 'Вы не можете использовать FTP для закачивания файлов, потому что Ваш PHP этого не поддерживает данную возможность.';

// Attachments -> Shadow Attachments
$lang['SHADOW_ATTACHMENTS_EXPLAIN'] = 'Здесь Вы можете удалить приложения, если сами файлы исчезли с сервера, или удалить файлы, которые не прикреплены ни к каким сообщениям. Вы можете скачать или посмотреть файл кликнув по нему. Если ссылки нет, то файл не существует.';
$lang['SHADOW_ATTACHMENTS_FILE_EXPLAIN'] = 'Удалить все приложения, которые существуют на сервере и не прикреплены ни к какому сообщению.';
$lang['SHADOW_ATTACHMENTS_ROW_EXPLAIN'] = 'Удалить всю информацию про приложения, которые больше не существуют в системе.';
$lang['EMPTY_FILE_ENTRY'] = 'Занесение пустого файла';

// Attachments -> Sync
$lang['SYNC_THUMBNAIL_RESETTED'] = 'Обновлена миниатюра для приложения: %s'; // replace %s with physical Filename
$lang['ATTACH_SYNC_FINISHED'] = 'Синхронизация приложений окончена.';
$lang['SYNC_TOPICS'] = 'Синхронизация тем';
$lang['SYNC_POSTS'] = 'Синхронизация сообщений';
$lang['SYNC_THUMBNAILS'] = 'Синхронизация миниатюр';

// Extensions -> Extension Control
$lang['MANAGE_EXTENSIONS'] = 'Конфигурация расширений';
$lang['MANAGE_EXTENSIONS_EXPLAIN'] = 'Здесь Вы можете настроить расширения файлов. Если Вы хотите разрешить/запретить определённые расширения, пожалуйста, используйте Контроль Групп Расширений.';
$lang['EXPLANATION'] = 'Обьяснение';
$lang['EXTENSION_GROUP'] = 'Группа Расширений';
$lang['INVALID_EXTENSION'] = 'Неправильное расширения';
$lang['EXTENSION_EXIST'] = 'Расширение %s уже существует'; // replace %s with the Extension
$lang['UNABLE_ADD_FORBIDDEN_EXTENSION'] = 'Расширение %s запрещено, Вы не можете добавить его к группе разрешённых расширений'; // replace %s with Extension

// Extensions -> Extension Groups Management
$lang['MANAGE_EXTENSION_GROUPS'] = 'Контроль Групп Расширений';
$lang['MANAGE_EXTENSION_GROUPS_EXPLAIN'] = 'Здесь Вы можете добавить, убрать или изменить группы расширений, Вы можете выключить группы расширений, добавить их в определённые категории, изменить механизм скачивания и выбрать иконку, которая будет отображаться приложением, которое относится к определённой группе.';
$lang['SPECIAL_CATEGORY'] = 'Специальная категория';
$lang['CATEGORY_IMAGES'] = 'Картинки';
$lang['CATEGORY_STREAM_FILES'] = 'Потоковые файлы';
$lang['CATEGORY_SWF_FILES'] = 'Flash файлы';
$lang['ALLOWED'] = 'Разрешено';
$lang['ALLOWED_FORUMS'] = 'Разрешённые форумы';
$lang['EXT_GROUP_PERMISSIONS'] = 'Права Групп';
$lang['DOWNLOAD_MODE'] = 'Метод скачивания';
$lang['UPLOAD_ICON'] = 'Иконка для закачки';
$lang['MAX_GROUPS_FILESIZE'] = 'Максимальный размер файла';
$lang['EXTENSION_GROUP_EXIST'] = 'Группа расширений %s уже существует'; // replace %s with the group name
$lang['COLLAPSE'] = '+';
$lang['DECOLLAPSE'] = '-';

// Extensions -> Special Categories
$lang['MANAGE_CATEGORIES'] = 'Контроль специальных категорий';
$lang['MANAGE_CATEGORIES_EXPLAIN'] = 'Здесь Вы можете настраивать специальные категории. Вы можете задать специальные параметры для специальных категорий прикреплённых к группам расширений.';
$lang['SETTINGS_CAT_IMAGES'] = 'Настройки для специальной категории: Изображения';
$lang['SETTINGS_CAT_STREAMS'] = 'Настройки для специальной категории: Потоковые файлы';
$lang['SETTINGS_CAT_FLASH'] = 'Настройки для специальной категории: Flash файлы';
$lang['DISPLAY_INLINED'] = 'Отображать изображения в сообщениях';
$lang['DISPLAY_INLINED_EXPLAIN'] = 'Выберите отображать ли изображения прямо в сообщениях (да) или отображать изображения в виде ссылок на них?';
$lang['MAX_IMAGE_SIZE'] = 'Максимальная величина изображения';
$lang['MAX_IMAGE_SIZE_EXPLAIN'] = 'Здесь Вы можете задать максимальную величину изображения (ширина х высота в пикселях).<br />Если установлен ноль, то эта функция отключена. С некоторыми изображениями эта функция не будет работать из-за ограничений в PHP.';
$lang['IMAGE_LINK_SIZE'] = 'Величина изображений, которые будут автоматически показываться как ссылка';
$lang['IMAGE_LINK_SIZE_EXPLAIN'] = 'Картинки установленной величины будут отображаться как ссылка, а не прямо в сообщении,<br />если включена функция "Отображать изображения в сообщениях".<br />Если установлен ноль, эта функция отключена. С некоторыми изображениями эта функция не будет работать из-за ограничений в PHP.';
$lang['ASSIGNED_GROUP'] = 'Прикрепленная группа';

$lang['IMAGE_CREATE_THUMBNAIL'] = 'Создать миниатюру';
$lang['IMAGE_CREATE_THUMBNAIL_EXPLAIN'] = 'Всегда создавать миниатюры. Эта функция замещает все настройки в этой специальной категории, кроме настройки "Максимальная величина изображения". При включении этой функции в сообщении будет отображаться миниатюра, пользователь может на неё нажать, чтобы открыть само изображение.<br />Пожалуйста, заметьте, что для этой функции необходим Imagick, если он не инсталлирован или если включен Safe-Mode, будет использоваться PHP расширения GD. Если тип изображения не поддерживается PHP, эта функция не будет задействована.';
$lang['IMAGE_MIN_THUMB_FILESIZE'] = 'Минимальный размер миниатюры';
$lang['IMAGE_MIN_THUMB_FILESIZE_EXPLAIN'] = 'Если изображение меньше, чем данный размер, миниатюра создаваться не будет, потому что само изображение уже достаточно маленькое.';
$lang['IMAGE_IMAGICK_PATH'] = 'Приложение Imagick (полный путь)';
$lang['IMAGE_IMAGICK_PATH_EXPLAIN'] = 'Задайте путь к программе конвертации Imagick, обычно /usr/bin/convert (в windows: c:/imagemagick/convert.exe).';
$lang['IMAGE_SEARCH_IMAGICK'] = 'Поиск Imagick';

$lang['USE_GD2'] = 'Включить использование GD2 расширения';
$lang['USE_GD2_EXPLAIN'] = 'PHP может быть скомпилировано с расширением GD1 или GD2 для работы с изображениями. Чтобы правильно создать миниатюры без imagemagick, Мод приложений может использовать два разных способа, основываясь на Вашем выборе в данной опции. Если Ваши Эскизы будут плохого качества или обезображены, попробуйте изменить эту настройку.';
$lang['ATTACHMENT_VERSION'] = 'Версия Мода приложений (Attachment Mod) %s'; // %s is the version number

// Extensions -> Forbidden Extensions
$lang['MANAGE_FORBIDDEN_EXTENSIONS'] = 'Управление запрещёнными расширениями';
$lang['MANAGE_FORBIDDEN_EXTENSIONS_EXPLAIN'] = 'Здесь Вы можете добавить или удалить запрещённое расширение. Расширения php, php3, php4 запрещены для безопасности по умолчанию, и их невозможно удалить.';
$lang['FORBIDDEN_EXTENSION_EXIST'] = 'Запрещённое расширение %s уже существует'; // replace %s with the extension
$lang['EXTENSION_EXIST_FORBIDDEN'] = 'Расширение %s уже задано в разрешённых расширениях, пожалуйста, удалите его оттуда, перед тем, как добавлять его здесь.';  // replace %s with the extension

// Extensions -> Extension Groups Control -> Group Permissions
$lang['GROUP_PERMISSIONS_TITLE_ADMIN'] = 'Права групп расширений -> \'%s\''; // Replace %s with the Groups Name
$lang['GROUP_PERMISSIONS_EXPLAIN'] = 'Здесь Вы можете ограничить использование определённых групп расширений в форумах (как задано в боксе "Разрешённые Форумы"). По умолчанию разрешены все группы расширений во всех форумах, в которых пользователь может добавлять файлы (т.е. нормальный метод, который использовался в Моде приложений с самого начала). Если Вы разрешите только определённые форумы, то вариант "Все Форумы" исчезнет. Вы сможете снова добавить все форумы в любое время. Если Вы добавите новый раздел на Вашем форуме и разрешение установлено на "Все форумы", то ничего не изменится. Но если Вы изменили или ограничили доступ к определённым форумам, Вы должны вернуться сюда и добавить этот новый форум. Это можно было бы сделать автоматически, но Вам бы пришлось изменять много файлов, поэтому автор решил использовать текущий вариант. Пожалуйста, заметьте, что здесь будут перечислены все Вами форумы.';
$lang['NOTE_ADMIN_EMPTY_GROUP_PERMISSIONS'] = 'Замечание:<br />В ниже перечисленных форумах пользователи обычно могут добавлять файлы, но так как никакие группы расширений там не разрешены, пользователи не смогут ничего прикрепить. Если они попробуют, они увидят сообщение об ошибке. Может быть Вы хотите установить разрешение \'Добавить файлы\' для администрации в этих форумах.<br /><br />';
$lang['ADD_FORUMS'] = 'Добавить форумы';
$lang['ADD_SELECTED'] = 'Добавить выбранные';
$lang['PERM_ALL_FORUMS'] = 'Все форумы';

// Attachments -> Quota Limits
$lang['MANAGE_QUOTAS'] = 'Настройка лимита квоты для расширений';
$lang['MANAGE_QUOTAS_EXPLAIN'] = 'Здесь Вы можете добавить/удалить/изменить квоты для расширений. Позднее Вы можете прикрепить эти ограничения к определённым пользователям или группам. Чтобы прикрепить ограничение к пользователю, откройте Пользователи-&gtУправление, выберите пользователя и Вы увидите необходимые настройки внизу страницы. Чтобы прикрепить ограничение к группе, откройте Группы-&gtУправление, выберите группу и Вы увидите панель настроек. Если Вы хотите увидеть, какие пользователи и группы прикреплены к определённым ограничениям, нажмите на "Посмотреть" слева от описания квоты.';
$lang['ASSIGNED_USERS'] = 'Прикрепленные пользователи';
$lang['ASSIGNED_GROUPS'] = 'Прикрепленные группы';
$lang['QUOTA_LIMIT_EXIST'] = 'Ограничение %s уже существует.'; // Replace %s with the Quota Description

// Attachments -> Control Panel
$lang['CONTROL_PANEL_TITLE'] = 'Контрольная панель приложений';
$lang['CONTROL_PANEL_EXPLAIN'] = 'Здесь Вы можете увидеть и настроить все приложения в зависимости от пользователей, приложений, количества просмотров и т.п.';
$lang['FILE_COMMENT_CP'] = 'Комментарий к файлу';

// Control Panel -> Search
$lang['SEARCH_WILDCARD_EXPLAIN'] = 'Используйте *, если не знаете точного названия';
$lang['SIZE_SMALLER_THAN'] = 'Приложение меньше чем (в байтах)';
$lang['SIZE_GREATER_THAN'] = 'Приложение больше чем (в байтах)';
$lang['COUNT_SMALLER_THAN'] = 'Количество скачиваний меньше чем';
$lang['COUNT_GREATER_THAN'] = 'Количество скачиваний больше чем';
$lang['MORE_DAYS_OLD'] = 'Старее, чем это количество дней';
$lang['NO_ATTACH_SEARCH_MATCH'] = 'Не найдено ни одного приложения, которое бы отвечало Вашему поиску';

// Control Panel -> Statistics
$lang['NUMBER_OF_ATTACHMENTS'] = 'Количество приложений';
$lang['TOTAL_FILESIZE'] = 'Общий размер всех приложений';
$lang['NUMBER_POSTS_ATTACH'] = 'Количество сообщений с приложениями';
$lang['NUMBER_TOPICS_ATTACH'] = 'Количество тем с приложениями';
$lang['NUMBER_USERS_ATTACH'] = 'Уникальных пользователей прикрепивших приложения';
$lang['NUMBER_PMS_ATTACH'] = 'Количество приложений в личных сообщениях';
$lang['ATTACHMENTS_PER_DAY'] = 'Прикрепления за день';

// Control Panel -> Attachments
$lang['STATISTICS_FOR_USER'] = 'Статистика приложений для %s'; // replace %s with username
$lang['SIZE_IN_KB'] = 'Размер (КБ)';
$lang['DOWNLOADS'] = 'Скачиваний';
$lang['POST_TIME'] = 'Дата сообщения';
$lang['POSTED_IN_TOPIC'] = 'Размещено в теме';
$lang['SUBMIT_CHANGES'] = 'Сохранить изменения';

// Sort Types
$lang['SORT_ATTACHMENTS'] = 'Приложения';
$lang['SORT_SIZE'] = 'Размер';
$lang['SORT_FILENAME'] = 'Название файла';
$lang['SORT_COMMENT'] = 'Комментарий';
$lang['SORT_EXTENSION'] = 'Расширение';
$lang['SORT_DOWNLOADS'] = 'Скачено';
$lang['SORT_POSTTIME'] = 'Дата сообщения';
$lang['SORT_POSTS'] = 'Сообщение';

// View Types
$lang['VIEW_STATISTIC'] = 'Статистика';
$lang['VIEW_SEARCH'] = 'Поиск';
$lang['VIEW_USERNAME'] = 'Имя';
$lang['VIEW_ATTACHMENTS'] = 'Приложения';

// Successfully updated
$lang['ATTACH_CONFIG_UPDATED'] = 'Конфигурация приложений успешно изменена';
$lang['CLICK_RETURN_ATTACH_CONFIG'] = 'Нажмите %sтут%s, чтобы вернуться к конфигурации приложений';
$lang['TEST_SETTINGS_SUCCESSFUL'] = 'Тест настроек окончен, конфигурация в порядке.';

// Some basic definitions
$lang['ATTACHMENTS'] = 'Приложения';
$lang['ATTACHMENT'] = 'Приложение';
$lang['EXTENSIONS'] = 'Расширения';
$lang['EXTENSION'] = 'Расширение';

// Auth pages
$lang['AUTH_ATTACH'] = 'Добавить файлы';
$lang['AUTH_DOWNLOAD'] = 'Скачать файлы';