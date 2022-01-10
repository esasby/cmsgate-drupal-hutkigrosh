<?php

namespace Drupal\commerce_hutkigrosh\Controller;

require_once(dirname(dirname(__FILE__)) . '/init.php');

use esas\cmsgate\hutkigrosh\controllers\ControllerHutkigroshAlfaclick;
use esas\cmsgate\hutkigrosh\controllers\ControllerHutkigroshNotify;
use esas\cmsgate\utils\Logger;
use Exception;
use Throwable;

class HutkigroshController
{
    public function alfaclick()
    {
        try {
            $controller = new ControllerHutkigroshAlfaclick();
            $controller->process();
        } catch (Throwable $e) {
            Logger::getLogger("alfaclick")->error("Exception: ", $e);
        } catch (Exception $e) { // для совместимости с php 5
            Logger::getLogger("alfaclick")->error("Exception: ", $e);
        }
    }

    public function notify()
    {
        try {
            $controller = new ControllerHutkigroshNotify();
            $controller->process();
        } catch (Throwable $e) {
            Logger::getLogger("notify")->error("Exception:", $e);
        } catch (Exception $e) { // для совместимости с php 5
            Logger::getLogger("notify")->error("Exception:", $e);
        }
    }
}