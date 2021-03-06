<?php

/**
 * UserChangePassword class.
 * UserChangePassword is the data structure for keeping
 * user change password form data. It is used by the 'changepassword' action of 'UserController'.
 */
class UserChangePassword extends CFormModel
{

    public $oldPassword, $password, $verifyPassword;

    public function rules()
    {
        return
            Yii::app()->controller->id == 'recovery' ?
            array(
                array('password, verifyPassword', 'required'),
                array('password, verifyPassword', 'length', 'max' => 128, 'min' => 4, 'message' => Yii::t('app', "Incorrect password (minimal length 4 symbols).")),
                array('verifyPassword', 'compare', 'compareAttribute' => 'password', 'message' => Yii::t('app', "Retype Password is incorrect.")),
            ) :
            array(
                array('oldPassword, password, verifyPassword', 'required'),
                array('oldPassword, password, verifyPassword', 'length', 'max' => 128, 'min' => 4, 'message' => Yii::t('app', "Incorrect password (minimal length 4 symbols).")),
                array('verifyPassword', 'compare', 'compareAttribute' => 'password', 'message' => Yii::t('app', "Retype Password is incorrect.")),
                array('oldPassword', 'verifyOldPassword'),
            );
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels()
    {
        return array(
            'oldPassword' => Yii::t('app', "Old Password"),
            'password' => Yii::t('app', "Password"),
            'verifyPassword' => Yii::t('app', "Retype Password"),
        );
    }

    /**
     * Verify Old Password
     */
    public function verifyOldPassword($attribute, $params)
    {
        $user = User::model()->notsafe()->findByPk(Yii::app()->user->id);
        if (!isset($user))
            $this->addError($attribute, Yii::t('app', "Your account doesn't exist."));
        elseif ($user->password != Yii::app()->getModule('user')->encrypting($this->$attribute))
            $this->addError($attribute, Yii::t('app', "Old Password is incorrect."));
    }

}
