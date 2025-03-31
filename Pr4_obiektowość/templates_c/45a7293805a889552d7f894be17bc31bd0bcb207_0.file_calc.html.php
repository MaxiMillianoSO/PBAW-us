<?php
/* Smarty version 5.4.2, created on 2025-03-31 16:53:10
  from 'file:D:\PBAW\htdocs\aplikacje\Pr4_obiektowosc/app/calc.html' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.4.2',
  'unifunc' => 'content_67eaac563ecc15_29774040',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '45a7293805a889552d7f894be17bc31bd0bcb207' => 
    array (
      0 => 'D:\\PBAW\\htdocs\\aplikacje\\Pr4_obiektowosc/app/calc.html',
      1 => 1743432788,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_67eaac563ecc15_29774040 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'D:\\PBAW\\htdocs\\aplikacje\\Pr4_obiektowosc\\app';
$_smarty_tpl->getInheritance()->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->getInheritance()->instanceBlock($_smarty_tpl, 'Block_139342516067eaac563df2a4_51453865', 'main');
$_smarty_tpl->getInheritance()->endChild($_smarty_tpl, "../templates/main.html", $_smarty_current_dir);
}
/* {block 'main'} */
class Block_139342516067eaac563df2a4_51453865 extends \Smarty\Runtime\Block
{
public function callBlock(\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'D:\\PBAW\\htdocs\\aplikacje\\Pr4_obiektowosc\\app';
?>


<section id="cta">
    <h2>Kalkulator</h2>

    <form>
        <div class="row gtr-50 gtr-uniform">
            <div class="col-6 col-12-mobilep">
				<label for="id_kw">Kwota kredytu: </label>
                <input id="id_kw" type="text" name="kw" value="<?php echo $_smarty_tpl->getValue('form')->kw;?>
" placeholder="Kwota:" /><br />
				 <label for="id_ok">Okres okredytowania (w latach): </label>
                <input id="id_ok" type="text" name="ok" value="<?php echo $_smarty_tpl->getValue('form')->ok;?>
" placeholder="Okres:" /><br />
				<label for="id_opr">Oprocentowanie (% rocznie): </label>
                <input id="id_opr" type="text" name="opr" value="<?php echo $_smarty_tpl->getValue('form')->opr;?>
" placeholder="Oprocentowanie:" /><br />
                <input type="submit" value="Oblicz" class="fit" />
		
            </div>

            <div class="col-6 col-12-mobilep">
                <section class="box special">
                    <?php if ((null !== ($_smarty_tpl->getValue('res')->result ?? null))) {?>
                        <h3 style="color: black">Wynik:</h3> 
                        <p class="res" style="color: black"><?php echo $_smarty_tpl->getValue('res')->result;?>
</p>
                    <?php }?>

                    

                  
                        <?php if ($_smarty_tpl->getValue('msgs')->isError()) {?> 
                            <h4 style="color: black">Wystąpiły błędy:</h4>
                            <ol class="err">
                                <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('msgs')->getErrors(), 'err');
$foreach0DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('err')->value) {
$foreach0DoElse = false;
?>
                                    <li style="color: black; text-align: left; line-height: 1.2; margin-left: -30px;"><?php echo $_smarty_tpl->getValue('err');?>
</li>
                                <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
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
