<?php

namespace app\modules\api\controllers;

use app\models\Patient;
use app\models\User;
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

    /**
     * @throws \Exception
     */
    public function actionIndex(): array
    {
        $params = Yii::$app->request->get();

        return $this->patientService->all($params);
    }

    public function actionCreate(): array
    {
        $params = $this->post();
        return $this->patientService->create($params);
    }
}