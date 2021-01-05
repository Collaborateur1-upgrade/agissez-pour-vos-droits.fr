<?php
if (!defined('_PS_VERSION_')) {
    exit;
}
 
class Up_OrderProcess extends Module
{
    // On place notre constructeur
    public function __construct()
    {
        $this->name = 'up_orderprocess'; // Nom du module // Identifiant interne qui doit porter le même nom que son dossier
        $this->tab = 'front_office_features'; // Onglet dans la liste des modules // Onglet auquel attaché ce module dans la liste des modules // https://devdocs.prestashop.com/1.7/modules/creation/#the-constructor-method
        $this->version = '1.0.0'; // Version du module // 1.0.0 par défaut
        $this->author = 'Agence Web Upgrade'; // Auteur du module // Nom et prénom de l'auteur et nom de l'entreprise
        $this->need_instance = 0; // Besoin d'instanciation dans la liste des module // Par exemple : pour afficher un avertissement sur la page des modules
        $this->ps_versions_compliancy = [ // Versions de prestashop compatible avec ce module // _PS_VERSION_ signifie version actuelle
            'min' => '1.7',
            'max' => _PS_VERSION_
        ];
        $this->bootstrap = true; // Utiliser Bootstrap pour ce module // oui ou non
    
        parent::__construct(); // Appeler le constructeur de la classe parente // Module e l'occurence afin d'exécuter la méthode constructeur de base
    
        $this->displayName = $this->l( 'Processus de commande personnalisé' ); // Nom affiché dans la liste des modules
        $this->description = $this->l( 'Le processus de commande classique de Prestashop est modifié par ce module' ); // Description affiché dans la liste des modules
    
        $this->confirmUninstall = $this->l( 'Êtes-vous sûr de vouloir désinstaller ce module ?' ); // (optionnel) Message de confirmation à afficher lors de la désinstallation
    
        if ( !Configuration::get( 'UP_ORDERPROCESS' ) ) { // Si le module n'a pas encore de valeur définie en base de données
            $this->warning = $this->l( 'Aucun nom fourni' ); // On génère un avertissement
        }
    }

    public function install()
    {
        if (Shop::isFeatureActive()) {
            Shop::setContext(Shop::CONTEXT_ALL);
        }
    
        if (!parent::install() ||
            !$this->registerHook('displayHome')
        ) {
            return false;
        }
        return true;
    }

    public function uninstall() {
        if ( !parent::uninstall() || // Vérifie que la méthode uninstall retourne true
            !Configuration::deleteByName('UP_ORDERPROCESS') // Vérifie la suppression de notre module en BDD
        ) {
            return false; // La désinstallation a échoué
        }
        return true; // La désinstallation a réussi
    }       

    public function hookDisplayHome($params)
    {
        $this->context->smarty->assign([ // Assignation de variable aux vues, elles seront utilisables dans les .tpl
            'up_page_name' => 'Formulaire de passation de commande',
            'up_page_link' => $this->context->link->getModuleLink('up_orderprocess', 'display') // Récupére, dans le contexte actuel, un lien vers une action display de notre module up_orderprocess. Nous la définirons plus loin
        ]);
    
        return $this->display(__FILE__, 'up_orderprocess.tpl'); // S’occupe de récupérer le fichier de template up_orderprocess.tpl utilisé pour afficher le contenu
    }
}

