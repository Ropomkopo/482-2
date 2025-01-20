<?php
// English   Multilingual SEO      Author: Sirius Dev
// Heading
$_['heading_title']		  = '<img src="view/seo_package/img/icon.png" style="vertical-align:top;padding-right:4px"/>Complete SEO Package';
$_['module_title']		  = 'Complete SEO <span>Package</span>';
  
// Tab seo editor
$_['tab_seo_editor']      					= 'SEO editor';
$_['tab_seo_editor_product']			= 'Product';
$_['tab_seo_editor_category']			= 'Category';
$_['tab_seo_editor_information']		= 'Information';
$_['tab_seo_editor_manufacturer']	= 'Manufacturer';
$_['tab_seo_editor_image']	= 'Image';
$_['tab_seo_editor_common']			= 'Common page';
$_['tab_seo_editor_special']			= 'Special page';
$_['tab_seo_editor_redirect']			= 'Url redirection';
$_['text_editor_query']					= 'Query';
$_['text_editor_query_redirect'] = 'Query';
$_['text_editor_query_common']		= 'Query (value after route=)';
$_['text_editor_query_special']		= 'Query (ex: custom_id=1)';
$_['text_editor_image']					= 'Image';
$_['text_editor_name']					= 'Name';
$_['text_editor_title']						= 'Title';
$_['text_editor_meta_title']				= 'Meta title';
$_['text_editor_meta_keyword']		= 'Meta keyword';
$_['text_editor_meta_description']	= 'Meta description';
$_['text_editor_url']						= 'SEO url';
$_['text_editor_url_redirect']	= 'Redirect';
$_['text_editor_tag']						= 'Tags';
$_['text_editor_h1']						= 'Seo H1';
$_['text_editor_item_name']	= 'Product name';
$_['text_editor_image_name']	= 'Name';
$_['text_editor_image_alt']	= 'Alt';
$_['text_editor_image_title']	= 'Title';
$_['text_editor_related']			= 'Related';
$_['text_seo_new_alias_title']			= 'Insert new url alias';
$_['text_seo_new_alias_info']			= 'Rewrite an url that use the route parameter, for example index.php?route=<b>account/account</b><br/>In query field put <b>account/account</b> (it is not necessary to insert route=)<br/>In SEO url field put the url you want: <b>my-account</b>';
$_['text_seo_new_spec_alias_info']	= 'Rewrite urls that belongs to any custom module even if it is not made to handle friendly urls.<br/>For example index.php?<b>blog_news_id=123</b><br/>In query field put <b>blog_news_id=123</b><br/>In SEO url field put the url you want: <b>a-great-url-for-my-great-news</b>';
$_['text_seo_new_redirect']	= 'This generates a 301 redirection to indicate to search engines that the current url has been moved permanently to a new one. Use this feature to fix crawling errors from google webmaster.<br/><br/>In query type the full url <b>http://example.com/broken-url</b><br/>In redirect field put new url <b>http://example.com/fixed-url</b><br/><br/>Or without the domain name (don\'t forget the initial /)<br/>In query: <b>/broken-url</b><br/>In redirect field: <b>/fixed-url</b><br/><br/>Dynamic redirection<br/>If you want to make it work even with further url updates fill the redirect field that way:<br/><b>product/product&product_id=42</b> (where 42 is your actual product id)';

