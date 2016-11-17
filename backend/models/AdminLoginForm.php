<?php
namespace backend\models;

use Yii;
use yii\base\Model;
use yii\helpers\VarDumper;

/**
 * Login form
 */
class AdminLoginForm extends Model
{
    public $username;
    public $password;
    public $rememberMe = true;

    private $_admin;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'password'], 'required'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            /**
             * username: bwoiladmin
             * password: bwoil123456
             * password_hash:$2y$13$WtQTCHFQh5dWvi.4U8z.eu4ss9ET98Pe9wAQ8t36n8U2UZCXaqaSS
             *
             */

            $admin = $this->getAdmin();
            if (!$admin || !$admin->validatePassword($this->password)) {
                $this->addError($attribute, 'Incorrect username or password.');
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.35Ol5f7ihd#6
     *
     * @return bool whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getAdmin(), $this->rememberMe ? 3600 * 24 * 30 : 0);
        } else {
            return false;
        }
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    protected function getAdmin()
    {
        if ($this->_admin === null) {
            $this->_admin = Admin::find()->where(['username' => $this->username])->one();
        }

        return $this->_admin;
    }
}
