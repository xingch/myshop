<?php defined('InShopNC') or exit('Access Invalid!');?>
<div class="ncc-form-default">
	<form method="POST" id="addr_form" action="index.php">
		<input type="hidden" value="buy" name="act"> <input type="hidden"
			value="add_addr" name="op"> <input type="hidden" name="form_submit"
			value="ok" />
		<dl>
			<dt>
				<i class="required">*</i><?php echo $lang['cart_step1_input_true_name'].$lang['nc_colon'];?></dt>
			<dd>
				<input type="text" class="text w100" name="true_name" maxlength="20"
					id="true_name" value="" />
			</dd>
		</dl>
		<dl>
			<dt>
				<i class="required">*</i>身份证号：
			</dt>
			<dd>
				<input type="text" class="text w100" name="id_number" id="id_number"
					maxlength="80" value="" />
			</dd>
		</dl>
		<dl>
			<dt>
				<i class="required">*</i>邮政编码：
			</dt>
			<dd>
				<input type="text" class="text w100" name="post_code" id="post_code"
					maxlength="80" value="" />
			</dd>
		</dl>
		<dl>
			<dt>
				<i class="required">*</i><?php echo $lang['cart_step1_area'].$lang['nc_colon'];?></dt>
			<dd>
				<div id="region">
					<select class="w110" id="areas">
					</select> <input type="hidden" value="" name="city_id" id="city_id">
					<input type="hidden" name="area_id" id="area_id" class="area_ids" />
					<input type="hidden" name="area_info" id="area_info"
						class="area_names" />
				</div>
			</dd>
		</dl>
		<dl>
			<dt>
				<i class="required">*</i><?php echo $lang['cart_step1_whole_address'].$lang['nc_colon'];?></dt>
			<dd>
				<input type="text" class="text w500" name="address" id="address"
					maxlength="80" value="" />
				<p class="hint"><?php echo $lang['cart_step1_true_address'];?></p>
			</dd>
		</dl>
		<dl>
			<dt>
				<i class="required">*</i><?php echo $lang['cart_step1_mobile_num'].$lang['nc_colon'];?></dt>
			<dd>
				<input type="text" class="text w200" name="mob_phone" id="mob_phone"
					maxlength="15" value="" />
        &nbsp;&nbsp;(或)&nbsp;<?php echo $lang['cart_step1_phone_num'].$lang['nc_colon'];?>
        <input type="text" class="text w200" id="tel_phone"
					name="tel_phone" maxlength="20" value="" />
			</dd>
		</dl>
	</form>
</div>

<script type="text/javascript">
$(document).ready(function(){
	regionInit("region");
    $('#addr_form').validate({
        rules : {
            true_name : {
                required : true
            },
	         post_code : {
                required : true,
                minlength : 5,
				maxlength : 10,
				digits : true
            },	
            id_number : {
                required : true,
                minlength : 15,
				maxlength : 18
            },		
            area_id : {
                required : true,
                min   : 1,
                checkarea:true
            },
            address : {
                required : true
            },
            mob_phone : {
                required : checkPhone,
                minlength : 11,
				maxlength : 11,
                digits : true
            },
            tel_phone : {
                required : checkPhone,
                minlength : 6,
				maxlength : 20
            }
        },
        messages : {
            true_name : {
                required : '<i class="icon-exclamation-sign"></i><?php echo $lang['cart_step1_input_receiver'];?>'
            },
            area_id : {
                required : '<i class="icon-exclamation-sign"></i><?php echo $lang['cart_step1_choose_area'];?>',
                min  : '<i class="icon-exclamation-sign"></i><?php echo $lang['cart_step1_choose_area'];?>',
                checkarea : '<i class="icon-exclamation-sign"></i><?php echo $lang['cart_step1_choose_area'];?>'
            },
	        post_code : {
                required : '<i class="icon-exclamation-sign"></i>请填写邮编',
                minlength: '<i class="icon-exclamation-sign"></i>邮编至少填写5位',
				maxlength: '<i class="icon-exclamation-sign"></i>邮编最多填写10位',
				digits: '<i class="icon-exclamation-sign"></i>请输入合法的邮编'
            },	
            id_number : {
                required : '<i class="icon-exclamation-sign"></i>请填写正确的身份证号码',
				minlength: '<i class="icon-exclamation-sign"></i>身份证号只能为15位或者18位',
				maxlength: '<i class="icon-exclamation-sign"></i>身份证号只能为15位或者18位',
            },		
            address : {
                required : '<i class="icon-exclamation-sign"></i><?php echo $lang['cart_step1_input_address'];?>'
            },
            mob_phone : {
                required : '<i class="icon-exclamation-sign"></i><?php echo $lang['cart_step1_telphoneormobile'];?>',
                minlength: '<i class="icon-exclamation-sign"></i><?php echo $lang['cart_step1_mobile_num_error'];?>',
				maxlength: '<i class="icon-exclamation-sign"></i><?php echo $lang['cart_step1_mobile_num_error'];?>',
                digits : '<i class="icon-exclamation-sign"></i><?php echo $lang['cart_step1_mobile_num_error'];?>'
            },
            tel_phone : {
                required : '<i class="icon-exclamation-sign"></i><?php echo $lang['cart_step1_telphoneormobile'];?>',
                minlength: '<i class="icon-exclamation-sign"></i><?php echo $lang['member_address_phone_rule'];?>',
				maxlength: '<i class="icon-exclamation-sign"></i><?php echo $lang['member_address_phone_rule'];?>'
            }
        },
        groups : {
            phone:'mob_phone tel_phone'
        }
    });
});
var province='';
var city='';
var district='';
<?php
/**
 * 根据用户ip自动默认选择省市*
 */
