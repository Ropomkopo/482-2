<?php
class ControllerFeedSeopackageSitemap extends Controller {
	public function index() {
		if ($this->config->get('seopackage_sitemap_status')) {
			$output  = '<?xml version="1.0" encoding="UTF-8"?>';
			$output .= '<?xml-stylesheet type="text/xsl" href="'.$this->url->link('feed/seopackage_sitemap/xsl').'"?>' . "\n";
			$output .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xhtml="http://www.w3.org/1999/xhtml" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">';
			
			$this->load->model('catalog/product');
      $this->load->model('tool/image');

			$this->load->model('localisation/language');
			$languages = array();
			$results = $this->model_localisation_language->getLanguages();
			foreach ($results as $result) {
				if ($result['status']) {
					$languages[] = array(
						'language_id'  => $result['language_id'],
						'code'  => $result['code']
					);
					
					// set current language to default
					if ($this->config->get('mlseo_default_lang') == $result['code']) {
						$this->config->set('config_language_id', $result['language_id']);
						$this->session->data['language'] = $result['code'];
					}
				}
			}
			
			$hreflang = $this->config->get('mlseo_hreflang');
      
      // handle sub-stores rewriting
      if ($this->config->get('mlseo_store_mode')) {
        $lang_to_store = $this->config->get('mlseo_lang_to_store');
      }
			
			// save current language id
			$current_lang_id = $this->config->get('config_language_id');
			$current_lang_code = $this->session->data['language'];

			$products = $this->model_catalog_product->getProducts();
			
			foreach ($products as $product) {
				$output .= '<url>';
				$output .= '<loc>' . $this->url->link('product/product', 'product_id=' . $product['product_id']) . '</loc>';
				
				if ($hreflang) {
					foreach ($languages as $lang) {
						$this->config->set('config_language_id', $lang['language_id']);
						$this->session->data['language'] = $lang['code'];
            
            $link = $this->url->link('product/product', 'product_id=' . $product['product_id']);
            
            if (!empty($lang_to_store)) {
              $link = str_replace(array($this->config->get('config_url'), $this->config->get('config_ssl')), $lang_to_store[$lang['code']], $link);
            }
            
						$output .= '<xhtml:link rel="alternate" hreflang="' . $lang['code'] . '" href="' . $link . '"/>';
					}
					
					// restore current language id
					$this->config->set('config_language_id', $current_lang_id);
					$this->session->data['language'] = $current_lang_code;
				}
				
        if (!empty($product['image']) && $img_loc = $this->model_tool_image->resize($product['image'], $this->config->get('config_image_popup_width') ?: 500, $this->config->get('config_image_popup_height') ?: 500)) {
          $output .= '<image:image>';
          $output .= '<image:loc>' . htmlspecialchars($img_loc) . '</image:loc>';
          $output .= '<image:caption>' . htmlspecialchars($product['name']) . '</image:caption>';
          $output .= '<image:title>' . htmlspecialchars($product['name']) . '</image:title>';
          $output .= '</image:image>';
        }
        
				$output .= '<changefreq>weekly</changefreq>';
				$output .= '<priority>1.0</priority>';
				$output .= '</url>';
			}

			$this->load->model('catalog/category');

			$output .= $this->getCategories(0, '', $languages);

			$this->load->model('catalog/manufacturer');

			$manufacturers = $this->model_catalog_manufacturer->getManufacturers();

			foreach ($manufacturers as $manufacturer) {
				$output .= '<url>';
				$output .= '<loc>' . $this->url->link('product/manufacturer/info', 'manufacturer_id=' . $manufacturer['manufacturer_id']) . '</loc>';
				$output .= '<changefreq>weekly</changefreq>';
				$output .= '<priority>0.7</priority>';
				$output .= '</url>';

				/* $products = $this->model_catalog_product->getProducts(array('filter_manufacturer_id' => $manufacturer['manufacturer_id']));

				foreach ($products as $product) {
					$output .= '<url>';
					$output .= '<loc>' . $this->url->link('product/product', 'manufacturer_id=' . $manufacturer['manufacturer_id'] . '&product_id=' . $product['product_id']) . '</loc>';
					$output .= '<changefreq>weekly</changefreq>';
					$output .= '<priority>1.0</priority>';
					$output .= '</url>';
				}
				*/
			}

			$this->load->model('catalog/information');

			$informations = $this->model_catalog_information->getInformations();

			foreach ($informations as $information) {
				$output .= '<url>';
				$output .= '<loc>' . $this->url->link('information/information', 'information_id=' . $information['information_id']) . '</loc>';
				
				if ($hreflang) {
					foreach ($languages as $lang) {
						$this->config->set('config_language_id', $lang['language_id']);
						$this->session->data['language'] = $lang['code'];
						
            $link = $this->url->link('information/information', 'information_id=' . $information['information_id']);
            
            if (!empty($lang_to_store)) {
              $link = str_replace(array($this->config->get('config_url'), $this->config->get('config_ssl')), $lang_to_store[$lang['code']], $link);
            }
            
						$output .= '<xhtml:link rel="alternate" hreflang="' . $lang['code'] . '" href="' . $link . '"/>';
					}
					
					// restore current language id
					$this->config->set('config_language_id', $current_lang_id);
					$this->session->data['language'] = $current_lang_code;
				}

				$output .= '<changefreq>weekly</changefreq>';
				$output .= '<priority>0.5</priority>';
				$output .= '</url>';
			}

			$output .= '</urlset>';

			$this->response->addHeader('Content-Type: application/xml; charset=utf-8');
			$this->response->setOutput($output);
		}
	}

