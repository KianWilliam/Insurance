<?php 
/*
 * @package component Insurance for Joomla! 3.x
 * @version $Id: com_Insurance 1.0.0 2017-10-10 23:26:33Z $
 * @author Kian William Nowrouzian
 * @copyright (C) 2016- Kian William Nowrouzian
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 
 This file is part of Insurance.
    Insurance is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.
    Insurance is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.
    You should have received a copy of the GNU General Public License
    along with Insurance.  If not, see <http://www.gnu.org/licenses/>.
 
*/
?>
<?php
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.modellist');
jimport('joomla.filesystem.file');
jimport('joomla.filesystem.folder');
use Joomla\Utilities\ArrayHelper;

class InsuranceModelInsuranceclients extends JModelList {
	private $items = [];
	public function __construct($config = array()) {
        if (empty($config['filter_fields'])) {
            $config['filter_fields'] = array(
                'id', 'a.id',
                'ordering', 'a.ordering',
                'published', 'a.published',              
            );
        }

        parent::__construct($config);
    }
	
		protected function populateState($ordering = null, $direction = null) {
        // Initialise variables.
        $app = JFactory::getApplication();

       // $published = $this->getUserStateFromRequest($this->context . '.filter.published', 'filter_published', '');
        //$this->setState('filter.published', $published);
		$limit = 100;

        // List state information.
        parent::populateState();
      }
	  
	  protected function getStoreId($id = '') {
        // Compile the store id.
        $id .= ':' . $this->getState('filter.published');
        return parent::getStoreId($id);
      }
	  
	  public function getListQuery() {
        // Create a new query object.
        $db = $this->getDbo();
        $query = $db->getQuery(true);

        // Select the required fields from the table.
        $query->select('id, published');
        $query->from('#__insurance');

        $db->setQuery($query);
		$results = $db->loadObjectList();
		
		//if($results!==null)
		//{
	//	for($i=0; $i<count($results); $i++)
		//{
			//if($results[$i]->published)
			//{
			    /* $query = $db->getQuery(true);
				 $query->select('*');
                 $query->from('#__'.$results[$i]->id .' AS a');
				 $published = $this->getState('filter.published');
                   if (is_numeric($published)) {
                        $query->where('in.published = ' . (int) $published);
                   } else if ($published === '') {
                     $query->where('(a.published = 0 OR a.published = 1)');
                   }
			     $orderCol = $this->state->get('list.ordering');
                 $orderDirn = $this->state->get('list.direction');
                 $order = $orderCol;
                 if (!empty($orderDirn))
                      $order .= " " . $orderDirn;
                 if (!empty($orderCol))
                       $query->order($order);
				 $db->setQuery($query);
				 $results = $db->loadObjectList();
				 array_merge($this->items, $results);*/
			//}

		//}       
		//}
       // return $this->items;
	   
	   $publishedresults = [];
	   if(!empty($results))	{   
	   	   		for($i=0; $i<count($results); $i++)
						if($results[$i]->published)
							$publishedresults [] = $results[$i];
	   

					 

	   $query = '';
	   		for($i=0; $i<count($publishedresults); $i++)
			{				
				if($i==0)
				  $query = ' (SELECT * FROM #__'.$publishedresults[0]->id. ' ) ';
				else
					$query .= ' UNION ( SELECT * FROM #__'.$publishedresults[$i]->id.' )'; 			
                		
			}
			
			
			return $query;
	   }
			
			return false;
	   
	   

	   
    }
	public function getItems()
	{
		  $store = $this->getStoreId();

        // Try to load the data from internal storage.
        if (!empty($this->_cache[$store])) {
               return $this->_cache[$store];
        }
	
		   $query  = $this->_getListQuery();
		   if($query!=false)
           $items  = $this->_getList((string)$query, 0, 10000);
		   
		    if ($this->_db->getErrorNum()) {
                $this->setError($this->_db->getErrorMsg());
                return false;
        }

        // Add the items to the internal cache.
  if($query!=false){
        $this->_cache[$store] = $items;
        
        return $this->_cache[$store];
  }
	else
		return null;
				
	}
	public function delete($cid)
	{
		 $db = JFactory::getDbo();
         
    
		foreach($cid as $key=>$value)
		{
			$ids = explode('_', $value);
		    $query = $db->getQuery(true);
			$query->select($db->quoteName('userid'))->from($db->quoteName('#__'.$ids[1]))->where($db->quoteName('id') . '='. $ids[0]);
			$db->setQuery($query);
			$result=$db->loadObjectList();
			$userid = $result[0]->userid;
		    $query = $db->getQuery(true);
			$query->delete($db->quoteName('#__'.$ids[1]))->where($db->quoteName('id') . '='. $ids[0]);
			$db->setQuery($query);
			$db->execute();	
            $files = JFolder::files(JPATH_ADMINISTRATOR.'/components/com_insurance/Fileuploads');			
		    foreach($files as $value)
		    {
				echo $value.'<br />';
				if(preg_match("/^".$ids[1]."_".$userid."/",  $value))
				{
					JFile::delete(JPATH_ADMINISTRATOR.'/components/com_insurance/Fileuploads/'.$value);
				}
			}
		}
		return true;	
	}
	public function update($cid, $params)
	{
		 $db = JFactory::getDbo();

		foreach($cid as $key=>$value)
		{
			$ids = explode('_', $value);
		    $query = $db->getQuery(true);
			if(!preg_match('/[0-9]+\=/', $params[$key]))
			{
			   $parray = explode(' ',$params[$key]);
			   $params[$key]=ArrayHelper::toString($parray);
			}
			


			$fields = array(
            $db->quoteName('params') . ' = ' . $db->quote($params[$key]),
             );
			$conditions = array(
               $db->quoteName('id') . ' = ' . $ids[0],
           );
			$query->update($db->quoteName('#__'.$ids[1]))->set($fields)->where($conditions);
		    $db->setQuery($query);
			$result =$db->execute();			
		}
		
		return true;
		
	}
	

	
	
}
