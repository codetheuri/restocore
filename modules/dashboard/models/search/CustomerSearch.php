<?php

namespace dashboard\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use iam\models\User;

/**
 * CustomerSearch represents the model behind the search form of `iam\models\User` for customers.
 */
class CustomerSearch extends User
{
    public $full_name;
    public $email_address;
    public $mobile_number;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'status'], 'integer'],
            [['username', 'full_name', 'email_address', 'mobile_number'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
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
        $auth = Yii::$app->authManager;
        $customerIds = $auth->getUserIdsByRole('customer');

        $query = User::find()
            ->innerJoinWith('profile')
            ->where(['{{%users}}.user_id' => $customerIds])
            ->andWhere(['{{%users}}.is_deleted' => 0]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['created_at' => SORT_DESC]],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['or', 
                ['like', 'profiles.first_name', $this->full_name],
                ['like', 'profiles.last_name', $this->full_name],
            ])
            ->andFilterWhere(['like', 'profiles.email_address', $this->email_address])
            ->andFilterWhere(['like', 'profiles.mobile_number', $this->mobile_number]);

        return $dataProvider;
    }
}
