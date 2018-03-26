<?php if (!defined('THINK_PATH')) exit();?><div class="category_info">
    <ul class="category_tools dib-wrap">
    <?php if(!empty($info["butadd"])): ?><li class="dib">
            <a id="categoryBtAdd" href="javascript:void(0);" target="popDialog" data-opt="<?php echo ($info['butadd']['data-opt']); ?>"><?php echo ($info['butadd']['title']); ?></a>
        </li><?php endif; ?>
    <?php if(!empty($info["butdel"])): ?><li class="dib">
            <a id="categoryBtDel" href="javascript:void(0);" target="ajaxDel" data-opt="<?php echo ($info['butdel']['data-opt']); ?>"><?php echo ($info['butdel']['title']); ?></a>
        </li><?php endif; ?>
    
</ul>
    <form action="<?php echo U('authedit');?>" method="post" class="clearfix" onsubmit="return Juuz.ajaxForm(this)">
        <input type="hidden" name="id" value="<?php echo ($info["id"]); ?>">
        <input type="hidden" name="level" value="<?php echo ($info["level"]); ?>">
        <?php switch($info["level"]): case "1": ?><div class="ui_col_3">
                    <label class="ui_label">控制器标题 : </label>
                    <input class="ui_text_input" type="text" name="title" value="<?php echo ($info["title"]); ?>" data-opt='{
                    type : "require",
                    msg : "请输入控制器标题"
                }' />
                </div>
                <div class="ui_col_3">
                    <label class="ui_label">控制器名称 : </label>
                    <input class="ui_text_input" type="text" name="controller" value="<?php echo ($info["controller"]); ?>" data-opt='{
                    type : "require",
                    msg : "请输入控制器名称"
                }'/>
                </div>
                <div class="ui_col_5">
                    <label class="ui_label">控制器路径 : </label>
                    <input class="ui_text_input" type="text" disabled="disabled" name="name" value="<?php echo ($info["name"]); ?>" />
                </div>
                <div class="ui_col_2">
                    <label class="ui_label">序号(降序) : </label>
                    <input  class="ui_text_input" type="text" name="sort" value="<?php if(empty($info["sort"])): ?>99<?php else: echo ($info["sort"]); endif; ?>"  data-opt='{
                    type : "require number",
                    msg : "请输入排序序号 排序序号只能为数字"
                }'/>
                </div>
                <div class="ui_col_10 mt20">
                    <button type="submit" class="ui_button medium r3">保 存</button>
                </div><?php break;?>
            <?php case "2": ?><div class="ui_col_3">
                    <label class="ui_label">方法标题 : </label>
                    <input class="ui_text_input" type="text" name="title" value="<?php echo ($info["title"]); ?>" data-opt='{
                        type : "require",
                        msg : "请输入方法标题"
                    }'/>
                </div>
                <div class="ui_col_3">
                    <label class="ui_label">方法名称 : </label>
                    <input class="ui_text_input" type="text" name="method" value="<?php echo ($info["method"]); ?>" data-opt='{
                        type : "require",
                        msg : "请输入方法名称"
                    }'/>
                </div>
                <div class="ui_col_5">
                    <label class="ui_label">方法路径 : </label>
                    <input class="ui_text_input" type="text" disabled="disabled" name="name" value="<?php echo ($info["name"]); ?>" />
                </div>
                <div class="ui_col_2">
                    <label class="ui_label">序号(降序) : </label>
                    <input id="categorySort" class="ui_text_input" type="text" name="sort" value="<?php if(empty($info["sort"])): ?>99<?php else: echo ($info["sort"]); endif; ?>"  data-opt='{
                    type : "require number",
                    msg : "请输入排序序号 排序序号只能为数字"
                }'/>
                </div>
                <div class="ui_col_4">
                    <label class="ui_label">是否菜单</label>
                    <label class="ui_radio">
                        <input type="radio"  value="0" name="is_menu" <?php if(($info["is_menu"]) == "0"): ?>checked="checked"<?php endif; ?>/>菜单
                    </label>
                    <label class="ui_radio">
                        <input type="radio" value="1" name="is_menu" <?php if(($info["is_menu"]) == "1"): ?>checked="checked"<?php endif; ?>/>非菜单
                    </label>
                </div>
                <div class="ui_col_10 mt20">
                    <button type="submit" id="categoryBtSave" class="ui_button medium r3">保 存</button>
                </div><?php break;?>
            <?php default: ?>
                <?php if(($info["id"]) == ""): ?><div class="ui_col_3">
                        <label class="ui_label">顶级模块 : </label>
                        <input id="categoryTitle" class="ui_text_input" type="text" disabled="disabled" value="权限分组"/>
                    </div>
                <?php else: ?>
                    <div class="ui_col_3">
                        <label class="ui_label">模块标题 : </label>
                        <input class="ui_text_input" type="text" name="title" value="<?php echo ($info["title"]); ?>" data-opt='{
                    type : "require",
                    msg : "请输入模块标题"
                }'/>
                    </div>
                    <div class="ui_col_3">
                        <label class="ui_label">模块名称 : </label>
                        <input class="ui_text_input" type="text" name="module" value="<?php echo ($info["module"]); ?>"  data-opt='{
                    type : "require",
                    msg : "请输入模块名称"
                }'/>
                    </div>
                    <div class="ui_col_5">
                        <label class="ui_label">模块路径 : </label>
                        <input class="ui_text_input" type="text" disabled="disabled" name="name" value="<?php echo ($info["name"]); ?>" />
                    </div>
                    <div class="ui_col_2">
                        <label class="ui_label">序号(降序) : </label>
                        <input id="categorySort" class="ui_text_input" type="text" name="sort" value="<?php if(empty($info["sort"])): ?>99<?php else: echo ($info["sort"]); endif; ?>"  data-opt='{
                    type : "require number",
                    msg : "请输入排序序号 排序序号只能为数字"
                }'/>
                    </div>
                    <div class="ui_col_10 mt20">
                        <button type="submit" id="categoryBtSave" class="ui_button medium r3">保 存</button>
                    </div><?php endif; endswitch;?>
    </form>
</div>