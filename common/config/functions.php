<?php

/**
 * Debug function
 * d($var);
 */
function d($var)
{
    echo '<pre>';
    yii\helpers\VarDumper::dump($var, 10, true);
    echo '</pre>';
}

/**
 * Debug function with die() after
 * dd($var);
 */
function dd($var)
{
    d($var);
    die();
} 

function validateDate($date, $format = 'Y-m-d H:i:s')
{
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) == $date;
}

function months() {
    $months = [];
    for ($i = 1; $i <= 12 ; $i++) { 
        $months[$i] = date('F', mktime(0, 0, 0, $i, 10));
    }
    return $months;
}

function monthsRoman($month)
{
    $romans = ['I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'];
    return $romans[date($month)-1];
}


function uploadFile($model, $field, $uploadedFile)
{
    $filename  = $model->id .'.'. $uploadedFile->extension;
    $directory = Yii::getAlias(Yii::$app->params['fileStorage'].$model->tableName().'/'.$field);

    if (!file_exists($directory)) mkdir($directory, 0777, true);
    if ($uploadedFile->saveAs($directory.'/'.$filename)) {
        $model->$field = $uploadedFile->name;
        if ($model->save()) return true;
    }
    return false;
}


function downloadFile($model, $field, $filename = null)
{
    if ($model->$field) {
        // $array     = explode('.', $model->$field);
        // $extension = end($array);
        $extension = pathinfo($model->$field, PATHINFO_EXTENSION);
        $filepath  = Yii::getAlias(Yii::$app->params['fileStorage'] . $model->tableName().'/'.$field.'/'.$model->id.'.'.$extension);
        $filename  = $filename ? $filename.'.'. $extension : $model->$field;
        if (file_exists($filepath)) {
            return Yii::$app->response->sendFile($filepath, $filename, ['inline' => true]);
        }
    }
    // return Yii::$app->response->redirect(Yii::$app->request->referrer);
}