// Tab seo configuration
$_['tab_seo_options']      	= 'SEO configuration';
$_['text_seo_tab_general_1']	= 'Main options';
$_['text_seo_tab_general_2']	= 'Language prefix';
$_['text_seo_tab_general_3']	= 'Hreflang';
$_['text_seo_tab_general_4']	= 'Keyword options';
$_['text_seo_tab_general_5']	= 'Auto update';
$_['text_seo_tab_general_6']	= 'Pagination';
$_['text_seo_tab_general_7']	= 'Cache';
$_['text_seo_tab_general_8']	= 'Canonical links';
$_['text_seo_tab_general_9']	= 'Multi-store prefix';
$_['text_seo_tab_general_10']	= 'Reviews';
$_['text_info_general']		= 'These settings impact the global functioning of SEOs, they take effect immediately and can be changed at any time.';
$_['text_info_general_2']		= 'Language prefix mode permits to add the language code at start of the url : website.com/en/<br/>It is useful to have a good separation between each language.';
$_['text_info_general_3']		= 'Hreflang tag allow search engines to know the url of current page for other languages.<br/>Once activated it will be included in all pages of your website, and also into the seo package sitemap (feed > seo package sitemap).<br/> More information : <a href="https://support.google.com/webmasters/answer/189077?hl=en" target="new">here</a>';
$_['text_info_general_6']		= 'Rewrite pagination links SEO friendly, for example website.com/category?page=3 will become website.com/category/page-3';
$_['text_info_general_7']		= 'The cache feature will speed up your website by caching all url links instead of calculating them each time';
$_['text_info_general_8']		= 'Canonical links are informing search engines that if it find a same page elsewhere on the website it have to only consider one link, this is important in order to avoid duplicate content penalties';
$_['text_info_general_9']		= 'Enable this option if you want your links to be written with specific store depending the language. For example if you have 2 stores defined like this :<br/><b>http://en.domain.com</b><br/><b>http://fr.domain.com</b><br/>By default opencart allows to change language but stay on same domain, if you enable this option and change the language, you will be redirected to the other domain. Also the hreflang links will be correctly updated with corresponding store.<br/><br/>If you make any modification on stores, come back here and save settings again.';
$_['text_info_general_10']		= 'In default opencart reviews are loaded dynamically by ajax, that make search engines to not see the content of reviews which would be valuable content for your website, enable this option to be able to insert a block containing the user reviews in HTML in order to make search engines to be able to see them.<br /><br />You have to insert manually this code in your product/product.tpl template : <b>&lt;?php echo $seo_reviews; ?&gt;</b><br /><br /> Then you can style it as you want, container class is <b>.seo_reviews</b>, item class is <b>.seo_review</b>';
$_['text_seo_pagination']		= 'Enable SEO pagination';
$_['text_seo_pagination_fix'] = 'Prev/next fix:<span class="help">Fix opencart 2 issue with prev/next in subcategories</span>';
$_['text_seo_canonical']		= 'Canonical:<span class="help">Enable canonical for all pages</span>';
$_['text_seo_absolute']		= 'Absolute category path:<span class="help">Allow to use same keyword for sub-categories (ex: <br/>/men/shoes<br/>/women/shoes)<br/>The keyword can be duplicated only in categories (do not use same for manufacturer or product)</span>';
$_['text_seo_reviews']		= 'SEO reviews:<span class="help">Insert reviews in HTML content</span>';
$_['text_seo_extension']		= 'Extension:<span class="help">Add the extension of your choice at the end of a product keyword (ex: .html)</span>';
$_['text_seo_flag']				= 'Language prefix mode:<span class="help">Add language code at start of the url (/en, /fr, ...)</span>';
$_['text_seo_flag_short']				= 'Short prefix:<span class="help">Display /en instead of /en-gb in case you have full format defined</span>';
$_['text_seo_flag_upper']	= 'Prefix in uppercase:<span class="help">/EN /FR</span>';
$_['text_seo_flag_default']	= 'No prefix for default:<span class="help">Default language does not use prefix</span>';
$_['text_seo_urlcache']		= 'URL Cache:<span class="help">Speed up page loading by using url caching</span>';
$_['text_seo_redirect_dynamic']		= 'Redirect dynamic links:<span class="help">Dynamic links (route=product/product&product_id=32) will be automatically redirected to their friendly url if it exists. The redirection is 301 so search engine will stop to index it and take only friendly url as reference.</span>';
$_['text_seo_banner']		= 'Banner links rewrite:<span class="help">Dynamically generate seo link on banners (used in banner, carousel, slideshow modules)</span>';
$_['text_seo_banner_help']	= 'In banners section, do not enter the seo link (/category/product_name) but enter instead the default opencart link : <b>index.php?route=product/product&path=10_21&product_id=54</b>.<br />You can also strip out the index.php, like this : <b>product/product&path=23&product_id=48</b>';
$_['text_seo_hreflang']			= 'Enable hreflang tag:';
$_['text_seo_substore']			= 'Enable multi-store rewriting:';
$_['text_info_transform']		= 'All these settings define the way that the keyword will be generated when saving an item or using the mass update.';
$_['text_seo_whitespace']		= 'Spaces:<span class="help">Replace space chars by...</span>';
$_['text_seo_lowercase']		= 'Lowercase:<span class="help">QWERTY => qwerty</span>';
$_['text_seo_duplicate']			= 'Duplicates:<span class="help">Allow to use same keyword for distinct language version of an item</span>';
$_['text_seo_ascii']				= 'ASCII mode:<span class="help">Replace accentuated chars by their ascii equivalent<br/>"éàôï" => "eaoi"</span>';
$_['text_seo_autofill']				= 'Auto fill';
$_['text_seo_autofill_on']		= 'on:';
$_['text_seo_autofill_desc']		= 'Auto fill:<span class="help">If left the field blank on insert or edit, a value will be created automatically based on the pattern in mass update tab.<br/><br/>This works for : <br/>- products<br/>- categories<br/>- informations</span>';
$_['text_seo_autourl']			= 'Auto URL:<span class="help">If left blank on insert or edit, seo url keyword will be generated automatically using the parameter set in "Mass update" tab<br/>This works for products, categories and informations</span>';
$_['text_seo_autotitle']			= 'Auto title and desc for other langs:<span class="help">If left blank on insert or edit, titles and descriptions of other languages will copy the default language title and description<br/>This works for products, categories and informations</span>';
$_['text_all']						= 'All';
$_['text_insert']						= 'Insert';
$_['text_edit']						= 'Edit';

