<?php

    namespace app\models;

    use Yii;
    use yii\base\Model;

    /**
     * LoginForm is the model behind the login form.
     *
     * @property User|null $user This property is read-only.
     *
     */
    class LoginForm extends Model {
        public $username;
        public $rememberMe = true;

        /**
         * @return array the validation rules.
         */
        public function rules() {
            return [
                [['username'], 'required'],
                [['username'], 'trim'],
                [['username'], 'string', 'min' => 2, 'max' => 255],
                [
                    ['username'],
                    'match',
                    'pattern' => '#[a-z][a-z0-9_-]*[a-z0-9]#i',
                    'message' => 'Доступны только буквы цифры и _-',
                ],
                ['rememberMe', 'boolean'],
            ];
        }

        public function attributeLabels() {
            return [
                'username' => 'Никнейм',
            ];
        }

        /**
         * Logs in a user using the provided username and password.
         *
         * @return bool whether the user is logged in successfully
         */
        public function login() {
            if ($this->validate()) {
                return Yii::$app->user->login($this->getUser(),
                    $this->rememberMe ? 3600 * 24 * 30 : 0);
            }

            return false;
        }

        /**
         * @return User
         */
        private function getUser()
        {
            $user = User::findByUsername($this->username);
            if(null === $user) {
                $user = new User();
                $user->username = $this->username;
                $user->save();
            }
            return $user;
        }
    }
