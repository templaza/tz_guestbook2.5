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
$listDirn = $this->state2;
 $listOrder = $this->state1;

?>
    <form action="index.php?option=com_tz_guestbook" method="post"  name="adminForm" id="adminForm">
        <fieldset id="filter-bar">
            <div class="filter-search fltlft">
                 <label for="filter_search" class="filter-search-lbl"><?php echo JText::_('JSEARCH_FILTER_LABEL'); ?></label>
                 <input type="text" title="<?php echo JText::_('Search fields by name');?>"
                        value="<?php echo JRequest::getCmd('filter_search',null);?>"
                        id="filter_search"
                        name="filter_search">
                 <button type="submit"><?php echo JText::_('JSEARCH_FILTER_SUBMIT'); ?></button>
                 <button onclick="document.getElementById('filter_search').value='';this.form.submit();" type="button"><?php echo JText::_('JSEARCH_FILTER_CLEAR'); ?></button>
            </div>
            <div class="filter-select fltrt">
                <?php echo JHTML::_('grid.state',$this->star);?>
                <select name="filter_user" class="inputbox" onchange="this.form.submit()">
                     <option>
                 <?php echo JText::_('JOPTION_SELECT_AUTHOR');  ?>
                    </option>
                    <?php echo JHtml::_('select.options', $this->authors , 'value', 'text',$this->author,true);?>
                </select>


            </div>

         </fieldset>
        <div class="clr"> </div>
        <table class="adminlist">
                <thead>
                        <tr>
                            <th width="1%">
                                    <input type="checkbox" name="checkall-toggle" value="" title="<?php echo JText::_('JGLOBAL_CHECK_ALL'); ?>" onclick="Joomla.checkAll(this)" />
                             </th>
                            <th width="25%">
                                    <?php echo JHtml::_('grid.sort','JGLOBAL_TITLE','title', $listDirn, $listOrder) ?>
                             </th>
                            <th width="15%">
                                     <?php echo JHtml::_('grid.sort',JText::_('COM_TZ_GUESTBOOK_GLOBAL_AUTHOR'),'tacgia', $listDirn, $listOrder) ?>
                             </th>
                            <th width="3%">
                                  <?php echo JHtml::_('grid.sort',JText::_('COM_TZ_GUESTBOOK_GLOBAL_PUBLICH'),'publich', $listDirn, $listOrder) ?>
                             </th>
                            <th width="5%">
                                      <?php echo JHtml::_('grid.sort','JSTATUS','state', $listDirn, $listOrder) ?>
                             </th>
                            <th width="15%">
                                     <?php echo JHtml::_('grid.sort',JText::_('COM_TZ_GUESTBOOK_GLOBAL_EMAIL'),'email', $listDirn, $listOrder) ?>
                              </th>
                            <th width="5%">
                                <?php echo JHtml::_('grid.sort','JGRID_HEADING_ID','id', $listDirn, $listOrder) ?>
                            </th>
                        </tr>
                </thead>
            <tbody>
            <?php
                foreach($this->Hienthi as $i=>$num){
            ?>
                <tr class="row<?php echo $i % 2; ?>">
                    <td class="center">
                         <?php echo JHtml::_('grid.id', $i, $num->cid); ?>
                    </td>
                    <td>
                        <a href="<?php echo JRoute::_('index.php?option=com_tz_guestbook&task=chitiet&id='.$num->cid);?>">
                       <?php
                                echo $num->ctitle;
                        ?>
                        </a>
                    </td>
                    <td class="center">
                        <?php
                               if(isset($num->uname) && !empty($num->uname)){
                                   echo $num->uname;
                               }else{
                                   echo JText::_("COM_TZ_GUESTBOOK_GLOBAL_USER_AUTHOR_");
                               }
                        ?>
                    </td>
                    <td class="center">
                        <?PHP echo $num->cpublic; ?>
                    </td>
                    <td class="center">
                        <?php echo JHtml::_('jgrid.published', $num->cstatus, $i, '', true, $checkbox = 'cb', '', ''); ?>
                    </td>
                    <td class="center">
                         <?php
                             echo $num->cemail;
                             ?>
                    </td>

                    <td class="center">
                        <?php
                            echo $num->cid;
                        ?>
                    </td>
                </tr>
               <?php
                }
                    ?>
            </tbody>
            <tfoot>
                         <tr>
                           <td colspan="8">
                               <?php echo $this -> pagination -> getListFooter();?>
                           </td>
                         </tr>
                       </tfoot>
        </table>
        <input type="hidden" name="option" value="com_tz_guestbook">
                   <input type="hidden" name="view" value="guestbook">
                   <input type="hidden" name="task" value="">
                   <input type="hidden" name="boxchecked" value="0">
        <input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>" />
        <input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>" />
    </form>