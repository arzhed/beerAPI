<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;

trait ValidatorTrait {
    protected function checkMandatoryParams(array $params, Request $request)
    {
        foreach ($params as $value) {
            if (empty($request->request->get($value))) {
                return $value;
            }
        }

        return true;
    }
}
