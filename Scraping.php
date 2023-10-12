<?php

class Scraping
{
    public function getSnowReportPage($skiCenter){

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://www.snowreport.gr/$skiCenter/",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return $this->ScrapingPage($response);

    }

    public function ScrapingPage($page){
        libxml_use_internal_errors(true);  // Enable error handling

        $lifts=[];
        $doc = new DOMDocument();
        $doc->loadHTML($page);
        $selector = new DOMXPath($doc);
        $result = $selector->query('//span[@class="lift-name red"]');
        foreach ($result as $element) {
            $liftname=$element->textContent;
            $liftname=str_replace("\n", "", $liftname);
            $lifts["$liftname"]=0;
        }
        $result = $selector->query('//span[@class="lift-name green"]');
        foreach ($result as $element) {
            $liftname=$element->textContent;
            $liftname=str_replace("\n", "", $liftname);
            $lifts["$liftname"]=0;
        }

        return $lifts;
    }

}