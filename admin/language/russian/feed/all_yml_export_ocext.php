<?php
$_['heading_title']    = 'All YML Export PRO от OCEXT - генератор всех вариантов YML для Яндекс.Маркет';

$_['tab_general']    = 'Главные настройки';
$_['tab_template_setting'] = 'Наборы атрибутов YML';
$_['tab_template_setting_help'] = 'Если у Вашего магазина данные отличаются от товара, к товару. Или есть разные типы товаров. Или нужны разные заголовки и прочие данные для разных товаров. Например, если у одних товаров страна производитель хранится в одной опции, а других в другой. Или Вам нужно сделать разные составные заголовки. Создайте набор(ы) атрибутов. В дальнейшем набор можно присвоить каждому отдельной категории, производителю.';
$_['tab_ym_categories'] = 'Категории Я.Маркет (для market_category)';
$_['tab_ym_filter_data'] = 'Настройка данных для выгрузки';
$_['tab_new_template_setting'] = 'Новый набор';

$_['error_permission'] = 'У Вас нет прав для управления этим модулем!';
$_['error_notifications'] = 'Ошибка проверки бесплатного обновления. Обновления доступны на сервере: www.ocext.com';

$_['text_template_setting_title']    = 'Название набора';
$_['text_template_setting_name']    = 'Название продукта';
$_['text_template_setting_name_name']    = 'Название продукта';
$_['text_template_setting_name_meta_title']    = 'Meta-title продукта (при пустом значении, продукт не будет выгружаться)';
$_['text_template_setting_name_composite']    = 'Составное';
$_['text_template_setting_name_composite_help'] = '<div class="small_text">Используйте составные названия, чтобы повысить привлекательность и релевантность. Составные заголовки также можно использовать для соотнесения с карточкой модели Яндекс.Маркета. В этом случае, также важен порядок элементов в заголовке. Также для разных групп товаров состав заголовка может быть свой. <a target="_blank" href="https://yandex.ru/support/partnermarket/guides/examples.xml">Изучите</a> группы своих товаров и составьте заголовки для каждой из них, если нужно соотнесение с моделью. Используя разные "Шаблоны параметров" данного модуля, Вы можете составить последовательности в заголовках для каждой группы товаров</div>';
$_['text_template_setting_name_composite_new_element']    = 'Добавить элемент';
$_['text_template_setting_name_composite_num_element']    = 'Порядковый номер элемента';
$_['text_template_setting_name_composite_element_name'] = 'Название продукта';
$_['text_template_setting_name_composite_element_meta_title'] = 'Meta-title продукта (при пустом значении, продукт не будет выгружаться)';
$_['text_template_setting_name_composite_element_product_id'] = 'ID продукта (из карточки продукта - product_id)';
$_['text_template_setting_name_composite_element_model'] = 'Модель';
$_['text_template_setting_name_composite_element_sku'] = 'SKU';
$_['text_template_setting_name_composite_element_upc'] = 'UPC';
$_['text_template_setting_name_composite_element_ean'] = 'EAN';
$_['text_template_setting_name_composite_element_jan'] = 'JAN';
$_['text_template_setting_name_composite_element_isbn'] = 'ISBN';
$_['text_template_setting_name_composite_element_mpn'] = 'MPN';
$_['text_template_setting_name_composite_element_location'] = 'Расположение (из карточки продукта - location)';
$_['text_template_setting_name_composite_element_manufacturer_id'] = 'Производитель (из карточки продукта - manufacturer_id)';
$_['text_template_setting_name_composite_element_price'] = 'Цена';
$_['text_template_setting_name_composite_element_weight'] = 'Вес (поле - weight)';
$_['text_template_setting_name_composite_element_length_width_height'] = 'Габариты (из карточки продукта - length / width / height)';
$_['text_template_setting_name_composite_element_category_id'] = 'Название категории';
$_['text_template_setting_name_composite_element_option_id'] = 'Из опций';
$_['text_template_setting_name_composite_element_attribute_id'] = 'Из атрибутов';
$_['text_template_setting_name_composite_element_self'] = ' - поле из таблицы продуктов';
$_['text_template_setting_offer_composite_category_id'] = 'Будет выбрана категория, в которой находится товар в YML<div class="small_text">В YML можно разместить только одну категорию. А в опенкарт можно сложить товар в несколько категорий. Обратите внимание на то, в какую категорию, если товар в нескольких, попадет товар</div>';
$_['text_template_setting_offer_composite_attribute_id_empty'] = 'Нет созданных атрибутов (характеристик)';
$_['text_template_setting_offer_composite_option_id_empty'] = 'Нет созданных опций';
$_['text_template_setting_name_composite_num_element_first'] = 'Первый элемент заголовка';
$_['text_template_setting_name_composite_num_element_next'] = 'Следующий элемент';
$_['text_template_setting_vendor_model'] = 'Тип описания <b>vendor.model</b><div class="small_text">При данном типе описания товара в YML, у товара должен быть указан производитель. Для товаров, у которых не указан производитель использовать vendor.model не нужно</div>';
$_['text_disable'] = 'Не выгружать';
$_['text_enable'] = 'Выгружать';
$_['text_need_select'] = 'Нужно выбрать';
$_['text_all_data'] = 'Любое';
$_['text_delete'] = 'Удалить';
$_['text_template_setting_pickup'] = 'Наличие самовывоза данного продукта из магазина - <b>pickup</b>';
$_['text_template_setting_delivery_options'] = 'Стоимость и срок доставки в своем регионе - <b>delivery-options</b><div class="small_text">Вместо устаревшего local_delivery_cost теперь можно указать до 5 значений условий доставки. Для каждого из 5-ти условий возможно указать: цену в рублях, срок в днях и время оформления заказа, до наступления которого действует данная цена и срок</div>';
$_['text_template_setting_delivery_options_help'] = '<div class="small_text">COST - стоимость в рублях за 1 кг веса товара. DAYS - срок доставки в днях (0 - в день заказа, 1 - на следующий день, 1-3 или 4-7 и т.п. - интервал в днях (интервал не должен превышать 3 дня, то есть 2-51 - ошибка, нужно 2-5, 5-8 и т.п.). ORDER-BEFORE - необязательно поле с указанием времени в часах, для которого действует данная COST и DAYS (например, 15 означает, что условия в COST и DAYS действуют при оформлении заказа до 15:00). Помните, что данные условия касаются только своего региона</div>';
$_['text_template_setting_sales_notes'] = 'Информация в <b>sales_notes</b><div class="small_text">Будьте внимательны, данный элемент используется только для отражения информации о минимальной сумме заказа, минимальной партии товара или необходимости предоплаты, а также для описания акций, скидок и распродаж. Не более 50 символов</div>';
$_['text_template_setting_country_of_origin'] = 'Страна производитель - <b>country_of_origin</b><div class="small_text">Допустимые название стран, указаны в <a target="_blank" href="http://partner.market.yandex.ru/pages/help/Countries.pdf">справочнике Яндекс.Маркет</a></div>';
$_['text_template_setting_barcode'] = 'Штрихкоды производителя (8, 12 и 13 цифр) - <b>barcode</b><div class="small_text">Поддерживаются следующие форматы штрихкодов: EAN-13, EAN-8, UPC-A, UPC-E</div>';
$_['text_template_setting_description'] = 'Источник для описания - <b>description</b>';
$_['text_template_setting_description_description']    = 'Описание продукта';
$_['text_template_setting_description_meta_keyword']    = 'Meta-keyword продукта';
$_['text_template_setting_description_meta_description']    = 'Meta-description продукта';
$_['text_template_setting_description_meta_title']    = 'Meta-title продукта';
$_['text_template_setting_description_option_id']    = 'Брать опции продукта';
$_['text_template_setting_description_attribute_id']    = 'Брать характеристики продукта';

