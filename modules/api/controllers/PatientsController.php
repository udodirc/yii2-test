<?php

namespace app\modules\api\controllers;

use app\modules\api\service\PatientService;
use Yii;

class PatientsController extends ApiController
{
    private PatientService $patientService;

    public function __construct($id, $module, PatientService $patientService)
    {
        parent::__construct($id, $module);
        $this->patientService = $patientService;
    }

    public function actionIndex(): array
    {
        $params = Yii::$app->request->get();

        return $this->patientService->all($params);
    }
}