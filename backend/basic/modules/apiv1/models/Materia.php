<?php

namespace app\modules\apiv1\models;

class materia extends \app\models\Materia
{

    public function fields()
    {
        return ['id', 'nombre', 'cant_alumnos', 'profesor', 'carrera'];
    }
}
