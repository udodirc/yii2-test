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
 * @property string|null $created
 * @property int|null $created_by
 * @property string|null $updated
 * @property int|null $updated_by
 * @property string|null $diagnosis_date
 * @property string|null $recovery_date
 * @property string|null $analysis_date
 * @property int|null $source_id
 * */
class CreatePatientForm extends \yii\db\ActiveRecord
{
    public string $name = '';
    public string $phone = '';
    public string $address = '';
    public ?string $birthday = '';
    public ?string $diagnosis_date = '';
    public ?string $recovery_date = '';
    public ?string $analysis_date = '';
    public ?int $polyclinic_id = 0;
    public int $status_id = 0;
    public int $treatment_id = 0;
    public int $form_disease_id = 0;
    public ?int $created_by = 0;
    public ?int $updated_by = 0;
    public int $source_id = 0;

    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'patients';
    }

    public function rules(): array
    {
        return [
            [['birthday', 'created', 'updated', 'diagnosis_date', 'recovery_date', 'analysis_date'], 'safe'],
            [['polyclinic_id', 'treatment_id', 'status_id', 'form_disease_id', 'created_by', 'updated_by', 'source_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['phone'], 'string', 'max' => 50],
            [['birthday'], 'string', 'max' => 20],
            [['address'], 'string', 'max' => 512],
        ];
    }

    public function formName(): string
    {
        return '';
    }
}