$_['text_template_setting_age'] = 'Источник для возрастной категории товара - <b>age</b><div class="small_text">Если включено, то нужно выбрать единицы измерения, в которых у Вас указывается данная информация. Допустимые значения - года, месяца. Для годов (unit="year"): 0, 6, 12, 16, 18. Для месяцев (unit="month"): 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12</div>';
$_['text_template_setting_age_unit_year'] = 'Значения заданы в годах (будет передано unit="year")';
$_['text_template_setting_age_unit_month'] = 'Значения заданы в месяцах (будет передано unit="month")';
$_['text_template_setting_cpa'] = 'Участвует в программе Заказ на Маркете - <b>cpa</b>';
$_['text_template_setting_rec'] = 'Передавать похожие товары - <b>rec</b>';
$_['text_template_setting_vendor'] = 'Источник названия производителя - <b>vendor</b>. Обязательно, если используется vendor.model';
$_['text_template_setting_vendorCode'] = 'Источник для кода производителя - <b>vendorCode</b>. Необязательный элемент, даже, если используется vendor.model';
$_['text_template_setting_manufacturer_warranty'] = 'Официальная гарантия производителя на товар - <b>manufacturer_warranty</b>';
$_['text_template_setting_expiry'] = 'Источник для срока годности или даты истичения срока годности - <b>expiry</b><div class="small_text">В формате ISO860. Формат для срока годности: P1Y2M10DT2H30M. Расшифровка примера — 1 год, 2 месяца, 10 дней, 2 часа и 30 минут. Формат для даты истечения срока годности: YYYY-MM-DDThh:mm</div>';
$_['text_template_setting_weight'] = 'Источник для веса, включая упаковку - <b>weight</b><div class="small_text">Вес указывается в кг с учетом упаковки. Указывается положительным числом с точностью 0.001 (разделитель целой и дробной части — обязательно точка)</div>';
$_['text_template_setting_dimensions'] = 'Источник указания габаритов товара - <b>dimensions</b><div class="small_text">Длина/Ширина/Высота) в упаковке. Размеры указываются в сантиметрах. Разделитель `/` без пробелов. Например, 0.11/22.333/1.5</div>';
$_['text_template_setting_typePrefix'] = 'Источник для типа / категории товара - <b>typePrefix</b><div class="small_text">Будет передаваться, если тип описания vendor.model (включается выше). Данный параметр необязательный, но существенено влияет на качество размещения. Узнайте больше о том, что сюда размещается <a target="_blank" href="https://yandex.ru/support/partnermarket/elements/typeprefix.xml">справочнике Яндекс.Маркет</a></div>';
$_['text_template_setting_adult'] = 'Товар для взрослых - <b>adult</b>';
$_['text_template_setting_oldprice'] = 'Если товар идет по акции, передавать цену по акции? Основная цена будет передана в <b>oldprice</b>';
$_['text_template_setting_ymlprice'] = 'Укажите на какой процент, нужно уменьшать все цены для Яндекс.Маркета?<div class="small_text">Разделитель дробей - точка, например, 10.5 - будет означать, что цену нужно понизить на 10.5%</div>';
$_['text_template_setting_store'] = 'Указывать, что данный продукт можно купить в торговой точке - <b>store</b><div class="small_text">Не указывайте этот параметр, если у Вас нет стационарной точки продаж, или товар невозможно купить в торговой точке продаж</div>';
$_['text_template_setting_delivery'] = 'Наличие доставки у данного продукта - <b>delivery</b><div class="small_text">Если продукт невозможно доставить - не указывайте этот параметр. Если есть доставка, в т.ч. в другие регионы, а не только по собственному - включите этот элемент</div>';
$_['text_template_setting_offer_stock_statuses_empty'] = 'Список статусов пуст. Если не указать статус, то доступность товара будет определяться по остаткам';
$_['text_template_setting_status'] = 'Применять этот шаблон';
$_['text_template_setting_no_title'] = 'Без названия';
$_['text_template_setting_offer_available_true'] = 'Укажите статус магазина, который означает, что товар в наличии - атрибут available="true" в offer<div class="small_text">Обратите внимание, Яндекс.Маркет следит за этой информацией. Нельзя передавать товар, как в наличии, если Ваш магазин не готов доставить товар в пункт самовывоза (либо отправить, если покупатель находится в другом регионе) в течение двух рабочих дней с момента оформления заказа. В этом случае и на сайте магазина, и в Яндекс.Маркет следует передавать статус означаемый нет в наличии (выбирается ниже)</div>';
$_['text_template_setting_offer_available_false'] = 'Укажите статусы магазина, которые означают, что товара нет в наличии (под заказ) - статус, который появляется при нулевых остатках - атрибут available="false" в offer?';
$_['text_template_setting_count_pictures'] = 'Максимальное количество дополнительных изображений';
$_['text_template_setting_pictures_sizes'] = 'Размер изображения (ширина и высота одинаковая), рекомендуется 500';
$_['text_template_setting_no_pictures'] = 'Передавать продукты без изображений';
$_['text_template_setting_model'] = 'Источник модели - <b>model</b>';
$_['text_template_setting_dispublic_quantity'] = 'Выгружать в YML товары с нулевыми остатками <div class="small_text">Если выбрать "не выгружать", то товары, у которых нулевые остатки не попадут в YML файл. Если выбрать "Выгружать", то данные товары будут с атрибутом в offer - available="false"</div>';
$_['text_template_setting_attribute_sintaxis'] = 'Оформление характеристик в <b>param</b>';
$_['entry_template_setting_attribute_sintaxis_0'] = '&lt;param name="Название группы атрибутов"&gt;Название атрибута: значение атрибута&lt;/param&gt;';
$_['entry_template_setting_attribute_sintaxis_1'] = '&lt;param name="Название атрибута"&gt;Значение атрибута&lt;/param&gt;';
$_['text_feed']    = 'Каналы продвижения';
$_['text_success']     = 'Настройки модуля обновлены!';
$_['text_ym_categories_filter_ym_category_last_child']     = 'Название Я.Маркет категории';
$_['text_ym_categories_filter_status']     = 'Показать по состоянию';
$_['text_ym_categories_filter_status_']     = 'Показывать все';
$_['text_ym_categories_filter_status_1']     = 'Активные';
$_['text_ym_categories_filter_status_2']     = 'В корзине';
$_['text_ym_categories_filter_category_id']     = 'Показывать по заполнению своими категориями';
$_['text_ym_categories_filter_category_id_']     = 'Показывать все';
$_['text_ym_categories_filter_category_id_1']     = 'Только с моими категориями';
$_['text_ym_filter_data_categories']     = 'Категории. Если не указаны - будут использованы все категории и выгрузка по упращенному формату YML<div class="small_text">Укажите категории, из которых нужно выгружать товары в YML. Выбирите набор атрибутов для каждой категории. К товарам из категории, при формировании YML, будут применины атрибуты, которые Вы настроили в соответствующем наборе атрибутов</div>';
$_['text_ym_filter_data_manufacturers']     = 'Производители. Если не указаны - будут учитываться все производители и выгрузка по упращенному формату YML<div class="small_text">Укажите производителей, товары которых нужно выгружать в YML. Выбирите набор атрибутов для каждого производителя. К товарам данного производителя, при формировании YML, будут применины атрибуты, которые Вы настроили в соответствующем наборе атрибутов. Если возникнут пересечения с категориями, то наборы атрибутов будут объеденены</div>';
$_['text_ym_filter_data_attributes']     = 'Вычеркнуть атрибуты. Вычеркнутые данные не будут передавать в YML. Если не указаны, то все атрибуты будут передаваться в атрибут param';
$_['text_ym_filter_data_options']     = 'Вычеркнуть опции. Вычеркнутые данные не будут передавать в YML. Если не указаны, то все опции будут передаваться в атрибут param';
$_['text_no_results']     = 'Нет результатов';

