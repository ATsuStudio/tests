<?php

namespace NamePlugin;

abstract class VacancyResponse{
    protected $_api_url;
    public function __construct($api_url){
        $this->_api_url = $api_url;
    }
    abstract public function GetList();
    abstract public function GetVacancy($vid = 0);
    abstract protected function GetApiResponse();
    abstract protected function api_send($param);
    abstract protected function self_get_option($option_name);

}


class VacancyHeadHunter extends VacancyResponse{
    // примеры запросов из документации HeadHunterAPI https://api.hh.ru/openapi/redoc#tag/Vakansii/operation/get-vacancy
    
    public function GetList() {
      $response = $this->GetApiResponse();
      if(!is_null($response['items']))
      {
        return $response['items'];
      }
      return false;
    }
    protected function GetApiResponse(){
      $params = "/employers/" . $this->self_get_option('superjob_user_id') . "/vacancies/active";
      //$params = "status=all&id_user=" . $this->self_get_option('superjob_user_id') . "&with_new_response=0&order_field=date&order_direction=desc&page={$page}&count=100";
      try {
        $res = $this->api_send($this->_api_url . $params);
        $resArray = json_decode($res);
      } catch (\Throwable $th) {
        throw $th;
        $resArray = false;
      }
      
      return $resArray;
    }
    public function GetVacancy($vid = 0){
      if($vid == 0)
        return false;
      $response = $this->GetApiResponse();
      if(!is_null($response['items']))
      {
        foreach ($response['items'] as $key => $value) {
          if($response['items'][$key]['id'] == $vid){
            return $response['items'][$key];
          }
        }
      }
      return false;
    }
    
    protected function api_send($param) {
        // curl request

        return ('{
            "found": 1,
            "items": [
              {
                "address": {
                  "building": "15 к 2",
                  "city": "Кемерово",
                  "description": null,
                  "id": "321123",
                  "lat": 55.324417,
                  "lng": 86.116411,
                  "metro": null,
                  "metro_stations": [],
                  "raw": "Кемерово, Пр.Молодежный, 15 к 2",
                  "street": "Пр.Молодежный"
                },
                "alternate_url": "https://hh.ru/vacancy/8331228",
                "apply_alternate_url": "https://hh.ru/applicant/vacancy_response?vacancyId=8331228",
                "archived": false,
                "area": {
                  "id": "1",
                  "name": "Москва",
                  "url": "https://api.hh.ru/areas/1"
                },
                "billing_type": {
                  "id": "standard",
                  "name": "Стандарт"
                },
                "can_upgrade_billing_type": true,
                "counters": {
                  "calls": 99,
                  "invitations": 10,
                  "invitations_and_responses": 14,
                  "new_missed_calls": 11,
                  "responses": 5,
                  "resumes_in_progress": 5,
                  "unread_responses": 3,
                  "views": 100500
                },
                "created_at": "2012-10-11T13:27:16+0400",
                "department": {
                  "id": "HH-1455-TECH",
                  "name": "HeadHunter::Технический департамент"
                },
                "employer": {
                  "accredited_it_employer": false,
                  "alternate_url": "https://hh.ru/employer/1455",
                  "id": "1455",
                  "logo_urls": {
                    "90": "https://hh.ru/employer-logo/289027.png",
                    "240": "https://hh.ru/employer-logo/289169.png",
                    "original": "https://hh.ru/file/2352807.png"
                  },
                  "name": "HeadHunter",
                  "trusted": true,
                  "url": "https://api.hh.ru/employers/1455"
                },
                "expires_at": "2013-07-08T16:17:21+0400",
                "has_test": true,
                "has_updates": false,
                "id": "8331228",
                "manager": {
                  "first_name": "Петр",
                  "id": "5032",
                  "last_name": "Иванов",
                  "middle_name": null
                },
                "name": "Секретарь",
                "negotiations_state": null,
                "premium": false,
                "published_at": "2013-07-08T16:17:21+0400",
                "relations": [],
                "response_letter_required": true,
                "salary": {
                  "currency": "RUR",
                  "from": 30000,
                  "gross": true,
                  "to": null
                },
                "type": {
                  "id": "open",
                  "name": "Открытая"
                },
                "url": "https://api.hh.ru/vacancies/8331228"
              }
            ],
            "page": 0,
            "pages": 1,
            "per_page": 20
          }');
    }
    protected function self_get_option($option_name) {
        // ... какая то логика
        return 'headhunterUser';
    }
}



class LinkedIn extends VacancyResponse{
  
   public function GetList() {
  }
   public function GetVacancy($vid = 0){
  
  }
   protected function GetApiResponse() {
    // some response 
    // return array
  }
   protected function api_send($param){
    // curl method request
    return '';
  }
   protected function self_get_option($option_name) {} 
}
class OtherVacancy extends VacancyResponse{
  
   public function GetList() {
  }
   public function GetVacancy($vid = 0){
  
  }
   protected function GetApiResponse() {
    // some response 
    // return array
  }
   protected function api_send($param){
    // curl method request
    return '';
  }
   protected function self_get_option($option_name) {}
}