// Tab store seo
$_['tab_seo_store']      			= 'Store SEO';
$_['text_info_store']				= 'In this section you can customize the meta title, h1, meta keywords and description on home page for each store and each language!<br/>Anything entered here will bypass the values entered in opencart settings.<br/><br/>Title values may be not automatically applied depending your theme, to insert them you have to edit your common/home template (and the same in prod/cat/info templates) and use these codes : <br/>&lt;h1&gt;&lt;?php echo $seo_h1; ?&gt;&lt;/h1&gt;<br/>&lt;h2&gt;&lt;?php echo $seo_h2; ?&gt;&lt;/h2&gt;<br/>&lt;h3&gt;&lt;?php echo $seo_h3; ?&gt;&lt;/h3&gt;<br/><br/>Consider that elements with display:none may not be considered by search engines, so you may want to insert only some of these depending your template (h1 is the most important).';
$_['entry_store_seo_title']      = 'Meta Title:';
$_['entry_store_title']      		= 'Heading Title H1:';
$_['entry_store_h2']      	  	= 'Title H2:';
$_['entry_store_h3']      	  	= 'Title H3:';
$_['entry_store_desc']      		= 'Meta Description:';
$_['entry_store_keywords']	= 'Meta Keywords:';

// Tab rich snippets
$_['tab_seo_snippets']			= 'Rich snippets';
$_['text_seo_tab_snippet_1']		= 'Google Microdata';
$_['text_seo_tab_snippet_2']		= 'Facebook Open Graph';
$_['text_seo_tab_snippet_3']		= 'Twitter Card';
$_['text_seo_tab_snippet_3']		= 'Twitter Card';
$_['text_seo_tab_snippet_4']		= 'Google Publisher';
$_['tab_microdata_1']		        = 'Product';
$_['tab_microdata_2']		        = 'Organization';
$_['tab_microdata_3']		        = 'Store';
$_['tab_microdata_4']		        = 'Website';
$_['tab_microdata_5']		        = 'Place';
$_['tab_microdata_6']		        = 'Breadcrumbs';
$_['entry_snippet_same_as']		  = 'Same as:';
$_['entry_enable_microdata']		= 'Enable Google Microdata:';
$_['entry_microdata_search']		= 'Search box';
$_['entry_microdata_logo']		  = 'Logo';
$_['entry_microdata_address']	  = 'Address';
$_['entry_snippet_contact']		  = 'Contacts';
$_['entry_microdata_gps']		    = 'GPS coordinates';
$_['entry_gps_lat']		          = 'Latitude';
$_['entry_gps_long']		        = 'Longitude';
$_['entry_address_street']      = 'Street';
$_['entry_address_city']        = 'Locality';
$_['entry_address_region']      = 'Region';
$_['entry_address_code']        = 'Postal code';
$_['entry_address_country']     = 'Country';
$_['entry_email']		            = 'Email';
$_['entry_phone']		            = 'Phone';
$_['entry_product_data']		    = 'Include product data:';
$_['entry_snippet_data']		    = 'Include data:';
$_['entry_model']		            = 'Model';
$_['entry_description']		      = 'Description (based on meta description)';
$_['entry_reviews']		          = 'Reviews';
$_['entry_rating']		          = 'Average rating';
$_['entry_manufacturer']		    = 'Manufacturer';
$_['entry_enable_opengraph']		= 'Enable Facebook Open Graph:';
$_['entry_opengraph_id']		    = 'Facebook page id:';
$_['entry_enable_tcard']		    = 'Enable Twitter Card:';
$_['entry_twitter_nick']		    = 'Twitter nickname (optional):';
$_['entry_twitter_home_type']		= 'Home page type:';
$_['entry_twitter_summary']		  = 'Summary';
$_['entry_twitter_summary_large'] = 'Summary with large image';
$_['entry_enable_gpublisher']		    = 'Enable Google Publisher:';
$_['entry_gpublisher_url']		    = 'Google+ url:';


