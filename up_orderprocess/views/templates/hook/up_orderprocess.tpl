<!-- Block up_orderprocess -->
<div id="up_orderprocess_block_home" class="block"> 
  <h4>{l s='Formulaire créé par Upgrade' d='Modules.Up_OrderProcess'}</h4> <!-- utilise la méthode de traduction l() en recherchant la traduction dans le contexte créé pour notre module, à savoir Modules.Up_OrderProcess, pour la clé New Slang Link -->
  <div class="block_content">
    <a href="{$up_page_link}"> <!-- affiche simplement la variable assignée depuis la méthode hookDisplayLeftColumn plus haut -->
            <!-- affiche la variable up_page_name si elle est définie, sinon un texte par défaut -->
           {if isset($up_page_name) && up_page_name}
               {$up_page_name}
           {else}
               Votre lien
           {/if}
    </a>
    <br/>
    <br/>
  </div>
</div>
<!-- /Block up_orderprocess -->