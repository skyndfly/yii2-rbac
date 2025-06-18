<?php

namespace app\widgets\form;

use yii\base\Model;

class AuthItemCreateForm extends Model
{
    public string $name = '';
    public $type;
    public string $description = '';


    public function rules(): array
    {
        return [
            [['name', 'type', 'description'], 'required'],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'name' => 'Имя',
            'type' => 'Тип',
            'description' => 'Описание'
        ];
    }


}
