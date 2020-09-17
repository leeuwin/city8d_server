<?php
/**
 * @author yupoxiong<i@yufuping.com>
 * @title 首页
 */

namespace app\api\controller;

use app\api\MyConst;
use think\facade\Config;
use think\facade\Log;

class Index extends Controller
{

    protected $authExcept = [
        'index'
    ];
    //function cmp($a, $b){return $a['ma']>$b['ma'];}
    public function index()
    {
        $data[] = array('ma'=>3,'amount'=>3);
        $data[] = array('ma'=>1,'amount'=>4);
        $data[] = array('ma'=>2,'amount'=>2);

        $this->gLianMa(MyConst::G_LM_3, $data, 2);

        return success($this->genRule);
    }



    //数据结构
    private $maBoard;       //Special特指特定位置
    private $genRule;       //General泛指统计结果

    //保存数据结构
    public function save(){

    }

    public function markSpecialMa($type, $data){

    }


    public function markGeneralMa($type, $data){

    }

    //-------------以下s前缀代表特指-----------
    //两面
    private function sLiangMian($type){
        switch ($type){
            case 0://大小
                break;
            case 1://单双
                break;
            case 2://合单双
                break;
            case 3://合大小
                break;
            case 4://尾大小
                break;
            case 5://天地肖
                break;
            case 6://前后肖
                break;
            case 7://家野肖
                break;
            default:
                break;
        }
    }
    //tm
    private function sTeMa($ma, $amount){
        //check param
        $this->maBoard[MyConst::TeMa][$ma] += $amount;
    }
    private function sZhengMaTe($pos, $ma, $amount){
        //check param
        $this->maBoard[$pos][$ma] += $amount;
    }
    private function sZhengMa1to6($type,$ma,$amount){
        switch ($type){
            case 3://大小
                break;
            case 4://单双
                break;
            case 5://合大小
                break;
            case 6://合单双
                break;
            case 7://尾大小
                break;
            case 8://色波
                break;
            default:
                break;
        }
    }
    private function sZhengMaGuoGuan(){

    }
    private function sTeXiao(){

    }
    private function sHeXiao(){

    }
    private function sColor(){

    }
    private function sHeadTail(){

    }
    //五行
    private function sFiveElements(){

    }

    //-------------以下g前缀代表泛指-----------
    private function gLiangMian($type, $ma, $amount){
        switch ($type){
            case 8://总和单双
                $this->genRule[$type][$ma] += $amount;
                break;
            case 9://总和大小
                $this->genRule[$type][$ma] += $amount;
                break;
            default:
                break;
        }
    }
    //6个正码位置中出现ma则中将
    private function gZhengMa($type, $ma, $amount){
        $this->genRule[$type][$ma] += $amount;
    }

    private function gLianMa($type, $data, $amount){
        //将data按ma值升序排列
        usort($data, function ($a, $b){return $a['ma']>$b['ma'];});

        $ma_num = 0;
        switch ($type){
            case MyConst::G_LM_4://4全中
                $ma_num = 4;
                break;
            case MyConst::G_LM_3://3全中
                $ma_num = 3;
                break;
            case MyConst::G_LM_3_2://3中+3中2
                $ma_num = 3;
                break;
            case MyConst::G_LM_2://2全中
                $ma_num = 2;
                break;
            case MyConst::G_LM_2_T://2中特
                $ma_num = 2;
                break;
            case MyConst::G_LM_T://特串
                $ma_num = 2;
                break;
            default:
                break;
        }
        if(count($data) != $ma_num){
            //错误
            Log::error("参数格式有误");
            return 1;
        }

        //插入关联数组结构维护
        $curNode = &$this->genRule[$type];//root
        if(is_null($curNode)){
            $curNode = array();
            //$this->genRule[$type] = $curNode;
        }
        for($i=0; $i<$ma_num; $i++){
            $element = $data[$i];
            //
            if(isset($curNode[$element['ma']])){
                $curNode = &$curNode[$element['ma']];
                //节点已存在，修改数量
                $curNode['amount'] += $element['amount'];
            }else{
                //如果节点为空，则创建一个
                $node = array('ma'=>$element['ma'], 'amount'=>$element['amount']);
                $curNode[$element['ma']] = $node;
            }
        }

        return 0;
    }

