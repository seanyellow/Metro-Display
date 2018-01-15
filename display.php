<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>MRT Display 1.0 Beta</title>
  <?php include 'style.php'?>
</head>

<body>
  <div id="display" class="container-fluid px-0">
    <!-- 頂部區塊 -->
    <div class="container-fluid top-area pt-4" >
      <div class="row justify-content-between align-items-center">
        <!-- 終點站 區塊 -->
        <div class="col-4 col-lg-6 terminal-area">
          <div  class="row no-gutters">
            <div class="col-6 col-lg-3 text-center">
              <span class="label" :class="GetAniClass('CH', 'fade')">終  點</span>
              <span class="label" :class="GetAniClass('EN', 'fade')" :style="GetTerminalLabelStyle('EN')">To</span>
            </div>
            <div class="col-6 col-lg-9">
              <div class="box" :class="GetAniClass('CH', 'fade')" >
                <span class="badge badge-dark name CH px-3"
                :style="GetLineColorStyle(stations[curr].ColorCode, stations[curr].TextColorCode)"><span>{{GetTerminal('CH')}}</span></span>
              </div>
              <div class="box" :class="GetAniClass('EN', 'fade')" :style="GetTerminalBoxStyle('EN')">
                <span class="badge badge-dark name EN px-4"
                :style="GetLineColorStyle(stations[curr].ColorCode, stations[curr].TextColorCode)"><span>{{GetTerminal('EN')}}</span></span>
              </div>
            </div>
          </div>
        </div>
        <!-- 車號 區塊 -->
        <div class="col-5 col-lg-3 car-num-area text-right">
          <span class="label ch" :class="GetAniClass('EN', 'fade')">Car No.</span>
          <span class="badge badge-dark badge-pill num">{{carNum}}</span>
          <span class="label ch mr-5"  :class="GetAniClass('CH', 'fade')" style="letter-spacing:.3rem;">號車</span>
        </div>
      </div>
      <div class="row align-items-center">
        <!-- 主車站編號 區塊 -->
        <div class="col-4 main-sta-num-area">
          <div class="row align-items-center ">
            <div class="col-8 text-center" >
              <span class="label" :class="GetAniClass('CH', 'fade')">下一站</span>
              <span class="label" :class="GetAniClass('EN', 'fade')" :style="GetMainStaNumStyle('EN')">Next</span>
            </div>
            <div class="col text-left">
              <span class="num badge" style="min-width:4.5rem;"
              :style="GetLineColorStyle(stations[curr].ColorCode, stations[curr].TextColorCode)">
              {{stations[curr].Color}}<br>{{GetNum(stations[curr].Num)}}</span>
            </div>
          </div>
        </div>

        <!-- 主車站文字 區塊 -->
        <div class="col-8 main-sta-area">
          <div class="box" style="overflow:hidden;">
            <span class="name CH" :class="GetAniClass('CH')" :style="GetMainStaStyle('CH')">
              <span class="text" :style="GetMainStaTextStyle('CH')">{{GetCurr('CH')}}</span>
            </span>
            <span class="name EN" :class="GetAniClass('EN')" :style="GetMainStaStyle('EN')">
              <span class="text" :style="GetMainStaTextStyle('EN')">{{GetCurr('EN')}}</span>
            </span>
            <span class="name JP" :class="GetAniClass('JP')" :style="GetMainStaStyle('JP')">
              <span class="text" :style="GetMainStaTextStyle('JP')">{{GetCurr('JP')}}</span>
            </span>
            <span class="name KR" :class="GetAniClass('KR')" :style="GetMainStaStyle('KR')">
              <span class="text" :style="GetMainStaTextStyle('KR')">{{GetCurr('KR')}}</span>
            </span>
          </div>
        </div>
      </div>
    </div>
    <!-- 中間顏色分割線 -->
    <div class="divide-line" :style="GetLineColorStyle(stations[curr].ColorCode, stations[curr].TextColorCode)"></div>

    <!-- 底部區塊 -->
    <div class="btm-area" >
      <div class="container sub-sta-area">
        <div class="row align-items-end">
          <template v-for="index in 7">
            <div class="col">
              <div :class="'box'+index" class="box">
                <div class="name CH" v-if="IsSubStaShow('CH')">
                  <span class="text" :style="GetSubStaTextStyle('CN',index)">{{GetSubStaName('CH',index-2)}}</span>
                </div>
                <div class="name EN" v-if="IsSubStaShow('EN')" >
                  <span class="text " :style="GetSubStaTextStyle('EN',index)" v-html="GetSubStaName('EN',index-2)"></span>
                </div>
                <div class="num">
                  {{GetSubStaNum(index-2)}}
                </div>
              </div>
              <template v-for="tran in GetSubStaTransfer(index-2)">
                <span class="badge align-bottom" style="height:1.5rem;width:1.5rem;padding:.35rem 0;" v-bind:style="GetLineColorStyle(tran.TransferColorCode,tran.TransferTextColorCode)" >
                  {{tran.TransferColor}}
                </span>
                <span>{{tran.TransferName}}線</span> <br>
                <span>{{tran.TransferName_EN}} Line</span>
              </template>
            </div>
          </template>
        </div>
      </div>
    </div>

    <!-- 控制器 -->
    <div>
      <button @click="ToggleMainStaLang(1)" type="button" class="btn btn-secondary">Toggle Main</button>
      <button @click="ToggleSubStaLang(1)" type="button" class="btn btn-secondary">Toggle Sub</button>
      <button @click="ToggleDirection()" type="button" class="btn btn-secondary">切換行車方向</button>
      <select v-model="color" @change="ChangeColor()" class="form-control d-inline-block" style=" width:5rem;">
        <template v-for="l in lines">
          <option :value="l.Color">{{l.Color}}</option>
        </template>
      </select>
      <div class="btn-group">
        <button @click="Toggle(-1)" type="button" class="btn btn-secondary"><</button>
        <button @click="Toggle(1)" type="button" class="btn btn-secondary">></button>
        <input v-model="curr" @keyup.left="Toggle(-1)" @keyup.right="Toggle(1)">
      </div>
    </div>
  </div>

  <?php require_once 'js.php'?>
  <script src="js/display.js"></script>
</body>

</html>