	protected function getCategories($parent_id, $current_path = '', &$languages) {
		$output = '';

		$results = $this->model_catalog_category->getCategories($parent_id, '', $languages);
		
		$hreflang = $this->config->get('mlseo_hreflang');
		
    // handle sub-stores rewriting
    if ($this->config->get('mlseo_store_mode')) {
      $lang_to_store = $this->config->get('mlseo_lang_to_store');
    }
      
		// save current language id
		$current_lang_id = $this->config->get('config_language_id');
		$current_lang_code = $this->session->data['language'];

		foreach ($results as $result) {
			if (!$current_path) {
				$new_path = $result['category_id'];
			} else {
				$new_path = $current_path . '_' . $result['category_id'];
			}

			$output .= '<url>';
			$output .= '<loc>' . $this->url->link('product/category', 'path=' . $new_path) . '</loc>';
			
			if ($hreflang) {
				foreach ($languages as $lang) {
					$this->config->set('config_language_id', $lang['language_id']);
					$this->session->data['language'] = $lang['code'];
					
          $link = $this->url->link('product/category', 'path=' . $new_path);
            
          if (!empty($lang_to_store)) {
            $link = str_replace(array($this->config->get('config_url'), $this->config->get('config_ssl')), $lang_to_store[$lang['code']], $link);
          }
          
          $output .= '<xhtml:link rel="alternate" hreflang="' . $lang['code'] . '" href="' . $link . '"/>';
				}
				
				// restore current language id
				$this->config->set('config_language_id', $current_lang_id);
				$this->session->data['language'] = $current_lang_code;
			}
			
			$output .= '<changefreq>weekly</changefreq>';
			$output .= '<priority>0.7</priority>';
			$output .= '</url>';
			
			/*
			$products = $this->model_catalog_product->getProducts(array('filter_category_id' => $result['category_id']));

			foreach ($products as $product) {
				$output .= '<url>';
				$output .= '<loc>' . $this->url->link('product/product', 'path=' . $new_path . '&product_id=' . $product['product_id']) . '</loc>';
				$output .= '<changefreq>weekly</changefreq>';
				$output .= '<priority>1.0</priority>';
				$output .= '</url>';
			}
			*/

			$output .= $this->getCategories($result['category_id'], $new_path, $languages);
		}

		return $output;
	}
  