$_['column_ym_category_path']     = 'Полный путь к категории Я.Маркет';
$_['column_ym_category_last_child']     = 'Категория Я.Маркет, в которой будет размещен товар';
$_['column_category_id']     = 'Применять, если товар в данных категориях (у товара добавится атрибут - market_category с соответствующей категорией Я.Маркет)';
$_['column_ym_status']     = 'Отправить в корзину';
$_['text_ym_status_1']     = 'В корзину';
$_['text_ym_status_0']     = 'Активная';
$_['text_ym_categories_categories_empty'] = 'Категорий не найдено';
$_['text_ym_filter_data_manufacturers_empty'] = 'Производителей не найдено';
$_['text_ym_filter_data_options_empty'] = 'Опций не найдено';
$_['text_ym_filter_data_attributes_empty'] = 'Атрибутов не найдено';
$_['text_ym_filter_data_templates_setting_empty'] = 'Наборы еще не создавались. Выгрузка будет по упращенному формату YML';
$_['text_ym_filter_data_templates_setting_0'] = 'Выгружать по упращенному формату YML';
$_['text_ym_categories_categories_name'] = 'Категории';
$_['text_ym_categories_manufacturers_name'] = 'Производители';
$_['text_general_setting_status'] = 'Статус модуля';
$_['text_general_setting_enable'] = 'Включен';
$_['text_general_setting_disable'] = 'Выключен';
$_['text_general_setting_name'] = 'Короткое название магазина<div class="small_text">Название, которое выводится в списке найденных на Яндекс.Маркете товаров. Не должно содержать более 20 символов</div>';
$_['text_general_setting_company'] = 'Полное наименование компании<div class="small_text">Не публикуется, используется для внутренней идентификации</div>';
$_['text_general_setting_currencies'] = 'Валюта цен товаров';
$_['text_general_setting_platform'] = 'CMS, удалите значение, если не хотите его передавать (рекомендуется передавать это значение)';
$_['text_general_setting_version'] = 'Версия, удалите значение, если не хотите его передавать (рекомендуется передавать это значение)';
$_['text_general_setting_filename_export'] = 'Имя файла YML, в который будет записан YML. Только латинские буквы и цифры<div class="small_text">Файл создается всякий раз, как вызовается ссылка на YML</div>';
$_['text_general_setting_path_token_export'] = 'Ссылка на YML - введите код, который защитит от несанкционированного вызова. Только латинские буквы и цифры<div class="small_text">Данную ссылку можно вызывать через планировщик или самостоятельно, для обновления файла YML</div>';
$_['text_general_setting_copy'] = 'Скопировать ссылку';

