<?php

/**
 * PanDownload 网页复刻版，PHP 语言版
 *
 * 首页文件
 *
 * @author Yuan_Tuo <yuantuo666@gmail.com>
 * @link https://imwcr.cn/
 * @link https://space.bilibili.com/88197958
 *
 */
require_once("./common/invalidCheck.php");
?>

<div class="col-lg-6 col-md-9 mx-auto mb-5 input-card">
    <div class="card">
        <div class="card-header bg-dark text-light">
            <?php if (USING_DB) { ?>
            <text id="parsingtooltip" data-placement="top" data-html="true"
                title="请稍等，正在连接服务器查询信息"><?php echo Language["IndexTitle"]; ?></text>
            <span style="float: right;" id="sviptooltip" data-placement="top" data-html="true"
                title="请稍等，正在连接服务器查询SVIP账号状态"><span class="point point-lg" id="svipstate-point"></span><span
                    id="svipstate">Loading...</span></span>
            <?php } else echo Language["IndexTitle"]; ?>
        </div>
        <div class="card-body">
            <form name="form1" method="post" onsubmit="return validateForm()">
                <div class="form-group my-2"><input type="text" class="form-control" name="surl"
                        placeholder="<?php echo Language["ShareLink"]; ?>" oninput="Getpw()"></div>
                <div class="form-group my-4"><input type="text" class="form-control" name="pwd"
                        placeholder="<?php echo Language["SharePassword"]; ?>"></div>
                <?php
				if (IsCheckPassword) {
					$return = '<div class="form-group my-4"><input type="text" class="form-control" name="Password" placeholder="' . Language["PassWord"] . '"></div>';
					if (isset($_SESSION["Password"])) {
						if ($_SESSION["Password"] === Password) {
							$return = '<div>' . Language["PassWordVerified"] . '</div>';
						}
					}
					echo $return;
				} // 密码
				?>
                <button type="submit"
                    class="mt-4 mb-3 btn btn-success btn-block"><?php echo Language["Submit"]; ?></button>
                <p class="text-center">关注公众号获取密码</p>
                <img src="http://alist.52shell.ltd:5244/d/%E5%A4%A9%E7%BF%BC%E4%BA%91%E7%9B%98/%E6%88%91%E7%9A%84%E5%9B%BE%E7%89%87/%E5%BE%AE%E4%BF%A1%E5%85%AC%E4%BC%97%E5%8F%B7%20%E6%96%B0.jpg?sign=uDO51EUtQne3SjjIYuKWghV8ps8Cm0SUeQVH5vcEUp4=:0"
                    alt="Image">

            </form>
            <?php if (file_exists("notice.html")) echo file_get_contents("notice.html"); ?>
        </div>
    </div>
    <?php if (USING_DB) { ?>
    <script>
    // 主页部分脚本
    $(document).ready(function() {

        $("#sviptooltip").tooltip(); // 初始化
        $("#parsingtooltip").tooltip(); // 初始化

        getAPI('LastParse').then(function(response) {
            if (response.success) {
                const data = response.data;
                if (data.error == 0) {
                    // 请求成功
                    if (data.svipstate == 1) {
                        $("#svipstate-point").addClass("point-success");
                    } else {
                        $("#svipstate-point").addClass("point-danger");
                    }
                }
                $("#svipstate").text(data.sviptips);
                $("#sviptooltip").attr("data-original-title", data.msg);
            }
        });

        getAPI('ParseCount').then(function(response) {
            if (response.success) {
                $("#parsingtooltip").attr("data-original-title", response.data.msg);
            }
        });
    });
    </script>
    <?php } ?>
</div>