  public function xsl($index = false) {
    header('Content-Type: application/xml');
    echo '<?xml version="1.0" encoding="UTF-8"?>';

?><xsl:stylesheet version="2.0" 
  xmlns:html="http://www.w3.org/TR/REC-html40"
  xmlns:image="http://www.google.com/schemas/sitemap-image/1.1"
  xmlns:sitemap="http://www.sitemaps.org/schemas/sitemap/0.9"
  xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
	<xsl:output method="html" version="1.0" encoding="UTF-8" indent="yes"/>
	<xsl:template match="/">
		<html xmlns="http://www.w3.org/1999/xhtml">
			<head>
				<title>XML Sitemap</title>
				<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

				<style type="text/css">
					body {
						font-family: Helvetica, Arial, sans-serif;
						font-size: 13px;
						color: #545353;
					}
					table {
						border: none;
						border-collapse: collapse;
					}
					#sitemap tr.odd, #sitemap tbody tr:nth-child(odd) {
						background-color: #eee;
					}
					#sitemap tbody tr:hover {
						background-color: #D7DEE8;
					}
					#sitemap tbody tr:hover td, #sitemap tbody tr:hover td a {
						color: #000;
					}
					#content {
						margin: 0 auto;
						width: 1000px;
					}
					.expl {
						margin: 10px 3px;
						line-height: 1.3em;
					}
					.expl a {
						color: #da3114;
						font-weight: bold;
					}
					a {
						color: #333;
						text-decoration: none;
					}
					a:hover {
						text-decoration: underline;
					}
					td {
						font-size:11px;
					}
					th {
						text-align:left;
						padding-right:30px;
						font-size:11px;
					}
					thead th {
						border-bottom: 1px solid #000;
						cursor: pointer;
					}
				</style>
			</head>
			<body>
				<div id="content">
					<h1>XML Sitemap</h1>
          <!--
					<p class="expl">
						Generated by <a href="">Advanced Sitemap Generator</a>'s Opencart plugin, this is an XML Sitemap, meant for consumption by search engines.
					</p>
					<p class="expl">
						You can find more information about XML sitemaps on <a href="http://sitemaps.org">sitemaps.org</a>.
					</p>
          -->
					<p class="expl">
          <?php if ($index) { ?>
            This index sitemap contains <xsl:value-of select="count(sitemap:sitemapindex/sitemap:sitemap)"/> sitemaps.
          <?php } else { ?>
						This sitemap contains <xsl:value-of select="count(sitemap:urlset/sitemap:url)"/> URLs.
          <?php } ?>
					</p>			
					<table id="sitemap" cellpadding="3">
						<thead>
							<tr>
								<th width="75%">URL</th>
                <?php if (!$index) { ?>
								<th width="5%">Priority</th>
								<th width="5%">Images</th>
								<th width="5%">Change Freq.</th>
                 <?php } ?>
							</tr>
						</thead>
						<tbody>
							<xsl:variable name="lower" select="'abcdefghijklmnopqrstuvwxyz'"/>
							<xsl:variable name="upper" select="'ABCDEFGHIJKLMNOPQRSTUVWXYZ'"/>
              <?php if ($index) { ?>
              <xsl:for-each select="sitemap:sitemapindex/sitemap:sitemap">
              <?php } else { ?>
							<xsl:for-each select="sitemap:urlset/sitemap:url">
              <?php } ?>
								<tr>
									<td>
										<xsl:variable name="itemURL">
											<xsl:value-of select="sitemap:loc"/>
										</xsl:variable>
										<a href="{$itemURL}">
											<xsl:value-of select="sitemap:loc"/>
										</a>
									</td>
                  <?php if (!$index) { ?>
									<td>
										<xsl:value-of select="concat(sitemap:priority*100,'%')"/>
									</td>
									<td>
										<xsl:value-of select="count(image:image)"/>
									</td>
									<td>
										<xsl:value-of select="concat(translate(substring(sitemap:changefreq, 1, 1),concat($lower, $upper),concat($upper, $lower)),substring(sitemap:changefreq, 2))"/>
									</td>
                  <?php } ?>
								</tr>
							</xsl:for-each>
						</tbody>
					</table>
				</div>
			</body>
		</html>
	</xsl:template>
</xsl:stylesheet><?php

  }
}