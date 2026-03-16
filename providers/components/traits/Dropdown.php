<?php

namespace helpers\traits;

use Yii;

trait Dropdown
{
    /**
     * Generic search for dropdowns with Multi-field support
     * @param \yii\db\ActiveQuery $query The base query
     * @param string|array $searchFields Column name or array of columns (e.g., ['name', 'code'])
     * @param array $selectFields Columns to return
     * @param int $limit
     * @return array
     */
    public function performDropdownSearch($query, $searchFields, array $selectFields, int $limit = 25): array
    {
        $q = Yii::$app->request->get('q');
        $modelClass = $query->modelClass;
        $tableName = $modelClass::tableName();

        $query->select($selectFields)
            ->andWhere([$tableName . '.is_deleted' => 0]);

        if (!empty($q)) {
            // Check if model uses the Like trait
            $hasLikeTrait = method_exists($modelClass, 'ciLike');

            if (is_array($searchFields)) {
                // Multi-field search (Name OR Code)
                if ($hasLikeTrait) {
                    $query->andWhere($modelClass::ciLikeAny($searchFields, $q));
                } else {
                    $orCondition = ['or'];
                    foreach ($searchFields as $field) {
                        $orCondition[] = ['like', $field, $q];
                    }
                    $query->andWhere($orCondition);
                }
            } else {
                // Single field search
                if ($hasLikeTrait) {
                    $query->andWhere($modelClass::ciLike($searchFields, $q));
                } else {
                    $query->andWhere(['like', $searchFields, $q]);
                }
            }
        }

        return $query->limit($limit)
            ->asArray()
            ->all();
    }
}
