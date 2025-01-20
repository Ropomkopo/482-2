<?php
// Heading
$_['heading_title']								= 'Обмен данными с Торгсофт (версия 2016-07-05)';
$_['oc_loader_torgsoft_text_edit']       		= 'Редактирование настроек модуля';
$_['button_save']								= 'Сохранить';
$_['button_cancel']								= 'Отменить';

// Text
$_['oc_loader_torgsoft_text_module']			= 'Модули';
$_['text_success']								= 'Настройки модуля сохранены!';
$_['oc_loader_torgsoft_version_version']		= 'Версия ';
$_['oc_loader_torgsoft_text_homepage']			= 'Официальный сайт модуля';

// Error
$_['oc_loader_torgsoft_error_permission']		= 'У Вас нет прав для управления этим модулем!';

// tab-general
$_['oc_loader_torgsoft_text_tab_general']		= 'Основное';
$_['oc_loader_torgsoft_text_status']			= 'Статус:';
$_['oc_loader_torgsoft_wrong_version']			= 'Ошибка: модуль синхронизации не может использоваться с версией {VERSION} OpenCart';
$_['oc_loader_torgsoft_LS_no_answer']			= 'Ошибка: нет ответа от сервера лицензий {LS}. Попробуйте позже. ';
$_['oc_loader_torgsoft_LS_bad_answer']			= 'Ошибка: ответ сервера лицензий {LS} не обработан: ';
$_['oc_loader_torgsoft_LS_answer']				= 'Ошибка: ответ сервера лицензий {LS}: ';
$_['oc_loader_torgsoft_file_missing']			= 'Ошибка: не найден файл модуля обмена ';
$_['oc_loader_torgsoft_attention']				= 'Внимание! Для настройки модуля надо предварительно выгрузить из Торгсофт на сайт файл с данными';

// tab-product
$_['oc_loader_torgsoft_text_tab_product']		= 'Синхронизация товаров';
$_['oc_loader_torgsoft_text_trs_file']			= 'Путь к файлу с данными';
$_['oc_loader_torgsoft_file_not_exist']			= 'Не найден файл, заданный параметром \'Путь к файлу с данными\'. Проверьте правильность пути и наличие файла.';
$_['oc_loader_torgsoft_help_text_trs_file']		= 'Относительно корневой папки сайта, например, trs/TSGoods.trs - файл с именем TSGoods.trs  находится в папке trs, которая расположена в корневой папке сайта';
$_['oc_loader_torgsoft_save_trs_file']			= 'Сохранить путь и имя файла';
$_['oc_loader_torgsoft_text_file_code']			= 'Ниже вы видите первые 2 строки входного файла.<br/>Если текст не читается, то измените кодировку.';
$_['oc_loader_torgsoft_save_file_code']			= 'Сохранить кодировку';
$_['oc_loader_torgsoft_file_is_blocked']		= 'Файл с данными недоступен для чтения';

$_['oc_loader_torgsoft_text_add_new_products']	= 'Добавлять новые товары';
$_['oc_loader_torgsoft_text_add_new_products_zero']	= 'Добавлять новые товары с нулевым остатком';

