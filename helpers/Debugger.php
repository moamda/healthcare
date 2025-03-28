<?php

// Debugger.php

namespace app\helpers;

use yii\helpers\VarDumper;

class Debugger
{
  /**
   * Dump a variable as a string.
   *
   * @param mixed $var The variable to dump.
   * @return string The variable's contents as a string.
   */
  public static function dump($var)
  {

    $dumpString = VarDumper::dumpAsString($var);
    echo '<pre>' . $dumpString . '</pre>';
  }
}



?>
