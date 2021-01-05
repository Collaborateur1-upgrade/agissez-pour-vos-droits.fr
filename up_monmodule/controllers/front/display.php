<?php

class up_monmoduledisplayModuleFrontController extends ModuleFrontController
{
    public function initContent()
    {
        parent::initContent();
        $this->setTemplate('module:up_monmodule/views/templates/front/display.tpl');
    }
}