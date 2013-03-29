<?php

/*------------------------------------------------------------------------

# TZ Guestbook Extension

# ------------------------------------------------------------------------

# author    TuNguyenTemPlaza

# copyright Copyright (C) 2012 templaza.com. All Rights Reserved.

# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL

# Websites: http://www.templaza.com

# Technical Support:  Forum - http://templaza.com/Forum

-------------------------------------------------------------------------*/
defined("_JEXEC") or die;
jimport('joomla.application.component.model');
jimport('joomla.html.pagination');

class Tz_guestbookModelGuestbook extends JModel{

    function populateState($ordering = null, $direction = null){
        $this->setState('sata',JRequest::getString('filter_state'));
        $this->setState('autho',JRequest::getString('filter_user'));
        $this->setState('lab1',JRequest::getString('filter_order'));
        $this->setState('lab2',JRequest::getString('filter_order_Dir'));
        $this->setState('tz_search',JRequest::getString('filter_search'));
        $this->setState('id_input',JRequest::getVar('cid'));
        $this->setState('detail2',JRequest::getInt('id'));
    }
    function getList(){

        $lisd       = $this->getState('lab1');
        $lisd2      = $this->getState('lab2');
        $limit      = JRequest::getCmd('limit',20);
        $limitstart = JRequest::getCmd('limitstart',0);
        $selectsta  = $this->getState('sata');
        $author     = $this->getState('autho');
        $search     = $this->getState('tz_search');
        switch($lisd){
            case'state':
                $ord = "order by c.status $lisd2";
                break;
            case'title':
                $ord ="order by c.title $lisd2";
                break;
            case'email':
                $ord="order by c.email $lisd2";
                break;
            case'id':
                $ord= "order by c.id_cm $lisd2";
                break;
            case'publich':
                $ord= "order by c.public $lisd2";
                break;
            case'tacgia':
                $ord="order by u.name $lisd2 ";
                break;
            default:
                $ord="order by c.date desc";
                break;
        }

        // status
        switch($selectsta){
            case'P':
                $satrus = '  c.status = 1';
                break;
            case'U':
                $satrus = ' c.status = 0';
                break;
            default:
                $satrus="c.status in (0,1)";
                break;
        }

        // author
        if(isset($author) && $author >0){
            $author =" AND u.id = $author";
        }else{
            $author=null;
        }

        // search
        if(isset($search) && !empty($search)){
            if(is_numeric($search) == true){
                $q_search = "AND c.id_cm = $search";
            }else if(is_numeric($search) == false){
                $q_search = "AND c.title like '%".$search."%'";
            }
        }else{
            $q_search=  '';
        }

        $where  =   "where ".$satrus." ". $author." ". $q_search." ". $ord;

        $db     = JFactory::getDbo();
        $sql    = "SELECT u.name AS uname, c.id_cm AS cid, c.title AS ctitle, c.email AS cemail, c.status AS cstatus, c.public AS cpublic
                    FROM #__users AS u RIGHT JOIN #__comment AS c ON c.id_us  = u.id
                    $where";
        $sql2   = "SELECT u.name AS uname, c.id_cm AS cid, c.title AS ctitle, c.email AS cemail, c.status AS cstatus, c.public AS cpublic
                    FROM #__users AS u RIGHT JOIN #__comment AS c ON c.id_us  = u.id
                    $where";

        $db     -> setQuery($sql);
        $number =  $db->query();
        $total  =  $db->getNumRows($number);
        $this   -> pagNav  = new JPagination($total,$limitstart,$limit);
        $db     -> setQuery($sql2,$this -> pagNav -> limitstart,$this -> pagNav -> limit);
        $row    =  $db->loadObjectList();

        return $row;
    }

    /*
    * Method paging
    */
    function getPagination(){
        if(!$this->pagNav)
        return '';
        return $this->pagNav;
    }

    /*
    * Method get data author
    */
    function getAuthor(){
        $db     = JFactory::getDbo();
        $sql    = "SELECT u.id AS value, u.name AS text
                  FROM #__users AS u LEFT JOIN #__comment AS c ON c.id_us  = u.id group by u.id";
        $db     -> setQuery($sql);
        $row    = $db -> loadObjectList();
        return $row;
    }

    /*
    * Method unpublich
    */
    function unpulich(){
        $idd    =  $this->getState('id_input');
        $string =  implode(",",$idd);
        $db     =  JFactory::getDbo();
        $sql    =  "UPDATE #__comment SET status =0 WHERE id_cm in($string)";
        $db     -> setQuery($sql);
        $db     -> query();
    }

    /*
    * Method publish
    */
    function publish(){
        $idd    =  $this->getState('id_input');
        $string =  implode(",",$idd);
        $db     =  JFactory::getDbo();
        $sql    =  "UPDATE #__comment SET status =1 WHERE id_cm in($string)";
        $db     -> setQuery($sql);
        $db     -> query();
    }

    /*
    * method delete
    */
    function delete(){
        $idd    = $this->getState('id_input');
        $string = implode(",",$idd);
        $db     = JFactory::getDbo();
        $sql    = "delete from  #__comment  WHERE id_cm in($string)";
        $db     -> setQuery($sql);
        $db     -> query();
    }

    /*
    * method view detail comment
    */
    function getDetail(){
        $id_input    = $this->getState('id_input');
        $id_script   = $this->getState('detail2');
        $id_in       = $id_input[0];
        if(isset($id_in) && $id_in !=""){
            $id      = $id_in;
        }
        else if(isset($id_script) && $id_script !=""){
            $id      = $id_script;
        }else{
            $id      = 0;
        }
        $db     = JFactory::getDbo();
        $sql    = "SELECT c.name AS cname,  c.email AS cemail,  c.title AS ctitle, c.content AS ccontent,  c.public AS cpublic,
                          c.date AS cdate, c.status AS cstatus, u.name AS uname,  c.website as cwebsite
                    FROM #__users AS u RIGHT JOIN #__comment AS c ON c.id_us  = u.id
                    WHERE c.id_cm = $id";
        $db -> setQuery($sql);
        $db -> query();
        $row = $db->loadObject();
        return $row;
    }
}
?>