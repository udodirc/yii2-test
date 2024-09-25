<?php

namespace app\modules\api\service;

use app\models\Patient;
use app\models\User;
use app\modules\api\forms\CreatePatientForm;
use app\modules\api\forms\PatientForm;
use app\modules\api\mappers\ServicePatientMapper;
use Exception;
use Yii;
use yii\base\Model;

class PatientService
{
    /**
     * @throws Exception
     */
    public function all(array $params, int $limit = 10): array
    {
        $form = new PatientForm();
        $this->validate($params, $form);
        $query = Patient::find()->with(["status", "polyclinic", "treatment", "formDisease", "updatedBy"])
            ->orderBy(
                [
                    'id' => SORT_DESC
                ]
            );
        $query->andFilterWhere([
            'polyclinic_id' => $form->polyclinic_id,
            'status_id' => $form->status_id,
            'form_disease_id' => $form->form_disease_id,
            'treatment_id' => $form->treatment_id,
        ]);
        $query->andFilterWhere(['like', 'name', $form->name])
            ->andFilterWhere(['like', 'phone', $form->phone]);
        $patients = $query->limit($limit)
            ->all();

        return ServicePatientMapper::mapAll($patients);
    }

    /**
     * @throws Exception
     */
    public function create(array $params)
    {
        $form = new CreatePatientForm();
        $model = new Patient();
        $user = User::findOne(Yii::$app->user->id);

        $this->validate($params, $form);
        $model->setAttributes($params);

//        if (!Yii::$app->user->isSuperadmin) {
//            $model->polyclinic_id = $user->polyclinic_id;
//        }

        $model->created_by = \Yii::$app->user->id;
        $model->updated_by = \Yii::$app->user->id;
        $model->birthday = $form->birthday ? date("Y-m-d", strtotime($form->birthday)) : null;
        $model->diagnosis_date = $form->diagnosis_date ? date("Y-m-d", strtotime($form->diagnosis_date)) : null;
        $model->recovery_date = $form->recovery_date ? date("Y-m-d", strtotime($form->recovery_date)) : null;
        $model->analysis_date = $form->analysis_date ? date("Y-m-d", strtotime($form->analysis_date)) : null;

        $model->save(false);

        return $model->attributes;

    }

    /**
     * @throws Exception
     */
    private function validate(array $params, Model $form): void
    {
        if ($form->load($params) === false) {
            throw new Exception('Параметры не загружены');
        }

        if ($form->validate() === false) {
            $errors = $form->getFirstErrors();
            throw new Exception(array_shift($errors));
        }
    }
}