// Tab friendly urls
$_['tab_seo_friendly']				= 'Friendly URLs';
$_['text_seo_export_urls']		= 'Export URLs';
$_['text_seo_export_urls_tooltip'] = 'Export Friendly URLs and send them to the developer for integration in official package';
$_['text_seo_reset_urls']  		= 'Restore default URLs';
$_['text_seo_reset_urls_tooltip']= 'If the current language does not have predefined urls the module will load english version';
$_['text_info_friendly']			= 'Here you can manage the friendly urls, edit them as you want.<br/>You have also the possibility to add new url, it works for example for any custom module you installed, just fill the 1st field with the value in route (?route=mymodule/action) and the 2nd field with the keyword you want to appear in the url.';
$_['text_seo_friendly']			= 'Friendly URLs for common pages:<span class="help">Enable this option in order to use friendly urls for common pages and special pages (edit them in SEO editor tab)</span>';
$_['text_seo_cat_slash']			= 'Final slash on category:<span class="help">Insert a final slash at the end of category urls</span>';
$_['text_seo_remove_urls'] = 'Remove all entries';
$_['text_seo_add_url']      = 'Add new entry';

// Tab full product path
$_['tab_seo_fpp']			= 'Path manager';
// Text
$_['tab_fpp_product']   = 'Product';
$_['tab_fpp_category']   = 'Category';
$_['tab_fpp_manufacturer']   = 'Manufacturer';
$_['tab_fpp_search']   = 'Search';
$_['text_fpp_cat_canonical']   = 'Category canonical:';
$_['text_fpp_cat_mode_0']   = 'Direct link';
$_['text_fpp_cat_mode_1']   = 'Full path';
$_['text_fpp_cat_canonical_help']   = 'What kind of link you want to give to search engines ?<br/><b>Direct link</b>: /category (default)<br/><b>Full path</b>: /cat1/cat2/category<br/><br/>With directl link path mode the canonical is automatically set on directl link too';
$_['text_fpp_mode']   = 'Product path mode:';
$_['text_fpp_mode_0']   = 'Direct link';
$_['text_fpp_mode_1']   = 'Shortest path';
$_['text_fpp_mode_2']   = 'Largest path';
$_['text_fpp_mode_3']   = 'Manufacturer path';

$_['text_fpp_bc_mode'] = 'Breadcrumbs mode:';
$_['text_fpp_breadcrumbs_fix'] = 'Breadcrumbs generator:';
$_['text_fpp_breadcrumbs_0']   = 'Default';
$_['text_fpp_breadcrumbs_1']   = 'Generate if empty';
$_['text_fpp_breadcrumbs_2']   = 'Always generate';

$_['text_fpp_mode_help']   = '<span class="help"><b>Direct link:</b> get direct link to product, no category included (ex: /product_name), this is default opencart behaviour<br/>
																		  <b>Shortest path:</b> get shortest path by default, can be altered by banned categories (ex: /category/product_name)<br/>
																		  <b>Largest path:</b> get largest path by default, can be altered by banned categories (ex: /category/sub-category/product_name)<br/>
																		  <b>Manufacturer path:</b> get manufacturer path instead of categories (ex: /manufacturer/product_name)</span>';
