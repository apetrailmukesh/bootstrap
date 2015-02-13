<?php

class UtilityFeature {

	public function getValue($source)
	{
		$value = '';
		if (array_key_exists('feature', $source)) {
			$values = Feature::where('feature' , '=', $source['feature']);
			if ($values->count()) {
				$value = $values->first()->feature;
			}
		}

		return $value;
	}
}