<?php
/**
 * Created by PhpStorm.
 * User: think
 * Date: 2020/9/17
 * Time: 14:22
 */
namespace app\api;

class MyConst
{
    //board
    const PingMa1 = 0;
    const PingMa2 = 1;
    const PingMa3 = 2;
    const PingMa4 = 3;
    const PingMa5 = 4;
    const PingMa6 = 5;
    const TeMa = 6;
    //生肖
    const SX_SHU = 1;
    const SX_NIU = 2;
    const SX_HU = 3;
    const SX_TU = 4;
    const SX_LONG = 5;
    const SX_SHE = 6;
    const SX_MA = 7;
    const SX_YANG = 8;
    const SX_HOU = 9;
    const SX_JI = 10;
    const SX_GOU = 11;
    const SX_ZHU = 12;

    //前后
    const SXS_FRONT = array(self::SX_SHU,self::SX_NIU,self::SX_HU,self::SX_TU,self::SX_LONG,self::SX_SHE);
    const SXS_BACK = array(self::SX_MA,self::SX_YANG,self::SX_HOU,self::SX_JI,self::SX_GOU,self::SX_ZHU);
    //天地
    const SXS_UPPER = array();
    const SXS_DOWN = array();
    //家野
    const SXS_HOME = array();
    const SXS_WILD = array();

//type定义
    const S_LM_DX = 10;     //大小
    const S_LM_DS = 11;     //单双
    const S_LM_HDX = 12;    //合大小
    const S_LM_HDS = 13;    //合单双
    const S_LM_WDX = 14;    //尾大小
    const S_LM_TDX = 15;    //天地肖
    const S_LM_QHX = 16;    //前后肖
    const S_LM_JYX = 17;    //家野肖

    const G_LM_ZDX = 18;    //总大小
    const G_LM_ZDS = 19;    //总单双

    const S_TM = 20;        //tm
    const G_ZM = 21;        //zm
    const S_ZMT = 22;       //zmt

    const S_ZM16_DX = 23;   //zm16大小
    const S_ZM16_DS = 24;   //zm16单双
    const S_ZM16_HDX = 25;   //zm16合大小
    const S_ZM16_HDS = 26;   //zm16合单双
    const S_ZM16_WDX = 27;   //zm16尾大小
    const S_ZM16_SB = 28;   //zm16色波
    const S_ZMGG = 29;   //zm过关

    const G_LM_4 = 30;   //lm4/4
    const G_LM_3 = 31;      //lm3/3
    const G_LM_3_2 = 32;    //lm3/3+2/3
    const G_LM_2 = 33;      //lm2/2
    const G_LM_2_T = 34;     //lm2+中特
    const G_LM_T = 35;       //lm中特

    const G_LX_2 = 40;      //2连X
    const G_LX_3 = 41;      //3连X
    const G_LX_4 = 42;      //4连X
    const G_LX_5 = 43;      //5连X

    const G_LW_2 = 50;      //2连W
    const G_LW_3 = 51;      //3连W
    const G_LW_4 = 52;      //4连W
    const G_LW_5 = 53;      //5连W

    const G_NO_5 = 60;      //5不中
    const G_NO_6 = 61;      //6不中
    const G_NO_7 = 62;      //7不中
    const G_NO_8 = 63;      //8不中
    const G_NO_9 = 64;      //9不中
    const G_NO_10 = 65;      //10不中
    const G_NO_11 = 66;      //11不中
    const G_NO_12 = 67;      //12不中

}