<?php

namespace Ceven\ExtraStepsEOP\Setup\Patch\Data;

use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Email\Model\ResourceModel\Template as EmailTemplateResource;
use Magento\Email\Model\TemplateFactory;
use Magento\Framework\Module\Dir\Reader as ModuleReader;

class SetupEmailTemplate implements DataPatchInterface
{
    private $moduleDataSetup;
    private $templateFactory;
    private $emailTemplateResource;
    private $moduleReader;

    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        TemplateFactory $templateFactory,
        EmailTemplateResource $emailTemplateResource,
        ModuleReader $moduleReader
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->templateFactory = $templateFactory;
        $this->emailTemplateResource = $emailTemplateResource;
        $this->moduleReader = $moduleReader;
    }

    public function apply()
    {
        $this->moduleDataSetup->getConnection()->startSetup();

        $templateFilePath = $this->moduleReader->getModuleDir(
            \Magento\Framework\Module\Dir::MODULE_VIEW_DIR,
            'Ceven_ExtraStepsEOP'
        ) . '/frontend/email/order_pickedup.html';

        $template = $this->templateFactory->create();
        $template->setTemplateCode('Pedido Recogido')
            ->setTemplateText(file_get_contents($templateFilePath))
            ->setTemplateType(\Magento\Framework\App\TemplateTypesInterface::TYPE_HTML)
            ->setTemplateSubject('Tu pedido ha sido recogido en el punto de retiro.')
            ->setOrigTemplateCode('ceven_extrastepseop_order_pickedup_template')
            ->setOrigTemplateVariables('')
            ->setAddedAt((new \DateTime())->format(\Magento\Framework\Stdlib\DateTime::DATETIME_PHP_FORMAT))
            ->setModifiedAt((new \DateTime())->format(\Magento\Framework\Stdlib\DateTime::DATETIME_PHP_FORMAT));

        $this->emailTemplateResource->save($template);

        $this->moduleDataSetup->getConnection()->endSetup();
    }

    public static function getDependencies()
    {
        return [];
    }

    public function getAliases()
    {
        return [];
    }
}
