<?php

class lgrafik {

    private function config($grap) {
        $temp = array();

        if (isset($grap->chart))
            $temp['chart'] = $grap->chart;
        if (isset($grap->title))
            $temp['title'] = $grap->title;
        if (isset($grap->subtitle))
            $temp['subtitle'] = $grap->subtitle;
        if (isset($grap->xAxis))
            $temp['xAxis'] = $grap->xAxis;
        if (isset($grap->yAxis))
            $temp['yAxis'] = $grap->yAxis;
        if (isset($grap->series))
            $temp['series'] = $grap->series;
        if (isset($grap->tooltip))
            $temp['tooltip'] = $grap->tooltip;
        if (isset($grap->plotOptions))
            $temp['plotOptions'] = $grap->plotOptions;
        if (isset($grap->legend))
            $temp['legend'] = $grap->legend;
        if (isset($grap->drilldown))
            $temp['drilldown'] = $grap->drilldown;
        
        $temp['credits']['enabled'] = false;

        return $this->encode_js($temp);
    }

    public function render($temp) {
        return $this->config($temp);
    }

    public function encode_js($data) {
        header("Content-Type: application/javascript");
        $result = json_encode($data, true);
        $obj = "while(1){function xhr_result(w,s,p){return {$result}}; break;}";
        return $obj;
    }

}
