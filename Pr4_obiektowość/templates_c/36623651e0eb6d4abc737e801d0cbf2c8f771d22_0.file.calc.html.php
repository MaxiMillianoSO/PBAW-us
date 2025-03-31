<?php
/* Smarty version 3.1.30, created on 2025-03-31 17:00:46
  from "D:\PBAW\htdocs\aplikacje\Pr4_obiektowosc\app\calc.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_67eaae1eba7d04_03792589',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '36623651e0eb6d4abc737e801d0cbf2c8f771d22' => 
    array (
      0 => 'D:\\PBAW\\htdocs\\aplikacje\\Pr4_obiektowosc\\app\\calc.html',
      1 => 1743432788,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:../templates/main.html' => 1,
  ),
),false)) {
function content_67eaae1eba7d04_03792589 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_95051713267eaae1eba6fd4_30433180', 'main');
$_smarty_tpl->inheritance->endChild();
$_smarty_tpl->_subTemplateRender("file:../templates/main.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 2, false);
}
/* {block 'main'} */
class Block_95051713267eaae1eba6fd4_30433180 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>


<section id="cta">
    <h2>Kalkulator</h2>

    <form>
        <div class="row gtr-50 gtr-uniform">
            <div class="col-6 col-12-mobilep">
				<label for="id_kw">Kwota kredytu: </label>
                <input id="id_kw" type="text" name="kw" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->kw;?>
" placeholder="Kwota:" /><br />
				 <label for="id_ok">Okres okredytowania (w latach): </label>
                <input id="id_ok" type="text" name="ok" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->ok;?>
" placeholder="Okres:" /><br />
				<label for="id_opr">Oprocentowanie (% rocznie): </label>
                <input id="id_opr" type="text" name="opr" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->opr;?>
" placeholder="Oprocentowanie:" /><br />
                <input type="submit" value="Oblicz" class="fit" />
		
            </div>

            <div class="col-6 col-12-mobilep">
                <section class="box special">
                    <?php if (isset($_smarty_tpl->tpl_vars['res']->value->result)) {?>
                        <h3 style="color: black">Wynik:</h3> 
                        <p class="res" style="color: black"><?php echo $_smarty_tpl->tpl_vars['res']->value->result;?>
</p>
                    <?php }?>

                    

                  
                        <?php if ($_smarty_tpl->tpl_vars['msgs']->value->isError()) {?> 
                            <h4 style="color: black">Wystąpiły błędy:</h4>
                            <ol class="err">
                                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['msgs']->value->getErrors(), 'err');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['err']->value) {
?>
                                    <li style="color: black; text-align: left; line-height: 1.2; margin-left: -30px;"><?php echo $_smarty_tpl->tpl_vars['err']->value;?>
</li>
                                <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

                            </ol>
                        <?php }?>
                   
                </section>
            </div>
        </div>
    </form>
</section>

<?php
}
}
/* {/block 'main'} */
}