$_['text_fpp_breadcrumbs_help']   = '<span class="help"><b>Default:</b> default opencart behaviour: will display breadcrumbs coming from categories<br/>
																		  <b>Generate if empty:</b> generate breadcrumbs only when it is not already available, so category breadcrumb is preserved (recommended)<br/>
																		  <b>Always generate:</b> overwrite also the category breadcrumbs, so the only breadcrumbs you will get is the one generated by the module<br/></span>';
$_['text_fpp_bypasscat'] = 'Rewrite product path in categories:';
$_['text_fpp_bypasscat_help'] = '<span class="help">If disabled, the product link from categories remains the same in order to preserve normal behaviour and breadcrumbs.<br/>If enabled, the product link from categories is overwritten with path generated by the module.<br>In any case canonical link is updated with good value so google will only see the url generated by the module for a given product.</span>';
$_['text_fpp_directcat'] = 'Category path mode:';
$_['text_fpp_directcat_help'] = 'What kind of link you want to display on your website ?<br/><b>Direct link</b>: /category<br/><b>Full path</b>: /cat1/cat2/category (default)';
$_['text_fpp_homelink'] = 'Rewrite home link:';
$_['text_fpp_homelink_help'] = '<span class="help">Set homepage link to mystore.com instead of mystore.com/index.php?route=common/home</span>';
$_['text_fpp_depth']   		= 'Max levels:';
$_['text_fpp_depth_help']   = '<span class="help">Maximum category depth you want to display, for example if you have a product in /cat/subcat/subcat/product and set this option to 2 the link will become /cat/subcat/product<br/>This option works in largest and shortest path modes</span>';
$_['text_fpp_unlimited']   = 'Unlimited';
$_['text_fpp_brand_parent']   = 'Manufacturer parent:';
$_['text_fpp_brand_parent_help']   = '<span class="help">Include the manufacturers inside the manufacturer list url.<br/>For example if your manufacturer list is /brand, the manufacturer apple will appear this way /brand/apple instead of direct /apple</span>';
$_['text_fpp_remove_search']   = 'Remove search parameter:';
$_['text_fpp_remove_search_help']   = '<span class="help">Remove the search parameter (?search=something) from product url in search results</span>';
$_['entry_category']		= 'Banned categories:<span class="help">Choose the categories that will never be displayed in case of multiple paths</span>';

// Tab mass update
$_['tab_seo_update']       = 'Mass update';
$_['text_info_update']     = 'Be careful when using this function since it will overwrite all your keywords.<br/>You can use the simulate function to check the result before really update.<br/>Select the language flags to update only these languages.';
$_['text_cleanup']				= 'Clean up:<span class="help">Remove old urls in database, make a clean up if you have troubles with some urls</span>';
$_['text_cache']					= 'URL cache:<span class="help">Generate or delete url cache</span>';
$_['text_redirection']					= 'Dynamic redirection:<span class="help">Save all actual urls for further redirection, then you can change the seo keyword, google will keep the track.</span>';
$_['text_cache_create_btn']= 'Generate cache';
$_['text_redirect_create_btn']= 'Generate redirection';
$_['text_cache_delete_btn']= 'Clear cache';
$_['text_cleanup_btn']		= 'Clean up';
$_['text_cleanup_duplicate_btn']		= 'Remove duplicate url alias';
$_['text_cleanup_done']		= 'Clean up done, %d entries deleted';
$_['text_seo_languages']   = 'Select languages';
$_['text_seo_simulate']    = 'Simulation:<span class="help">No changes are made while this button is on</span>';
$_['text_seo_empty_only']    = 'Update empty values only:<span class="help">Check off to overwrite all values</span>';
$_['text_seo_redirect']    = 'Redirection';
$_['text_seo_redirect_mode']    = 'Url redirection:<span class="help">Automatically insert a redirection for old urls</span>';
$_['text_image_name_lang'] = 'Image names can be set in only one language, please choose one and click on generate again';
$_['text_enable']   	 		 = 'Enable';
$_['text_deleted']   	 	 = 'Deleted';

