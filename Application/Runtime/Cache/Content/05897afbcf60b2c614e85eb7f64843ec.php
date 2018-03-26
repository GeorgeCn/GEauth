<?php if (!defined('THINK_PATH')) exit();?><div class="category_info">
    <ul class="category_tools dib-wrap">
    <?php if(!empty($info["butadd"])): ?><li class="dib">
            <a id="categoryBtAdd" href="javascript:void(0);" target="popDialog" data-opt="<?php echo ($info['butadd']['data-opt']); ?>"><?php echo ($info['butadd']['title']); ?></a>
        </li><?php endif; ?>
    <?php if(!empty($info["butdel"])): ?><li class="dib">
            <a id="categoryBtDel" href="javascript:void(0);" target="ajaxDel" data-opt="<?php echo ($info['butdel']['data-opt']); ?>"><?php echo ($info['butdel']['title']); ?></a>
        </li><?php endif; ?>
    
</ul>
     <form action="<?php echo U('upcate');?>" method="post" class="clearfix" onsubmit="return Juuz.ajaxForm(this)">
        <div class="ui_col_11">
            <div class="ui_col_2">
                <label class="ui_label">分类编号 : </label>
            <input id="categoryId" class="ui_text_input" readonly="readonly" type="text" name="id"  value="<?php echo ($info["id"]); ?>" />
            </div>
            <div class="ui_col_3">
                <label class="ui_label">分类名称 : </label>
                <input id="categoryName" class="ui_text_input" type="text" name="title" value="<?php echo ($info["title"]); ?>" data-opt='{
                    type : "require",
                    msg : "请输入分类名称"
                }' />
            </div>
			<div class="ui_col_3">
				<label class="ui_label">序号 : </label>
				<input id="categorySort" class="ui_text_input" type="text" name="sort" value="<?php echo ($info["sort"]); ?>" />
			</div>
			<div class="ui_col_3">
				<label class="ui_label">最高编号 : </label>
				<input id="categorySort" class="ui_text_input" type="text" readonly="readonly"  value="<?php echo ($sortmax); ?>" />
			</div>
        </div>
        <div class="ui_col_10 mt20">
            <button type="submit" id="categoryBtSave" class="ui_button medium r3">保 存</button>
        </div>
    </form>
</div>