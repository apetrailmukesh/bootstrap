<?php

class UtilityModel {

	public function buildFilterQuery($and, $model_filter)
	{
		if (!empty($model_filter)) {
			$or = array();
			$models = explode("-", $model_filter);
			foreach ($models as $model) {
				array_push($or, array("term" => array("model_id" => $model)));
			}

			array_push($and, array("or" => $or));
		}

		return $and;
	}

	public function buildAggregationQuery()
	{
		return array("model" => array("terms" => array("field" => "model_id", "size" => 0)));
	}

	public function decodeAggregation($results)
	{
		$values = array();
		
		$counter = 0;
		foreach ($results['aggregations']['model']['buckets'] as $model) {
			$models = Model::where('id' , '=', $model['key']);
			if ($models->count()) {
				$title = $models->first()->model . ' (' . $model['doc_count'] . ')';
				$values[$model['key']] = array("index" => $counter, "key" => $model['key'], "title" => $title, "count" => $model['doc_count']);
				$counter++;
			}
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
					$title = $models->first()->model . ' (' .  $aggregations['model'][$model_range]['count'] . ')';
					array_push($values, array("title" => $title, "index" => 'model-remove-' . $model_range));
				}
			}

			array_push($filters, array("name" => "Model", "values" => $values));
		}

		return $filters;
	}
}