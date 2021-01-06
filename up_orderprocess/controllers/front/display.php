<?php

class up_orderprocessdisplayModuleFrontController extends ModuleFrontController
{
    public function initContent()
    {
        parent::initContent();

        // Etape 3
        if (isset($_POST['step2'], $_POST['prestation']) && $_POST['prestation'] != 0){ // Si le deuxieme formulaire est envoyé

            print_r($_POST['prestation']);
            $category = new Category($_POST['prestation']);
            $categoryName = $category->getName($this->context->language->id);
            print_r($categoryName);
            print_r($_POST['produit']);


//            Code pour ajouter au panier, à utiliser avec la déclinaison trouvée grâce à id_produit (step1) et nom_déclinaison == nom_catégorie (step2) avec id_lang
//            // On ajoute le produit au panier
//            $Cart = $this->context->cart;
//            $Cart->updateQty(1, $_POST['produit']);

            // Tools::redirect('https://agissez-pour-vos-droits.fr/commande'); // Redirection sur le tunnel classique de Prestashop

            // Etape 2
        }if (isset($_POST['step1'], $_POST['produit']) && $_POST['produit'] != 0){ // Si le premier formulaire est envoyé
        $this->setTemplate('module:up_orderprocess/views/templates/front/displaystep2.tpl');

        print_r($_POST['produit']);

        // debug :
        // $this->context->smarty->assign('suite', 'ok'); => mettre {$suite} dans .tpl

        // Listage des catégories
        $selectList = Category::getHomeCategories($this->context->language->id);
        $this->context->smarty->assign('selectList', $selectList);

        // Assigner une valeur de base au select
        $this->context->smarty->assign(
            array(
                'prestation' => '0',
                'produit' => '$_POST["produit"]'
            )
        );

        // Etape 1
    }else{ // Si le premier formulaire n'est pas envoyé
        $this->setTemplate('module:up_orderprocess/views/templates/front/displaystep1.tpl');

        // Listage des produits
        $selectList = Product::getSimpleProducts($this->context->language->id);
        $this->context->smarty->assign('selectList', $selectList);

        // Assigner une valeur de base au select
        $this->context->smarty->assign(
            array(
                'produit' => '0'
            )
        );
    }
    }
}