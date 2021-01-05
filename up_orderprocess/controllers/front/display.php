<?php

class up_orderprocessdisplayModuleFrontController extends ModuleFrontController
{
    public function initContent()
    {
        parent::initContent();
        
        // Verification du premier formulaire
        if (isset($_POST['step2'], $_POST['prestation']) && $_POST['prestation'] != 0){ // Si le deuxieme formulaire est envoyé
            $this->setTemplate('module:up_orderprocess/views/templates/front/displaystep2.tpl');

            // Listage des produits
            $selectList = Product::getSimpleProducts($this->context->language->id);
            $this->context->smarty->assign('selectList', $selectList);

            // Définition de la valeur séléctionné
            $this->context->smarty->assign(
                array(
                    'produit' => '0'
                )
            );
        }if (isset($_POST['step1'], $_POST['produit']) && $_POST['produit'] != 0){ // Si le premier formulaire est envoyé
            $this->setTemplate('module:up_orderprocess/views/templates/front/displaystep1.tpl');

            $this->context->smarty->assign('suite', 'ok');

            // Listage des produits
           $selectList = Product::getSimpleProducts($this->context->language->id);
            $this->context->smarty->assign('selectList', $selectList);

            // Définition de la valeur séléctionné
            $this->context->smarty->assign(
                array(
                'produit' => '0'
                )
            );

            $Cart = $this->context->cart;
            $Cart->updateQty(1, $_POST['produit']);

            Tools::redirect('https://agissez-pour-vos-droits.fr/commande');
        }else{ // Si le premier formulaire n'est pas envoyé
            $this->setTemplate('module:up_orderprocess/views/templates/front/display.tpl');

            // Listage des catégories
            $selectList = Category::getHomeCategories($this->context->language->id);
            $this->context->smarty->assign('selectList', $selectList);
            
            $this->context->smarty->assign(
                array(
                'prestation' => '0'
                )
            );
        }
    }
}