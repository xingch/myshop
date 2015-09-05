<?php defined('InShopNC') or exit('Access Invalid!');?>
<!--//zmr>v30-->
<div class="tabmenu">
  <?php include template('layout/submenu');?>
</div>
<div class="ncsc-form-default">
  <form method="post"  action="index.php?act=wifi_gw&op=add_form" enctype="multipart/form-data" id="form">
    <input type="hidden" name="form_submit" value="ok" />
    <dl>
      <dt>路由名称：</dt>
      <dd>
       <input type="text" value="<?php echo $output['gw_info']['gw_name'];?>" name="gw_name" class="text w400">
       </dd>
    </dl>
    <dl>
      <dt>路由平台账号（MAC）：</dt>
      <dd>
        <input type="text" value="<?php echo $output['gw_info']['gw_account'];?>" name="gw_account" class="text w400">
        <p class="hint">一般填写路由MAC地址;</p>
      </dd>
    </dl>
    <div class="bottom">
        <label class="submit-border"><input type="submit" class="submit" value="<?php echo $lang['store_goods_class_submit'];?>" /></label>
      </div>
  </form>
</div>
<script type="text/javascript">

$(function(){
  jQuery.validator.addMethod("check_account", function(value, element, params) {
    var result = true;
    $.ajax({
      type:"GET",
      url:'<?php echo urlShop('wifi_gw', 'ajax_check_account');?>',
      async:false,
      data:{gw_account: $('#gw_account').val()},
      success: function(data){
        if(data != 'true') {
          $.validator.messages.check_account = "热点账号已经存在，验证失败";
          result = false;
        }
      }
    });
    return result;
  },  '');
	$('#form').validate({
    	submitHandler:function(form){
    		ajaxpost('form', '', '', 'onerror')
    	},
		rules : {
          gw_name: {
            required : true,
            maxlength: 20
          },
          gw_account: {
            required : true,
            maxlength: 21,
            check_account：true
          }
        },
        messages : {
          gw_name : {
            required : '<i class="icon-exclamation-sign"></i>请输入路由名称',
            maxlength: '<i class="icon-exclamation-sign"></i>路由名称不能超过20个字符'
          },
          gw_account : {
            required : '<i class="icon-exclamation-sign"></i>请输入路由账号',
            maxlength: '<i class="icon-exclamation-sign"></i>路由名称不能超过21个字符'
          },
        }
    });
});
</script>
