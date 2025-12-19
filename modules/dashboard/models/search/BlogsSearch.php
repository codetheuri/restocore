<?php

namespace dashboard\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use dashboard\models\Blogs;

/**
 * BlogsSearch represents the model behind the search form of `dashboard\models\Blogs`.
 */
class BlogsSearch extends Blogs
{
    /**
     * {@inheritdoc}
     */
    public $globalSearch;
    public function rules()
    {
        return [
            [['id', 'author_id', 'created_at', 'is_deleted', 'updated_at'], 'integer'],
            [['title',  'content', 'image_link', 'published_at', 'status'], 'safe'],
            ['globalSearch', 'safe']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Blogs::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [ 'defaultPageSize' => \Yii::$app->params['defaultPageSize'], 'pageSizeLimit' => [1, \Yii::$app->params['pageSizeLimit']]],
            'sort'=> ['defaultOrder' => ['created_at'=>SORT_DESC]]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        if(isset($this->globalSearch)){
                $query->orFilterWhere([
            'id' => $this->globalSearch,
            'author_id' => $this->globalSearch,
            'published_at' => $this->globalSearch,
            'created_at' => $this->globalSearch,
            'is_deleted' => $this->globalSearch,
            'updated_at' => $this->globalSearch,
        ]);

        $query->orFilterWhere(['like', 'title', $this->globalSearch])
           
            ->orFilterWhere(['like', 'content', $this->globalSearch])
            ->orFilterWhere(['like', 'image_link', $this->globalSearch])
            ->orFilterWhere(['like', 'status', $this->globalSearch]);
        }else{
                $query->andFilterWhere([
            'id' => $this->id,
            'author_id' => $this->author_id,
            'published_at' => $this->published_at,
            'created_at' => $this->created_at,
            'is_deleted' => $this->is_deleted,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
         
            ->andFilterWhere(['like', 'content', $this->content])
            ->andFilterWhere(['like', 'image_link', $this->image_link])
            ->andFilterWhere(['like', 'status', $this->status]);
        }
        return $dataProvider;
    }
}
