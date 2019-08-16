<?php

    namespace app\models;

    use Yii;
    use app\models\User;

    /**
     * This is the model class for table "transfer".
     *
     * @property int    $id
     * @property int    $id_user
     * @property string $username_recipient
     * @property int    $transfer_amount
     *
     * @property User   $user
     */
    class Transfer extends \yii\db\ActiveRecord {
        /**
         * {@inheritdoc}
         */
        public static function tableName() {
            return '{{%transfer}}';
        }

        /**
         * {@inheritdoc}
         */
        public function rules() {
            return [
                [['username_recipient', 'transfer_amount'], 'required'],
                [['id_user'], 'integer'],
                ['transfer_amount', 'number'],
                [
                    'transfer_amount',
                    'compare',
                    'compareValue' => 0,
                    'operator' => '>',
                    'message' => 'Вы не можете перевести отрицательную или нулевую сумму'
                ],
                [
                    ['transfer_amount'],
                    'match',
                    'pattern' => '/^(?=.*\d)\d*(?:\.\d{0,2})?$/',
                    'message' => 'Принимаются переводы, только до 2-го знака после точки!'
                ],
                [
                    ['transfer_amount'],
                    'validateTransferAmount'
                ],
                [['username_recipient'], 'string', 'min' => 2, 'max' => 255],
                [
                    ['username_recipient'],
                    'exist',
                    'skipOnError' => true,
                    'targetClass' => User::class,
                    'targetAttribute' => ['username_recipient' => 'username']
                ],
                [
                    ['username_recipient'],
                    'validateUser'
                ],
            ];
        }

        /**
         * @param $attribute
         */
        public function validateTransferAmount($attribute) {
            $user = User::findOne(['id' => Yii::$app->user->id]);
            if (($user->balance - $this->transfer_amount) <= -1000) {
                $this->addError($attribute,
                    'Не достаточно средств, для перевода');
            }
        }

        /**
         * @param $attribute
         */
        public function validateUser($attribute) {
            $user = User::findOne(['id' => Yii::$app->user->id]);
            if ($this->username_recipient == $user->username) {
                $this->addError($attribute,
                    'Отправка самому себе не возможна');
            }
        }

        /**
         * {@inheritdoc}
         */
        public function attributeLabels() {
            return [
                'id' => 'ID',
                'id_user' => 'ID переводчика',
                'username_recipient' => 'Имя получателя',
                'transfer_amount' => 'Сумма перевода',
            ];
        }

        /**
         * @return \yii\db\ActiveQuery
         */
        public function getUser() {
            return $this->hasOne(User::class, ['id' => 'id_user']);
        }

        /**
         * @param bool $insert
         *
         * @return bool
         */
        public function beforeSave($insert) {
            if (parent::beforeSave($insert)) {
                $this->id_user = Yii::$app->user->id;
                $this->transferUser();

                return true;
            } else {
                return false;
            }
        }

        public function transferUser() {
            $user = $this->user;
            $user->balance -= $this->transfer_amount;
            $user->save();

            $user_recipient
                = User::findOne(['username' => $this->username_recipient]);
            $user_recipient->balance += $this->transfer_amount;
            $user_recipient->save();

        }
    }
