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
defined('_JEXEC') or die;
jimport('joomla.application.component.controller');

class Tz_guestbookControllerGuestbook extends JController {

    function display($cachable=false,$urlparams=array()){
        $task   =  JRequest::getVar('task');
        $doc    =  JFactory::getDocument();
        $type   =  $doc->getType();
        $view   =  $this -> getView('guestbook',$type);
        $model  =  $this->getModel('guestbook');
        $view   -> setModel($model,true);

        switch($task){
            case'edit':
            case'g_edit':
                $view->setLayout('edit');
                break;
            case'unpublish':
                $model-> unpulich();
                break;
            case'publish':
                $model-> publish();
                break;
            case'remove':
                $model->delete();
                break;
            default:
                $view->setLayout('default');
                break;
        }
        $view->display();
    }
}
?>