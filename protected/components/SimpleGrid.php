<?php

/**
 * SimpleGrid class file.
 *
 * @author Wang Dongyang <wangdy@trunkbow.com>
 * @copyright Copyright &copy; 2001-2010 Trunkbow international
 *  2010-12.30
 */
class SimpleGrid
{

    private $grid_title = '';
    private $newrow = true;
    private $newrow_attr = array();
    private $rows = 0;
    private $headers = array();
    private $i = 0;
    private $ti = 0;
    private $grid_toolbar = '';
    public $tid;
    public $url;
    public $updateDom;

    public function __construct($tid, $grid_title='')
    {
        $this->tid = $tid;
        $this->grid_title = $grid_title;
    }

    public function set_url($url)
    {
        $this->url = $url;
    }
    /**
     * 设置标题
     * @param <string> $title 标题名称
     * @param <integer> $width 宽
     * @param <string> $align  标题对齐方式
     * @param <string> $order  排序字段名
     */
    public function set_header($title, $width = "", $align="", $order="")
    {
        if(is_numeric($width)){//如果是数值则默认为 px;
            $width=$width."px";
        }
        $this->headers[$this->i++] = array(
            "title" => $title,
            "width" => $width,
            "align" => $align,
            "order" => $order
        );
    }

    public function set_grid_toolbar($grid_toolbar)
    {
        $this->grid_toolbar = $grid_toolbar;
    }

    /**
     * 输出标题
     * @param <string> $width
     * @param <string> $style
     */
    public function echo_grid_header($width = '100%', $style='')
    {
        echo '<div id="st_' . $this->tid . '">', "\n";
        if ($this->grid_title != "")
        { //标题
            echo '<div class="bodyTitle">';
            echo '<div class="bodyTitleLeft"></div>';
            echo '<div class="bodyTitleText">', $this->grid_title, '</div>';
            echo '</div>';
            echo '<br/>';
        }
        if ($this->grid_toolbar != '')
        {
            echo $this->grid_toolbar;
            echo '<br/>';
        }

        echo '<table class="dbTable" width="' . $width . '">';
        echo '<thead><tr>', "\n";

        if (count($this->headers) > 0)
            foreach ($this->headers as $i => $header)
            {
                $align = $header['align'];
                $width = $header['width'];
                $title = $header['title'];
                $order = $header['order'];
                echo '<th ';
                echo $width != '' ? " style='width:".$width.";' width=\"$width\" " : '';
                echo $align != '' ? " style=\"text-align:$align;\" " : '';
                echo ' >';
                if ($order == '')
                    echo $title;
                else
                {
                    $q_order = $_REQUEST['q_order'];

                    /*
                          * 结尾~标识升序,否则为降序
                          */
                    if (substr($q_order, -1) == '~')
                    {
                        $q_order = substr($_REQUEST['q_order'], 0, -1);
                        $direction = 'up';
                    } else
                    {
                        $direction = 'down';
                    }

                    if ($q_order == $order)
                    {
                        if ($direction == 'up')
                        {
                            $q_order_new = $q_order;
                        } else
                        {
                            $q_order_new = $q_order . '~';
                        }
                        echo '<a href="javascript:void(0);" onclick="' . $this->tid . ".order='" . $q_order_new . "';" . $this->tid . '.refresh();">', $title, '</a>';
                        echo "<img src='images/arrow-{$direction}.gif' style='padding-left:3px;'/>";
                    } else
                    {
                        echo '<a href="javascript:void(0);" onclick="' . $this->tid . ".order='" . $order . "';" . $this->tid . '.refresh();">', $title, '</a>';
                    }
                }
                echo '</th>', "\n";
            }
        echo '</tr></thead><tbody>';
    }

    /*
     * 设置tr属性（可选）
     * 两种形式的参数
     * 1.数组形式，可以传递多条设置
     * @param <array> $attr 数组
     * 2.单条设置的简化传递
	 * @param <string> $attr 名称
	 * @param <string> $value  值
     *
     * onClickDirect 参数传递整行点击跳转url
     */
    public function begin_row($attr, $value='')
    {
        if($value!='')
            $this->newrow_attr = array($attr => $value);
        else
            $this->newrow_attr = $attr;
    }