$_['button_filter']     = 'Фильтр';







////////////////////////////////////////////////////////////////

$_['tab_pvz']    = 'ПВЗ';
$_['tab_new_self_pvz']    = 'Добавить свой ПВЗ';

// Text


// Entry 
$_['entry_cost']       = 'Своя стоимость доставки (если указана, будет добавляться при оформлении заказа)';
$_['entry_name']       = 'Название пункта выдачи заказов';
$_['entry_address_map']   = 'Адрес для карты  (для карты)';
$_['entry_latitude_longitude'] = 'latitude / longitude (для карты, дробь через точку)';
$_['entry_description_map']   = 'Информация по ПВЗ';
$_['entry_delivery_term']   = 'Сроки доставки';
$_['entry_payment_info']   = 'Информация об оплате';
$_['entry_stock_term']   = 'Время хранения';
$_['entry_phones']   = 'Телефоны';
$_['entry_office_term']   = 'Время работы';
$_['entry_email']   = 'Контактный email';
$_['entry_information_status']   = 'Показывать этот пункт на карте';
$_['entry_information_id']   = 'Выберите статью, в которой нужно выводить карту и информацию о пункте выдачи.';
$_['entry_no_information_id']   = 'Список статей пуст. Создайте статью в КАТАЛОГ / СТАТЬИ. И укажите её здесь';
$_['entry_set_template_all_data']   = 'Выбрать набор для всех данных...';


$_['entry_free']       = 'Бесплатная доставка от суммы<br /> (0 - для всех бесплатная)';
$_['entry_tax']        = 'Класс налога';
$_['entry_geo_zone']   = 'Географическая зона';
$_['entry_status']     = 'Статус';
$_['entry_sort_order'] = 'Порядок сортировки';

// Error

$_['error_DeliveryPoint_empty'] = 'Не получен список доставок с сервера IML. Возможно Вы еще не настроили подключение <a href="%s">в модуле IML</a>. Это не влияет на работу доставок, настроенных ранее - они будут работать. Список доставок с сервера IML нужен для проверки появления новых ПВЗ';

?>