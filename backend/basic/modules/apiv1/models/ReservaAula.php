<?php

namespace app\modules\apiv1\models;

class reservaaula extends \app\models\ReservaAula {

    public function fields()
    {
        return ['id', 'fh_desde', 'fh_hasta','observacion', 'aula'];
    }
}