    private function gLianXiao($type, $data, $amount){
        //将data按ma值升序排列
        usort($data, function ($a, $b){return $a['xiao']>$b['xiao'];});
        $xiao_num = 0;
        switch ($type){
            case MyConst::G_LX_2://2连肖
                $xiao_num = 2;
                break;
            case MyConst::G_LX_3://3连肖
                $xiao_num = 3;
                break;
            case MyConst::G_LX_4://4连肖
                $xiao_num = 4;
                break;
            case MyConst::G_LX_5://5连肖
                $xiao_num = 5;
                break;
            default:
                break;
        }
        //插入关联数组结构维护
        $curNode = $this->genRule[$type];//root
        for($i=0; $i<$xiao_num; $i++){
            $element = $data[$i];
            $curNode = $curNode[$element['xiao']];
            if( is_null($curNode) ){
                //如果节点为空，则创建一个
                $node = array('ma'=>$element['xiao'], 'amount'=>$element['amount']);
                $curNode = $node;
            }else{
                //节点已存在，修改数量
                $curNode['amount'] += $element['amount'];
            }
        }
    }

    //连尾 data结构{'tail':2, 'amount':1}
    private function gLianTail($type, $data, $amount){
        //将data按ma值升序排列
        usort($data, function ($a, $b){return $a['tail']>$b['tail'];});
        $tail_num = 0;
        switch ($type){
            case MyConst::G_LW_2://2连尾
                $tail_num = 2;
                break;
            case MyConst::G_LW_3://3连尾
                $tail_num = 3;
                break;
            case MyConst::G_LW_4://4连尾
                $tail_num = 4;
                break;
            case MyConst::G_LW_5://5连尾
                $tail_num = 5;
                break;
            default:
                break;
        }
        //插入关联数组结构维护
        $curNode = $this->genRule[$type];//root
        for($i=0; $i<$tail_num; $i++){
            $element = $data[$i];
            $curNode = $curNode[$element['tail']];
            if( is_null($curNode) ){
                //如果节点为空，则创建一个
                $node = array('ma'=>$element['tail'], 'amount'=>$element['amount']);
                $curNode = $node;
            }else{
                //节点已存在，修改数量
                $curNode['amount'] += $element['amount'];
            }
        }
    }
    //取反，不中
    private function gNegate($type, $data,$amount){
        //将data按ma值升序排列
        usort($data, function ($a, $b){return $a['ma']>$b['ma'];});
        $no_num = 0;
        switch ($type){
            case MyConst::G_NO_5://5不中
                $no_num = 5;
                break;
            case MyConst::G_NO_6://6不中
                $no_num = 6;
                break;
            case MyConst::G_NO_7://7不中
                $no_num = 7;
                break;
            case MyConst::G_NO_8://8不中
                $no_num = 8;
                break;
            case MyConst::G_NO_9://9不中
                $no_num = 9;
                break;
            case MyConst::G_NO_10://10不中
                $no_num = 10;
                break;
            case MyConst::G_NO_11://11不中
                $no_num = 11;
                break;
            case MyConst::G_NO_12://12不中
                $no_num = 12;
                break;
            default:
                break;
        }
        //插入关联数组结构维护
        $curNode = $this->genRule[$type];//root
        for($i=0; $i<$no_num; $i++){
            $element = $data[$i];
            $curNode = $curNode[$element['ma']];
            if( is_null($curNode) ){
                //如果节点为空，则创建一个
                $node = array('ma'=>$element['ma'], 'amount'=>$element['amount']);
                $curNode = $node;
            }else{
                //节点已存在，修改数量
                $curNode['amount'] += $element['amount'];
            }
        }
    }
    private function gColor(){

    }
    private function gTail(){
        //正特尾数
    }
    private function gSevenMa(){

    }
    //只中一
    private function gZhongOne(){

    }
}