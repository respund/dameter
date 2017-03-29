<?php
namespace frontend\controllers;

use yii\web\Controller;
use yii;
/**
 * Site controller
 */
class SurveyController extends Controller
{

    public function getViewPath()
    {
        // TODO get template from settings
        $templateName='default';
        return Yii::getAlias('@frontend/templates/'.$templateName);
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     *
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index.twig',['username' => 'Alex']);
    }

}
