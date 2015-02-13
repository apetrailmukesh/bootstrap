<?php

class UtilityModel {

	public function getValue($source)
	{
		$value = '';
		if (array_key_exists('model', $source)) {
			$values = Model::where('model' , '=', $source['model']);
			if ($values->count()) {
				$value = $values->first()->model;
			}
		}

		return $value;
	}
	
	public function buildFilterQuery($and, $model_filter)
	{
		if (!empty($model_filter)) {
			$or = array();
			$models = explode("-", $model_filter);
			foreach ($models as $model) {
				array_push($or, array("term" => array("model" => $model)));
			}

			array_push($and, array("or" => $or));
		}

		return $and;
	}

	public function buildAggregationQuery()
	{
		return array("model" => array("terms" => array("field" => "model", "size" => 0)));
	}

	public function decodeAggregation($results)
	{
		$sorted = array();
		$values = array();

		foreach ($results['aggregations']['model']['buckets'] as $model) {
			$models = Model::where('id' , '=', $model['key']);
			if ($models->count()) {
				$entity = $models->first();
				$name = $entity->model;
				$count = $model['doc_count'];
				$title = $name . ' (' . $count . ')';
				$sorted[$name] = array("key" => $model['key'], "title" => $title, "count" => $count);
			}
		}

		ksort($sorted);

		$counter = 0;
		foreach ($sorted as $value) {
			$values[$value['key']] = array('index' => $counter, 'key' => $value['key'], 'title' => $value['title'], 'count' => $value['count']);
    		$counter++;
		}

		return $values;
	}

	public function findSelectedFilter($filters, $aggregations, $model_filter)
	{
		if (!empty($model_filter)) {
			$values = array();
			$model_ranges = explode("-", $model_filter);
			foreach ($model_ranges as $model_range) {
				$models = Model::where('id' , '=', $model_range);
				if ($models->count()) {
					$title = '';
					if (array_key_exists($model_range, $aggregations['model'])) {
						$title = $models->first()->model . ' (' .  $aggregations['model'][$model_range]['count'] . ')';
					} else {
						$title = $models->first()->model . ' (0)';
					}

					array_push($values, array("title" => $title, "index" => 'model-remove-' . $model_range));
				}
			}

			array_push($filters, array("name" => "Model", "values" => $values));
		}

		return $filters;
	}
}