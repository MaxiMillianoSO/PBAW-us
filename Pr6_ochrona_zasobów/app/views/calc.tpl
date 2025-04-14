{extends file="main.tpl"}

{block name=main}

<section id="cta">
    <h2>Kalkulator</h2>

    <form action="{$conf->action_url}calcCompute" method="post">
	
        <div class="row gtr-50 gtr-uniform">
            <div class="col-6 col-12-mobilep">
				<label for="id_kw">Kwota kredytu: </label>
                <input id="id_kw" type="text" name="kw" value="{$form->kw}" placeholder="Kwota:" /><br />
				 <label for="id_ok">Okres okredytowania (w latach): </label>
                <input id="id_ok" type="text" name="ok" value="{$form->ok}" placeholder="Okres:" /><br />
				<label for="id_opr">Oprocentowanie (% rocznie): </label>
                <input id="id_opr" type="text" name="opr" value="{$form->opr}" placeholder="Oprocentowanie:" /><br />
                <input type="submit" value="Oblicz" class="fit" />
		
            </div>

            <div class="col-6 col-12-mobilep">
                <section class="box special">
                    {if isset($res->result)}
                        <h3 style="color: black">Wynik:</h3> 
                        <p class="res" style="color: black">{$res->result}</p>
                    {/if}

                    

                  
                        {if $msgs->isError()} 
                            <h4 style="color: black">Wystąpiły błędy:</h4>
                            <ol class="err">
                                {foreach $msgs->getErrors() as $err}
                                    {strip}
									<li style="color: black; text-align: left; line-height: 1.2; margin-left: -30px;">{$err}</li>
                                    {/strip}
                                {/foreach}
                            </ol>
                        {/if}
                   
                </section>
            </div>
        </div>
    </form>
</section>

{/block}