<?php

// Heading
$_['heading_title'] = 'AlphaSms.ua';
$_['text_module']   = 'Модулі';
$_['text_edit']   = 'Редагувати модуль AlphaSms.ua';

$_['alphasms_saved_success'] = 'Успішно збережено налаштування';
$_['alphasms_smssend_success'] = 'Повідомлення успішно надіслано на шлюз';

// Error
$_['alphasms_error_permission'] = 'Ви не маєте повноважень для зміни налаштувань у модулі!';
$_['alphasms_error_request'] = 'Помилка запиту';
$_['alphasms_error_auth_info'] = 'Необхідно спочатку вказаити ідентифікаційні дані SMS-шлюза';
$_['alphasms_error_login_field'] = 'Необхідно вказати логін';
$_['alphasms_error_password_field'] = 'Необхідно вказати пароль';
$_['alphasms_error_sign_field'] = 'Необходимо підпис для повідомлень';
$_['alphasms_error_admphone_field'] = 'Вкажіть номер телефону адміністратора';
$_['alphasms_error_sign_to_large'] = 'Підпис занадто довга. Максимум 11 символів.';
$_['alphasms_error_empty_frmsms_message'] = 'Необхідно вказати текст повідомлення.';
$_['alphasms_error_frmsms'] = 'Помилка з надсиланням повідомлення';

// Tabs name in view
$_['alphasms_tab_connection'] = 'Налаштування шлюза';
$_['alphasms_tab_signature'] = 'Підпис для повідомлень';
$_['alphasms_tab_events'] = 'Виконувати для дій';
$_['alphasms_tab_about'] = 'Про модуль';
$_['alphasms_tab_sendsms'] = 'Надістали SMS';

// Text messges
$_['alphasms_text_gate_settings'] = 'Налаштування шлюзу';
$_['alphasms_text_login'] = 'Логін';
$_['alphasms_text_login_placeholder'] = 'Логін (телефон) з сайту AlphaSms.ua';
$_['alphasms_error_login'] = 'Порожній телефон, чи не відповідає формату. Повинен бути на зразок такого: +380112223344';
$_['alphasms_text_password'] = 'Пароль';
$_['alphasms_error_password'] = 'Пароль не може бути порожнім !';
$_['alphasms_text_key'] = 'API ключ';
$_['alphasms_error_key'] = 'Порожній API ключ';
$_['alphasms_text_sign'] = 'Підпис повідомлень';
$_['alphasms_error_sign'] = 'Порожній підпис, або він не відповідає формату. Повинен бути не довшим 11 символів латиницею !';
$_['alphasms_text_admphone'] = 'Телефон адміністратора';
$_['alphasms_error_admphone'] = 'Порожній телефон адміністратора, чи не відповідає формату. Повинен бути схожим на +380112223344';
$_['alphasms_text_phone'] = 'Телефон отримувача';
$_['alphasms_error_phone'] = 'Порожній телефон отримувача, чи не відповідає формату. Зробіть його схожим на +380112223344';
$_['alphasms_text_notify_sms_to_admin'] = 'Повідомляти про події адміністратора';
$_['alphasms_text_notify_sms_to_customer'] = 'Повідомляти про події покупця';
$_['alphasms_text_connection_established'] = 'З`єднання з SMS-шлюзом встановлено';
$_['alphasms_text_connection_error'] = 'Відсутній зв`язок із SMS-шлюзом';
$_['alphasms_events_admin_new_customer'] = 'Новий покупець зареєструвався';
$_['alphasms_events_admin_new_order'] = 'Здійснили нове замовлення';
$_['alphasms_events_admin_new_email'] = 'Надійшов лист з контактної форми магазину';
$_['alphasms_text_frmsms_message'] = 'Текст повідомлення';
$_['alphasms_error_message'] = 'Порожній текст повідомлення';
$_['alphasms_text_frmsms_phone'] = 'Номер отримувача';
$_['alphasms_text_button_send_sms'] = 'Надіслати SMS';
$_['alphasms_events_admin_gateway_connection_error'] = 'Повідомляти на email у випадках неполадок з`єднання із шлюзом';
$_['alphasms_events_customer_new_order_status'] = 'Зміна статусу замовлення';
$_['alphasms_events_customer_new_order'] = 'Повідомляти покупця про нове замовлення';
$_['alphasms_events_customer_new_register'] = 'Вдале завершення реєтрації';

$_['alphasms_message_customer_new_order_status'] = 'Статус замовлення #%s змінено на "%s"';

$_['alphasms_text_connection_tab_description'] =
'Вкажіть вірні дані для подключения до шлюзу AlphaSms.ua через HTTP/HTTPS протокол.<br/>';

$_['alphasms_text_about_tab_description'] =
'<b>%s &copy; %s Всі права захищено</b><br/>
<br/>
Модуль призначено для розсилки SMS повідомлень за допомогою шлюза AlphaSms.ua.
<br/><br/>
Дана робота розповсюджується на основі ліцензії BSD<br/><br/>
Поточна версія: %s<br/>';

// UPD from 2016-08-04

$_['alphasms_tab_templates'] = 'Шаблони повідомлень';
$_['alphasms_connection_error_title'] = "Помилка з'єднання зі шлюзом";
$_['alphasms_customer_new_register_title'] = 'Привітання користувача з реєстрацією';
$_['alphasms_customer_new_order_title'] = 'Повідомлення про покупку';
$_['alphasms_admin_new_customer_title'] = 'Повідомлення адміну про нового користувача';
$_['alphasms_admin_new_order_title'] = 'Повідомлення адміну про нове замовлення';
$_['alphasms_admin_new_email_title'] = 'Повідомлення адміну про запит в службу підтримки';
$_['alphasms_customer_new_order_status_title'] = 'Повідомлення про зміну статуса замовлення';
$_['alphasms_text_button_save_templates'] = 'Зберегти шаблони повідомлення';
