<?php

    use app\models\User;
    use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SearchTransfer */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'История переводов';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="transfer-index">

    <h1><?= Html::encode($this->title.': '.User::findOne(['id' => Yii::$app->user->id])->username) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'username_recipient',
            'transfer_amount',
        ],
    ]); ?>


</div>
