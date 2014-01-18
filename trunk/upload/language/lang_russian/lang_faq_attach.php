<?php
/**
*
* attachment mod faq [English]
*
* @package attachment_mod
* @version $Id: lang_faq_attach.php,v 1.1 2005/11/05 10:25:02 acydburn Exp $
* @copyright (c) 2002 torgeir andrew waterhouse
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

/**
* DO NOT CHANGE
*/
if (!isset($faq) || !is_array($faq))
{
	$faq = array();
}

$faq[] = array("--","Вложения");
$faq[] = array("Как мне вставить вложение?", "Вы можете добавить вложение, когда вы отправляете новое сообщение. Вы увидите форму <i>Вставить вложение</i> под основным окном отправки сообщения. Когда вы нажмёте на кнопку <i>Поиск...</i>, откроется стандартный диалог. Найдите файл, который вы хотите добавить, выберите его и нажмите ОК. Если вы хотите добавить комментарий в поле <i>Комментарии</i> ваш комментарий будет использован как ссылка к прикреплённому файлу. Если вы не добавили комментарий, само название файла будет использоваться, как ссылка на вложение. Если администратор форума разрешил, вы сможете добавить несколько файлов, используя тот же метод, что описан наверху, пока не будет достигнуто число разрешённых вложений для каждого сообщения.<br/><br/>Размер файлов, разрешённые расширения и другие вещи, связанные с вложениями, зависят от администратора форума. Но вся ответственность за вложенные вами файлы ложится на вас. Проверьте, что файлы отвечают правилам форума, иначе они будут удалены без предупреждения.<br/><br/>Пожалуйста заметьте, что администраторы и модераторы форума не принимают ответственности за потерю файлов.");
$faq[] = array("Как добавить вложение, если сообщение уже отправлено?", "Чтобы добавить вложение после отправки сообщения, вам необходимо отредактировать ваше сообщение. Новое вложение будет добавлено когда вы нажмёте <i>Отправить</i>, чтобы отправить отредактированное сообщение.");
$faq[] = array("Как удалить вложение?", "Чтобы удалить вложение, необходимо отредактировать сообщение и нажать на <i>Удалить вложение</i> возле вложение, которое вы хотите удалить. Вложение будет удалено, когда вы нажмёте на <i>Отправить</i>, чтобы отправить отредактированное сообщение.");
$faq[] = array("Как изменить комментарий к файлу?", "Чтобы изменить комментарий к файлу, нужно отредактировать почту, изменив текст в поле <i>Комментарий к файлу</i> и нажать на кнопку <i>Обновить комментарии</i> возле комментария, который вы хотите изменить. Комментарий будет изменён, когда вы нажмёте на кнопку <i>Отправить</i>, чтобы отправить отредактированное сообщение.");
$faq[] = array("Почему моего вложения не видно в сообщении?", "Наверное файл или расширение больше не разрешены на форуме, или модератор/администратор убрал его, потому что оно конфликтует с правилами форума.");
$faq[] = array("Почему я не могу добавить вложение?", "В некоторых форумах добавление файлов разрешено только определённым пользователям или группам. Чтобы добавить файлы, необходимо получить специальное разрешение. Только модератор форума или администратор может вам его дать, так что свяжитесь с ними.");
$faq[] = array("Я получил разрешение, почему я всё ещё не могу добавлять приложения?", "Размер файлов, разрешённые расширения и другие вещи зависят от администратора форума. Может быть модератор или администратор изменили ваши права, или запретили приложения в определённых форумах. Когда вы пытаетесь добавить файл, форум должен выдать подробное описание проблемы, почему приложения не работают. Если этого недостаточно, свяжитесь с модератором или администратором, чтобы решить проблему.");
$faq[] = array("Почему я не могу удалить вложение?", "В некоторых форумах удаление вложений разрешено только определённым пользователям или группам. Чтобы удалить вложение, необходимы права, которые могут дать только модератор или администратор форума, поэтому свяжитесь с ними.");
$faq[] = array("Почему я не могу просмотреть/скачать вложение?", "В некоторых форумах скачивание файлов может быть разрешено только определённым пользователям или группам. Чтобы скачать файлы, нужны определённые права, и только модератор и администратор могут их вам дать, так что свяжитесь с ними.");
$faq[] = array("С кем мне надо связаться, чтобы сообщить о незаконных приложениях?", "Свяжитесь с администратором форума. Если вы не знаете, кто это, свяжитесь сначала с модераторами и спросите их, как связаться с администратором. Если вы не получите ответа, вам нужно будет связаться с владельцем домена (с помощью whois поиска), или, если сайт находится на бесплатном хостинге, вроде yahoo/tripod,, свяжитесь с администратором того сёрвера. Заметьте, что phpBB Group не принимает никакой ответственности за то, как или кто использует форум. Поэтому совершенно бесполезно контактировать phpBB Group с просьбами о прекращении какой бы то ни было нелегальной деятельности совершённой 3-ми лицами.");