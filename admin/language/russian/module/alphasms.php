<?php

// Heading
$_['heading_title'] = 'AlphaSms.ua';
$_['text_module']   = 'Модули';
$_['text_edit']   = 'Редактировать модуль AlphaSms.ua';

$_['alphasms_saved_success'] = 'Успешно сохранены настройки';
$_['alphasms_smssend_success'] = 'Сообщение успешно отправлено на шлюз';

// Error
$_['alphasms_error_permission'] = 'Вы не имеете полномочий для изменения настроек данного модуля!';
$_['alphasms_error_request'] = 'Ошибка запроса';
$_['alphasms_error_auth_info'] = 'Необходимо задать идентификационный данные SMS-шлюза';
$_['alphasms_error_login_field'] = 'Необходимо указать логин';
$_['alphasms_error_password_field'] = 'Необходимо указать пароль';
$_['alphasms_error_sign_field'] = 'Необходимо указать подпись для сообщений';
$_['alphasms_error_admphone_field'] = 'Укажите номер телефона администратора';
$_['alphasms_error_sign_to_large'] = 'Подпись слишком длинная. Максимум 11 символов.';
$_['alphasms_error_empty_frmsms_message'] = 'Необходимо указать текст сообщения';
$_['alphasms_error_frmsms'] = 'Ошибка с отправкой сообщения';

// Tabs name in view
$_['alphasms_tab_connection'] = 'Настройки шлюза';
$_['alphasms_tab_signature'] = 'Подпись сообщений';
$_['alphasms_tab_events'] = 'Выполнять при действиях';
$_['alphasms_tab_about'] = 'О модуле';
$_['alphasms_tab_sendsms'] = 'Отправить SMS';

// Text messges
$_['alphasms_text_gate_settings'] = 'Настройки шлюза';
$_['alphasms_text_login'] = 'Логин';
$_['alphasms_text_login_placeholder'] = 'Логин (телефон) с AlphaSms.ua';
$_['alphasms_error_login'] = 'Телефон пустой или имеет неправильный формат. Должен быть как +380112223344';
$_['alphasms_text_password'] = 'Пароль';
$_['alphasms_error_password'] = 'Пароль не может быть пустым !';
$_['alphasms_text_key'] = 'API ключ';
$_['alphasms_error_key'] = 'Пустой API ключ';
$_['alphasms_text_sign'] = 'Подпись сообщений';
$_['alphasms_error_sign'] = 'Пустая подпись или несоответствующая формату. Должна быть не длинее 11 символов латиницей !';
$_['alphasms_text_admphone'] = 'Телефон администратора';
$_['alphasms_error_admphone'] = 'Телефон администратора пустой или имеет неправильный формат. Должен быть как +380112223344';
$_['alphasms_text_phone'] = 'Телефон получателя';
$_['alphasms_error_phone'] = 'Телефон получателя пустой или имеет неправильный формат. Должен быть как +380112223344';
$_['alphasms_text_notify_sms_to_admin'] = 'Сообщать по событиям администратора';
$_['alphasms_text_notify_sms_to_customer'] = 'Сообщать по событиям покупателя';
$_['alphasms_text_connection_established'] = 'Соеденение с SMS-шлюзом установлено';
$_['alphasms_text_connection_error'] = 'Нет связи с SMS-шлюзом';
$_['alphasms_events_admin_new_customer'] = 'Новый покупатель зарегистрирован';
$_['alphasms_events_admin_new_order'] = 'Осуществили новый заказ';
$_['alphasms_events_admin_new_email'] = 'Поступило новое письмо с контактной формы магазина';
$_['alphasms_text_frmsms_message'] = 'Текст сообщения';
$_['alphasms_error_message'] = 'Пустое сообщение';
$_['alphasms_text_frmsms_phone'] = 'Номер получателя';
$_['alphasms_text_button_send_sms'] = 'Отправить SMS';
$_['alphasms_events_admin_gateway_connection_error'] = 'Уведомлять на email при неудачном соединении со шлюзом';
$_['alphasms_events_customer_new_order_status'] = 'Изменение статуса заказа';
$_['alphasms_events_customer_new_order'] = 'Покупателю сообщение о новом заказе';
$_['alphasms_events_customer_new_register'] = 'Успешное завершение регистрации';

$_['alphasms_message_customer_new_order_status'] = 'Статус заказа #%s изменен на "%s"';

$_['alphasms_text_connection_tab_description'] =
'Укажите правильные данные для подключения к шлюзу AlphaSms.ua через HTTP/HTTPS протокол.<br/>';

$_['alphasms_text_about_tab_description'] =
'<b>%s &copy; %s Все права защищены</b><br/>
<br/>
Модуль предназначен для рассылки SMS уведомлений посредством шлюза AlphaSms.ua.
<br/><br/>
Данное произведение распространяется на основании BSD лицензии<br/><br/>
Текущая версия: %s<br/>';

// UPD from 2016-08-04

$_['alphasms_tab_templates'] = 'Шаблоны сообщений';
$_['alphasms_connection_error_title'] = 'Ошибка соединения со шлюзом';
$_['alphasms_customer_new_register_title'] = 'Поздравление пользователя с регистрацией';
$_['alphasms_customer_new_order_title'] = 'Сообщение о покупке';
$_['alphasms_admin_new_customer_title'] = 'Уведомление админу о новом пользователе';
$_['alphasms_admin_new_order_title'] = 'Уведомление админу о новом заказе';
$_['alphasms_admin_new_email_title'] = 'Уведомление админу о сообщении в службу поддержки';
$_['alphasms_customer_new_order_status_title'] = 'Сообщение о изменении статуса заказа';
$_['alphasms_text_button_save_templates'] = 'Сохранить шаблоны сообщений';