$_['oc_loader_torgsoft_text_parameters']		= 'Основные параметры.<br/>В скобках указаны рекомендуемые заголовки колонок.<br/><font color=red>*</font> Звездочкой отмечены поля, колонки для которых должны быть выбраны обязательно.';
$_['oc_loader_torgsoft_text_column_title']		= 'ЗАГОЛОВКИ КОЛОНОК<br/>Если колонка не выбрана, то соответствующий параметр не обрабатывается.';
$_['oc_loader_torgsoft_select_column']			= 'Выберите колонку';
$_['oc_loader_torgsoft_text_update']			= 'Отметить для обновления при каждой синхронизации';
$_['oc_loader_torgsoft_text_keys']				= 'Отметить при использовании этого поля для идентификации товаров в базе данных'; // GoodID - если без опций
// основные поля
$_['oc_loader_torgsoft_text_GoodID']			= 'Ключ товара<br/>По этому полю товары в заказе синхронизируются с ТоргСофт';
$_['oc_loader_torgsoft_text_name']				= 'Наименование';
$_['oc_loader_torgsoft_text_strip']				= 'Использовать символ | (вертикальная черта) для обрезки наименования';
$_['oc_loader_torgsoft_text_model']				= 'Модель';
$_['oc_loader_torgsoft_text_sku']				= 'Артикул';
$_['oc_loader_torgsoft_text_description']		= 'Описание';
$_['oc_loader_torgsoft_text_price']				= 'Цена';
$_['oc_loader_torgsoft_text_quantity']			= 'Количество';
$_['oc_loader_torgsoft_text_display']			= 'Статус';
$_['oc_loader_torgsoft_text_manufacturer']		= 'Производитель';
$_['oc_loader_torgsoft_text_category']			= 'Категория';
// характеристики
$_['oc_loader_torgsoft_text_attributes_title']	= 'Атрибуты';
$_['oc_loader_torgsoft_text_attributes_title2']	= 'Название атрибута.<br/>В скобках указаны рекомендуемые заголовки колонок.';
$_['oc_loader_torgsoft_text_attributes_group_title']	= 'Группа артибутов';
$_['oc_loader_torgsoft_text_select_attributes_group']	= 'Выберите группу артибутов';
$_['oc_loader_torgsoft_save_attributes_group']	= 'Сохранить выбранную группу артибутов';
$_['oc_loader_torgsoft_text_attributes_alert']	= 'Предупреждение: В базе данных нет такого атрибута в выбранной группе атрибутов';
// параметры по умолчанию
$_['oc_loader_torgsoft_text_parameters_title']	= 'Параметры товаров, которые устанавливаются по умолчанию для новых товаров<br/>Применяются, если параметр отсутствует в файле или не обрабатывается<br/>Параметры, отсуствующие в файле, отмечены звездочкой *';
$_['oc_loader_torgsoft_text_location']			= 'Расположение*';
$_['oc_loader_torgsoft_text_mimimum']			= 'Минимальное количество*';
$_['oc_loader_torgsoft_text_subtract']			= 'Вычитать со склада*';
$_['oc_loader_torgsoft_text_stock_status_id']	= 'Отсутствие на складе*';
$_['oc_loader_torgsoft_text_shipping']			= 'Необходима доставка*';
$_['oc_loader_torgsoft_text_length']			= 'Длина*';
$_['oc_loader_torgsoft_text_width']				= 'Ширина*';
$_['oc_loader_torgsoft_text_height']			= 'Высота*';
$_['oc_loader_torgsoft_text_length_class_id']	= 'Единица длины*';
$_['oc_loader_torgsoft_text_weight']			= 'Вес*';
$_['oc_loader_torgsoft_text_weight_class_id']	= 'Единица веса*';
$_['oc_loader_torgsoft_text_sort_order']		= 'Порядок сортировки*';
$_['oc_loader_torgsoft_text_new_category']		= 'Категория, в которую добавляются новые товары<br/>(если не выбрана колонка для параметра Категория)';
$_['oc_loader_torgsoft_text_fill_parent_cats']	= 'Помещать товары в категории верхних уровней';
// обработка результатов
$_['oc_loader_torgsoft_text_formulas_category']			= 'Шаблоны для формирования мета-тэгов добавляемых категорий.<br/><font color=red>*</font> Звездочкой отмечены поля, которые должны быть заполнены обязательно.';
$_['oc_loader_torgsoft_text_formulas_category_comment']	= 'В шаблоне можно использовать:<br/>
															{category-name} - наименование категории';
$_['oc_loader_torgsoft_text_meta_title_category']		= 'HTML-тег Title';
$_['oc_loader_torgsoft_text_meta_h1_category']			= 'HTML-тег H1';
$_['oc_loader_torgsoft_text_meta_description_category']	= 'Мета-тег Description';
$_['oc_loader_torgsoft_text_meta_keywords_category']	= 'Мета-тег Keywords';
$_['oc_loader_torgsoft_text_formulas_product']			= 'Шаблоны для формирования мета-тэгов товаров.<br/><font color=red>*</font> Звездочкой отмечены поля, которые должны быть заполнены обязательно.';
$_['oc_loader_torgsoft_text_formulas_product_comment']	= 'В шаблоне можно использовать:<br/>
															{name} - наименование товара,<br/>
															{model} - модель,<br/>
															{articul} - артикул,<br/>
															{product-id} - внутренний код товара,<br/>
															{GoodID} - ключ товара в Торгсофт';
