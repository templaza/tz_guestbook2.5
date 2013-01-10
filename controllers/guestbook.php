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
        function display(){
            $task = JRequest::getVar('task');
            $ci = $_POST['cid'];
			if(isset($_POST['cid']) && $_POST['cid'] !=""){
            $rr = implode(",",$ci);
			}else{
				$rr = 0;
			}
            $doc = &JFactory::getDocument();
            $type = $doc->getType();

            $view= &$this -> getView('guestbook',$type);

            $model=&$this->getModel('guestbook');
            $view-> setModel($model,true);

            switch($task){
                case'edit':
                case'chitiet':
                    $view->setLayout('edit');
                      break;
                case'unpublish':
                    $model-> unpulich($rr);
                    break;
                case'publish':
                     $model-> publish($rr);
                      break;
                case'remove':
                    $model->delete($rr);
                    break;
                default:
                    $view->setLayout('default');
                    break;
            }

            $view->display();
        }
    }
?>