<?php /* Smarty version Smarty-3.0.8, created on 2011-07-24 04:22:20
         compiled from "/usr/local/cmdb/www//noc/lib/templates/events.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1621792734e2b81dcaf6878-19010928%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd62edd423045434a1361b2a38bf6a5a5f0a17daa' => 
    array (
      0 => '/usr/local/cmdb/www//noc/lib/templates/events.tpl',
      1 => 1311474138,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1621792734e2b81dcaf6878-19010928',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php while ($_smarty_tpl->getVariable('event')->value->next()){?>
 <?php echo $_smarty_tpl->getVariable('event')->value->id;?>
 <?php echo $_smarty_tpl->getVariable('event')->value->host->name;?>
 <?php echo $_smarty_tpl->getVariable('event')->value->service->name;?>
 <?php echo $_smarty_tpl->getVariable('event')->value->data;?>
 <br />
<?php }?>
