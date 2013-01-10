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
        jimport('joomla.application.component.view');

    class Tz_guestbookViewGuestbook extends JView{
        function display($tpl = null){
            $state  = $this -> get('State');


            $status = $state->get('sata');
            $aut = $state->get('autho');
            $listOrder = $state->get('lab1');
              $listDirn = $state->get('lab2');

            $this->assign('detail',$this->get('Detail'));
             $this->assign('state1',$listOrder);
             $this->assign('state2',$listDirn);
            $this->assign('author',$aut);
            $this->assign('star',$status);
            $this->assign('Hienthi',$this->get('List'));
           $this->assign('authors',$this->get('Author'));
            $this -> assignRef('pagination',$this -> get('Pagination'));
            $task = JRequest::getVar('task');

            switch($task){
                case'edit':
                case'chitiet':
                    $this->adde();
                    break;
                default:
                    $this->addtool();
                    break;
            }

            parent::display($tpl);
        }

        function adde(){
            JToolBarHelper::title(JText::_("COM_TZ_GUESTBOOK_CONTENT_GUESTBOOK"),'article-add.png');
            JToolBarHelper::preferences('com_tz_guestbook');
            JToolBarHelper::cancel();
            JToolBarHelper::help('JHELP_CONTENT_ARTICLE_MANAGER_EDIT');
        }
        function addtool(){
            JToolBarHelper::editListX();
            JToolBarHelper::title(JText::_("COM_TZ_GUESTBOOK_2"),'article-add.png');
            JToolBarHelper::publishList();
            JToolBarHelper::unpublishList();
            JToolBarHelper::deleteListX(JText::_("COM_TZ_GUESTBOOK_1"));
            JToolBarHelper::preferences('com_tz_guestbook');
            JToolBarHelper::cancel();
            JToolBarHelper::help('JHELP_CONTENT_ARTICLE_MANAGER_EDIT');


        }
    }
?>