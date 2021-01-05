{extends file='page.tpl'}
 
{block name="page_content"}
    <br/>
    <br/>
    <!-- Début étape -->
    <div class="row text-sm-center">
        <div class="col-md-2"><p><a href="https://agissez-pour-vos-droits.fr/module/up_orderprocess/display"> ETAPE 1 </a></p></div>
        <div class="col-md-2"><h3> ETAPE 2 </h3></div>
        <div class="col-md-2"><p> ETAPE 3 </p></div>
        <div class="col-md-2"><p> ETAPE 4 </p></div>
        <div class="col-md-2"><p> ETAPE 5 </p></div>
        <div class="col-md-2"><p> ETAPE 6 </p></div>
    </div>
    <!-- Fin étape -->
    <br/>
    {if isset($suite)}{$suite}{/if}
    <br/>
    <!-- Début formulaire -->
    <form action="" method="post" class="form-inline text-sm-center">
        <div class="form-group" id="produit">
            <label for="produit">Choisissez votre litige :</label>
            <select name="produit" class="form-control ml-1">
                <option value="0" {if $produit=="0"}selected{/if} disabled>Choisissez votre type de litige</option>
                {* Début listage automatique des catégories *}
                {foreach from=$selectList key=k item=v} 
                    {foreach from=$v key=k2 item=v2}
                        {if $k2=='id_product'}{assign var="id_product" value={$v2}}{/if}
                        {if $k2=='name'}{assign var="name" value={$v2}}{/if}
                    {/foreach}
                    <option value="{$id_product}" {if $produit=="{$id_product}"}selected{/if}>{$name}</option>
                {/foreach}
                {* Fin listage automatique des catégories *}
            </select>
            <input type="submit" name="step2" value="VALIDER" class="btn btn-primary" />
        </div>
    </form>
    <!-- Fin formulaire -->
    <br/>
    <br/>
    <br/>
 


{/block}