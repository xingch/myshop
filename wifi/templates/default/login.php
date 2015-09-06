    <div class="login-form">
        <form action="" method ="">
            <?php 
            foreach($output['data'] as $k => $v):?>
            <input name="<?php echo $k;?>" value="<?php echo $v;?>" type="hidden" />
            <?php endforeach;?>
            <span>
                <input type="text" placeholder="用户名" class="input-40" name="username" id="username"/>
            </span>
             <span>
                <input type="password" placeholder="密码" class="input-40" name="pwd" id="userpwd"/>
            </span>
            <!-- <span class="clearfix auto-login">
                <i class="s-chk1 fleft mr5"></i>
                <span>7天内免登录</span>
            </span> -->
            <div class="error-tips mt10"></div>
            <a href="javascript:void(0);" class="l-btn-login mt10" id="loginbtn">
                登录
            </a>
            <a href="/wifi/index.php?act=index&op=reg" class="l-btn-reg mt10" id="regbtn">
                注册
            </a>
        </form>
    </div>