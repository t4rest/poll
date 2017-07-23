<?php

namespace backend\modules\country\api;

use common\models\Country as CountryModel;


class Country
{
    /**
     * @return array
     */
    public function country()
    {
        return CountryModel::find()
//            ->select(["iso", "nicename", "iso3", "numcode", "phonecode"])
            ->asArray()
            ->all();
    }
}