<?php

namespace app\modules\api\controllers;

use app\modules\api\exceptions\InfoException;
use Yii;
use yii\helpers\ArrayHelper;
use yii\rest\Controller;
use yii\web\Response;

class ApiController extends Controller
{
    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            [
                'class' => 'yii\filters\ContentNegotiator',
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                ],
            ]
        ]);
    }

    public function init()
    {
        parent::init();

        Yii::$app->response->on(Response::EVENT_BEFORE_SEND, function ($event) {
            /** @var Response $response */
            $response = $event->sender;

            if (!$response->isSuccessful) {

                /** @var InfoException $exception */
                $exception = Yii::$app->getErrorHandler()->exception;

                if (is_a($exception, InfoException::class)) {
                    $response->data = [
                        'message' => $exception->getMessage(),
                        'code' => $response->statusCode,
                    ];
                }
            }

            if ($response->data !== null) {
                if ($response->isSuccessful) {
                    $data = $response->data;
                } else {
                    $data = [
                        'message' => $response->data['message'],
                        'code' => $response->data['code'],
                    ];
                }

                $response->data = [
                    'success' => $response->isSuccessful,
                    'data' => $data,
                ];
                $response->statusCode = 200;
            }
        });
    }
}
