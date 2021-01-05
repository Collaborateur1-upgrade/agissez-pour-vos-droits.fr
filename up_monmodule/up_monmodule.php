<?php
if (!defined('_PS_VERSION_')) {
    exit;
}
 
class Up_MonModule extends Module
{
    // On place notre constructeur
    public function __construct()
    {
        $this->name = 'up_monmodule'; // Nom du module // Identifiant interne qui doit porter le même nom que son dossier
        $this->tab = 'front_office_features'; // Onglet dans la liste des modules // Onglet auquel attaché ce module dans la liste des modules // https://devdocs.prestashop.com/1.7/modules/creation/#the-constructor-method
        $this->version = '1.0.0'; // Version du module // 1.0.0 par défaut
        $this->author = 'Nicolas MEUNIER - Agence Web Upgrade'; // Auteur du module // Nom et prénom de l'auteur et nom de l'entreprise
        $this->need_instance = 0; // Besoin d'instanciation dans la liste des module // Par exemple : pour afficher un avertissement sur la page des modules
        $this->ps_versions_compliancy = [ // Versions de prestashop compatible avec ce module // _PS_VERSION_ signifie version actuelle
            'min' => '1.7',
            'max' => _PS_VERSION_
        ];
        $this->bootstrap = true; // Utiliser Bootstrap pour ce module // oui ou non
    
        parent::__construct(); // Appeler le constructeur de la classe parente // Module e l'occurence afin d'exécuter la méthode constructeur de base
    
        $this->displayName = $this->l( 'Module de Nicolas MEUNIER' ); // Nom affiché dans la liste des modules
        $this->description = $this->l( 'Module d\'exemple et de test' ); // Description affiché dans la liste des modules
    
        $this->confirmUninstall = $this->l( 'Êtes-vous sûr de vouloir désinstaller ce module ?' ); // (optionnel) Message de confirmation à afficher lors de la désinstallation
    
        if ( !Configuration::get( 'UP_MONMODULE' ) ) { // Si le module n'a pas encore de valeur définie en base de données
            $this->warning = $this->l( 'Aucun nom fourni' ); // On génère un avertissement
        }
    }

    public function install()
    {
        if (Shop::isFeatureActive()) {
            Shop::setContext(Shop::CONTEXT_ALL);
        }
    
        if (!parent::install() ||
            !$this->registerHook('leftColumn') ||
            !$this->registerHook('header') ||
            !Configuration::updateValue('UP_MONMODULE_PAGENAME', 'Mentions légales')
        ) {
            return false;
        }
        return true;
    }

    public function uninstall() {
        if ( !parent::uninstall() || // Vérifie que la méthode uninstall retourne true
            !Configuration::deleteByName('UP_MONMODULE') // Vérifie la suppression de notre module en BDD
        ) {
            return false; // La désinstallation a échoué
        }
        return true; // La désinstallation a réussi
    }       
    
    public function getContent()
    {
        $output = null;
    
        if (Tools::isSubmit('btnSubmit')) { // Verifie si le formulaire a été envoyé (en fonction du nom du bouton de validation, ici appelé btnSubmit)
            // Si oui il gère les informations envoyées par le formulaire
            $pageName = strval(Tools::getValue('UP_MONMODULE_PAGENAME')); //On récupère la valeur de UP_MONMODULE_PAGENAME 
    
            if ( !$pageName || empty($pageName) ) { // On teste cette valeur en regardant si elle existe et si elle n’est pas vide
                $output .= $this->displayError($this->l('Invalid Configuration value')); // Si elle est n’est pas valide, on affiche une erreur à l’aide de la méthode displayError
            } else {
                // Sinon on met à jour la valeur avec Configuration::updateValue et ensuite on affiche une confirmation de modification avec displayConfirmation
                Configuration::updateValue('UP_MONMODULE_PAGENAME', $pageName);
                $output .= $this->displayConfirmation($this->l('Settings updated'));
            }
        }
    
        // sinon il affiche simplement le formulaire plus bas
        return $output.$this->displayForm(); // Pour terminer, on fait appel à la méthode displayForm (que nous allons créer par la suite) pour afficher le contenu du formulaire
    }

    public function displayForm()
    {
        // Récupère la langue par défaut
        $defaultLang = (int)Configuration::get('PS_LANG_DEFAULT');
    
        // Initialise les champs du formulaire dans un tableau
        $form = array(
            'form' => array(
                'legend' => array( // Titre
                    'title' => $this->l('Settings'),
                ),
                'input' => array( // Champs // Ceci crée automatiquement un champ de formulaire bien propre
                    array(
                        'type' => 'text',
                        'label' => $this->l('Configuration value'),
                        'name' => 'UP_MONMODULE_PAGENAME',
                        'size' => 20,
                        'required' => true
                    )
                ),
                'submit' => array( // Bouton de validation
                    'title' => $this->l('Save'),
                    'name'  => 'btnSubmit' // Ce nom correspond à la valeur que l'on verifie dans la méthode GetContent()
                )
            ),
        );
        
        $helper = new HelperForm(); // Creation d'un objet qui recevra les champs définis en paramètre lors de la génération.

        // Module, token et currentIndex
        $helper->module = $this; // Spécifie le module parent de ce formulaire
        $helper->name_controller = $this->name; // Renseigne le nom du controller, ici le nom du module
        $helper->token = Tools::getAdminTokenLite('AdminModules'); // Token unique spécifique à ce formulaire (pour éviter le code malicieux). Ce token est générée grâce à la méthode getAdminTokenLite fournie par Prestashop
        $helper->currentIndex = AdminController::$currentIndex.'&configure='.$this->name; // Indique la valeur de l’attribut action du formulaire, donc l’URL à laquelle soumettre le formulaire. Ici il s’agit du controller actuel avec en paramètre le nom de notre module en valeur de la clé configure. En gros, la page actuelle

        // Langue
        $helper->default_form_language = $defaultLang; // Défini la langue utilisée pour ce formulaire à la langue par défaut du shop récupérée plus haut

        // Charge la valeur de UP_MONMODULE_PAGENAME depuis la base
        $helper->fields_value['UP_MONMODULE_PAGENAME'] = Configuration::get('UP_MONMODULE_PAGENAME'); // Pour terminer, récupère la valeur actuelle de notre champ dans la base pour l’afficher

        // Génération du formulaire avec, en paramètre, la liste des champs à créer
        return $helper->generateForm(array($form));
    }

    public function hookDisplayLeftColumn($params)
    {
        $this->context->smarty->assign([ // Assignation de variable aux vues, elles seront utilisables dans les .tpl
            'up_page_name' => Configuration::get('UP_MONMODULE_PAGENAME'), // Récupère le champ dans la table ps_configuration tel que défini dans la configuration du module
            'up_page_link' => $this->context->link->getModuleLink('up_monmodule', 'display') // Récupére, dans le contexte actuel, un lien vers une action display de notre module up_monmodule. Nous la définirons plus loin
        ]);
    
        return $this->display(__FILE__, 'up_monmodule.tpl'); // S’occupe de récupérer le fichier de template up_monmodule.tpl utilisé pour afficher le contenu
    }

    public function hookDisplayHeader()
    {
        $this->context->controller->registerStylesheet(
            'up_monmodule',
            $this->_path.'views/css/up_monmodule.css',
            ['server' => 'remote', 'position' => 'head', 'priority' => 150]
        );
    }
}

