<?php
class ModelToolImage extends Model {
	public function resize($filename, $width, $height, $type = '') {
		if (!is_file(DIR_IMAGE . $filename)) {
			return;
		}

		$extension = pathinfo($filename, PATHINFO_EXTENSION);

		$old_image = $filename;
		$new_image = 'cache/' . utf8_substr($filename, 0, utf8_strrpos($filename, '.')) . '-' . $width . 'x' . $height . '.' . $extension;

		if (!is_file(DIR_IMAGE . $new_image) || (filectime(DIR_IMAGE . $old_image) > filectime(DIR_IMAGE . $new_image))) {
			$path = '';

			$directories = explode('/', dirname(str_replace('../', '', $new_image)));

			foreach ($directories as $directory) {
				$path = $path . '/' . $directory;

				if (!is_dir(DIR_IMAGE . $path)) {
					@mkdir(DIR_IMAGE . $path, 0777);
				}
			}

			list($width_orig, $height_orig) = getimagesize(DIR_IMAGE . $old_image);

			if ($width_orig != $width || $height_orig != $height) {
				$image = new Image(DIR_IMAGE . $old_image);
				$image->resize($width, $height, $type);
				$image->save(DIR_IMAGE . $new_image);
			} else {
				copy(DIR_IMAGE . $old_image, DIR_IMAGE . $new_image);
			}
		}

		$imagepath_parts = explode('/', $new_image);
		$new_image = implode('/', array_map('rawurlencode', $imagepath_parts));
		

				/* LabelMaker */
				$this->load->model('module/labelmaker');
				$new_image = $this->model_module_labelmaker->init($old_image, $new_image, $width, $height);
			
		if ($this->request->server['HTTPS']) {
			return (defined('HTTPS_STATIC_CDN') ? HTTPS_STATIC_CDN : $this->config->get('config_ssl')) . 'image/' . $new_image;
		} else {
			return (defined('HTTP_STATIC_CDN') ? HTTP_STATIC_CDN : $this->config->get('config_url')) . 'image/' . $new_image;
		}
	}
}
