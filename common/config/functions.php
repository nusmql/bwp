<?php

/**
 * Debug function
 * d($var);
 */
function d($var)
{
    return yii\helpers\BaseVarDumper::dump($var, 10, true);
}