<?php

namespace Api\SearchBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Search controller.
 *
 */
class SearchController extends Controller
{
    public function  totalInternalSearchAction()
    {
        return $this->render('ApiSearchBundle:Search:totalInternalSearch.html.twig');
    }
    
    public function  jobWebSearchAction(Request $request)
    {
        $geoip = $this->get('maxmind.geoip')->lookup($this->getIp());
        
//        $geoip->getCountryCode();
//        $geoip->getCountryCode3();
//        $geoip->getCountryName();
//        $geoip->getRegion();
//        $geoip->getCity();
//        $geoip->getPostalCode();
//        $geoip->getLatitude();
//        $geoip->getLongitude();
//        $geoip->getAreaCode();
//        $geoip->getMetroCode();
//        $geoip->getContinentCode();
        
        if($request->get('what') != ""){
            $what = $request->get('what');
        }else{
            $what = "";
        }

        if($request->get('where') != ""){
            $where = $request->get('where');
        }else{
            $where = $geoip->getRegion().', '.$geoip->getCountryName();
        }
        return $this->render('ApiSearchBundle:Search:jobWebSearch.html.twig', array(
            'what' => $what,
            'where' => $where,
        ));
    } 
    
    public function getIp()   //Permet d'avoir l'ip d'un membre (meme si proxy)
    {
        if ( isset($_SERVER['HTTP_X_FORWARDED_FOR']) ){
            if($_SERVER['HTTP_X_FORWARDED_FOR'] == '127.0.0.1'){
                $ip = '82.246.104.59';
            }else{
                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            }
        }
        elseif(isset($_SERVER['REMOTE_ADDR'])){
            if($_SERVER['REMOTE_ADDR'] == '127.0.0.1'){
                $ip = '82.246.104.59';
            }else{
                $ip = $_SERVER['REMOTE_ADDR'];
            }
        }   
        elseif(isset($_SERVER['HTTP_CLIENT_IP'])){
            if($_SERVER['HTTP_CLIENT_IP'] == '127.0.0.1'){
                $ip = '82.246.104.59';
            }else{
                $ip = $_SERVER['HTTP_CLIENT_IP'];
            }
        }
        return $ip;
    }
    
    public function getLocality()
    {
        $geoip = $this->get('maxmind.geoip')->lookup($this->getIp());
        
        return array('geoip' => $geoip);
    }
}
