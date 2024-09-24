<?php

namespace app\modules\api\service;

use app\models\Patient;
use app\modules\api\forms\PatientForm;
use app\modules\api\mappers\ServicePatientMapper;
use app\modules\service\mappers\ServiceModificationMapper;
use Exception;
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