    public function echo_td($content = "&nbsp;", $align = "", $attr = "")
    {

        if ($this->newrow == true)
        {
            $row_attr = '';
            $class = '';
            if(count($this->newrow_attr)>0)
            {
                foreach($this->newrow_attr as $rk => $rv)
                {
                    if($rk == 'onClickDirect')
                    {
                        $row_attr .= " onClick=\"window.location.href='{$rv}';\" ";
                        $class .=" cursor ";
                    }
                    elseif($rk == 'class')
                    {
                        $class .=" $rv ";
                    }
                    else
                    {
                        $row_attr .= " {$rk}=\"{$rv}\"  ";
                        if($rk=='onclick')
                        {
                            $class .=" cursor ";
                        }
                    }
                }
            }
            //	$class = $this->rows % 2 == 0 ? '' : " class='bgFleet'";
            echo "<tr {$row_attr} class=\"".$class."\">";
            $this->newrow = false;
        }
        if ($content == '')
            $content = '&nbsp;';

        $style = '';
        try{
            if($this->headers[$this->ti]){
                $width=$this->headers[$this->ti]['width'];
                if(!$align)
                    $align=$this->headers[$this->ti]['align'];
            }
            $this->ti++;
        }catch (Exception $e){

        }
        if($align != '')
            $style .= "  text-align:$align; ";
        if($width != ''){
            $style .= "  width:".$width.";";
        }
        $valign = 'top';
        $td_attr = '';
        if($attr!='' && count($attr)>0)
        {
            foreach($attr as $k => $v)
            {
                if($k=='valign')
                    $valign = $v;
                elseif($k=='style')
                    $style .= " $v ";
                $td_attr .= " {$k}=\"{$v}\"  ";
            }
        }
        echo '<td  valign="'.$valign.'" '.$td_attr;
        echo $style != '' ? " style=\"$style\" " : '';
        echo '>' . $content . '</td>';
    }

    public function safecho_td($content = "&nbsp;", $align = "", $attr = "")
    {
        if($content!='&nbsp;') $content = htmlspecialchars($content);
        $this->echo_td($content, $align, $attr);
    }

    public function end_row()
    {
        $this->rows += 1;
        echo '</tr>', "\n";
        $this->newrow = true;
        $this->newrow_attr = array();
        $this->ti=0;
    }

    private function echo_grid_none_data()
    {
        $out = "";
        $out .= "\n<tr>";
        $out .= "\n<td colSpan=" . (count($this->headers)) . ">&nbsp;&nbsp;&nbsp;&nbsp;没有任何记录!</td>";
        $out .= "</tr>";
        echo $out;
    }

    public function echo_grid_floor()
    {

        if ($this->rows == 0)
        {
            $this->echo_grid_none_data();
        }
        echo '  </tbody></table>', "\n";
        $page = intval($_REQUEST['page']);
        $condition = '';
        $order = $_REQUEST['q_order'];
        echo '
<script type="text/javascript">

$(document).ready(function(){
    // 为表格的偶数行添加背景色
    $(".dbTable  > tbody > tr:odd").css("background-color","#f7f7f7");

    //防止冒泡事件
    $("a").bind("click", function (event) {
        event.stopPropagation();
    });
    $("input").bind("click", function (event) {
        event.stopPropagation();
    });
    $("label").bind("click", function (event) {
        event.stopPropagation();
    });
})
if( typeof ' . $this->tid . ' == "undefined" ) {
		var ' . $this->tid . ' = {};
		' . $this->tid . '.page = ' . $page . ';
		' . $this->tid . '.condition = "' . $condition . '";
		' . $this->tid . '.order = "' . $order . '";
		' . $this->tid . '.refresh = function(page) {
			if( typeof page == "undefined" ) page = this.page;
			url = "' . $this->url . '"+"&page="+page+"&"+' . $this->tid . '.condition+"&q_order="+' . $this->tid . '.order;

			url=encodeURI(url);
			jQuery.ajax({
			type: "get",
			url: url,
			beforeSend: function(XMLHttpRequest){
				displayLoadingLayer();
			},
			success: function(data, textStatus){
				jQuery("#' . $this->updateDom . '").html(data);
			},
			complete: function(XMLHttpRequest, textStatus){
				hideLoadingLayer();
			},
			error: function(){
				alert("请求失败");
			}
			});
		};
	}else{
	    ' . $this->tid . '.page = ' . $page . ';
	    ' . $this->tid . '.order = "' . $order . '";
	}
</script>
		';
        echo '</div>', "\n";
    }

}
