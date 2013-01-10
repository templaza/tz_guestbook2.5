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
    jimport('joomla.html.pagination'); // phan trang
    class Tz_guestbookModelGuestbook extends JModel{
        function populateState(){
            $this->setState('sata',JRequest::getString('filter_state'));
            $this->setState('autho',JRequest::getString('filter_user'));
            $this->setState('lab1',JRequest::getString('filter_order'));
            $this->setState('lab2',JRequest::getString('filter_order_Dir'));
            $this->setState('timkiem',JRequest::getString('filter_search'));
            $this->setState('detail1',$_POST['cid']);
            $this->setState('detail2',JRequest::getInt('id'));

        }
        function getList(){
            $lisd = $this->getState('lab1');
            $lisd2 = $this->getState('lab2');
            $limit = JRequest::getCmd('limit',20);
            $limitstart = JRequest::getCmd('limitstart',0);
            $selectsta = $this->getState('sata');
            $author = $this->getState('autho');
            $timkiem = $this->getState('timkiem');


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
            // ket qua tim status
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
            // ket qua tim tac gia
            if(isset($author) && $author >0){
                $author =" AND u.id = $author";
            }else{
                $author=null;
            }
            // ket qua tim kim
            if(isset($timkiem) && !empty($timkiem)){
                if(is_numeric($timkiem) == true){
                    $tim = "AND c.id_cm = $timkiem";
                }else if(is_numeric($timkiem) == false){
                    $tim = 'AND c.title = "'.$timkiem.'"';
             }else{
                $tim =null;
            }
            }

                $db = &JFactory::getDbo();
                $sql="SELECT u.name AS uname, c.id_cm AS cid, c.title AS ctitle, c.email AS cemail, c.status AS cstatus, c.public AS cpublic
                       FROM #__users AS u RIGHT JOIN #__comment AS c ON c.id_us  = u.id
                      where $satrus $author $tim $ord";
                 $sql2="SELECT u.name AS uname, c.id_cm AS cid, c.title AS ctitle, c.email AS cemail, c.status AS cstatus, c.public AS cpublic
                                   FROM #__users AS u RIGHT JOIN #__comment AS c ON c.id_us  = u.id
                                  where $satrus $author $tim $ord";

                $db->setQuery($sql);
                $tinh = $db->query();

                   $total = $db->getNumRows($tinh);  // ham tra ve so dong bi anh huong boi cau lenh select
                   $this -> pagNav         = new JPagination($total,$limitstart,$limit); // tao mot doi tuog moi de phan trang

                $db->setQuery($sql2,$this -> pagNav -> limitstart,$this -> pagNav -> limit); //  thuc hien cau lenh select voi dk
                $row = $db->loadObjectList();

                return $row;
        }
        function getPagination(){ // vi khi view du lieu ra faj la nhung ham get k co tham so vi vay ta faj tao ra ham nay
                        if(!$this->pagNav)
                            return '';
                        return $this->pagNav;
                    }
        function getAuthor(){
            $db = &JFactory::getDbo();
            $sql ="SELECT u.id AS value, u.name AS text
                   FROM #__users AS u LEFT JOIN #__comment AS c ON c.id_us  = u.id";
            $db->setQuery($sql);
            $row = $db->loadObjectList();
            return $row;

        }
        function unpulich($rr){
            $db = &JFactory::getDbo();
            $sql ="UPDATE #__comment SET status =0 WHERE id_cm in($rr)";
            $db->setQuery($sql);
            $db->query();
        }
        function publish($rr){
            $db = &JFactory::getDbo();
                        $sql ="UPDATE #__comment SET status =1 WHERE id_cm in($rr)";
                        $db->setQuery($sql);
                        $db->query();
        }
        function delete($rr){
            $db = &JFactory::getDbo();
                        $sql ="delete from  #__comment  WHERE id_cm in($rr)";
                        $db->setQuery($sql);
                        $db->query();
        }
        function getDetail(){
            $id2 = $this->getState('detail1'); // lay ve mang
            $id1 = $this->getState('detail2');
            $id3 = $id2[0];
            if(isset($id3) && $id3 !=""){
                     $id = $id3;

             }
            else if(isset($id1) && $id1 !="")
              {
                  $id = $id1;
              }

           $db = &JFactory::getDbo();
           $sql="SELECT c.name AS cname,  c.email AS cemail,  c.title AS ctitle, c.content AS ccontent,  c.public AS cpublic,
                        c.date AS cdate, c.status AS cstatus, u.name AS uname,  c.website as cwebsite
                 FROM #__users AS u RIGHT JOIN #__comment AS c ON c.id_us  = u.id
                 WHERE c.id_cm = $id";
           $db->setQuery($sql);
            $db->query();
           $row = $db->loadObject();
            return $row;
        }


    }
?>