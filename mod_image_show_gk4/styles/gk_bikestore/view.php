<?php

/**
* GK Image Show - view file
* @package Joomla!
* @Copyright (C) 2009-2012 Gavick.com
* @ All rights reserved
* @ Joomla! is Free Software
* @ Released under GNU/GPL License : http://www.gnu.org/copyleft/gpl.html
* @ version $Revision: GK4 1.0 $
**/

// no direct access
defined('_JEXEC') or die;

jimport('joomla.utilities.string');

if($this->config['random_slides'] == 1) {
	shuffle($this->config['image_show_data']);
}

?>

<div id="gkIs-<?php echo $this->config['module_id'];?>" class="gkIsWrapper-gk_bikestore">
	<div class="gkIsPreloader"></div>
	
	<?php for($i = 0; $i < count($this->config['image_show_data']); $i++) : ?>
	<?php if($this->config['image_show_data'][$i]->published) : ?>
		<?php 
			
			unset($path, $title, $link);
			// creating slide path
			$path = '';
			// check if the slide have to be generated or not
			if($this->config['generate_thumbnails'] == 1) {
				$path = $uri->root().'modules/mod_image_show_gk4/cache/'.GKIS_Bikestore_Image::translateName($this->config['image_show_data'][$i]->image, $this->config['module_id']);
			} else {
				$path = $uri->root();
				$path .= $this->config['image_show_data'][$i]->image;
			}
			//
            if($this->config['image_show_data'][$i]->type == "k2") {
              	if(isset($this->articlesK2[$this->config['image_show_data'][$i]->artK2_id])) {
              		$title = htmlspecialchars($this->articlesK2[$this->config['image_show_data'][$i]->artK2_id]["title"]);
                	$link =  $this->articlesK2[$this->config['image_show_data'][$i]->artK2_id]["link"];
                } else {
                	$title = 'Selected article doesn\'t exist!';
                	$link = '#';
                }
            } else {
                // creating slide title
				$title = htmlspecialchars(($this->config['image_show_data'][$i]->type == "text") ? $this->config['image_show_data'][$i]->name : $this->articles[$this->config['image_show_data'][$i]->art_id]["title"]);
				// creating slide link
				$link = ($this->config['image_show_data'][$i]->type == "text") ? $this->config['image_show_data'][$i]->url : $this->articles[$this->config['image_show_data'][$i]->art_id]["link"];	
			}
		?>
		<figure>
			<div class="gkIsSlide" style="z-index: <?php echo $i+1; ?>;" title="<?php echo $title; ?>"><?php echo $path; ?><a href="<?php echo $link; ?>">link</a></div>
			
			<?php if($this->config['config']->gk_bikestore->gk_bikestore_show_title_block) : ?>	
			<figcaption<?php echo ' class="'.$this->config['config']->gk_bikestore->gk_bikestore_title_block_position.' '.$this->config['config']->gk_bikestore->gk_bikestore_title_block_position_x.'"'; ?>>
				<h3><a href="<?php echo $link; ?>"><?php echo JString::substr($title, 0, $this->config['config']->gk_bikestore->gk_bikestore_title_block_length); ?></a></h3>
			</figcaption>
			<?php endif; ?>
		</figure>
	<?php endif; ?>
	<?php endfor; ?>
	
	<?php if($this->config['config']->gk_bikestore->gk_bikestore_pagination) : ?>
	<div class="gkIsButtons">
		<div class="prevSlide">&laquo;</div>
		<div class="nextSlide">&raquo;</div>
	</div>
	<?php endif; ?>
</div>