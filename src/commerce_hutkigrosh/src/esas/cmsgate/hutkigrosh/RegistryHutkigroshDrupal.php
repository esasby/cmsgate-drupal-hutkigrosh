<?php
/**
 * Created by PhpStorm.
 * User: nikit
 * Date: 01.10.2018
 * Time: 12:05
 */

namespace esas\cmsgate\hutkigrosh;

use Drupal\Core\Url;
use esas\cmsgate\CmsConnectorDrupal;
use esas\cmsgate\descriptors\ModuleDescriptor;
use esas\cmsgate\descriptors\VendorDescriptor;
use esas\cmsgate\descriptors\VersionDescriptor;
use esas\cmsgate\hutkigrosh\view\client\CompletionPanelHutkigroshDrupal;
use esas\cmsgate\view\admin\AdminViewFields;
use esas\cmsgate\view\admin\ConfigFormDrupal;

class RegistryHutkigroshDrupal extends RegistryHutkigrosh
{
    public function __construct()
    {
        $this->cmsConnector = new CmsConnectorDrupal();
        $this->paysystemConnector = new PaysystemConnectorHutkigrosh();
    }


    /**
     * Переопределение для упрощения типизации
     * @return RegistryHutkigroshDrupal
     */
    public static function getRegistry()
    {
        return parent::getRegistry();
    }

    /**
     * @throws \Exception
     */
    public function createConfigForm()
    {
        $managedFields = $this->getManagedFieldsFactory()->getManagedFieldsExcept(AdminViewFields::CONFIG_FORM_COMMON,
            [
                ConfigFieldsHutkigrosh::shopName(),
                ConfigFieldsHutkigrosh::paymentMethodName(),
                ConfigFieldsHutkigrosh::paymentMethodNameWebpay(),
                ConfigFieldsHutkigrosh::paymentMethodDetails(),
                ConfigFieldsHutkigrosh::paymentMethodDetailsWebpay(),
                ConfigFieldsHutkigrosh::sandbox() //managed by drupal
            ]);
        $configForm = new ConfigFormDrupal(
            AdminViewFields::CONFIG_FORM_COMMON,
            $managedFields);
        $configForm->addPhoneFieldNameIfPresent();
        return $configForm;
    }


    function getUrlAlfaclick($orderWrapper)
    {
        return Url::fromRoute('commerce_hutkigrosh.alfaclick', [], ['absolute' => TRUE])->toString();
    }


    function getUrlWebpay($orderWrapper)
    {
        return Url::fromRoute('<current>', [], ['absolute' => TRUE])->toString();
    }

    public function createModuleDescriptor()
    {
        return new ModuleDescriptor(
            "commerce_hutkigrosh", // код должен совпадать с кодом решения в маркете (@id в Plugin\Commerce\PaymentGateway\xxx.php)
            new VersionDescriptor("2.15.0", "2021-12-23"),
            "Прием платежей через ЕРИП (сервис Hutkigrosh)",
            "https://bitbucket.org/esasby/cmsgate-drupal-hutkigrosh/src/master/",
            VendorDescriptor::esas(),
            "Выставление пользовательских счетов в ЕРИП"
        );
    }

    public function getCompletionPanel($orderWrapper)
    {
        return new CompletionPanelHutkigroshDrupal($orderWrapper);
    }


}