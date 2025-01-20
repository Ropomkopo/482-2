<?php

require_once(DIR_SYSTEM . 'library/labelmaker/ImageWorkshop.php');

class LabelMaker {
	private $image_workshop;
	private $image;
	private $info;
	private $file;
	private $positions = array('LT','MT','RT','LM','MM','RM','LB','MB','RB');

	public function __construct($file) {
		$file = DIR_IMAGE . $file;

		if (file_exists($file)) {
			$this->file = $file;

			$info = getimagesize($file);

			$this->info = array(
				'width'  => $info[0],
				'height' => $info[1],
				'bits'   => $info['bits'],
				'mime'   => $info['mime']
			);

			if (is_resource($this->image)) {
				imagedestroy($this->image);
			}

			$this->image_workshop = new ImageWorkshop();

			$this->image = $this->image_workshop->initFromPath($file);
		} else {
			exit('Error: Could not load image ' . $file . '!');
		}
	}

	public function label($label_settings) {
		if (!empty($label_settings['layers'])) {
			$layers = $label_settings['layers'];
			
			foreach ($layers as $layer_data) {
				$layer = $this->image_workshop->initFromPath(IMODULE_ROOT . $layer_data['image']);

				// DB Layer Data
				$width 		= (int)$layer_data['width'];
				$height 	= (int)$layer_data['height'];
				$posx		= (int)$layer_data['posx'];
				$posy		= (int)$layer_data['posy'];
				$rotation 	= (int)$layer_data['rotation'];

				// Positioning
				if (!empty($label_settings['Position']) && in_array($label_settings['Position'], $this->positions)) {
					$position_start = $label_settings['Position'];
				} else {
					$position_start = "LT";
				}

				// Automatic Re-scaling
				if ($label_settings['LimitSize'] == 'all' && !empty($label_settings['AutomaticRescaling'])) {
					if ($this->info['width'] >= $this->info['height']) {
						$ratio = round($this->info['width'] / 420, 2);
					} else {
						$ratio = round($this->info['height'] / 420, 2);
					}

					$width = $width * $ratio;
					$height = $height * $ratio;
					$posx = $posx * $ratio;
					$posy = $posy * $ratio;
				}

				// Resize	
				$layer->resizeInPixel($width, $height, false);

				// Adjust Offset 
				if ($position_start == 'MT' || $position_start == 'MM' || $position_start == 'MB') {
					$posx = $posx + ($layer->getWidth() / 2);
				}
				if ($position_start == 'LM' || $position_start == 'MM' || $position_start == 'RM') {
					$posy = $posy + ($layer->getHeight() / 2);
				}

				$width_after_resize 	= $layer->getWidth();
				$height_after_resize 	= $layer->getHeight();

				$layer->rotate($rotation);
				
				// Adjust Rotation
					// X 
					if ($position_start == 'LT' || $position_start == 'RT' || $position_start == 'LM' || $position_start == 'RM' || $position_start == 'LB' || $position_start == 'RB') {
						if ($rotation != 0 && $rotation != 360) {
							$posx = $posx - (($layer->getWidth() - $width_after_resize)/2);
						}
					}

					// Y
					if ($position_start == 'LT' || $position_start == 'MT' || $position_start == 'RT' || $position_start == 'LB' || $position_start == 'MB' || $position_start == 'RB') {
						if ($rotation != 0 && $rotation != 360) {
							$posy = $posy - (($layer->getHeight() - $height_after_resize)/2);
						}
					}

				$layer->opacity((int)$label_settings['Opacity']);

				// Add Layer
				$this->image->addLayerOnTop($layer, $posx, $posy, $position_start);
			}
		}
	}

	public function resize($width = 0, $height = 0) {
		if (!$this->info['width'] || !$this->info['height'] || empty($width) || empty($height)) {
			return;
		}

		$this->image->resizeInPixel((int)$width, (int)$height, true, 0, 0, 'MM');

		$this->info['width']  = (int)$width;
		$this->info['height'] = (int)$height;
	}

	public function save($file, $quality = 95) {
		$this->image->save(DIR_IMAGE, $file, true, null, $quality);

		unset($this->image);
	}
}

?>