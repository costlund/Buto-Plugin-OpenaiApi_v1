<?php
class PluginOpenaiApi_v1{
  public $settings;
  private $db;
  function __construct(){
    /**
     * 
     */
    $this->settings = wfPlugin::getPluginSettings('openai/api_v1', true);
    /**
     * 
     */
    $this->settings->set('settings', wfSettings::getSettingsFromYmlString($this->settings->get('settings')));
    /**
     * 
     */
    if(!$this->settings->get('settings/api_key')){
      throw new Exception(__CLASS__.'::'.__FUNCTION__.' says: Api key is not set!');
    }
    /**
     * log_file
     */
    $this->settings->set('settings/log_file', wfGlobals::getAppDir().'/../buto_data/theme/[theme]/openai_log/'.date('ymd').'.yml');
    /**
     * db
     */
    wfPlugin::includeonce('openai/db');
    $this->db = new PluginOpenaiDb();
  }
  public function widget_test($data){
    /**
     * 
     */
    $data = new PluginWfArray($data);
    if(!$data->get('data')){
      throw new Exception(__CLASS__.'::'.__FUNCTION__.' says: No data is set!');
    }
    /**
     * 
     */
    wfHelp::print($data->get('data'));
    $response = $this->api_chat_completions($data->get('data'));
    $response = new PluginWfArray($response);
    wfHelp::print($response->get('choices/0/message/content'));
    wfHelp::print($response);
  }
  public function api_chat_completions($data, $tag = null){
    /**
     * tag
     */
    if($tag){
      /**
       * If tag and db record we skip api request.
       */
      $db_data = $this->db->db_openai_chat_select_one_by_tag($tag);
      if($db_data->get('id')){
        $response = $db_data->get('response');
        $response = sfYaml::load($response);
        $response['db']['id'] = $db_data->get('id');
        $response['db']['tag'] = $db_data->get('tag');
        $response['db']['created_at'] = $db_data->get('created_at');
        $response['db']['request'] = sfYaml::load($db_data->get('request'));
        return $response;
      }
    }
    /**
     * 
     */
    $data = new PluginWfArray($data);
    /**
     * 
     */
    if(!$data->get('model')){
      throw new Exception(__CLASS__.'::'.__FUNCTION__.' says: Param model is not set!');
    }
    if(!$data->get('messages')){
      throw new Exception(__CLASS__.'::'.__FUNCTION__.' says: Param messages is not set!');
    }
    if(!$data->get('max_tokens')){
      throw new Exception(__CLASS__.'::'.__FUNCTION__.' says: Param max_tokens is not set!');
    }
    if(!$data->get('temperature')){
      throw new Exception(__CLASS__.'::'.__FUNCTION__.' says: Param temperature is not set!');
    }
    /**
     * url
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
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data->get()));
    $response = curl_exec($ch);
    /**
     * 
     */
    $response_data = array();
    if(curl_errno($ch)){
      $this->log(array('datetime' => date('Y-m-d H:i:s'), 'curl_error' => curl_error($ch)));
    }else{
      $response_data = json_decode($response, true);
      $response_data['db']['created_at'] = date('Y-m-d H:i:s');
      /**
       * log
       */
      $this->log(array('datetime' => date('Y-m-d H:i:s'), 'request' => $data->get(), 'response' => $response_data));
      /**
       * db, insert
       */
      $this->db->db_openai_chat_insert(sfYaml::dump($data->get(), 99), sfYaml::dump($response_data, 99), $tag);
    }
    curl_close($ch);
    return $response_data;
  }
  private function log($data){
    wfSettings::$safe_mode = false;
    $yml = new PluginWfYml($this->settings->get('settings/log_file'));
    $yml->set('log/', $data);
    $yml->save();
    return null;
  }
}