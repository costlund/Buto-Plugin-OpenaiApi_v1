<?php
class PluginOpenaiApi_v1{
  public $settings;
  function __construct(){
    $this->settings = wfPlugin::getPluginSettings('openai/api_v1', true);
    $this->settings->set('settings', wfSettings::getSettingsFromYmlString($this->settings->get('settings')));
    if(!$this->settings->get('settings/api_key')){
      throw new Exception(__CLASS__.'::'.__FUNCTION__.' says: Api key is not set!');
    }
    /**
     * log_file
     */
    $this->settings->set('settings/log_file', wfGlobals::getAppDir().'/../buto_data/theme/[theme]/log/'.date('ymd').'.yml');
  }
  public function widget_test($data){
    /**
     * 
     */
    $data = new PluginWfArray($data);
    /**
     * 
     */
    if(!$data->get('data/model')){
      throw new Exception(__CLASS__.'::'.__FUNCTION__.' says: Param model is not set!');
    }
    if(!$data->get('data/messages')){
      throw new Exception(__CLASS__.'::'.__FUNCTION__.' says: Param messages is not set!');
    }
    if(!$data->get('data/max_tokens')){
      throw new Exception(__CLASS__.'::'.__FUNCTION__.' says: Param max_tokens is not set!');
    }
    if(!$data->get('data/temperature')){
      throw new Exception(__CLASS__.'::'.__FUNCTION__.' says: Param temperature is not set!');
    }
    /**
     * 
     */
    $url = 'https://api.openai.com/v1/chat/completions';
    /**
     * headers
     */
    $headers = [
        'Content-Type: application/json',
        'Authorization: Bearer ' . $this->settings->get('settings/api_key'),
    ];
    /**
     * curl
     */
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data->get('data')));
    $response = curl_exec($ch);
    /**
     * 
     */
    if(curl_errno($ch)){
      //echo 'Error: '.curl_error($ch);
      $this->log(array('datetime' => date('Y-m-d H:i:s'), 'curl_error' => curl_error($ch)));
    }else{
      $response_data = json_decode($response, true);
      $this->log(array('datetime' => date('Y-m-d H:i:s'), 'request' => $data->get(), 'response' => $response_data));
      //wfHelp::print($response_data, true);
    }
    curl_close($ch);
  }
  private function log($data){
    $yml = new PluginWfYml($this->settings->get('settings/log_file'));
    $yml->set('log/', $data);
    $yml->save();
    wfHelp::print($data);
    return null;
  }
}