// Tab cron
$_['tab_seo_cron'] 			= 'Cron';
$_['text_info_cron']			= 'You can make mass update using cron jobs, copy the file <b>seo_package_cli.php</b> from "_extra files" folder (preferably into a directory outside of web root) and configure your cron with the path to that file.<br/>The script will use the settings configured on this page.<br/>Warning: cron jobs cannot generate unlimited items (only mass updater can), so depending on your server limitations and number of items you have you may face error on using cron, it is recommended to use the "empty only" parameter to limit the number of items you are going to update using cron.';
$_['text_seo_cron_update'] = 'Update:';
$_['text_clear_logs'] = 'Clear logs';
$_['text_tab_cron_1'] = 'Configuration';
$_['text_tab_cron_2'] = 'Report';
$_['text_cli_log_save'] = 'Save log file';
$_['text_cli_log_too_big'] = 'Your log file is too big (%s) to be displayed here - you can download it or clear it with buttons below';

// Tab about
$_['tab_seo_about']			 = 'About';

$_['text_nothing_changed']    				= 'Zero items';
$_['text_seo_no_language']    				= 'No language selected';
$_['text_seo_fullscreen']    						= 'Fullscreen';
$_['text_seo_show_old']    						= 'Display old value';
$_['text_seo_change_count']    				= 'entries changed';
$_['text_seo_old_value']    						= 'Old value';
$_['text_seo_new_value']    					= 'New value';
$_['text_seo_item']    					= 'Item';
$_['text_simulation']    					= 'Simulation mode';
$_['text_write']    					    = 'Write mode';
$_['text_empty_only']    					    = 'Empty values only';
$_['text_all_values']    					    = 'All values';
$_['text_seo_update_info']    					= '1. Enable or disable simulation mode<br/>2. Select if you want to update only empty items or all items<br/>3. Click on the Generate button of your choice<br/>4. Results will be displayed here';
$_['text_seo_simulation_mode']    			= '<span>SIMULATION MODE</span><br/>No changes will be made to database';
$_['text_seo_write_mode']		    			= '<span>WRITE MODE</span><br/>Modifications will be saved';
$_['text_seo_product']							= 'Product';
$_['text_seo_category']							= 'Category';
$_['text_seo_manufacturer']					= 'Manufacturer';
$_['text_seo_information']						= 'Information';
$_['text_seo_cache']								= 'Name';
$_['text_seo_cleanup']							= 'Entry (url)';
$_['text_seo_type_product']					= 'Products';
$_['text_seo_type_category']					= 'Categories';
$_['text_seo_type_manufacturer']			= 'Manufacturers';
$_['text_seo_type_information']				= 'Informations';
$_['text_seo_type_redirect']				= 'Dynamic redirection';
$_['text_seo_mode_product']					= 'Products';
$_['text_seo_mode_category']					= 'Categories';
$_['text_seo_mode_manufacturer']			= 'Manufacturers';
$_['text_seo_mode_information']				= 'Informations';
$_['text_seo_mode_url_alias']				= 'Url Alias';
$_['text_seo_mode_duplicate']				= 'Remove duplicate';
$_['text_seo_type_redirection']					= 'Dynamic redirection';
$_['text_seo_type_report']						= 'Report';
$_['text_seo_type_cache']						= 'Cache';
$_['text_seo_type_cleanup']					= 'Clean up';
$_['text_seo_generator_product']			= 'Products:';
$_['text_seo_generator_product_desc']	= '<span class="help">Available patterns:<br/><b>[name]</b> : Product name<br/><b>[model]</b> : Model<br/><b>[category]</b> : Category name<br/><b>[brand]</b> : Brand name<br/><b>[desc]</b> : Description extract<br/><b>[current]</b> : Current value<br/><b>{aa|bb|cc}</b> : Random values<br/><b>{en}..{/en}</b> : Only for lang<br/><br/>Other : <b>[parent_category]</b> <b>[upc]</b> <b>[sku]</b> <b>[ean]</b> <b>[jan]</b> <b>[isbn]</b> <b>[mpn]</b> <b>[location]</b> <b>[price]</b> <b>[lang]</b> <b>[lang_id]</b> <b>[prod_id]</b> <b>[cat_id]</b></span>';
$_['text_seo_generator_category']			= 'Categories:';
$_['text_seo_generator_category_desc']	= '<span class="help">Available patterns:<br/><b>[name]</b> : Category name<br/><b>[desc]</b> : Description extract<br/><b>[current]</b> : Current value<br/><b>{aa|bb|cc}</b> : Random values<br/><b>{en}..{/en}</b> : Only for lang<br/><br/><b>[parent]</b> : Parent category name<br/><br/>Other : <b>[lang]</b> <b>[lang_id]</b> <b>[cat_id]</b></span>';
$_['text_seo_generator_information']		= 'Informations pages:';
$_['text_seo_generator_information_desc']= '<span class="help">Available patterns:<br/><b>[name]</b> : Information title<br/><b>[desc]</b> : Description extract<br/><b>[current]</b> : Current value<br/><b>{aa|bb|cc}</b> : Random values<br/><b>{en}..{/en}</b> : Only for lang<br/><br/>Other : <b>[lang]</b> <b>[lang_id]</b></span>';
$_['text_seo_generator_manufacturer']	= 'Manufacturers:';
$_['text_seo_generator_manufacturer_desc']= '<span class="help">Available patterns:<br/><b>[name]</b> : Manufacturer name<br/><b>[current]</b> : Current value<br/><b>{aa|bb|cc}</b> : Random values<br/><b>{en}..{/en}</b> : Only for lang</span>';
$_['text_seo_mode_url']					= 'SEO URLs';
$_['text_seo_generator_redirect']	= 'Generate dynamic redirections';
$_['text_seo_mode_title']				= 'Meta Title';
$_['text_seo_mode_h1']				  = 'SEO H1';
$_['text_seo_mode_image_name']  = 'Image name';
$_['text_seo_mode_image_alt']  = 'Image alt';
$_['text_seo_mode_image_title']  = 'Image title';
$_['text_seo_mode_keyword'] 		= 'Meta Keywords';
$_['text_seo_mode_description']		= 'Meta Description';
$_['text_seo_mode_related']		= 'Related products';
$_['text_seo_mode_tag']				= 'Tags';
$_['text_seo_mode_create']			= 'Generate';
$_['text_seo_mode_delete']			= 'Delete';
$_['text_seo_report']			= 'Report';
$_['text_seo_generator_url']			= 'Generate URLs';
$_['text_seo_generator_title']			= 'Generate Meta Title';
$_['text_seo_generator_keywords'] = 'Generate Meta Keywords';
$_['text_seo_generator_desc']		= 'Generate Meta Description';
$_['text_seo_generator_full_desc']		= 'Generate Description';
$_['text_seo_generator_tag']			= 'Generate Tags';
$_['text_seo_generator_h1']			= 'Generate SEO H1';
$_['text_seo_generator_h2']			= 'Generate SEO H2';
$_['text_seo_generator_h3']			= 'Generate SEO H3';
$_['text_seo_generator_imgalt']	= 'Generate Image Alt';
$_['text_seo_generator_imgtitle']	= 'Generate Image Title';
$_['text_seo_generator_imgname']	= 'Generate Image Name';
$_['text_seo_generator_related']		= 'Generate Related Products';
$_['text_seo_generator_related_no']		= 'Qty:';
$_['text_seo_generator_related_relevance']		= 'Relevance (0-10):';
$_['text_query']		= 'Query';
$_['text_keyword']		= 'Keyword';
$_['text_status']		= 'Status';
$_['text_empty']		= 'Empty';
$_['text_duplicate']		= 'Duplicate';
$_['text_report']		= 'Report';
$_['text_url_alias_report_btn']		= 'Url alias report';

$_['text_seo_result']      = 'Result:';

$_['text_module']          = 'Modules';
$_['text_success']         = 'Success: You have modified module SEO module!';

$_['text_man_ext']				 = 'Manufacturer extended';

$_['text_seo_confirm']		 = 'Are you sure ?';


// Full product path



// Error
$_['error_permission'] = 'Warning: You do not have permission to modify this module!';
?>