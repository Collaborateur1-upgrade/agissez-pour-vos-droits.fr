{extends file='page.tpl'}
 
{block name="page_content"}
    <br/>
    <br/>
    <!-- Début étape -->
    <div class="row text-sm-center">
        <div class="col-md-2"><h3> ETAPE 1 </h3></div>
        <div class="col-md-2"><p> ETAPE 2 </p></div>
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
        <div class="form-group" id="prestation">
            <label for="prestation">Choisissez votre démarche :</label>
            <select name="prestation" class="form-control ml-1" id="prestation">
                <option value="0" {if $prestation=="0"}selected{/if} disabled>Choisissez votre prestation</option>
                {* Début listage automatique des catégories *}
                {foreach from=$selectList key=k item=v} 
                    {foreach from=$v key=k2 item=v2}
                        {if $k2=='id_category'}{assign var="id_category" value={$v2}}{/if}
                        {if $k2=='name'}{assign var="name" value={$v2}}{/if}
                    {/foreach}
                    <option value="{$id_category}" {if $prestation=="{$id_category}"}selected{/if}>{$name}</option>
                {/foreach}
                {* Fin listage automatique des catégories *}
            </select>
            <input type="submit" name="step1" value="VALIDER" class="btn btn-primary" />
        </div>
    </form>
    <!-- Fin formulaire -->
    <br/>
    <br/>
    <br/>
 


{/block}