if (extension_loaded ( 'qqwry' )) {
	$q = new qqwry ( '/home/wwwroot/qqwry.dat' );
	$addres = $q->q ( getenv ( "REMOTE_ADDR" ) );
	$addres [0] = iconv ( 'GBK', "UTF-8//IGNORE", $addres [0] );
	if (mb_strpos ( $addres [0], '省' ) !== false) {
		echo "province='" . strstr ( $addres [0], '省', true ) . "省';";
		$c = strstr ( $addres [0], '省' );
		if (strpos ( $c, '市' ) !== false) {
			$d = mb_substr ( strstr ( $c, '市' ), 1 );
			echo "city='" . mb_substr ( strstr ( $c, '市', true ), 1 ) . "市';";
		}
	} elseif (mb_strpos ( $addres [0], '北京' ) !== false || mb_strpos ( $addres [0], '上海' ) !== false || mb_strpos ( $addres [0], '天津' ) !== false || mb_strpos ( $addres [0], '重庆' ) !== false) {
		echo "province='" . mb_substr ( $addres [0], 1 ) . "';";
		echo "city='" . mb_substr ( $addres [0], 1 ) . "市';";
	} elseif (mb_strpos ( $addres [0], '宁夏' ) !== false || mb_strpos ( $addres [0], '西藏' ) !== false || mb_strpos ( $addres [0], '新疆' ) !== false || mb_strpos ( $addres [0], '广西' ) !== false || mb_strpos ( $addres [0], '内蒙古' ) !== false) {
		switch (mb_substr ( $addres [0], 0, 2 )) {
			case '广西' :
				echo "province='广西壮族自治区';";
				if (strpos ( $addres [0], '市' ) !== false) {
					$c = strstr ( $addres [0], '市', true );
					echo "city='" . str_replace ( '广西', '', $c ) . "市';";
				}
				break;
			case '宁夏' :
				echo "province='宁夏回族自治区';";
				if (strpos ( $addres [0], '市' ) !== false) {
					$c = strstr ( $addres [0], '市', true );
					echo "city='" . str_replace ( '宁夏', '', $c ) . "市';";
				}
				break;
			case '新疆' :
				echo "province='新疆维吾尔自治区';";
				if (strpos ( $addres [0], '市' ) !== false) {
					$c = strstr ( $addres [0], '市', true );
					echo "city='" . str_replace ( '新疆', '', $c ) . "市';";
				} elseif (strpos ( $addres [0], '地区' ) !== false) {
					$c = strstr ( $addres [0], '地区', true );
					echo "city='" . str_replace ( '新疆', '', $c ) . "地区';";
				}
				// 其它自治州不考虑了
				break;
			case '内蒙古' :
				echo "province='内蒙古自治区';";
				if (strpos ( $addres [0], '市' ) !== false) {
					$c = strstr ( $addres [0], '市', true );
					echo "city='" . str_replace ( '内蒙古', '', $c ) . "市';";
				} elseif (strpos ( $addres [0], '盟' ) !== false) {
					$c = strstr ( $addres [0], '盟', true );
					echo "city='" . str_replace ( '内蒙古', '', $c ) . "盟';";
				}
				break;
			default :
				echo "province='西藏自治区';";
				if (strpos ( $addres [0], '市' ) !== false) {
					$c = strstr ( $addres [0], '市', true );
					echo "city='" . str_replace ( '西藏', '', $c ) . "市';";
				} elseif (strpos ( $addres [0], '地区' ) !== false) {
					$c = strstr ( $addres [0], '地区', true );
					echo "city='" . str_replace ( '西藏', '', $c ) . "地区';";
				}
				break;
		}
	} elseif (mb_strpos ( $addres [0], '香港' ) !== false) {
		echo "province='香港特别行政区';";
	} elseif (mb_strpos ( $addres [0], '澳门' ) !== false) {
		echo "province='澳门特别行政区';";
	} else {
		echo "province='海外';";
		echo "city='海外';";
		echo "district='" . $addres [0] . "';";
	}

?>
$('input[name="true_name"]').change(function() { 	
	$("#areas option:contains('"+province+"')").attr('selected', true);
	$('#areas').trigger('change');
	if(city!==""){
		$('#region').find('select:eq(1) option:contains("'+city+'")').attr('selected', true);
		$('#region').find('select:eq(1)').trigger('change');
	}
});
<?php
}
?>
function checkPhone(){
    return ($('input[name="mob_phone"]').val() == '' && $('input[name="tel_phone"]').val() == '');
}
function submitAddAddr(){
    if ($('#addr_form').valid()){
        $('#buy_city_id').val($('#region').find('select').eq(1).val());
        $('#city_id').val($('#region').find('select').eq(1).val());
        var datas=$('#addr_form').serialize();
        $.post('index.php',datas,function(data){
            if (data.state){
                var true_name = $.trim($("#true_name").val());
                var tel_phone = $.trim($("#tel_phone").val());
                var mob_phone = $.trim($("#mob_phone").val());
            	var area_info = $.trim($("#area_info").val());
                var post_code = $.trim($("#post_code").val());
				var id_number = $.trim($("#id_number").val());				
            	var address = $.trim($("#address").val());
            	showShippingPrice($('#city_id').val(),$('#area_id').val());
            	//hideAddrList(data.addr_id,true_name,area_info+'&nbsp;&nbsp;'+address,(mob_phone != '' ? mob_phone : tel_phone));
				hideAddrList(data.addr_id,true_name,area_info+'&nbsp;&nbsp;'+address,(mob_phone != '' ? mob_phone : tel_phone),post_code,id_number);
            }else{
                alert(data.msg);
            }
        },'json');
    }else{
        return false;
    }
}
</script>