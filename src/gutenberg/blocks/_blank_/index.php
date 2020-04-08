<?php

class WKG_Module_Block__blank_ extends WKG_Module_Block {

	function __construct() {
		parent::__construct('_blank_');
	}

	public function render(array $attributes, $content) {
		ob_start ();
		// print_r($attributes);
		$id = isset($attributes['id']) ? str_replace('-', '', $attributes['id']) : uniqid('wkg');
		?>
		<div class="<?php echo $this->getFrontClasses(); ?>" id="<?php echo $id; ?>">
			TODO display block front content
		</div>
		<?php return ob_get_clean();
	}
}
new WKG_Module_Block__blank_();
