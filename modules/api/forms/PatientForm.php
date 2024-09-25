<?php

namespace app\modules\api\forms;

use yii\base\Model;

/**
 * This is the model class for table "patients".
 *
 * @property int $id
 * @property string $name
 * @property string|null $phone
 * @property int|null $polyclinic_id
 * @property int|null $treatment_id
 * @property int|null $status_id
 * @property int|null $form_disease_id
 * */
class PatientForm extends Model
{
    public string $name = '';
    public string $phone = '';
    public int $polyclinic_id = 0;
    public int $status_id = 0;
    public int $treatment_id = 0;
    public int $form_disease_id = 0;

    public function rules(): array
    {
        return [
            [['polyclinic_id', 'treatment_id', 'status_id', 'form_disease_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['phone'], 'string', 'max' => 50],
        ];
    }

    public function formName(): string
    {
        return '';
    }

    public function attributeLabels(): array
    {
        return [
            'name' => 'Name',
        ];
    }
}