$_['oc_loader_torgsoft_text_meta_title']				= 'HTML-тег Title';
$_['oc_loader_torgsoft_text_meta_h1']					= 'HTML-тег H1';
$_['oc_loader_torgsoft_text_meta_description']			= 'Мета-тег Description';
$_['oc_loader_torgsoft_text_meta_keywords']				= 'Мета-тег Keywords';
$_['oc_loader_torgsoft_text_seourl']					= 'SEO URL<br/>(шаблон обязательно должен обеспечивать уникальность}';
$_['oc_loader_torgsoft_text_words_deleted_from_tag'] 	= 'Удаляемые слова из Тегов товара (разделитель - запятая)';
$_['oc_loader_torgsoft_text_update_tag']				= 'Отметить для обновления Тегов товара при каждой синхронизации';
// изображения
$_['oc_loader_torgsoft_text_images']					= 'Информация для обработки изображений';
$_['oc_loader_torgsoft_text_image_ext']					= 'Допустимые расширения файлов изображений<br/>(jpg,png,jpeg,gif)';
$_['oc_loader_torgsoft_text_image_output']				= 'Расширение сохраняемого изображения <br/>(jpg,png)';
$_['oc_loader_torgsoft_text_image_quality']				= 'Качество сохраняемого изображения для jpg <br/>(от 50 до 100, рекомендуется 90)<br/>Степень сжатия сохраняемого изображения для png <br/>(от 0 до 9, рекомендуется 9)';
$_['oc_loader_torgsoft_text_image_dir']					= 'Имя папки для изображений товаров.<br/>Папка должна находиться в папке image<br/>Если папки нет, то она создается автоматически.<br/>Рекомендумеиое имя папки - products';
// специальные настройки
$_['oc_loader_torgsoft_text_special']							= 'Дополнительные настройки';
$_['oc_loader_torgsoft_text_hide_missing_products']				= 'Скрывать товары, которые есть в базе данных сайта, но нет в файле';
$_['oc_loader_torgsoft_text_hide_products_with_zero_quantity'] 	= 'Скрывать  товары с нулевым остатком';
$_['oc_loader_torgsoft_text_show_not_changed']					= 'Выводить в отчет список товаров, которые есть в базе данных сайта, но нет в файле';
$_['oc_loader_torgsoft_text_cache']								= 'Список очищаемых папок с кэшем (разделитель - запятая)';
$_['oc_loader_torgsoft_text_help_cache']						= 'Путь задается относительно корневой папки сайта. После каждой синхронизации товаров перечислленные папки будут очищены.';

// заказы
$_['oc_loader_torgsoft_text_tab_order']							= 'Обмен заказами';
$_['oc_loader_torgsoft_text_entry_order_status_to_exchange']	= 'Статус заказов, которые выгружаются в файл с расширением SAL для передачи в Торгсофт';
$_['oc_loader_torgsoft_text_entry_order_status']				= 'Статус, который устанавливается заказам после выгрузки в файл с расширением SAL';

// сообщения об ошибках
$_['oc_loader_torgsoft_error_key']						= 'Ошибка: не поставлена отметка поля для идентификации товаров в базе данных';
$_['oc_loader_torgsoft_error_cols']						= 'Ошибка: не выбраны колонки для всех обязательных полей';
$_['oc_loader_torgsoft_error_fields']					= 'Ошибка: не заполнены все обязательные поля';
$_['oc_loader_torgsoft_error_exts']						= 'Ошибка: не задано ни одно из допустимых расширений файлов изображений ';
$_['oc_loader_torgsoft_error_output']					= 'Ошибка: не задано ни одно из допустимых расширений файлов сохраняемого изображения ';
$_['oc_loader_torgsoft_error_quality']					= 'Ошибка: для выбранного расширения сохраняемого изображения качество должно быть в диапазоне ';
$_['oc_loader_torgsoft_error_dir']						= 'Ошибка: не найдена папка для сохраняемых изображений';
$_['oc_loader_torgsoft_error_dir_create']				= 'Ошибка: не удалось создать папку для сохраняемых изображений';
$_['oc_loader_torgsoft_error_file_create']				= 'Ошибка: папка для сохраняемых изображений недоступна для записи';
$_['oc_loader_torgsoft_error_file_write']				= 'Ошибка: в папку для сохраняемых изображений не удалось сделать запись файла. Проверьте доступное место на диске и права на запись';
$_['oc_loader_torgsoft_error_order']					= 'Ошибка: статус заказов, которые выгружаются в файл, и статус, который устанавливается заказам после выгрузки в файл, не должны совпадать';
$_['oc_loader_torgsoft_error_sal_dir']					= 'Ошибка: не найдена папка для записи файлов с заказами';
$_['oc_loader_torgsoft_error_file_sal_create']			= 'Ошибка: папка для записи файлов с заказами недоступна для записи';
$_['oc_loader_torgsoft_error_file_sal_write']			= 'Ошибка: в папку для записи файлов с заказами не удалось сделать запись файла. Проверьте доступное место на диске и права на запись';


